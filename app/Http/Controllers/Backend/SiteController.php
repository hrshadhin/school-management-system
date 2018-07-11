<?php

namespace App\Http\Controllers\Backend;

use App\AboutContent;
use App\AboutSlider;
use App\SiteMeta;
use App\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
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
        $images = AboutSlider::orderBy('order', 'asc')->get();
        if(count($images)>10){
            Session::flash('warning','Don\'t add more than 10 image for better site performance!');
        }
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

    /**
     * service content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serviceContent(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'meta_value' => 'required|min:5|max:500'

            ]);

            //now crate or update model
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'our_service_text'],
                $request->all()
            );
            return redirect()->route('site.service')->with('success', 'Contents saved!');
        }

        //for get request
        $content = SiteMeta::where('meta_key', 'our_service_text')->first();
        return view('backend.site.home.service', compact('content'));
    }

    /**
     * service content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statisticContent(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'student' => 'required|numeric|min:1',
                'teacher' => 'required|numeric|min:1',
                'graduate' => 'required|numeric|min:1',
                'books' => 'required|numeric|min:1'

            ]);



            $values = $request->get('student').','.$request->get('teacher').','.$request->get('graduate').','.$request->get('books');



            //now crate or update model
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'statistic'],
                ['meta_value' => $values]
            );
            return redirect()->route('site.statistic')->with('success', 'Contents saved!');
        }

        //for get request
        $statistic = SiteMeta::where('meta_key', 'statistic')->first();
        $content = null;
        if($statistic){
            $content = new \stdClass();
            $data = explode(',', $statistic->meta_value);
            $content->student = $data[0];
            $content->teacher = $data[1];
            $content->graduate = $data[2];
            $content->books = $data[3];
        }

        return view('backend.site.home.statistic', compact('content'));
    }



    /**
     * testimonials  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testimonialIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'student' => 'required|numeric|min:1',
                'teacher' => 'required|numeric|min:1',
                'graduate' => 'required|numeric|min:1',
                'books' => 'required|numeric|min:1'

            ]);



            $values = $request->get('student').','.$request->get('teacher').','.$request->get('graduate').','.$request->get('books');



            //now crate or update model
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'statistic'],
                ['meta_value' => $values]
            );
            return redirect()->route('site.statistic')->with('success', 'Contents saved!');
        }

        //for get request
        $testimonials = Testimonial::all();


        return view('backend.site.home.testimonial.list', compact('testimonials'));
    }

    /**
     * testimonials  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testimonialCreate(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            $messages = [
                'photo.max' => 'The :attribute size must be under 2MB.',
                'photo.dimensions' => 'The :attribute dimensions must be minimum 94 X 94.',
            ];
            $this->validate($request, [
                'writer' => 'required|min:5|max:255',
                'comments' => 'required',
                'photo' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:min_width=94,min_height=94',


            ]);
            $data = $request->all();
            if($request->hasFile('photo')){
                $storagepath = $request->file('photo')->store('public/testimonials');
                $fileName = basename($storagepath);
                $data['photo'] = $fileName;

            }

            Testimonial::create($data);

            return redirect()->route('site.testimonial_create')->with('success', 'Testimonial added!');
        }

        //for get request
        $testimonials = Testimonial::all();


        return view('backend.site.home.testimonial.list', compact('testimonials'));
    }
    
}
