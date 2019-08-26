<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rennokki\Larafy\Larafy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Rennokki\Larafy\Larafy', function ($app) {
            return new Larafy();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
