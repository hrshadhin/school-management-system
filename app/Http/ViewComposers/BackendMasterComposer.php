<?php

namespace App\Http\ViewComposers;

use App\Http\Helpers\AppHelper;
use Illuminate\Contracts\View\View;

class BackendMasterComposer
{
    public function compose(View $view)
    {

        // get app settings
        $appSettings = AppHelper::getAppSettings(null, true);

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


        $view->with('maintainer', 'CloudSchool');
        $view->with('maintainer_url', 'http://cloudschoolbd.com');
        $view->with('majorVersion', '3');
        $view->with('minorVersion', '0');
        $view->with('patchVersion', '1');
        $view->with('suffixVersion', 'ce');
        $view->with('appSettings', $appSettings);
        $view->with('languages', AppHelper::LANGUEAGES);
        $view->with('idc', 'f51d28b319e6729b462abf03856d26985137752d');
        $view->with('institute_category', AppHelper::getInstituteCategory());
    }
}
