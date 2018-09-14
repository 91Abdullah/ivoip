<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("is-admin", function ($user) {
            return $user->isSuperAdmin();
        }); 

        Gate::define("is-agent", function ($user) {
            return $user->isAgent();
        }); 

        Gate::define("is-blended", function ($user) {
            return $user->isBlended();
        });

        Gate::define("is-outbound", function ($user) {
            return $user->isOutbound();
        });

        Gate::define("is-supervisor", function ($user) {
            return $user->isSupervisor();
        });
    }
}
