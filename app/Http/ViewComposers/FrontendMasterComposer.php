<?php

namespace App\Http\ViewComposers;
use App\Event;
use App\SiteMeta;
use Illuminate\Contracts\View\View;

class FrontendMasterComposer
{
    public function compose(View $view)
    {
        //for get request
        $address = SiteMeta::where('meta_key', 'contact_address')->first();
        $phone = SiteMeta::where('meta_key', 'contact_phone')->first();
        $email = SiteMeta::where('meta_key', 'contact_email')->first();
        $gaInfo = SiteMeta::where('meta_key', 'ga_tracking_id')->first();
        $GA_TRACKING_ID = null;
        if($gaInfo){
            $GA_TRACKING_ID = $gaInfo->meta_value;
        }
        $siteInfo = [
            'address' => $address->meta_value,
            'phone' => $phone->meta_value,
            'email' => $email->meta_value,
            'name' => '',
            'logo' => '',
            'logo2x' => '',
            'favicon' => '',
            'facebook' => '',
            'google' => '',
            'twitter' => '',
            'youtube' => '',
        ];
        $upComingEvent = Event::whereDate('event_time','>=', date('Y-m-d'))->orderBy('event_time','asc')->take(1)->first();
        $settings = SiteMeta::where('meta_key','settings')->first();
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


        /**
         * Acronyms generator of a phrase
         */
//         $siteInfo['short_name'] = preg_replace('~\b(\w)|.~', '$1', $siteInfo['name']);


        $view->with('maintainer', 'ShanixLab');
        $view->with('maintainer_url', 'http://shanixlab.com');
        $view->with('siteInfo', $siteInfo);
        $view->with('event', $upComingEvent);
        $view->with('GA_TRACKING_ID', $GA_TRACKING_ID);
    }
}