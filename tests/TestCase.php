<?php

namespace Chargefield\LaravelWidget\Tests;

use Illuminate\Support\Facades\File;
use Chargefield\LaravelWidget\WidgetParser;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Chargefield\LaravelWidget\WidgetServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');

        $this->loadLaravelMigrations();
    }

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

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Clean all widget files.
     *
     * @param \Chargefield\LaravelWidget\WidgetParser $parser
     * @return void
     */
    protected function cleanFiles(WidgetParser $parser)
    {
        if (File::exists($parser->getClassPath())) {
            File::delete($parser->getClassPath());
        }

        if (File::exists($parser->getViewPath())) {
            File::delete($parser->getViewPath());
        }
    }
}
