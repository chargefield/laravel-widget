<?php

namespace Chargefield\LaravelWidget\Facades;

use Illuminate\Support\Facades\Facade;
use Chargefield\LaravelWidget\Tests\Fakes\Widget as TestWidget;

/**
 * @method static string getRootNamespace()
 * @method static string getRootView()
 * @method static \Chargefield\LaravelWidget\WidgetParser parse(string $class)
 *
 * @see \Chargefield\LaravelWidget\Widget
 * @see \Chargefield\LaravelWidget\Tests\Fakes\Widget
 */
class Widget extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return \Chargefield\LaravelWidget\Tests\Fakes\Widget
     */
    public static function fake()
    {
        static::swap($fake = new TestWidget());

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chargefield.laravel.widget';
    }
}
