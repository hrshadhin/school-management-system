<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\SiteMeta;
use App\Slider;
use App\AboutContent;
use App\AboutSlider;
use App\Testimonial;
use Validator;
use Illuminate\Http\Request;


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

    /**
     * subscriber  manage
     * @return mixed
     */
    public function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Emails is invalid!'
            ];

            return $response;
        }

        $subscriber = SiteMeta::create([
            'meta_key' => 'subscriber',
            'meta_value' => $request->get('email')
            ]);
        $response = [
            'success' => true,
            'message' => 'Thank your for subscribing us.'
        ];

        return $response;


    }
}
