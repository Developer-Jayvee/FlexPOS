<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utilities\Helpers;
use Illuminate\Contracts\Foundation\Application;

class UtilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Helpers::class , function(Application $app){
            return new Helpers();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
