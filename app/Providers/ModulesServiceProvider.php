<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Override;

final class ModulesServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $modulesPath = app_path('Modules');

        if (! is_dir($modulesPath)) {
            return;
        }

        foreach (File::directories($modulesPath) as $moduleDir) {
            $moduleName = basename((string) $moduleDir);
            $moduleKey = Str::lower($moduleName);

            // ----------------------------------------
            // Load module config EARLY (before register)
            // ----------------------------------------
            $configPath = sprintf('%s/Config/%s.php', $moduleDir, $moduleKey);

            if (file_exists($configPath)) {
                $this->mergeConfigFrom(
                    $configPath,
                    $moduleKey,
                );
            }

            // ----------------------------------------
            // Skip disabled modules
            // ----------------------------------------
            if (! config($moduleKey . '.enabled', true)) {
                continue;
            }

            $providerClass = sprintf('App\Modules\%s\%sServiceProvider', $moduleName, $moduleName);

            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }
}
