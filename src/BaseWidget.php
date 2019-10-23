<?php

namespace Chargefield\LaravelWidget;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Illuminate\Support\Collection;
use Chargefield\LaravelWidget\Facades\Widget;

abstract class BaseWidget
{
    private $view_data = [];

    /**
     * Render view with public data.
     *
     * @param string $data
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return $this->view()->with($this->buildViewData());
    }

    /**
     * Set the view for render.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $parser = Widget::parse(static::class);

        return view($parser->getViewName());
    }

    /**
     * Merge given $data.
     *
     * @param array $data
     * @return \Chargefield\LaravelWidget\BaseWidget
     */
    public function with(array $data = [])
    {
        $this->view_data = $data;

        return $this;
    }

    /**
     * Build view data.
     *
     * @return array
     */
    protected function buildViewData()
    {
        $this->getProperties()->each(function ($property) {
            $this->view_data[$property->getName()] = $property->getValue($this);
        });

        $this->getMethods()->each(function ($method) {
            $name = $method->getName();
            $this->view_data[$name] = $this->$name();
        });

        return $this->view_data;
    }

    /**
     * Get class public properties.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getProperties()
    {
        return (new Collection((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC)))
            ->sortBy('name');
    }

    /**
     * Get filtered class public methods.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getMethods()
    {
        return (new Collection((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC)))
            ->filter(function ($method) {
                return ! in_array($method->getName(), ['with', 'view', 'render']) && ! $method->isConstructor();
            })
            ->sortBy('name');
    }
}
