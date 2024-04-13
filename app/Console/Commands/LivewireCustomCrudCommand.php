<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class LivewireCustomCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud
    {nameOfTheClass? : The name of the class.},
    {nameOfTheModelClass? : The name of the model class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a custom livewire CRUD';

    /**
     * Our custom class properties here!
     */
    protected $nameOfTheClass;

    protected $nameOfTheModelClass;

    protected $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Gathers all parameters
        $this->gatherParameters();

        if(!empty($this->nameOfTheClass) && !empty($this->nameOfTheModelClass)) {
            // Generates the Livewire Class File
            $this->generateLivewireCrudClassfile();

            // Generates the Livewire View File
            $this->generateLivewireCrudViewFile();
        }        
    }

    /**
     * Gather all necessary parameters.
     *
     * @return void
     */
    protected function gatherParameters()
    {
        $this->nameOfTheClass = $this->argument('nameOfTheClass');
        $this->nameOfTheModelClass = $this->argument('nameOfTheModelClass');

        // If you didn't input the name of the class
        if (empty($this->nameOfTheClass) || is_null($this->nameOfTheClass)) {
            $this->nameOfTheClass = $this->ask('Enter class name');
        }
        
        if (!empty($this->nameOfTheClass) && $this->isReservedClassName($name = $this->nameOfTheClass)) {
            $this->comment('WHOOPS! 😳, Class name is reserved');
            $this->nameOfTheClass = $this->ask('Enter class name');
        }

        // If you didn't input the name of the class
        if (empty($this->nameOfTheModelClass) || is_null($this->nameOfTheModelClass)) {
            $this->nameOfTheModelClass = $this->ask('Enter model name');
        }

        if (!empty($this->nameOfTheModelClass) && $this->isReservedClassName($name = $this->nameOfTheModelClass)) {
            $this->comment('WHOOPS! 😳, Class name is reserved');
            $this->nameOfTheClass = $this->ask('Enter class name');
        }

        // Convert to studly case
        $this->nameOfTheClass = Str::studly($this->nameOfTheClass);
        $this->nameOfTheModelClass = Str::studly($this->nameOfTheModelClass);
    }

    /**
     * Generates the CRUD class file.
     *
     * @return void
     */
    protected function generateLivewireCrudClassfile()
    {
        // Set the origin and destination for the livewire class file
        $fileOrigin = base_path('/stubs/livewire-crud/custom.livewire.crud.stub');
        $fileDestination = base_path('/app/Livewire/' . $this->nameOfTheClass . '.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This class file already exists: ' . $this->nameOfTheClass . '.php');
            $this->info('Aborting class file creation.');

            return false;
        }

        // Get the original string content of the file
        $fileOriginalString = $this->file->get($fileOrigin);

        // Replace the strings specified in the array sequentially
        $replaceFileOriginalString = Str::replaceArray(
            '{{}}',
            [
                $this->nameOfTheModelClass, // Name of the model class
                $this->nameOfTheClass, // Name of the class
                $this->nameOfTheModelClass, // Name of the model class
                $this->nameOfTheModelClass, // Name of the model class
                $this->nameOfTheModelClass, // Name of the model class
                $this->nameOfTheModelClass, // Name of the model class
                $this->nameOfTheModelClass, // Name of the model class
                Str::kebab($this->nameOfTheClass), // From "FooBar" to "foo-bar"
            ],
            $fileOriginalString,
        );

        // Put the content into the destination directory
        $this->file->put($fileDestination, $replaceFileOriginalString);
        $this->info('Livewire class file created: ' . $fileDestination);
    }

    /**
     * generateLivewireCrudViewFile.
     *
     * @return void
     */
    protected function generateLivewireCrudViewFile()
    {
        // Set the origin and destination for the livewire class file
        $fileOrigin = base_path('/stubs/livewire-crud/custom.livewire.crud.view.stub');
        $fileDestination = base_path('/resources/views/livewire/' . Str::kebab($this->nameOfTheClass) . '.blade.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This view file already exists: ' . Str::kebab($this->nameOfTheClass) . '.php');
            $this->info('Aborting view file creation.');

            return false;
        }

        // Copy file to destination
        $this->file->copy($fileOrigin, $fileDestination);
        $this->info('Livewire view file created: ' . $fileDestination);
    }

    public function isReservedClassName($name)
    {
        return array_search(strtolower($name), $this->getReservedName()) !== false;
    }

    private function getReservedName()
    {
        return [
            'parent',
            'component',
            'interface',
            '__halt_compiler',
            'abstract',
            'and',
            'array',
            'as',
            'break',
            'callable',
            'case',
            'catch',
            'class',
            'clone',
            'const',
            'continue',
            'declare',
            'default',
            'die',
            'do',
            'echo',
            'else',
            'elseif',
            'empty',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'eval',
            'exit',
            'extends',
            'final',
            'finally',
            'fn',
            'for',
            'foreach',
            'function',
            'global',
            'goto',
            'if',
            'implements',
            'include',
            'include_once',
            'instanceof',
            'insteadof',
            'interface',
            'isset',
            'list',
            'namespace',
            'new',
            'or',
            'print',
            'private',
            'protected',
            'public',
            'require',
            'require_once',
            'return',
            'static',
            'switch',
            'throw',
            'trait',
            'try',
            'unset',
            'use',
            'var',
            'while',
            'xor',
            'yield',
        ];
    }
}
