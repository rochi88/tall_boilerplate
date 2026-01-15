<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name} {--api} {--web}';

    protected $description = 'Create a new application module';

    public function handle(): int
    {
        $name = ucfirst($this->argument('name'));
        $basePath = app_path('Modules/' . $name);

        if (File::exists($basePath)) {
            $this->error('Module already exists.');

            return self::FAILURE;
        }

        $this->createStructure($basePath);
        $this->createServiceProvider($name, $basePath);
        $this->createRoutesFile($basePath);
        $this->createConfigFile($name, $basePath);
        $this->createExampleFiles($name, $basePath);

        $this->info(sprintf('Module %s created successfully.', $name));

        return self::SUCCESS;
    }

    private function createStructure(string $basePath): void
    {
        $folders = [
            'Actions',
            'DTOs',
            'Enums',
            'Events',
            'Exceptions',
            'Http/Controllers',
            'Http/Requests',
            'Http/Resources',
            'Jobs',
            'Listeners',
            'Models',
            'Observers',
            'Policies',
            'Queries',
            'Repositories/Contracts',
            'Repositories/Eloquent',
            'Rules',
            'Services',
            'Transformers',
            'Tests/Unit',
            'Tests/Feature',
            'Database/Migrations',
            'Database/Seeders',
            'Resources/views',
            'Resources/lang',
            'Config',
        ];

        foreach ($folders as $folder) {
            $path = sprintf('%s/%s', $basePath, $folder);
            File::makeDirectory($path, 0755, true);

            // Add .gitignore to keep empty folders
            File::put($path . '/.gitignore', "!.gitignore\n");
        }
    }

    private function createServiceProvider(string $name, string $basePath): void
    {
        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$name};

use App\Providers\ModuleServiceProvider;

final class {$name}ServiceProvider extends ModuleServiceProvider
{
    protected string \$module = '{$name}';

    public function register(): void
    {
        \$this->basePath = __DIR__;
    }
}
PHP;

        File::put(sprintf('%s/%sServiceProvider.php', $basePath, $name), $content);
    }

    private function createRoutesFile(string $basePath): void
    {
        File::put(
            $basePath . '/routes.php',
            <<<PHP
            <?php

            use Illuminate\Support\Facades\Route;

            /*
            |--------------------------------------------------------------------------
            | Module Routes
            |--------------------------------------------------------------------------
            |
            | Here is where you can register module routes.
            |
            */

            PHP
        );
    }

    private function createExampleFiles(string $name, string $basePath): void
    {
        $isWeb = $this->option('web');
        $controllerClass = $name . 'Controller';

        $controller = $isWeb
            ? $this->webControllerStub($name)
            : $this->apiControllerStub($name);

        File::put(
            sprintf('%s/Http/Controllers/%s.php', $basePath, $controllerClass),
            $controller,
        );

        // Auto-register route
        $this->appendRoute($name, $basePath, $isWeb);
    }

    private function apiControllerStub(string $name): string
    {
        return <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Modules\\{$name}\Http\Controllers;

        use Illuminate\Http\JsonResponse;
        use Illuminate\Routing\Controller;

        final class {$name}Controller extends Controller
        {
            public function index(): JsonResponse
            {
                return response()->json([
                    'module' => '{$name}',
                    'status' => 'ok',
                ]);
            }
        }
        PHP;
    }

    private function webControllerStub(string $name): string
    {
        return <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Modules\\{$name}\Http\Controllers;

        use Illuminate\Routing\Controller;
        use Illuminate\View\View;

        final class {$name}Controller extends Controller
        {
            public function index(): View
            {
                return view('{$name}::index');
            }
        }
        PHP;
    }

    private function appendRoute(string $name, string $basePath, bool $isWeb): void
    {
        $route = $isWeb
            ? sprintf("Route::get('/%s', [\\App\\Modules\\%s\\Http\\Controllers\\%sController::class, 'index']);", $name, $name, $name)
            : sprintf("Route::get('/%s', [\\App\\Modules\\%s\\Http\\Controllers\\%sController::class, 'index']);", $name, $name, $name);

        File::append(
            $basePath . '/routes.php',
            PHP_EOL . $route . PHP_EOL,
        );
    }

    private function createConfigFile(string $name, string $basePath): void
    {
        $configName = mb_strtolower($name);

        File::put(
            sprintf('%s/Config/%s.php', $basePath, $configName),
            <<<PHP
            <?php

            declare(strict_types=1);

            return [

                /*
                |--------------------------------------------------------------------------
                | {$name} Module Configuration
                |--------------------------------------------------------------------------
                |
                | Configuration values for the {$name} module.
                |
                */

                'enabled' => true,

                /*
                |--------------------------------------------------------------------------
                | Database Driver Configurations
                |--------------------------------------------------------------------------
                |
                | Available database drivers
                |
                */

                'drivers' => [
                    'database' => [
                        'connection' => null,
                    ],
                ],

            ];
            PHP
        );
    }
}
