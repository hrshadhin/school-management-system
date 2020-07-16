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
            'instagram' => '',
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
            $siteInfo['logo'] = $info->logo ?? null;
            $siteInfo['logo2x'] = $info->logo2x ?? null;
            $siteInfo['favicon'] = $info->favicon ?? null;
            $siteInfo['facebook'] = $info->facebook;
            $siteInfo['instagram'] = $info->instagram;
            $siteInfo['twitter'] = $info->twitter;
            $siteInfo['youtube'] = $info->youtube;
        }


        $view->with('maintainer', 'CloudSchool');
        $view->with('maintainer_url', 'http://cloudschoolbd.com');
        $view->with('siteInfo', $siteInfo);
        $view->with('event', $upComingEvent);
        $view->with('GA_TRACKING_ID', $GA_TRACKING_ID);
    }
}