<?php

namespace Ikbal\WisePayment;

use Illuminate\Support\ServiceProvider;

class WiseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/wise.php', 'wise');

        $this->app->singleton('wise', function () {
            return new WiseService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/wise.php' => config_path('wise.php'),
        ], 'config');
    }
}