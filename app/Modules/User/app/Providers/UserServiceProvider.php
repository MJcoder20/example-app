<?php

namespace App\Modules\User\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    protected $namespaceApi = 'App\\Modules\\User\\App\\Http\\Controllers';
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->register(RouteServiceProvider::class);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $modulePath = base_path() . '/App/Modules/User';

        $this->publishes([
            $modulePath.'/config/config.php' => config_path('config.php'),
        ], 'config');

       
        Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespaceApi)
        ->group(base_path('App/Modules/User/routes/api.php'));

        Route::middleware('web')
            ->group(base_path('App/Modules/User/routes/web.php'));

    
        $this->loadRoutesFrom($modulePath . '/routes/web.php');
        // $this->loadRoutesFrom(__DIR__.'../../routes/web.php');
        $this->loadMigrationsFrom($modulePath .'/database/migrations');
        $this->loadViewsFrom($modulePath .'/resources/views', 'User');
    }

   
}
