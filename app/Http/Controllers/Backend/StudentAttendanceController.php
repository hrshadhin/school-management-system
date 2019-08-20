<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\AppMeta;
use App\AttendanceFileQueue;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Jobs\PushStudentAbsentJob;
use App\Registration;
use App\Section;
use App\StudentAttendance;
use App\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        //if student id present  that means come from student profile
        // show fetch the attendance and send json response
        if($request->ajax() && $request->query->get('student_id', 0)){
                $id = $request->query->get('student_id', 0);
                $attendances = StudentAttendance::where('registration_id', $id)
                    ->select('attendance_date', 'present','registration_id')
                    ->orderBy('attendance_date', 'asc')
                    ->get();
                return response()->json($attendances);

        }

        // get query parameter for filter the fetch
        $class_id = $request->query->get('class',0);
        $section_id = $request->query->get('section',0);
        $acYear = $request->query->get('academic_year',0);
        $attendance_date = $request->query->get('attendance_date',date('d/m/Y'));
        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }
        else{

            $acYear = $request->query->get('academic_year',AppHelper::getAcademicYear());
        }



        //if its a ajax request that means come from attendance add exists checker
        if($request->ajax()){
            $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, true);
            return response()->json($attendances);
        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $sections = [];

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
                 ->with(['attendanceSingleDay' => function ($query) use($att_date, $class_id, $acYear) {
                     $query->select('id','present','registration_id','in_time','out_time','staying_hour')
                         ->where('academic_year_id', $acYear)
                         ->where('class_id', $class_id)
                         ->whereDate('attendance_date', $att_date);
                 }])
                 ->whereHas('attendance' , function ($query) use($att_date, $class_id, $acYear) {
                     $query->select('id','registration_id')
                         ->where('academic_year_id', $acYear)
                         ->where('class_id', $class_id)
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


    private function getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, $isCount = false) {
        $att_date = Carbon::createFromFormat('d/m/Y',$attendance_date)->toDateString();
       return $attendances = Registration::where('academic_year_id', $acYear)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('status', AppHelper::ACTIVE)
            ->with(['student' => function ($query) {
                $query->select('name','id');
            }])
            ->whereHas('attendance' , function ($query) use($att_date, $class_id, $acYear) {
                $query->select('id','registration_id')
                    ->where('academic_year_id', $acYear)
                    ->where('class_id', $class_id)
                    ->whereDate('attendance_date', $att_date);
            })
            ->select('id','regi_no','roll_no','student_id')
            ->orderBy('roll_no','asc')
            ->CountOrGet($isCount);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $students = collect();
        $academic_year = '';
        $class_name = '';
        $section_name = '';
        $academic_years = [];
        $attendance_date = date('d/m/Y');
        $acYear = null;
        $class_id = null;
        $section_id = null;
        $sendNotification = 0;

        if ($request->isMethod('post')) {

            if(AppHelper::getInstituteCategory() == 'college') {
                $acYear = $request->get('academic_year', 0);
            }
            else{
                $acYear = AppHelper::getAcademicYear();
            }
            $class_id = $request->get('class_id',0);
            $section_id = $request->get('section_id',0);
            $attendance_date = $request->get('attendance_date','');

            $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, true);
            if($attendances){
                return redirect()->route('student_attendance.create')->with("error","Attendance already exists!");
            }

            $students = Registration::with(['info' => function($query){
                $query->select('name','id');
            }])->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->select( 'regi_no', 'roll_no', 'id','student_id')
                ->orderBy('roll_no','asc')
                ->get();


            $classInfo = IClass::where('status', AppHelper::ACTIVE)
                ->where('id', $class_id)
                ->first();
            $class_name = $classInfo->name;
            $sectionsInfo = Section::where('status', AppHelper::ACTIVE)
                ->where('id', $section_id)
                ->where('class_id', $class_id)
                ->first();
            $section_name = $sectionsInfo->name;


            if(AppHelper::getInstituteCategory() == 'college') {
                $acYearInfo = AcademicYear::where('status', '1')->where('id', $acYear)->first();
                $academic_year = $acYearInfo->title;
            }

            $sendNotification = AppHelper::getAppSettings('student_attendance_notification');
        }

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }


        return view('backend.attendance.student.add', compact(
            'academic_years',
            'classes',
            'sections',
            'students',
            'class_name',
            'academic_year',
            'section_name',
            'attendance_date',
            'class_id',
            'section_id',
            'acYear',
            'sendNotification'
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
//            'outTime.required' => 'Out time missing!',
//            'inTime.required' => 'In time missing!',
        ];
        $rules = [
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'attendance_date' => 'required|min:10|max:11',
            'registrationIds' => 'required|array',
//            'inTime' => 'required|array',
//            'outTime' => 'required|array',

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
            $acYear =  $request->get('academic_year',0);
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
        $present = $request->get('present',[]);
        $attendance_date = Carbon::createFromFormat('d/m/Y', $request->get('attendance_date'))->format('Y-m-d');
        $dateTimeNow = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
//        $inTimes = $request->get('inTime');
//        $outTimes = $request->get('outTime');

        //fetch institute shift running times
        $shiftData = AppHelper::getAppSettings('shift_data');
        if($shiftData){
            $shiftData = json_decode($shiftData, true);
        }

        $shiftRuningTimes = [];

        foreach ($shiftData as $shift => $times){
            $shiftRuningTimes[$shift] = [
                'start' => Carbon::createFromFormat('Y-m-d h:i a',$attendance_date.' '.$times['start']),
                'end' => Carbon::createFromFormat('Y-m-d h:i a',$attendance_date.' '.$times['end'])
            ];
        }

        $studentsShift = Registration::whereIn('id', $students)
            ->get(['id','shift'])
            ->reduce(function ($studentsShift, $student) {
                $studentsShift[$student->id] = $student->shift;
                return $studentsShift;
        });

        $attendances = [];
        $absentIds = [];
        $parseError = false;

        foreach ($students as $student){

//            $inTime = Carbon::createFromFormat('d/m/Y h:i a', $inTimes[$student]);
//            $outTime = Carbon::createFromFormat('d/m/Y h:i a', $outTimes[$student]);
              $inTime = $shiftRuningTimes[$studentsShift[$student]]['start'];
            $outTime = $shiftRuningTimes[$studentsShift[$student]]['end'];

//            if($outTime->lessThan($inTime)){
//                $message = "Out time can't be less than in time!";
//                $parseError = true;
//                break;
//            }
//
//            if($inTime->diff($outTime)->days > 1){
//                $message = "Can\'t stay more than 24 hrs!";
//                $parseError = true;
//                break;
//            }

            $timeDiff  = $inTime->diff($outTime)->format('%H:%I');
//            $isPresent = ($timeDiff == "00:00") ? "0" : "1";

            $isPresent = isset($present[$student]) ? '1' : '0';
            $status = [];

            //late or early out find
//            if($timeDiff != "00:00" && strlen($studentsShift[$student]) && isset($shiftRuningTimes[$studentsShift[$student]])){
//
//                if($inTime->greaterThan($shiftRuningTimes[$studentsShift[$student]]['start'])){
//                    $status[] = 1;
//                }
//
//                if($outTime->lessThan($shiftRuningTimes[$studentsShift[$student]]['end'])){
//                    $status[] = 2;
//                }
//            }

            $attendances[] = [
                "academic_year_id" => $acYear,
                "class_id" => $class_id,
                "registration_id" => $student,
                "attendance_date" => $attendance_date,
                "in_time" => $inTime,
                "out_time" => $outTime,
                "staying_hour" => $timeDiff,
                "status" => implode(',',$status),
                "present"   => $isPresent,
                "created_at" => $dateTimeNow,
                "created_by" => auth()->user()->id,
            ];

            if(!$isPresent){
                $absentIds[] = $student;
            }
        }

        if($parseError){
            return redirect()->route('employee_attendance.create')->with("error",$message);
        }

//        dd($attendances, $absentIds);

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


        //now invalid cache
        Cache::forget('student_attendance_count');

        $message = "Attendance saved successfully.";
        //check if notification need to send?
        $sendNotification = AppHelper::getAppSettings('student_attendance_notification', true);
        if($sendNotification != "0" && $request->has('is_send_notification')) {
            PushStudentAbsentJob::dispatch($absentIds, $attendance_date)
                ->onQueue('absent');
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
        if ($request->isMethod('post')) {

            //validate form
            $messages = [
                'file.max' => 'The :attribute size must be under 1mb.',
            ];
            $rules = [
                'file' => 'mimetypes:text/plain|max:1024',

            ];

            $this->validate($request, $rules, $messages);

            $clientFileName = $request->file('file')->getClientOriginalName();

            // again check for file extention manually
            $ext = strtolower($request->file('file')->getClientOriginalExtension());
            if($ext != 'txt'){
                return redirect()->back()->with('error', 'File must be a .txt file');
            }

            try {
                $storagepath = $request->file('file')->store('student-attendance');
                $fileName = basename($storagepath);

                $fullPath = storage_path('app/').$storagepath;

                //check file content
                $linecount = 0;
                $isValidFormat = 0;
                $handle = fopen($fullPath, "r");
                while(!feof($handle)){
                    $line = fgets($handle, 4096);
                    $linecount = $linecount + substr_count($line, PHP_EOL);

                    if($linecount == 1){
                        $isValidFormat = AppHelper::isLineValid($line);
                        if(!$isValidFormat){
                            break;
                        }
                    }
                }
                fclose($handle);

                if(!$linecount){
                    throw new Exception("File is empty.");
                }

                if(!$isValidFormat){
                    throw new Exception("File content format is not valid.");
                }

                AttendanceFileQueue::create([
                    'file_name' => $fileName,
                    'client_file_name' => $clientFileName,
                    'file_format' => $isValidFormat,
                    'total_rows' => 0,
                    'imported_rows' => 0,
                    'attendance_type' => 1,
                    'send_notification' => $request->has('is_send_notification') ? 1 : 0,
                ]);

                //push command on queue
                Artisan::queue('attendance:seedStudent')
                    ->onQueue('commands');

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }

            return redirect()->back();
        }

        $isProcessingFile = false;
        $pendingFile = AttendanceFileQueue::where('attendance_type',1)
            ->where('is_imported','=',0)
            ->orderBy('created_at', 'DESC')
            ->count();

        if($pendingFile){
            $isProcessingFile = true;

        }

        $queueFireUrl = route('student_attendance_seeder',['code' => 'hr799']);
        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');

        return view('backend.attendance.student.upload', compact(
            'isProcessingFile',
            'queueFireUrl',
            'sendNotification'
        ));
    }

    /**
     * Uploaded file status
     * @param Request $request
     * @return array
     */
    public function fileQueueStatus(Request $request)
    {
        $pendingFile = AttendanceFileQueue::where('attendance_type',1)->orderBy('created_at', 'DESC')
            ->first();

        if(empty($pendingFile)) {
            return [
                'msg' => 'No file in queue to process. Reload the page.',
                'success' => true
            ];
            //nothing to do
        }

        if($pendingFile->is_imported === 1) {
            return [
                'msg' => 'Attendance data processing complete. You can check the log.',
                'success' => true
            ];
        }
        else if($pendingFile->is_imported === -1) {
            return [
                'msg' => 'Something went wrong to import data, check log file.',
                'success' => false,
                'status' => $pendingFile->is_imported
            ];
        }
        else {
            $status = $pendingFile->imported_rows . '  attendance has been imported out of ' . $pendingFile->total_rows;
            if($pendingFile->imported_rows >= $pendingFile->total_rows) {
                $status = "attendance has been imported. Now sending notification for absent students";
            }
            return [
                'msg' => $status,
                'success' => false,
                'status' => $pendingFile->is_imported
            ];
        }
    }
}
