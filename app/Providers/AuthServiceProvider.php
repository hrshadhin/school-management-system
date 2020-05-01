<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Gate;
//use App\Providers\CacheUserProvider;
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

        //

        // Caching user
        Auth::provider('cache-user', function() {
            return resolve(CacheUserProvider::class);
        });
    }
}
