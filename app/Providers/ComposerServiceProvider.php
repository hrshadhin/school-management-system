<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
            [
                'frontend.layouts.master',
                'frontend.contact_us'
            ],
            'App\Http\ViewComposers\FrontendMasterComposer'
        );
        View::composer(
            [
                'backend.layouts.master',
                'backend.layouts.front_master',
                'backend.partial.leftsidebar',
                'backend.user.login',
                'backend.user.forgot',
                'backend.user.reset',
                'backend.user.lock',
                'backend.settings.institute'
            ],
            'App\Http\ViewComposers\BackendMasterComposer'
        );
        View::composer(
                    [
                        'backend.report.layouts.master',
                        'backend.report.layouts.header',
                        'backend.report.layouts.footer',
                    ],
                    'App\Http\ViewComposers\ReportMasterComposer'
                );

        \view()->share('default_academic_year', Cache::get('default_academic_year', 0));
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
