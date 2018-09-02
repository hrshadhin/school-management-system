<?php

namespace App\Http\ViewComposers;
use App\Event;
use App\Http\Helpers\AppHelper;
use App\SiteMeta;
use Illuminate\Contracts\View\View;

class FrontendMasterComposer
{
    public function compose(View $view)
    {
        //get site meta values
        $metas = AppHelper::getSiteMetas();

        $GA_TRACKING_ID = isset($metas['ga_tracking_id']) ? $metas['ga_tracking_id'] : null;

        $siteInfo = [
            'address' => isset($metas['contact_address']) ? $metas['contact_address'] : '',
            'phone' => isset($metas['contact_phone']) ? $metas['contact_phone'] : '',
            'email' => isset($metas['contact_email']) ? $metas['contact_email'] : '',
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
        $upComingEvent = AppHelper::getUpcommingEvent();
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


        $view->with('maintainer', 'ShanixLab');
        $view->with('maintainer_url', 'http://shanixlab.com');
        $view->with('siteInfo', $siteInfo);
        $view->with('event', $upComingEvent);
        $view->with('GA_TRACKING_ID', $GA_TRACKING_ID);
    }
}