<?php

namespace Chargefield\LaravelWidget;

use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/widget.php', 'widget');

        $this->app->singleton('chargefield.laravel.widget', function ($app) {
            return new Widget;
        });

        $this->commands([]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    /**
     * Register publishable assets.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/widget.php' => config_path('widget.php'),
        ], 'widget-config');
    }
}
