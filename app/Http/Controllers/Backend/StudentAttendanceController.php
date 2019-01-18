<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\AppMeta;
use App\Http\Helpers\AppHelper;
use App\Http\Helpers\SmsHelper;
use App\IClass;
use App\Registration;
use App\Section;
use App\StudentAttendance;
use App\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get query parameter for filter the fetch
        $class_id = $request->query->get('class',0);
        $section_id = $request->query->get('section',0);
        $acYear = $request->query->get('academic_year',0);
        $attendance_date = $request->query->get('attendance_date','');
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');
        $sections = [];

        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }
        else{

            $acYear = $request->query->get('academic_year',AppHelper::getAcademicYear());
        }


        //now fetch attendance data
        $attendances = [];
        if($class_id && $section_id && $acYear && strlen($attendance_date) >= 10) {
            $att_date = Carbon::createFromFormat('d/m/Y',$attendance_date)->toDateString();
            $attendances = Registration::where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('status', AppHelper::ACTIVE)
                ->with(['student' => function ($query) {
                    $query->select('name','id');
                }])
                ->whereHas('attendance' , function ($query) use($att_date) {
                    $query->select('id','present','registration_id')
                    ->whereDate('attendance_date', $att_date);
                })
                ->select('id','regi_no','roll_no','student_id')
                ->orderBy('roll_no','asc')
                ->get();

            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');
        }


        return view('backend.attendance.student.list', compact(
            'academic_years',
            'classes',
            'sections',
            'acYear',
            'class_id',
            'section_id',
            'attendance_date',
            'attendances'
        ));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');
        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }

        return view('backend.attendance.student.add', compact(
            'academic_years',
            'classes'
        ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate form
        $messages = [
            'registrationIds.required' => 'This section has no students!',
        ];
        $rules = [
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'attendance_date' => 'required|min:10|max:11',
            'registrationIds' => 'required',

        ];
        //if it college then need another 2 feilds
        if(AppHelper::getInstituteCategory() == 'college') {
            $rules['academic_year'] = 'required|integer';
        }

        $this->validate($request, $rules, $messages);

        //process the insert data
        $students = $request->get('registrationIds');
        $present = $request->get('present');
        $attendance_date = Carbon::createFromFormat('d/m/Y', $request->get('attendance_date'))->format('Y-m-d');
        $dateTimeNow = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $attendances = [];
        $absentIds = [];
        foreach ($students as $student){
            $isPresent = isset($present[$student]) ? '1' : '0';

            $attendances[] = [
                "registration_id" => $student,
                "attendance_date" => $attendance_date,
                "present"   => $isPresent,
                "created_at" => $dateTimeNow,
                "created_by" => auth()->user()->id,
            ];

            if(!$isPresent){
                $absentIds[] = $student;
            }
        }

        DB::beginTransaction();
        try {

            StudentAttendance::insert($attendances);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('student_attendance.create')->with("error",$message);
        }


        $message = "Attendance saved successfully.";
        //check if notification need to send?
        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');
        if($sendNotification != "0") {
            if($sendNotification == "1"){
                //then send sms notification

                //get sms gateway information
                $gateway = AppMeta::where('id', AppHelper::getAppSettings('student_attendance_gateway'))->first();
                if(!$gateway){
                    redirect()->route('student_attendance.create')->with("warning",$message." But SMS Gateway not setup!");
                }

                //get sms template information
                $template = Template::where('id', AppHelper::getAppSettings('student_attendance_template'))->first();
                if(!$template){
                    redirect()->route('student_attendance.create')->with("warning",$message." But SMS template not setup!");
                }

                $res = AppHelper::sendAbsentNotificationForStudentViaSMS($absentIds, $attendance_date);

            }

            if($sendNotification == "2"){
                //then send email notification
                //todo: need to implement email notification
            }
        }


        return redirect()->route('student_attendance.create')->with("success",$message);
    }


    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $attendance =  StudentAttendance::findOrFail($id);
        if(!$attendance){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $attendance->present = (string)$request->get('status');

        $attendance->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }

    /**
     * Upload file for add attendance
     * @return mixed
     */
    public function createFromFile(Request $request)
    {

       dd('file upload');
    }
}
