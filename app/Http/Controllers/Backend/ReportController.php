<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Registration;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     *  Student ID card print.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentIdcard(Request $request)
    {


        if($request->isMethod('post')){
            $templateId = $request->get('template_id', 0);
            $side = $request->get('side', 'back');
//            $howMany = intval($request->get('how_many', 0));

            $templateConfig = Template::where('id', $templateId)->where('type',3)->where('role_id', AppHelper::USER_STUDENT)->first();

            if(!$templateConfig){
                return redirect()->route('administrator.report.student_idcard')->with('error', 'Template not found!');
            }

            $templateConfig = json_decode($templateConfig->content);

            $format = "format_";
            if($templateConfig->format_id == 2){
                $format .="two";
            }
            else if($templateConfig->format_id == 3){
                $format .="three";
            }
            else {
                $format .="one";
            }

            //get institute information
            $instituteInfo = AppHelper::getAppSettings('institute_settings');


            //pull students
            //filters
            if(AppHelper::getInstituteCategory() != 'college') {
                // now check is academic year set or not
                $acYear = AppHelper::getAcademicYear();
                if (!$acYear || (int)($acYear) < 1) {

                    return redirect()->route('administrator.report.student_idcard')
                        ->with("error", 'Academic year not set yet! Please go to settings and set it.');
                }
            }
            else {
                $acYear = $request->get('academic_year',0);
            }

            $classId = $request->get('class_id');
            $sectionId = $request->get('section_id');

            $session = '';
            $validity = '';
            $totalStudent = 0;

            if($side == "front") {
                $students = Registration::where('academic_year_id', $acYear)
                    ->where('class_id', $classId)
                    ->where('section_id', $sectionId)
                    ->where('status', AppHelper::ACTIVE)
                    ->with(['student' => function ($query) {
                        $query->select('name', 'blood_group', 'id', 'photo');
                    }])
                    ->with(['class' => function ($query) {
                        $query->select('name', 'group', 'id');
                    }])
                    ->select('id', 'roll_no', 'regi_no', 'student_id','class_id', 'house')
                    ->orderBy('roll_no', 'asc')
                    ->get();


                $acYearInfo = AcademicYear::where('id', $acYear)->first();

                $session = $acYearInfo->title;
                $validity = $acYearInfo->end_date->format('Y');

                if($templateConfig->format_id == 3){
                    $validity = $acYearInfo->end_date->format('F Y');
                }
            }
            else{
                $students = Registration::where('academic_year_id', $acYear)
                    ->where('class_id', $classId)
                    ->where('section_id', $sectionId)
                    ->where('status', AppHelper::ACTIVE)
                    ->select('id', 'regi_no')
                    ->orderBy('regi_no', 'asc')
                    ->get();

                $totalStudent = count($students);
            }


            return view('backend.report.student.idcard.'.$format, compact(
                'templateConfig',
                'instituteInfo',
                'side',
                'students',
                'totalStudent',
                'session',
                'validity'
            ));

        }

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }

        //get templates for students
        // AppHelper::TEMPLATE_TYPE  1=SMS , 2=EMAIL, 3=Id card
        $templates = Template::whereIn('type',[3])->where('role_id', AppHelper::USER_STUDENT)->pluck('name','id');

        return view('backend.report.student.idcard.form', compact(
            'academic_years',
            'classes',
            'templates'
        ));

    }
}
