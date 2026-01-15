<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeModuleCrudCommand extends Command
{
    protected $signature = 'make:module-crud {module} {entity}';

    protected $description = 'Create CRUD scaffolding for a module';

    public function handle(): int
    {
        $module = Str::studly($this->argument('module'));
        $entity = Str::studly($this->argument('entity'));

        $basePath = app_path('Modules/' . $module);

        if (! File::isDirectory($basePath)) {
            $this->error(sprintf('Module [%s] does not exist.', $module));

            return self::FAILURE;
        }

        $this->createAction($module, $entity, $basePath);
        $this->createService($module, $entity, $basePath);
        $this->createRepository($module, $entity, $basePath);
        $this->createController($module, $entity, $basePath);
        $this->registerRoutes($module, $entity, $basePath);

        $this->info(sprintf('CRUD for %s created in %s module.', $entity, $module));

        return self::SUCCESS;
    }

    private function createAction(string $module, string $entity, string $basePath): void
    {
        File::put(
            sprintf('%s/Actions/Create%s.php', $basePath, $entity),
            <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Actions;

use App\Modules\\{$module}\Services\\{$entity}Service;

final class Create{$entity}
{
    public function __construct(
        private readonly {$entity}Service \$service
    ) {}

    public function handle(array \$data): mixed
    {
        return \$this->service->create(\$data);
    }
}
PHP
        );
    }

    private function createService(string $module, string $entity, string $basePath): void
    {
        File::put(
            sprintf('%s/Services/%sService.php', $basePath, $entity),
            <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Services;

use App\Modules\\{$module}\Repositories\Contracts\\{$entity}RepositoryInterface;

final class {$entity}Service
{
    public function __construct(
        private readonly {$entity}RepositoryInterface \$repository
    ) {}

    public function create(array \$data): mixed
    {
        return \$this->repository->create(\$data);
    }
}
PHP
        );
    }

    private function createRepository(string $module, string $entity, string $basePath): void
    {
        File::put(
            sprintf('%s/Repositories/Contracts/%sRepositoryInterface.php', $basePath, $entity),
            <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Repositories\Contracts;

interface {$entity}RepositoryInterface
{
    public function create(array \$data): mixed;
}
PHP
        );

        File::put(
            sprintf('%s/Repositories/Eloquent/%sRepository.php', $basePath, $entity),
            <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Repositories\Eloquent;

use App\Modules\\{$module}\Repositories\Contracts\\{$entity}RepositoryInterface;

final class {$entity}Repository implements {$entity}RepositoryInterface
{
    public function create(array \$data): mixed
    {
        // Persist entity safely
        return \$data;
    }
}
PHP
        );
    }

    private function createController(string $module, string $entity, string $basePath): void
    {
        File::put(
            sprintf('%s/Http/Controllers/%sController.php', $basePath, $entity),
            <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Modules\\{$module}\Actions\Create{$entity};

final class {$entity}Controller extends Controller
{
    public function store(Create{$entity} \$action): JsonResponse
    {
        return response()->json(
            \$action->handle(request()->all())
        );
    }
}
PHP
        );
    }

    private function registerRoutes(string $module, string $entity, string $basePath): void
    {
        File::append(
            $basePath . '/routes.php',
            "\nRoute::post('/{$entity}', [\\App\\Modules\\{$module}\\Http\\Controllers\\{$entity}Controller::class, 'store']);\n",
        );
    }
}
