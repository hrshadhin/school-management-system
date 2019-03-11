<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Grade;
use App\Http\Helpers\AppHelper;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppMeta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * institute setting section content manage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function institute(Request $request)
    {


        //for save on POST request
        if ($request->isMethod('post')) {

            //validate form
            $messages = [
                'logo.max' => 'The :attribute size must be under 1MB.',
                'logo_small.max' => 'The :attribute size must be under 512kb.',
                'logo.dimensions' => 'The :attribute dimensions max be 230 X 50.',
                'logo_small.dimensions' => 'The :attribute dimensions max be 50 X 50.',
                'favicon.max' => 'The :attribute size must be under 512kb.',
                'favicon.dimensions' => 'The :attribute dimensions must be 32 X 32.',
            ];

            $rules = [
                'name' => 'required|min:5|max:255',
                'short_name' => 'required|min:3|max:255',
                'logo' => 'mimes:jpeg,jpg,png|max:1024|dimensions:max_width=230,max_height=50',
                'logo_small' => 'mimes:jpeg,jpg,png|max:512|dimensions:max_width=50,max_height=50',
                'favicon' => 'mimes:png|max:512|dimensions:min_width=32,min_height=32,max_width=32,max_height=32',
                'establish' => 'min:4|max:255',
                'website_link' => 'max:255',
                'email' => 'nullable|email|max:255',
                'phone_no' => 'required|min:8|max:15',
                'address' => 'required|max:500',
                'language' => 'required|min:2',
                'student_attendance_notification' => 'required|integer',
                'employee_attendance_notification' => 'required|integer',
                'institute_type' => 'required|integer',
                'student_idcard_template' => 'required|integer',
                'employee_idcard_template' => 'required|integer',
                'result_default_grade_id' => 'required|integer',
            ];

            if(AppHelper::getInstituteCategory() != 'college') {
                $rules[ 'academic_year'] ='required|integer';
            }
            $this->validate($request, $rules, $messages);



            if($request->hasFile('logo')) {
                $storagepath = $request->file('logo')->store('public/logo');
                $fileName = basename($storagepath);
                $data['logo'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldLogo','');
                if( $oldFile != ''){
                    $file_path = "public/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $data['logo'] = $request->get('oldLogo','');
            }

            if($request->hasFile('logo_small')) {
                $storagepath = $request->file('logo_small')->store('public/logo');
                $fileName = basename($storagepath);
                $data['logo_small'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldLogoSmall','');
                if( $oldFile != ''){
                    $file_path = "public/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $data['logo_small'] = $request->get('oldLogoSmall','');
            }

            if($request->hasFile('favicon')) {
                $storagepath = $request->file('favicon')->store('public/logo');
                $fileName = basename($storagepath);
                $data['favicon'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldFavicon','');
                if( $oldFile != ''){
                    $file_path = "public/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $data['favicon'] = $request->get('oldFavicon','');
            }

            $data['name'] = $request->get('name');
            $data['short_name'] = $request->get('short_name');
            $data['establish'] = $request->get('establish');
            $data['website_link'] = $request->get('website_link');
            $data['email'] = $request->get('email');
            $data['phone_no'] = $request->get('phone_no');
            $data['address'] = $request->get('address');

            //now crate
            AppMeta::updateOrCreate(
                ['meta_key' => 'institute_settings'],
                ['meta_value' => json_encode($data)]
            );


            if(AppHelper::getInstituteCategory() != 'college') {
                AppMeta::updateOrCreate(
                    ['meta_key' => 'academic_year'],
                    ['meta_value' => $request->get('academic_year', 0)]
                );
            }

            AppMeta::updateOrCreate(
                ['meta_key' => 'frontend_website'],
                ['meta_value' => $request->has('frontend_website') ? 1 : 0]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'language'],
                ['meta_value' => $request->get('language', '')]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'disable_language'],
                ['meta_value' => $request->has('disable_language') ? 1 : 0]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'institute_type'],
                ['meta_value' => $request->get('institute_type', 1)]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'student_attendance_notification'],
                ['meta_value' => $request->get('student_attendance_notification', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'employee_attendance_notification'],
                ['meta_value' => $request->get('employee_attendance_notification', 0)]
            );

            //if send notification then add settings
            AppMeta::updateOrCreate(
                ['meta_key' => 'student_attendance_gateway'],
                ['meta_value' => $request->get('sms_gateway_St', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'student_attendance_template'],
                ['meta_value' => $request->get('notification_template_St', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'employee_attendance_gateway'],
                ['meta_value' => $request->get('sms_gateway_Emp', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'employee_attendance_template'],
                ['meta_value' => $request->get('notification_template_Emp', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'student_idcard_template'],
                ['meta_value' => $request->get('student_idcard_template', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'employee_idcard_template'],
                ['meta_value' => $request->get('employee_idcard_template', 0)]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'result_default_grade_id'],
                ['meta_value' => $request->get('result_default_grade_id', 0)]
            );


            Cache::forget('app_settings');

            //now notify the admins about this record
            $msg = "Institute settings updated by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('settings.institute')->with('success', 'Setting updated!');
        }

        //for get request
        $settings = AppMeta::where('meta_key', 'institute_settings')->select('meta_key','meta_value')->first();
        $info = null;
        if($settings) {
            $info = json_decode($settings->meta_value);
        }


        $settings = AppMeta::select('meta_key','meta_value')->get();

        $metas = [];
        foreach ($settings as $setting){
            $metas[$setting->meta_key] = $setting->meta_value;
        }


        //if its college then no need to setup up default academic year
        $academic_years = [];
        $academic_year = 0;
        if(AppHelper::getInstituteCategory() != 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
            $academic_year = isset($metas['academic_year']) ? $metas['academic_year'] : 0;
        }

        $frontend_website = isset($metas['frontend_website']) ? $metas['frontend_website'] : 0;
        $language = isset($metas['language']) ? $metas['language'] : 0;
        $disable_language = isset($metas['disable_language']) ? $metas['disable_language'] : 0;
        $student_attendance_notification = isset($metas['student_attendance_notification']) ? $metas['student_attendance_notification'] : 0;
        $employee_attendance_notification = isset($metas['employee_attendance_notification']) ? $metas['employee_attendance_notification'] : 0;
        $institute_type = isset($metas['institute_type']) ? $metas['institute_type'] : 1;


        //get idcard templates
        // AppHelper::TEMPLATE_TYPE  1=SMS , 2=EMAIL, 3=Id card
        $studentIdcardTemplates = Template::whereIn('type',[3])->where('role_id', AppHelper::USER_STUDENT)
            ->pluck('name','id')->prepend('None', 0);
        $employeIdcardTemplates = Template::whereIn('type',[3])->where('role_id', AppHelper::USER_TEACHER)
            ->pluck('name','id')->prepend('None', 0);

        $student_idcard_template = $metas['student_idcard_template'] ?? 0;
        $employee_idcard_template = $metas['employee_idcard_template'] ?? 0;

        //result settings
        $grades = Grade::pluck('name', 'id')->prepend('None',0);
        $grade_id = $metas['result_default_grade_id'] ?? 0;


        return view(
            'backend.settings.institute', compact(
                'info',
                'academic_years',
                'academic_year',
                'grades',
                'grade_id',
                'frontend_website',
                'disable_language',
                'student_attendance_notification',
                'employee_attendance_notification',
                'institute_type',
                'language',
                'metas',
                'studentIdcardTemplates',
                'employeIdcardTemplates',
                'student_idcard_template',
                'employee_idcard_template'
            )
        );
    }


    /**
     * SMS Gateway settings  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smsGatewayIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);

            $gateway = AppMeta::findOrFail($request->get('hiddenId'));

            // now check is gateway currently used ??
            $stGateway = AppHelper::getAppSettings('student_attendance_gateway');
            $empGateway = AppHelper::getAppSettings('employee_attendance_gateway');
            if($gateway->id == $stGateway || $gateway->id == $empGateway){
                return redirect()->route('settings.sms_gateway.index')->with('error', 'Can not delete it because this gateway is being used.');
            }
            if($gateway->meta_key == "sms_gateway"){
                $gateway->delete();
            }

            return redirect()->route('settings.sms_gateway.index')->with('success', 'Gateway deleted!');
        }

        //for get request
        $smsGateways = AppMeta::where('meta_key','sms_gateway')->get();

        //if it is ajax request then send json response with formated data
        if($request->ajax()){
            $data = [];
            foreach ($smsGateways as $gateway){
                $json_data = json_decode($gateway->meta_value);
                $data[] = [
                    'id' => $gateway->id,
                    'text' => $json_data->name.'['.AppHelper::SMS_GATEWAY_LIST[$json_data->gateway].']',
                ];
            }

            return response()->json($data);
        }



        return view('backend.settings.smsgateway_list', compact('smsGateways'));
    }

    /**
     *  SMS Gateway settings   manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smsGatewayCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'gateway' => 'required|integer',
                'name' => 'required|min:4|max:255',
                'sender_id' => 'nullable',
                'user' => 'required|max:255',
                'password' => 'nullable|max:255',
                'api_url' => 'required',
            ]);


            $data = [
                'gateway' => $request->get('gateway',''),
                'name' => $request->get('name',''),
                'sender_id' => $request->get('sender_id',''),
                'user' => $request->get('user',''),
                'password' => $request->get('password',''),
                'api_url' => $request->get('api_url',''),
            ];


            AppMeta::updateOrCreate(
                ['id' => $id],
                [
                    'meta_key' => 'sms_gateway',
                    'meta_value' => json_encode($data)
                ]
            );
            $msg = "SMS Gateway ";
            $msg .= $id ? 'updated.' : 'added.';

            if($id){
                return redirect()->route('settings.sms_gateway.index')->with('success', $msg);
            }
            return redirect()->route('settings.sms_gateway.create')->with('success', $msg);
        }

        //for get request
        $gateways = AppHelper::SMS_GATEWAY_LIST;
        $gateway_id = null;
        $gateway = AppMeta::find($id);
        if($gateway) {
            $gateway_id = (json_decode($gateway->meta_value))->gateway;
        }

        return view('backend.settings.smsgateway_add', compact('gateways', 'gateway', 'gateway_id'));
    }


    /**
     * report settings  manage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report(Request $request)
    {

        //for save on POST request
        if ($request->isMethod('post')) {

            //validate form
            $messages = [
                'logo.max' => 'The :attribute size must be under 1MB.',
            ];
            $rules = [
                'logo' => 'mimes:jpeg,jpg,png|max:1024',
                'background_color' => 'nullable|max:255',
                'background_image' => 'mimes:jpeg,jpg,png|max:1024',
                'text_color' => 'nullable|max:255',

            ];
            $this->validate($request, $rules, $messages);


            $report_logo = '';
            if($request->hasFile('logo')) {
                $storagepath = $request->file('logo')->store('public/report');
                $report_logo = basename($storagepath);

                //if file chnage then delete old one
                $oldFile = $request->get('oldLogo','');
                if( $oldFile != ''){
                    $file_path = "public/report/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $report_logo = $request->get('oldLogo','');
            }

            $report_background = '';
            if($request->hasFile('background_image')) {
                $storagepath = $request->file('background_image')->store('public/report');
                $report_background = basename($storagepath);

                //if file chnage then delete old one
                $oldFile = $request->get('oldBackgroundImage','');
                if( $oldFile != ''){
                    $file_path = "public/report/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $report_background = $request->get('oldBackgroundImage','');
            }

            //now crate
            AppMeta::updateOrCreate(
                ['meta_key' => 'report_logo'],
                ['meta_value' => $report_logo]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'report_background_color'],
                ['meta_value' => $request->get('background_color', '')]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'report_background_image'],
                ['meta_value' => $report_background]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'report_text_color'],
                ['meta_value' => $request->get('text_color', '')]
            );

            Cache::forget('app_settings');

            //now notify the admins about this record
            $msg = "Report settings updated by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('settings.report')->with('success', 'Report setting updated!');
        }

        //for get request
        $settings = AppMeta::where('meta_key', 'like', '%report_%')->select('meta_key','meta_value')->get();
        $metas = [];
        foreach ($settings as $setting){
            $metas[$setting->meta_key] = $setting->meta_value;
        }

        return view('backend.settings.report', compact('metas'));
    }


}
