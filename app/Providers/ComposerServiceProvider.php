<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'frontend.layouts.master', 'App\Http\ViewComposers\FrontendMasterComposer'
        );
        View::composer(
            [
                'backend.layouts.master',
                'backend.layouts.front_master',
                'backend.user.login',
                'backend.user.forgot',
                'backend.user.reset',
                'backend.user.lock'
            ],
            'App\Http\ViewComposers\BackendMasterComposer'
        );



    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
