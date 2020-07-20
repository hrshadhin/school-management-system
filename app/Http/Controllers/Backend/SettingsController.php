<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Grade;
use App\Http\Helpers\AppHelper;
use Carbon\Carbon;
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
                'phone_no' => 'required|min:8|max:255',
                'address' => 'required|max:500',
//                'language' => 'required|min:2',
                'board_name' => 'nullable|max:255',
                'weekends' => 'required|array',
                'morning_start' => 'required|max:8|min:7',
                'morning_end' => 'required|max:8|min:7',
                'day_start' => 'required|max:8|min:7',
                'day_end' => 'required|max:8|min:7',
                'evening_start' => 'required|max:8|min:7',
                'evening_end' => 'required|max:8|min:7',
                'institute_type' => 'required|integer',
                'result_default_grade_id' => 'required|integer',
                'START_DAY_OF_WEEK' => 'required|integer',
                'END_DAY_OF_WEEK' => 'required|integer',

            ];

            if(AppHelper::getInstituteCategory() != 'college') {
                $rules[ 'academic_year'] ='required|integer';
            }
            $this->validate($request, $rules, $messages);

            if($request->get('START_DAY_OF_WEEK') == $request->get('END_DAY_OF_WEEK')){
                return redirect()->back()->with('error','Start and End day of week can\'t be same')->withInput();
            }


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
                ['meta_value' => $request->get('language', 'en')]
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
                ['meta_key' => 'board_name'],
                ['meta_value' => $request->get('board_name', '')]
            );

            $shiftData = [
                'Morning' => [
                    'start' => strtolower($request->get('morning_start','12:00 am')),
                    'end' => strtolower($request->get('morning_end','12:00 am')),
                ],
                'Day' => [
                    'start' => strtolower($request->get('day_start','12:00 am')),
                    'end' => strtolower($request->get('day_end','12:00 am')),
                ],
                'Evening' => [
                    'start' => strtolower($request->get('evening_start','12:00 am')),
                    'end' => strtolower($request->get('evening_end','12:00 am')),
                ]
            ];

            AppMeta::updateOrCreate(
                ['meta_key' => 'shift_data'],
                ['meta_value' => json_encode($shiftData)]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'weekends'],
                ['meta_value' => json_encode($request->get('weekends',[]))]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'week_start_day'],
                ['meta_value' => trim($request->get('START_DAY_OF_WEEK'))]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'week_end_day'],
                ['meta_value' => trim($request->get('END_DAY_OF_WEEK'))]
            );

            AppMeta::updateOrCreate(
                ['meta_key' => 'result_default_grade_id'],
                ['meta_value' => $request->get('result_default_grade_id', 0)]
            );


            Cache::forget('app_settings');
            //invalid dashboard cache
            Cache::forget('studentCount');
            Cache::forget('student_count_by_class');
            Cache::forget('student_count_by_section');
            Cache::put('default_academic_year', $request->get('academic_year', 0));

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
        $language = isset($metas['language']) ? $metas['language'] : 'en';
        $disable_language = isset($metas['disable_language']) ? $metas['disable_language'] : 1;
        $institute_type = isset($metas['institute_type']) ? $metas['institute_type'] : 1;

        $weekends = isset($metas['weekends']) ? json_decode($metas['weekends'], true) : [-1];
        //format shifting data
        if(isset($metas['shift_data'])) {
            $shiftData = json_decode($metas['shift_data'], true);
            $formatedShiftData = [];
            foreach ($shiftData as $shift => $times){
                $formatedShiftData[$shift] = [
                    'start' => Carbon::parse($times['start'])->format('h:i a'),
                    'end' => Carbon::parse($times['end'])->format('h:i a')
                ];
            }

            $metas['shift_data'] = $formatedShiftData;
        }


        //result settings
        $grades = Grade::pluck('name', 'id')->prepend('None',0);
        $grade_id = $metas['result_default_grade_id'] ?? 0;

        $START_DAY_OF_WEEK  = $metas['week_start_day'] ?? null;
        $END_DAY_OF_WEEK  = $metas['week_end_day'] ?? null;


        return view(
            'backend.settings.institute', compact(
                'info',
                'academic_years',
                'academic_year',
                'weekends',
                'grades',
                'grade_id',
                'frontend_website',
                'disable_language',
                'institute_type',
                'language',
                'metas',
                'START_DAY_OF_WEEK',
                'END_DAY_OF_WEEK'
            )
        );
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
                'ms_log.max' => 'Logo must be under 512kb.',
                'ms_log.dimensions' => 'Logo size must be 150x110.',
                'ms_watermark.max' => 'Watermark must be under 1mb.',
                'ms_watermark.dimensions' => 'Watermark size must be 649x918.',
                'ms_title.max' => 'Institute name must be under 512kb.',
                'ms_title.dimensions' => 'Institute name size must be 428x92.',
            ];
            $rules = [
                'background_color' => 'nullable|max:255',
                'text_color' => 'nullable|max:255'

            ];
            $this->validate($request, $rules, $messages);


            //now crate
            if($request->has('show_logo')){
                AppMeta::updateOrCreate(
                    ['meta_key' => 'report_show_logo'],
                    ['meta_value' => 1]
                );
            }
            else{
                AppMeta::updateOrCreate(
                    ['meta_key' => 'report_show_logo'],
                    ['meta_value' => 0]
                );
            }

            AppMeta::updateOrCreate(
                ['meta_key' => 'report_background_color'],
                ['meta_value' => $request->get('background_color', '')]
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

        $show_logo  = $metas['report_show_logo'] ?? 0;

        return view('backend.settings.report', compact('metas','show_logo'));
    }


}
