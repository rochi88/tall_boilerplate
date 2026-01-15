<?php

declare(strict_types=1);

namespace App\Providers;

use Livewire\Livewire;
use Livewire\Component;
use Livewire\Volt\Volt;
use Laravel\Folio\Folio;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

abstract class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Module name (e.g. Customer, Order)
     */
    protected string $module;

    /**
     * Module base path
     */
    protected string $basePath;

    final public function boot(): void
    {
        $this->loadRoutes();
        $this->loadMigrations();
        $this->loadTranslations();
        $this->loadViews();
        $this->publishConfig();

        $this->registerLivewireComponents();
        $this->registerVoltComponents();
        $this->registerFolioRoutes();
    }

    /* -----------------------------------------------------------------
     | Routes
     |-----------------------------------------------------------------*/
    protected function loadRoutes(): void
    {
        $routesPath = $this->basePath . '/routes.php';

        if (file_exists($routesPath)) {
            Route::middleware('api')
                ->group($routesPath);
        }
    }

    /* -----------------------------------------------------------------
     | Migrations
     |-----------------------------------------------------------------*/
    protected function loadMigrations(): void
    {
        $migrationsPath = $this->basePath . '/Database/Migrations';

        if (is_dir($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }

    /* -----------------------------------------------------------------
     | Translations
     |-----------------------------------------------------------------*/
    protected function loadTranslations(): void
    {
        $langPath = $this->basePath . '/Resources/lang';

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, mb_strtolower($this->module));
        }
    }

    /* -----------------------------------------------------------------
     | Views
     |-----------------------------------------------------------------*/
    protected function loadViews(): void
    {
        $viewsPath = $this->basePath . '/Resources/views';

        if (is_dir($viewsPath)) {
            $this->loadViewsFrom($viewsPath, mb_strtolower($this->module));
        }
    }

    /* -----------------------------------------------------------------
     | Config
     |-----------------------------------------------------------------*/
    protected function publishConfig(): void
    {
        $configPath = $this->basePath . '/Config/' . mb_strtolower($this->module) . '.php';

        if (file_exists($configPath)) {
            $this->publishes([
                $configPath => config_path(mb_strtolower($this->module) . '.php'),
            ], $this->module . '-config');
        }
    }

    /* -----------------------------------------------------------------
     | Livewire Components
     |-----------------------------------------------------------------*/
    protected function registerLivewireComponents(): void
    {
        if (! class_exists(Livewire::class)) {
            return; // Livewire not installed
        }

        $path = $this->basePath . '/Http/Livewire';

        if (! is_dir($path)) {
            return;
        }

        foreach (glob($path . '/**/*.php') as $file) {
            $class = $this->classFromFile($file);

            if (
                $class &&
                class_exists($class) &&
                is_subclass_of($class, Component::class)
            ) {
                Livewire::component(
                    Str::kebab($this->module)
                    . '::'
                    . Str::kebab(class_basename($class)),
                    $class
                );
            }
        }
    }

    protected function livewireAlias(string $class): string
    {
        return Str::kebab($this->module) . '::' .
            Str::kebab(class_basename($class));
    }

    /* -----------------------------------------------------------------
    | Volt Components
    |-----------------------------------------------------------------*/
    protected function registerVoltComponents(): void
    {
        if (! (class_exists(Livewire::class) && class_exists(Volt::class))) {
            return;
        }

        $path = $this->basePath . '/Resources/views/pages';

        if (is_dir($path)) {
            Volt::mount([
                $path => Str::lower($this->module),
            ]);
        }
    }

    /* -----------------------------------------------------------------
    | Folio Routes
    |-----------------------------------------------------------------*/
    protected function registerFolioRoutes(): void
    {
        if (! class_exists(Folio::class)) {
            return;
        }

        $path = $this->basePath . '/Resources/views/pages';

        if (is_dir($path)) {
            Folio::path($path);
        }
    }

    /* -----------------------------------------------------------------
     | Helpers
     |-----------------------------------------------------------------*/
    protected function classFromFile(string $path): ?string
    {
        $contents = file_get_contents($path);

        if (! preg_match('/namespace\s+(.+?);/', $contents, $ns)) {
            return null;
        }

        if (! preg_match('/class\s+(\w+)/', $contents, $cls)) {
            return null;
        }

        return sprintf('%s\%s', $ns[1], $cls[1]);
    }
}
