<?php

namespace App\Http\Controllers\Backend;

use App\AboutContent;
use App\AboutSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Json;

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
        return view('backend.site.home.about.content', compact('content', 'images'));
    }

  /**
     * About section content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function aboutContentImage(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form
            $messages = [
                'image.max' => 'The :attribute size must be under 2MB.',
                'image.dimensions' => 'The :attribute dimensions must be minimum 570 X 380.',
            ];
            $this->validate($request, [
                'image' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=570,min_height=380',
            ]);

            $storagepath = $request->file('image')->store('public/about');
            $fileName = basename($storagepath);

            $data = $request->all();
            $data['image'] = $fileName;
            AboutSlider::create($data);

            return redirect()->route('site.about_content_image')->with('success', 'Image uploaded');
        }

        //for get request
        $images = AboutSlider::orderBy('order', 'asc')->get()->take(10);
        return view('backend.site.home.about.image', compact('images'));
    }

    /**
     * About section content image delete
     * @return array
     */
    public function aboutContentImageDelete($id)
    {

        $image = AboutSlider::findOrFail($id);
        Storage::delete('/public/about/' . $image->image);
        $image->delete();

        return [
            'success' => true,
            'message' => 'Image deleted!'
        ];
    }


    
}
