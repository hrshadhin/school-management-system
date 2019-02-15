<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\EmployeeAttendance;
use App\Http\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        //if employee id present  that means come from employee profile
        // show fetch the attendance and send json response
        if($request->ajax() && $request->query->get('employee_id', 0)){
            $id = $request->query->get('employee_id', 0);
            $attendances = EmployeeAttendance::where('employee_id', $id)
                ->select('attendance_date', 'present','employee_id')
                ->orderBy('attendance_date', 'asc')
                ->get();
            return response()->json($attendances);

        }

        // get query parameter for filter the fetch
        $employee_id = $request->query->get('employee_id',0);
        $attendance_date = $request->query->get('attendance_date','');


        //if its a ajax request that means come from attendance add exists checker
        if($request->ajax()){
            $attendances = $this->getAttendanceByFilters(null, $attendance_date, true);
            return response()->json($attendances);
        }


        $employees = Employee::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');


        //now fetch attendance data
        $attendances = [];
        if(strlen($attendance_date) >= 10) {

            $attendances = $this->getAttendanceByFilters($employee_id, $attendance_date);
        }



        return view('backend.attendance.employee.list', compact(
            'employees',
            'employee_id',
            'attendance_date',
            'attendances'
        ));

    }


    private function getAttendanceByFilters($employee_id=null, $attendance_date, $isCount = false) {
        $att_date = Carbon::createFromFormat('d/m/Y',$attendance_date)->toDateString();
        return $attendances = EmployeeAttendance::with('employee')
            ->whereDate('attendance_date', $att_date)
            ->Employee($employee_id)
            ->CountOrGet($isCount);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('status', AppHelper::ACTIVE)
        ->pluck('name', 'id');

        //if its college then have to get those academic years

        return view('backend.attendance.employee.add', compact(
            'employees'
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


        //check attendance exists or not
        $class_id = $request->get('class_id',0);
        $section_id = $request->get('section_id',0);
        $attendance_date = $request->get('attendance_date','');
        if(AppHelper::getInstituteCategory() == 'college') {
            $acYear =  $request->query->get('academic_year',0);
        }
        else{

            $acYear = AppHelper::getAcademicYear();
        }
        $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, true);

        if($attendances){
            return redirect()->route('student_attendance.create')->with("error","Attendance already exists!");
        }


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

            EmployeeAttendance::insert($attendances);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('student_attendance.create')->with("error",$message);
        }


        $message = "Attendance saved successfully.";
        //check if notification need to send?
        //todo: need uncomment these code on client deploy
//        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');
//        if($sendNotification != "0") {
//            if($sendNotification == "1"){
//                //then send sms notification
//
//                //get sms gateway information
//                $gateway = AppMeta::where('id', AppHelper::getAppSettings('student_attendance_gateway'))->first();
//                if(!$gateway){
//                    redirect()->route('student_attendance.create')->with("warning",$message." But SMS Gateway not setup!");
//                }
//
//                //get sms template information
//                $template = Template::where('id', AppHelper::getAppSettings('student_attendance_template'))->first();
//                if(!$template){
//                    redirect()->route('student_attendance.create')->with("warning",$message." But SMS template not setup!");
//                }
//
//                $res = AppHelper::sendAbsentNotificationForStudentViaSMS($absentIds, $attendance_date);
//
//            }
//        }

        //push job to queue
        //todo: need comment these code on client deploy
//        PushStudentAbsentJob::dispatch($absentIds, $attendance_date);


        return redirect()->route('student_attendance.create')->with("success",$message);
    }


    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $attendance =  EmployeeAttendance::findOrFail($id);
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

}
