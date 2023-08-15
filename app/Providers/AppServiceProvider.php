<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use App\Models\PurchaseOrder;
use App\Observers\PurchaseObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use App\Models\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PurchaseOrder::observe(PurchaseObserver::class);
        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Response::macro('bEncode', function ($value) {
            return Response::make(base64_encode($value));
        });
    }
}
