<?php

namespace Coderello\SharedData\Providers;

use Coderello\SharedData\SharedData;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class SharedDataServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap shared data service.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/shared-data.php' => config_path('shared-data.php'),
        ], 'shared-data-config');
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/shared-data.php',
            'shared-data'
        );

        $this->app->singleton(SharedData::class, function () {
            return new SharedData($this->app['config']['shared-data']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            SharedData::class,
        ];
    }
}
