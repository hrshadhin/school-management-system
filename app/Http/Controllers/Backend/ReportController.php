<?php

namespace App\Http\Controllers\Backend;

use App\AcademicCalendar;
use App\AcademicYear;
use App\Employee;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Registration;
use App\Section;
use App\StudentAttendance;
use App\Template;
use Carbon\Carbon;
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
                return redirect()->route('report.student_idcard')->with('error', 'Template not found!');
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
            ->orderBy('order','asc')
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

    /**
     *  Employee ID card print.
     *
     * @return \Illuminate\Http\Response
     */
    public function employeeIdcard(Request $request)
    {



        if($request->isMethod('post')){
            $templateId = $request->get('template_id', 0);
            $side = $request->get('side', 'back');

            $templateConfig = Template::where('id', $templateId)->where('type',3)->where('role_id', AppHelper::USER_TEACHER)->first();

            if(!$templateConfig){
                return redirect()->route('report.employee_idcard')->with('error', 'Template not found!');
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


            //pull employee
            if($side == "front") {
                $employees = Employee::orderBy('id_card', 'asc')->get();

            }
            else{

                $employees = Employee::select('id_card')->orderBy('id_card', 'asc')->get();
            }


            return view('backend.report.hrm.employee.idcard.'.$format, compact(
                'templateConfig',
                'instituteInfo',
                'side',
                'employees',
                ''
            ));

        }




        //get templates for students
        // AppHelper::TEMPLATE_TYPE  1=SMS , 2=EMAIL, 3=Id card
        $templates = Template::whereIn('type',[3])->where('role_id', AppHelper::USER_TEACHER)->pluck('name','id');

        return view('backend.report.hrm.employee.idcard.form', compact(
            'templates'
        ));

    }


    /**
     *  Student attendance Monthly Section wise
     *  @return \Illuminate\Http\Response
     */
    public function studentMonthlyAttendance(Request $request){

        if($request->isMethod('post')){
            $rules = [
                'class_id' => 'required|integer',
                'section_id' => 'required|integer',
                'month' => 'required|min:7|max:7',
            ];
            $this->validate($request, $rules);

            if(AppHelper::getInstituteCategory() == 'college') {
                $rules['academic_year'] = 'required|integer';
            }

            $month = Carbon::createFromFormat('m/Y', $request->get('month'))->timezone(env('APP_TIMEZONE','Asia/Dhaka'));
            $classId = $request->get('class_id', 0);
            $sectionId = $request->get('section_id', 0);
            if(AppHelper::getInstituteCategory() == 'college') {
                $academicYearId = $request->get('academic_year', 0);
            }
            else{
                $academicYearId = AppHelper::getAcademicYear();
            }
            $monthStart = $month->startOfMonth()->copy();
            $monthEnd = $month->endOfMonth()->copy();

            $students = Registration::where('status', AppHelper::ACTIVE)
                ->where('class_id', $classId)
                ->where('academic_year_id', $academicYearId)
                ->where('section_id', $sectionId)
                ->with(['info' => function($query){
                    $query->select('name','id');
                }])
                ->select('id','student_id','roll_no','regi_no')
                ->orderBy('roll_no','asc')
                ->get();

            $studentIds = $students->pluck('id');
            $attendanceData = StudentAttendance::select('registration_id','attendance_date','present','status')
                ->whereIn('registration_id', $studentIds)
                ->whereDate('attendance_date', '>=', $monthStart->format('Y-m-d'))
                ->whereDate('attendance_date', '<=', $monthEnd->format('Y-m-d'))
                ->get()
                ->reduce(function ($attendanceData, $attendance){
                    $inLate = 0;
                    if(strpos($attendance->status, '1') !== false){
                        $inLate = 1;
                    }
                    $attendanceData[$attendance->registration_id][$attendance->getOriginal('attendance_date')] = [
                      'present' => $attendance->getOriginal('present'),
                      'inLate'  => $inLate
                    ];

                    return $attendanceData;
                });

            $wekends = AppHelper::getAppSettings('weekends');
            if($wekends){
                $wekends = json_decode($wekends);
            }
            //pull holidays
            $calendarData = AcademicCalendar::where(function ($q){
                   $q->where('is_holiday','1')
                       ->orWhere('is_exam','1');
               })
                ->where(function ($q) use($monthStart, $monthEnd){
                    $q->whereDate('date_from', '>=', $monthStart->format('Y-m-d'))
                        ->whereDate('date_from', '<=', $monthEnd->format('Y-m-d'))
                        ->orWhere(function ($q) use($monthStart, $monthEnd){
                            $q->whereDate('date_upto', '>=', $monthStart->format('Y-m-d'))
                                ->whereDate('date_upto', '<=', $monthEnd->format('Y-m-d'));
                        });
                    })

                ->select('date_from','date_upto','is_holiday','is_exam','class_ids')
                ->get()
                ->reduce(function ($calendarData, $calendar) use($monthEnd, $monthStart, $wekends){

                    $startDate = $calendar->date_from;
                    $endDate = $calendar->date_upto;
                    if($calendar->date_upto->gt($monthEnd)){
                        $endDate = $monthEnd;
                    }

                    if($calendar->date_from->lt($monthStart)){
                        $startDate = $monthStart;
                    }

                    $cladendarDateRange = AppHelper::generateDateRangeForReport($startDate, $endDate, true, $wekends, true);
                   foreach ($cladendarDateRange as $date => $value){
                       $symbols = 'H';
                       if($calendar->is_exam == 1){
                           $symbols = 'E';
                       }
                       $calendarData[$date] = $symbols;
                   }
                    return $calendarData;
                });


            $monthDates = AppHelper::generateDateRangeForReport($monthStart, $monthEnd, true, $wekends);

            $headerData = new \stdClass();
            $headerData->reportTitle = 'Monthly Attendance';
            $headerData->reportSubTitle = 'Month: '.$month->format('F,Y');

            $filters = [];
            if(AppHelper::getInstituteCategory() == 'college') {
                $academicYearInfo = AcademicYear::where('id', $academicYearId)->first();
                $filters[] = "Academic year: ".$academicYearInfo->title;
            }
            $section = Section::where('id', $sectionId)
                    ->with(['class' => function($q){
                        $q->select('name','id');
                    }])
                    ->select('id','class_id','name')
                    ->first();

            $filters[] = "Class: ".$section->class->name;
            $filters[] = "Section: ".$section->name;


            return view('backend.report.student.attendance.monthly_print',compact(
                'headerData',
                'monthDates',
                'students',
                'attendanceData',
                'calendarData',
                'filters'
            ));
        }



        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }

        return view('backend.report.student.attendance.monthly', compact(
            'academic_years',
            'classes'
        ));

    }
}
