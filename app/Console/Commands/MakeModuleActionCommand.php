<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeModuleActionCommand extends Command
{
    protected $signature = 'make:module-action {module} {name}';

    protected $description = 'Create an action class inside a module';

    public function handle(): int
    {
        $module = ucfirst($this->argument('module'));
        $name = Str::studly($this->argument('name'));

        $basePath = app_path('Modules/' . $module);

        if (! File::isDirectory($basePath)) {
            $this->error(sprintf('Module [%s] does not exist.', $module));

            return self::FAILURE;
        }

        $actionPath = sprintf('%s/Actions/%s.php', $basePath, $name);

        if (File::exists($actionPath)) {
            $this->error('Action already exists.');

            return self::FAILURE;
        }

        File::put($actionPath, $this->actionStub($module, $name));

        $this->info(sprintf('Action [%s] created in module [%s].', $name, $module));

        return self::SUCCESS;
    }

    private function actionStub(string $module, string $name): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace App\Modules\\{$module}\Actions;

final class {$name}
{
    public function handle(array \$payload): mixed
    {
        // Single-purpose use case logic

        return null;
    }
}
PHP;
    }
}
