<?php

namespace App\Http\ViewComposers;
use App\Http\Helpers\AppHelper;
use Illuminate\Contracts\View\View;

class BackendMasterComposer
{
    public function compose(View $view)
    {

        // get app settings
        $appSettings = AppHelper::getAppSettings();

        $view->with('frontend_website', 1);
        $view->with('show_language', 1);
        if (!isset($appSettings['frontend_website']) or $appSettings['frontend_website'] == '0') {
            $view->with('frontend_website', 0);
        }
        if (!isset($appSettings['disable_language']) or $appSettings['disable_language'] == '1') {
            $view->with('show_language', 0);
        }

        $view->with('locale', 'en');
        if (isset($appSettings['language']) && $appSettings['language'] != '') {
            $view->with('locale', $appSettings['language']);
        }


        $view->with('maintainer', 'ShanixLab');
        $view->with('maintainer_url', 'http://shanixlab.com');
        $view->with('appSettings', $appSettings);
        $view->with('languages', AppHelper::LANGUEAGES);
        $view->with('idc', '36237fc442afd31e37c0acab35ad6b19d96c232a');
        $view->with('institute_category', AppHelper::getInstituteCategory());
    }
}