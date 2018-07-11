<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\SiteMeta;
use App\Slider;
use App\AboutContent;
use App\AboutSlider;

class HomeController extends Controller
{
    public function home()
    {
        $sliders = Slider::orderBy('order','asc')->get()->take(10);

        $aboutContent = AboutContent::first();
        $aboutImages = AboutSlider::orderBy('order', 'asc')->get()->take(10);
        $ourService = SiteMeta::where('meta_key', 'our_service_text')->first();
        //for get request
        $statisticContent = SiteMeta::where('meta_key', 'statistic')->first();
        $statistic = null;
        if($statisticContent){
            $statistic = new \stdClass();
            $data = explode(',', $statisticContent->meta_value);
            $statistic->student = $data[0];
            $statistic->teacher = $data[1];
            $statistic->graduate = $data[2];
            $statistic->books = $data[3];
        }
        $testimonials = Testimonial::orderBy('order','asc')->get();

        return view('frontend.home', compact(
            'sliders',
            'aboutContent',
            'aboutImages',
            'ourService',
            'statistic',
            'testimonials'
        ));
    }
}
