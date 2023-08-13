<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;


use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        // Passport::tokensCan([
        //     'view-posts' => 'View Posts',
        //     'view-users' => 'View Users',
        // ]);

        Passport::tokensExpireIn(now()->addDays(6));
        Passport::refreshTokensExpireIn(now()->addHours(5));
        Passport::personalAccessTokensExpireIn(now()->addHours(2));
    }
}
