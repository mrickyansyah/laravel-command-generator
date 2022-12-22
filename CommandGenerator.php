<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class CommandGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commnand:name {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * the stub file path
     * 
     * @var string
     */
    protected $stubFile;

    /**
     * the class namespace
     * 
     * @var string
     */
    protected $namespace;

    /**
     * the path of generate file
     * 
     * @var string
     */
    protected $pathGenerateFile;

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->stubFile) {
            $this->info('the stubFile property must be a value');
            return Command::FAILURE;
        }

        if (!$this->namespace) {
            $this->info('the namespace property must be a value');
            return Command::FAILURE;
        }

        if (!$this->pathGenerateFile) {
            $this->info('the pathGenerateFile property must be a value');
            return Command::FAILURE;
        }

        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        if (!$this->files->exists($path)) {
            $this->files->put($path, $this->getSourceFile());
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }

        return Command::SUCCESS;
    }

    /**
     * Return the stub file path
     * 
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . "/../stubs/{$this->stubFile}.stub";
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
    */
    public function getStubVariables()
    {
        return [
            'namespace' => $this->namespace, // exp: App\\Enums
            'class'     => $this->getSingularClassName($this->argument('name')),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);
        foreach ($stubVariables as $search => $replace){
            $contents = str_replace('{{ '.$search.' }}' , $replace, $contents);
        }

        return $contents;

    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path($this->pathGenerateFile) . '/' . $this->getSingularClassName($this->argument('name')) . '.php';
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true, true);
        }

        return $path;
    }
}
