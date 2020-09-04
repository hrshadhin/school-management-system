<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\AboutContent;
use App\AboutSlider;
use App\Event;
use App\SiteMeta;
use App\Testimonial;
use App\Http\Helpers\AppHelper;



class SiteController extends Controller
{
    /**
     * Show site dashboard.
     *
     * @return Response
     */
    public function dashboard()
    {

        $gaInfo = SiteMeta::where('meta_key', 'ga_key_file')->first();
        $KEY_FILE_LOCATION = null;
        if($gaInfo){
            $KEY_FILE_LOCATION = storage_path('app/secrets/'.$gaInfo->meta_value);
        }
        $googleToken = AppHelper::getGoogleAccessToken($KEY_FILE_LOCATION);

        $subscribers = SiteMeta::where('meta_key', 'subscriber')->count();
        $photos = SiteMeta::where('meta_key', 'gallery')->count();
        $events = Event::count();
        $gaInfo = SiteMeta::where('meta_key', 'ga_id')->first();
        $gaId = null;
        if($gaInfo){
            $gaId = $gaInfo->meta_value;
        }


        return view('backend.site.dashboard', compact(
            'subscribers',
            'photos',
            'events',
            'googleToken',
            'gaId'
        ));
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
        return view('backend.site.home.about.content', compact('content'));
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
                'hiddenId' => 'required|integer',

            ]);

            $test = Testimonial::findOrFail($request->get('hiddenId'));
            $test->delete();


            return redirect()->route('site.testimonial')->with('success', 'Contents deleted!');
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
                'photo' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=94,min_height=94',


            ]);
            $data = $request->all();
            if($request->hasFile('photo')){
                $storagepath = $request->file('photo')->store('public/testimonials');
                $fileName = basename($storagepath);
                $data['avatar'] = $fileName;

            }

            Testimonial::create($data);

            return redirect()->route('site.testimonial_create')->with('success', 'Testimonial added!');
        }

        //for get request
        $testimonials = Testimonial::all();


        return view('backend.site.home.testimonial.add', compact('testimonials'));
    }

    /**
     * subscriber  manage
     * @return mixed
     */
    public function subscribe(Request $request)
    {
        //for get request
        $subscribers = SiteMeta::where('meta_key', 'subscriber')->get();
        return view('backend.site.home.subscribers', compact('subscribers'));
    }


    /**
     * About gallery content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gallery()
    {


        //for get request
        $images = SiteMeta::where('meta_key','gallery')->paginate(env('MAX_RECORD_PER_PAGE',25));

        return view('backend.site.gallery.content', compact('images'));
    }
    /**
     * About gallery content add
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function galleryAdd(Request $request)
    {

        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form
            $messages = [
                'image.max' => 'The :attribute size must be under 2MB.',
            ];
            $this->validate($request, [
                'image' => 'mimes:jpeg,jpg,png|max:2048',
            ]);

            $storagepath = $request->file('image')->store('public/gallery');
            $fileName = basename($storagepath);

            //now crate
            SiteMeta::create(
                [
                    'meta_key' => 'gallery',
                    'meta_value' => $fileName
                ]
            );

            return redirect()->route('site.gallery_image')->with('success', 'Image uploaded');
        }

        return view('backend.site.gallery.image');
    }

    /**
     * About gallery content image delete
     * @return array
     */
    public function galleryDelete($id)
    {

        $image = SiteMeta::findOrFail($id);
        Storage::delete('/public/gallery/' . $image->meta_value);
        $image->delete();

        return [
            'success' => true,
            'message' => 'Image deleted!'
        ];
    }


    /**
     * contact us manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactUs(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'address' => 'required|min:5|max:500',
                'phone_no' => 'required|min:5|max:500',
                'email' => 'required|email|min:5|max:500',
                'latlong' => 'required|min:5|max:500',

            ]);

            //now crate or update model
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'contact_address'],
                [ 'meta_value' => $request->get('address')]
            );
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'contact_phone'],
                [ 'meta_value' => $request->get('phone_no')]
            );
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'contact_email'],
                [ 'meta_value' => $request->get('email')]
            );
            $content = SiteMeta::updateOrCreate(
                ['meta_key' => 'contact_latlong'],
                [ 'meta_value' => $request->get('latlong')]
            );

            Cache::forget('site_metas');

            return redirect()->route('site.contact_us')->with('success', 'Information saved!');
        }

        //for get request
        $address = SiteMeta::where('meta_key', 'contact_address')->first();
        $phone = SiteMeta::where('meta_key', 'contact_phone')->first();
        $email = SiteMeta::where('meta_key', 'contact_email')->first();
        $latlong = SiteMeta::where('meta_key', 'contact_latlong')->first();
        return view('backend.site.contact_us', compact('address', 'phone', 'email', 'latlong'));
    }

    /**
     * fqa section content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form
            $this->validate($request, [
                'question' => 'required|min:5|max:255',
                'answer' => 'required|min:5',
            ]);

            $data = [
                'q' => $request->get('question'),
                'a' => $request->get('answer')
            ];
            //now crate
            SiteMeta::create(
                [
                    'meta_key' => 'faq',
                    'meta_value' => json_encode($data)
                ]
            );
            return redirect()->route('site.faq')->with('success', 'Record added!');
        }

        //for get request
        //for get request
        $faqs = SiteMeta::where('meta_key','faq')->paginate(env('MAX_RECORD_PER_PAGE',25));
        return view('backend.site.faq', compact('faqs'));
    }

    /**
     * Faq section content image delete
     * @return array
     */
    public function faqDelete($id)
    {

        $faq = SiteMeta::findOrFail($id);
        $faq->delete();

        return redirect()->route('site.faq')->with('success', 'Record Deleted!');
    }

    /**
     * timeline section content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timeline(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form
            $this->validate($request, [
                'title' => 'required|min:5|max:255',
                'description' => 'required|min:5|max:500',
                'year' => 'required|min:4|max:4',
            ]);

            $data = [
                't' => $request->get('title'),
                'd' => $request->get('description'),
                'y' => $request->get('year')
            ];
            //now crate
            SiteMeta::create(
                [
                    'meta_key' => 'timeline',
                    'meta_value' => json_encode($data)
                ]
            );
            return redirect()->route('site.timeline')->with('success', 'Record added!');
        }

        //for get request
        $timeline = SiteMeta::where('meta_key','timeline')->get();
        return view('backend.site.timeline', compact('timeline'));
    }

    /**
     * timeline section content image delete
     * @return array
     */
    public function timelineDelete($id)
    {

        $timeline = SiteMeta::findOrFail($id);
        $timeline->delete();

        return redirect()->route('site.timeline')->with('success', 'Record Deleted!');
    }


    /**
     * setting section content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form
            $messages = [
                'logo.max' => 'The :attribute size must be under 1MB.',
                'logo.dimensions' => 'The :attribute dimensions must be 82 X 72.',
                'logo2x.max' => 'The :attribute size must be under 1MB.',
                'logo2x.dimensions' => 'The :attribute dimensions must be 162 X 142.',
                'favicon.max' => 'The :attribute size must be under 1MB.',
                'favicon.dimensions' => 'The :attribute dimensions must be 32 X 32.',
            ];
            $this->validate($request, [
                'name' => 'required|min:5|max:255',
                'short_name' => 'required|min:3|max:255',
                'logo' => 'nullable|mimes:jpeg,jpg,png|max:1024|dimensions:min_width=82,min_height=72,max_width=82,max_height=72',
                'logo2x' => 'nullable|mimes:jpeg,jpg,png|max:1024|dimensions:min_width=162,min_height=142,max_width=162,max_height=142',
                'favicon' => 'nullable|mimes:png|max:512|dimensions:min_width=32,min_height=32,max_width=32,max_height=32',
                'facebook' => 'max:255',
                'instagram' => 'max:255',
                'twitter' => 'max:255',
                'youtube' => 'max:255',
            ]);

            if($request->hasFile('logo')) {
                $storagepath = $request->file('logo')->store('public/site');
                $fileName = basename($storagepath);
                $data['logo'] = $fileName;
            }

            if($request->hasFile('logo2x')) {
                $storagepath = $request->file('logo2x')->store('public/site');
                $fileName = basename($storagepath);
                $data['logo2x'] = $fileName;
            }

            if($request->hasFile('favicon')) {
                $storagepath = $request->file('favicon')->store('public/site');
                $fileName = basename($storagepath);
                $data['favicon'] = $fileName;
            }

            $data['name'] = $request->get('name');
            $data['short_name'] = $request->get('short_name');
            $data['facebook'] = $request->get('facebook');
            $data['instagram'] = $request->get('instagram');
            $data['twitter'] = $request->get('twitter');
            $data['youtube'] = $request->get('youtube');

            //now crate
            SiteMeta::updateOrCreate(
                ['meta_key' => 'settings'],
                ['meta_value' => json_encode($data)]
            );
            Cache::forget('website_settings');
            return redirect()->route('site.settings')->with('success', 'Record updated!');
        }

        //for get request
        $settings = SiteMeta::where('meta_key','settings')->first();
        $info = null;
        if($settings){
            $info = json_decode($settings->meta_value);
        }

        return view('backend.site.settings', compact('info'));
    }

    /**
     * Google Analytics section content manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function analytics(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form
            $this->validate($request, [
                'ga_tracking_id' => 'required|max:255',
                'ga_report_id' => 'required|max:255',
                'ga_key_file' => 'required|file|mimetypes:text/plain',
            ]);


            $storagepath = $request->file('ga_key_file')->storeAs('secrets', 'ga_key_file.json');
            $fileName = basename($storagepath);

            //now crate
            SiteMeta::updateOrCreate(
                ['meta_key' => 'ga_key_file'],
                ['meta_value' => $fileName]
            );
            SiteMeta::updateOrCreate(
                ['meta_key' => 'ga_tracking_id'],
                ['meta_value' => $request->get('ga_tracking_id')]
            );
            SiteMeta::updateOrCreate(
                ['meta_key' => 'ga_id'],
                ['meta_value' => $request->get('ga_report_id')]
            );

            return redirect()->route('site.analytics')->with('success', 'Record updated!');
        }

        //for get request
        $info = new \stdClass();
        $info->key_file = null;
        $info->ga_id = null;
        $info->ga_tracking_id = null;

        $gaInfo = SiteMeta::where('meta_key', 'ga_key_file')->first();
        if($gaInfo){
            $info->key_file = $gaInfo->meta_value;
        }
        $gaInfo = SiteMeta::where('meta_key', 'ga_id')->first();
        if($gaInfo){
            $info->ga_id = $gaInfo->meta_value;
        }
        $gaInfo = SiteMeta::where('meta_key', 'ga_tracking_id')->first();
        if($gaInfo){
            $info->ga_tracking_id = $gaInfo->meta_value;
        }

        return view('backend.site.analytics', compact('info'));
    }


}
