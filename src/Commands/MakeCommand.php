<?php

namespace Chargefield\LaravelWidget\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Chargefield\LaravelWidget\Facades\Widget;

class MakeCommand extends Command
{
    protected $parser;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'widget:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new widget class and view';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parser = Widget::parse($this->argument('name'));

        $class = $this->createClass();
        $view = $this->createView();

        ($class && $view) && $this->line("Widget created!\n");
        $class && $this->line("Class: {$class}\n");
        $view && $this->line("View: {$view}");

        return 0;
    }

    protected function createClass()
    {
        $classPath = $this->parser->getClassPath();

        if (File::exists($classPath)) {
            $this->warn('Widget class already exists!');

            return false;
        }

        $this->ensureDirectoryExists($classPath);

        File::put($classPath, $this->parser->getClassContents());

        return $classPath;
    }

    protected function createView()
    {
        $viewPath = $this->parser->getViewPath();

        if (File::exists($viewPath)) {
            $this->warn('Widget view already exists!');

            return false;
        }

        $this->ensureDirectoryExists($viewPath);

        File::put($viewPath, '');

        return $viewPath;
    }

    protected function ensureDirectoryExists($path)
    {
        if (! File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0777, $recursive = true, $force = true);
        }
    }
}
