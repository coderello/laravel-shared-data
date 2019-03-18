<?php

namespace Coderello\SharedData\Providers;

use Coderello\SharedData\SharedData;
use Illuminate\Support\ServiceProvider;

class SharedDataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/shared-data.php' => config_path('shared-data.php'),
        ], 'shared-data-config');
    }

    /**
     * Register any application services.
     *
     * @return void
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
}
