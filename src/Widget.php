<?php

namespace Chargefield\LaravelWidget;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class Widget
{
    protected $root_namespace;
    protected $root_view_path;

    public function __construct()
    {
        $this->root_namespace = Config::get('widget.class_namespace', 'App\\Http\\Widgets');
        $this->root_view_path = Config::get('widget.root_view_path', 'widgets');
    }

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return $this->root_namespace;
    }

    /**
     * Get root view.
     *
     * @return string
     */
    public function getRootView()
    {
        $path = $this->root_view_path;

        if (Str::startsWith($path, 'views')) {
            $path = Str::substr($path, strlen('views') + 1);
        }

        return trim($path, '/');
    }

    /**
     * Parse widget from given $class.
     *
     * @param string $class
     * @return \Chargefield\LaravelWidget\WidgetParser
     */
    public function parse(string $class)
    {
        return new WidgetParser($class, $this->root_namespace);
    }
}
