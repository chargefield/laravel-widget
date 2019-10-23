<?php

namespace Chargefield\LaravelWidget;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Chargefield\LaravelWidget\Facades\Widget;

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
            return new \Chargefield\LaravelWidget\Widget;
        });

        $this->commands([
            \Chargefield\LaravelWidget\Commands\MakeCommand::class,
            \Chargefield\LaravelWidget\Commands\MakeWidgetCommand::class,
        ]);
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

        Blade::directive('widget', function ($expression) {
            $params = (new Collection(explode(',', $expression)))
                ->map(function ($param) {
                    return trim(trim($param, "'"));
                })
                ->take(2);

            $parser = Widget::parse($params->first());

            $data = $params->count() === 2 ? $params->last() : '[]';

            return "<?= resolve('{$parser->getFullClassName()}')->with({$data})->render(); ?>";
        });
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
