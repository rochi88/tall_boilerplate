<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeModuleServiceCommand extends Command
{
    protected $signature = 'make:module-service {module} {name}';

    protected $description = 'Create a service class inside a module';

    public function handle(): int
    {
        $module = ucfirst($this->argument('module'));
        $name = Str::studly($this->argument('name'));

        $basePath = app_path('Modules/' . $module);

        if (! File::isDirectory($basePath)) {
            $this->error(sprintf('Module [%s] does not exist.', $module));

            return self::FAILURE;
        }

        $servicePath = sprintf('%s/Services/%s.php', $basePath, $name);

        if (File::exists($servicePath)) {
            $this->error('Service already exists.');

            return self::FAILURE;
        }

        File::put($servicePath, $this->serviceStub($module, $name));

        $this->info(sprintf('Service [%s] created in module [%s].', $name, $module));

        return self::SUCCESS;
    }

    private function serviceStub(string $module, string $name): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Services;

final class {$name}
{
    public function execute(array \$data): mixed
    {
        // Business logic here

        return null;
    }
}
PHP;
    }
}
