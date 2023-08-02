<?php

namespace App\Providers;

use App\Models\PurchaseOrder;
use App\Observers\PurchaseObserver;
use Illuminate\Support\ServiceProvider;

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
    }
}
