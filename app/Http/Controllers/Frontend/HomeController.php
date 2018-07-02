<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Slider;

class HomeController extends Controller
{
    public function home()
    {
        $sliders = Slider::get()->take(10);
        return view('frontend.home', compact('sliders'));
    }
}
