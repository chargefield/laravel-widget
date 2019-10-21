<?php

namespace Chargefield\LaravelWidget\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Chargefield\LaravelWidget\WidgetServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            WidgetServiceProvider::class,
        ];
    }
}
