<?php

namespace App\Http\Controllers\Frontend;

use App\ClassProfile;
use App\Event;
use App\Http\Controllers\Controller;
use App\SiteMeta;
use App\Slider;
use App\AboutContent;
use App\AboutSlider;
use App\TeacherProfile;
use App\Testimonial;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



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

    /* subscriber  manage
     * @return mixed
     */
    public function classProfile()
    {

        $profiles = ClassProfile::all();

        return view('frontend.class', compact('profiles'));

    }
    /* subscriber  manage
     * @return mixed
     */
    public function classDetails($name)
    {

        $profile = ClassProfile::where('slug',$name)->first();

        if(! $profile){
            aboart(404);
        }

        return view('frontend.class_details', compact('profile'));

    }

    /* Teacher  manage
     * @return mixed
     */
    public function teacherProfile()
    {

        $profiles = TeacherProfile::paginate(env('MAX_RECORD_PER_PAGE_FRONT',10));

        return view('frontend.teacher', compact('profiles'));

    }

    /* Event  manage
     * @return mixed
     */
    public function event()
    {

        $events = Event::paginate(env('MAX_RECORD_PER_PAGE_FRONT',10));

        return view('frontend.event', compact('events'));

    }
    /* Event  manage
     * @return mixed
     */
    public function eventDetails($slug)
    {

        $event = Event::where('slug',$slug)->first();
        if(!$event){
            abort(404);
        }

        return view('frontend.event_details', compact('event'));

    }
    /* Gallery
     * @return mixed
     */
    public function gallery()
    {
        //for get request
        $images = SiteMeta::where('meta_key','gallery')->paginate(env('MAX_RECORD_PER_PAGE_FRONT',10));
        return view('frontend.gallery', compact('images'));

    }

    /* Contact Us
     * @return mixed
     */
    public function contactUs(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'name' => 'required|min:2|max:255',
                'message' => 'required|min:5|max:500',
            ]);

            if ($validator->fails()) {
                $response = [
                    'info' => 'error',
                    'message' => 'Input is invalid! Check it again!'
                ];

                return response()->json($response);
            }

            //now send mail
            $data = [
                'from' =>  $request->get('email'),
                'to'  => env('MAIL_RECEIVER','info@cloudschoolbd.com'),
                'subject' => "[".$request->get('name')."]".$request->get('subject'),
                'body' => $request->get('message')
            ];

          Mail::send(array(), array(), function ($message) use ($data) {
                $message->to($data['to'])
                ->subject($data['subject'])
                ->from($data['from'])
                ->setBody($data['body']);
            });

            $response = [
                'info' => 'success',
                'message' => 'Mail delivered to receiver. Will contact you soon.'
            ];

            return response()->json($response);


        }
        //for get request
        $address = SiteMeta::where('meta_key', 'contact_address')->first();
        $phone = SiteMeta::where('meta_key', 'contact_phone')->first();
        $email = SiteMeta::where('meta_key', 'contact_email')->first();
        $latlong = SiteMeta::where('meta_key', 'contact_latlong')->first();
        return view('frontend.contact_us', compact('address', 'phone', 'email', 'latlong'));

    }

    /* FAQ
     * @return mixed
     */
    public function faq()
    {

        $faqs = SiteMeta::where('meta_key','faq')->get();
        return view('frontend.faq', compact('faqs'));

    }
    /* Timeline
     * @return mixed
     */
    public function timeline()
    {

        $timeline = SiteMeta::where('meta_key','timeline')->orderBy('id','desc')->get();
        return view('frontend.timeline', compact('timeline'));

    }
}
