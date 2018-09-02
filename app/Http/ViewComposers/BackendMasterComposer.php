<?php

namespace App\Http\ViewComposers;
use App\Event;
use App\Http\Helpers\AppHelper;
use App\SiteMeta;
use Illuminate\Contracts\View\View;

class BackendMasterComposer
{
    public function compose(View $view)
    {
        $languages = AppHelper::LANGUEAGES;
        $locale = 'en';

        $siteInfo = [
            'name' => '',
            'short_name' => '',
            'logo' => '',
            'logo2x' => '',
            'favicon' => '',
            'facebook' => '',
            'google' => '',
            'twitter' => '',
            'youtube' => '',
        ];
        $settings = AppHelper::getWebsiteSettings();
        $info = null;
        if($settings){
            $info = json_decode($settings->meta_value);
            $siteInfo['name'] = $info->name;
            $siteInfo['short_name'] = $info->short_name;
            $siteInfo['logo'] = $info->logo;
            $siteInfo['logo2x'] = $info->logo2x;
            $siteInfo['favicon'] = $info->favicon;
            $siteInfo['facebook'] = $info->facebook;
            $siteInfo['google'] = $info->google;
            $siteInfo['twitter'] = $info->twitter;
            $siteInfo['youtube'] = $info->youtube;
        }

        // get app settings
        $appSettings = AppHelper::getAppSettings();

        $view->with('frontend_website', 1);
        if (!isset($appSettings['frontend_website']) or $appSettings['frontend_website'] == 0) {
            $view->with('frontend_website', 0);
        }


        $view->with('maintainer', 'ShanixLab');
        $view->with('maintainer_url', 'http://shanixlab.com');
        $view->with('siteInfo', $siteInfo);
        $view->with('languages', $languages);
        $view->with('locale', $locale);
        $view->with('idc', 'fa63573e454f8fd86fe6a2c49eb60a1d2691b8fe');
    }
}