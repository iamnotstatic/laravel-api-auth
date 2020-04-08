<?php

namespace Iamnotstatic\LaravelAPIAuth;

use Illuminate\Support\ServiceProvider;

class LaravelAPIAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__. '/routes/api.php');
        $this->loadViewsFrom(__DIR__. '/view', 'apiauth');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(
            __DIR__.'/config/apiauth.php', 'apiauth'
        );
        $this->publishes([
            __DIR__.'/config/apiauth.php' => config_path('apiauth.php'),
            __DIR__.'/Http/Controllers/Auth' => app_path('Http/Controllers/Auth')
        ]);
        
    }
}
