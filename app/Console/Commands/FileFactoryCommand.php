<?php
namespace App\Console\Commands; 
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Illuminate\Console\Command;


abstract class FileFactoryCommand extends Command
{
    /**
     * Execute the console command.
     */
    protected $file;


    abstract function setStubName(): string;
    abstract function setFilePath(): string;
    abstract function setSuffix(): string;


    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    public function singleClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    public function makeDir($path)
    {
        $this->file->makeDirectory($path, 0777, true, true);
        return $path;
    }

    public function stubPath()
    {
        $stubName = $this->setStubName();
        return __DIR__ . "/../../../stubs/{$stubName}.stub";
    }

    public function stubVariables()
    {
        return [
            'NAME' => $this->singleClassName($this->argument('classname'))
        ];
    }

    public function stubContent($stubPath, $stubVariables)
    {
        $contents = file_get_contents($stubPath);
        foreach ($stubVariables as $search => $name) {
            $contents = str_replace('$' . $search, $name, $contents);
        }
        return $contents;
    }

    public function getPath()
    {
        $filePath = $this->setFilePath();
        $suffix = $this->setSuffix();
        return base_path($filePath) . $this->singleClassName($this->argument('classname')) . "{$suffix}.php";
    }

    public function handle()
    {
        $path = $this->getPath();
        $this->makeDir(dirname($path));
        if ($this->file->exists($path)) {
            $this->info("this file already exists");
        }
        $content = $this->stubContent($this->stubPath(), $this->stubVariables());
        $this->file->put($path, $content);
        $this->info('this file has been created');
    }
}
