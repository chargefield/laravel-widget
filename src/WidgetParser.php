<?php

namespace Chargefield\LaravelWidget;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Chargefield\LaravelWidget\Facades\Widget;

class WidgetParser
{
    protected $class;
    protected $namespace;
    protected $stub;

    public function __construct(string $class, string $namespace)
    {
        $this->class = $class;
        $this->namespace = $namespace;
        $this->stub = __DIR__.DIRECTORY_SEPARATOR.'Stubs'.DIRECTORY_SEPARATOR.'Widget.stub';
    }

    /**
     * Set stub.
     *
     * @param string $path
     * @return \Chargefield\LaravelWidget\WidgetParser
     */
    public function setStub(string $path)
    {
        $this->stub = $path;

        return $this;
    }

    /**
     * Get view name.
     *
     * @return string
     */
    public function getViewName()
    {
        return $this->generateViewPath('.');
    }

    /**
     * Get view path.
     *
     * @return string
     */
    public function getViewPath()
    {
        $separator = DIRECTORY_SEPARATOR;

        return resource_path("views{$separator}{$this->generateViewPath()}.blade.php");
    }

    /**
     * Get full class name.
     *
     * @return string
     */
    public function getFullClassName()
    {
        return "{$this->namespace}\\{$this->class}";
    }

    /**
     * Get class path.
     *
     * @return string
     */
    public function getClassPath()
    {
        return "{$this->generateClassPath()}.php";
    }

    /**
     * Get widget class contents.
     *
     * @return string
     */
    public function getClassContents()
    {
        $template = file_get_contents($this->stub);

        $class_path = (new Collection(explode('\\', $this->class)))
            ->prepend($this->namespace);

        $class = $class_path->pop();

        $namespace = $class_path->implode('\\');

        return preg_replace_array(
            ['/\[namespace\]/', '/\[class\]/'],
            [$namespace, $class],
            $template
        );
    }

    /**
     * Generate view path.
     *
     * @param string $separator
     * @return string
     */
    protected function generateViewPath(string $separator = DIRECTORY_SEPARATOR)
    {
        $base = $this->getSanatizedPath(Widget::getRootView(), $separator);

        $namespace = $this->getSanatizedPath($this->namespace, $separator);

        $name = $this->getSanatizedPath($this->class, $separator);

        if (Str::startsWith($name, $namespace)) {
            $name = Str::substr($name, strlen($namespace) + 1);
        }

        return "{$base}{$separator}{$name}";
    }

    /**
     * Get sanatized path.
     *
     * @param string $path
     * @param string $separator
     * @return string
     */
    protected function getSanatizedPath(string $path, string $separator = DIRECTORY_SEPARATOR)
    {
        return (new Collection(explode('.', str_replace(['/', '\\'], '.', $path))))
            ->map([Str::class, 'kebab'])
            ->implode($separator);
    }

    /**
     * Generate path from namespace.
     *
     * @return string
     */
    protected function generateClassPath()
    {
        $name = Str::replaceFirst(App::getNamespace(), '', $this->namespace);

        return rtrim(app('path').'/'.str_replace('\\', '/', $name), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.rtrim(str_replace('\\', '/', $this->class), DIRECTORY_SEPARATOR);
    }
}
