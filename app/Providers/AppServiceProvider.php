<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //user caching observer
        User::observe(UserObserver::class);

        //custom if query builder macro
        Builder::macro('if', function ($condition, $column, $operator, $value) {
            if ($condition) {
                return $this->where($column, $operator, $value);
            }

            return $this;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
