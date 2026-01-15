<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeModuleVoltCrudCommand extends Command
{
    protected $signature = 'make:module-volt-crud 
                            {module : Module name (e.g. Customer)} 
                            {entity : Entity name (e.g. Customer)} 
                            {--version=V1 : UI version}';

    protected $description = 'Create fintech-safe Volt CRUD UI with CQRS Actions & Queries';

    public function handle(): int
    {
        $module = Str::studly($this->argument('module'));
        $entity = Str::studly($this->argument('entity'));
        $plural = Str::kebab(Str::pluralStudly($entity));
        $version = Str::studly($this->option('version'));

        $basePath = app_path('Modules/' . $module);

        if (! File::isDirectory($basePath)) {
            $this->error(sprintf('Module [%s] does not exist.', $module));

            return self::FAILURE;
        }

        $this->createQueries($module, $entity, $basePath);
        $this->createActions($module, $entity, $basePath);
        $this->createVoltViews($module, $entity, $plural, $version, $basePath);
        $this->registerRoutes($module, $entity, $plural, $version, $basePath);

        $this->info(sprintf('Volt CRUD for %s created successfully in %s module.', $entity, $module));

        return self::SUCCESS;
    }

    /* -----------------------------------------------------------------
     |  Queries (READ – CQRS)
     |-----------------------------------------------------------------*/
    private function createQueries(string $module, string $entity, string $basePath): void
    {
        $path = $basePath . '/Queries';
        File::ensureDirectoryExists($path);

        File::put(
            sprintf('%s/List%ss.php', $path, $entity),
            <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Queries;

use App\Modules\\{$module}\Models\\{$entity};

final class List{$entity}s
{
    public function handle(): iterable
    {
        return {$entity}::query()
            ->select(['id', 'created_at'])
            ->latest()
            ->get();
    }
}
PHP
        );
    }

    /* -----------------------------------------------------------------
     |  Actions (WRITE – Explicit, Audited)
     |-----------------------------------------------------------------*/
    private function createActions(string $module, string $entity, string $basePath): void
    {
        $path = $basePath . '/Actions';
        File::ensureDirectoryExists($path);

        foreach (['Create', 'Update', 'Delete'] as $action) {
            File::put(
                sprintf('%s/%s%s.php', $path, $action, $entity),
                <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Actions;

final class {$action}{$entity}
{
    public function handle(array \$payload): void
    {
        // Emit domain event or delegate to service
        // NEVER mutate state directly in UI
    }
}
PHP
            );
        }
    }

    /* -----------------------------------------------------------------
     |  Volt Views (UI – READ FIRST, WRITE VIA EVENTS)
     |-----------------------------------------------------------------*/
    private function createVoltViews(
        string $module,
        string $entity,
        string $plural,
        string $version,
        string $basePath,
    ): void {
        $path = sprintf('%s/Http/Volt/%s', $basePath, $version);
        File::ensureDirectoryExists($path);

        // INDEX (READ-ONLY)
        File::put(
            sprintf('%s/%s-index.blade.php', $path, $plural),
            <<<BLADE
<?php

use function Livewire\Volt\\{computed};
use App\Modules\\{$module}\Queries\\List{$entity}s;

\${$plural} = computed(fn () =>
    app(List{$entity}s::class)->handle()
);
?>

<div>
    <h1 class="text-xl font-bold mb-4">{$entity} List</h1>

    <table class="w-full border">
        <thead>
            <tr>
                <th>ID</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach (\${$plural} as \$item)
                <tr>
                    <td>{{ \$item->id }}</td>
                    <td>{{ \$item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
BLADE
        );

        // CREATE (INTENT ONLY)
        File::put(
            sprintf('%s/%s-create.blade.php', $path, $plural),
            <<<BLADE
<?php

use function Livewire\Volt\\{state};

state([
    'form' => [],
]);

\$submit = function () {
    \$this->dispatch('{$plural}-create-requested', \$this->form);
};
?>

<div>
    <h1 class="text-xl font-bold mb-4">Create {$entity}</h1>

    <button wire:click="submit" class="btn-primary">
        Submit for Approval
    </button>
</div>
BLADE
        );
    }

    /* -----------------------------------------------------------------
     |  Routes (Versioned, Module Scoped)
     |-----------------------------------------------------------------*/
    private function registerRoutes(
        string $module,
        string $entity,
        string $plural,
        string $version,
        string $basePath,
    ): void {
        File::append(
            $basePath . '/routes.php',
            <<<PHP

// Volt {$entity} CRUD ({$version})
Route::middleware(['web', 'audit'])
    ->prefix(strtolower('{$module}'))
    ->name(strtolower('{$module}.{$version}.'))
    ->group(function () {
        Route::view('/{$plural}', '{$module}::pages.{$plural}.index')
            ->name('index');
    });

PHP
        );
    }
}
