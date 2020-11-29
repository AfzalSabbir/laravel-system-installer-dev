<?php

namespace AfzalSabbir\SystemInstaller;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SystemInstallerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/SystemInstaller.php', 'SystemInstaller');

        $this->publishConfig();

        $this->loadViewsFrom(__DIR__.'/resources/views', 'SystemInstaller');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    /**
    * Get route group configuration array.
    *
    * @return array
    */
    private function routeConfiguration()
    {
        return [
            'namespace'  => "AfzalSabbir\SystemInstaller\Http\Controllers",
            'middleware' => 'web',
            'prefix'     => 'system-installer'
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register facade
        $this->app->singleton('system-installer', function () {
            return new SystemInstaller;
        });
    }

    /**
     * Publish Config
     *
     * @return void
     */
    public function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/SystemInstaller.php' => config_path('SystemInstaller.php'),
            ], 'config');
        }
    }
}
