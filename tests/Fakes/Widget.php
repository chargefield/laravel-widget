<?php

namespace Chargefield\LaravelWidget\Tests\Fakes;

use Chargefield\LaravelWidget\WidgetParser;
use Chargefield\LaravelWidget\Widget as BaseWidget;

class Widget extends BaseWidget
{
    /**
     * Parse widget from given $class.
     *
     * @param string $class
     * @return \Chargefield\LaravelWidget\WidgetParser
     */
    public function parse(string $class)
    {
        return (new WidgetParser('UsersWidget', 'App\\Http\\Widgets'))
            ->setStub(__DIR__.'/../../src/Stubs/UsersWidget.stub');
    }
}
