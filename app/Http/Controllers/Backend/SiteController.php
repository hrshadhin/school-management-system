<?php

namespace App\Http\Controllers\Backend;

use App\AboutContent;
use App\AboutSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Show site dashboard.
     *
     * @return Response
     */
    public function dashboard()
    {
        return view('backend.site.dashboard');
    }

    /**
     * About section content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function aboutContent(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'why_content' => 'required|min:5|max:500',
                'key_point_1_title' => 'required|min:5|max:100',
                'key_point_1_content' => 'required',
                'key_point_2_title' => 'max:100',
                'key_point_3_title' => 'max:100',
                'key_point_4_title' => 'max:100',
                'key_point_5_title' => 'max:100',
                'about_us' => 'required|min:50|max:500',
                'who_we_are' => 'required|min:100|max:1000',
                'intro_video_embed_code' => 'required',
                'video_site_link' => 'max:500',

            ]);

            //now crate or update model
           $content = AboutContent::updateOrCreate(
                ['id' => 1],
                $request->all()
            );
            return redirect()->route('site.about_content')->with('success', 'Contents saved!');
        }

        //for get request
        $content = AboutContent::first();
        $images = AboutSlider::orderBy('order', 'asc')->get()->take(10);
        return view('backend.site.home.about.content', compact('content', 'images'));
    }


    
}
