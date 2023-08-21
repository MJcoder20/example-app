<?php

namespace App\Modules\User\App\Providers;

use App\Modules\User\App\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('config.php'),
        ], 'config');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'User');
    }

    // protected function registerConfig()
    // {
    //     $this->publishes([
    //         module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
    //     ], 'config');
    //     $this->mergeConfigFrom(
    //         module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
    //     );
    // }

    // public function registerViews()
    // {
    //     $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

    //     $sourcePath = module_path($this->moduleName, 'Resources/views');

    //     $this->publishes([
    //         $sourcePath => $viewPath
    //     ], ['views', $this->moduleNameLower . '-module-views']);

    //     $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    // }
}
