<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\PurchaseOrder;
use Illuminate\Support\Collection;
use App\Observers\PurchaseObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'test1',
            \App\Support\TestClass::class
        );
    
        $this->app->bind(
            'test2',
            \App\Support\TestClass::class
        );

 
       
        $this->app->bind(User::class, function ($app) {
            return new User();
        });
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PurchaseOrder::observe(PurchaseObserver::class);
        

        Response::macro('apiPaginate', function ($data, $status = 200, $headers = []) {
         
                $currentPage = $data->currentPage();
                $lastPage = $data->lastPage();

                $meta = [
                    'current_page' => $currentPage,
                    'last_page' => $lastPage,
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ];

                $links = [
                    'first' => $data->url(1),
                    'last' => $data->url($lastPage),
                    'prev' => ($currentPage > 1) ? $data->url($currentPage - 1) : null,
                    'next' => ($currentPage < $lastPage) ? $data->url($currentPage + 1) : null,
                ];
                return Response::json([
                    'data' => $data->items(),
                    'meta' => $meta,
                    'links' => $links,
                ], $status, $headers);
       
        });

        Response::macro('api', function($value, $status = 200, $headers = []){
            return Response::json(['data' => $value], $status, $headers);
        });


        Response::macro('msg', function (array $value) {
            return Response::make($value);
        });

    }
}
