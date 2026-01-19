<?php

namespace Modules\User\App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    protected $namespaceApi = 'Modules\\User\\App\\Http\\Controllers';
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
    public function boot(Router $router)
    {
        $modulePath = base_path() . '/Modules/User';

        $this->publishes([
            $modulePath.'/config/config.php' => config_path('config.php'),
        ], 'config');
        // $this->publishes([
        //     $modulePath. '/Resources/Assets' => public_path('Modules/User'),
        // ], 'assets'); // The 'assets' group name is a common convention
        $this->publishes([
            module_path('User', 'Resources/assets') => public_path('modules/user'),
        ], 'user-assets');
    

        Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespaceApi)
        ->group(base_path('/Modules/User/routes/api.php'));

        Route::middleware('web')
            ->group(base_path('/Modules/User/routes/web.php'));

        $this->loadRoutesFrom($modulePath . '/routes/web.php');
        // $this->loadRoutesFrom(__DIR__.'../../routes/web.php');
        $this->loadMigrationsFrom($modulePath .'/database/migrations');
        $this->loadViewsFrom($modulePath .'/resources/views', 'User');

        // $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
        // $kernel->pushMiddleware('\App\Modules\User\App\Http\Middleware\Admin');
        $router->aliasMiddleware('Admin', \Modules\User\App\Http\Middleware\Admin::class);

    }

   
}
