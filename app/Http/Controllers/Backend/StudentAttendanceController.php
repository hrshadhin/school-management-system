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
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

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
        $attendance_date = $request->query->get('attendance_date','');
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
            ->pluck('name', 'id');
        $sections = [];

        //now fetch attendance data
        $attendances = [];
        if($class_id && $section_id && $acYear && strlen($attendance_date) >= 10) {

            $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date);
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
            ->whereHas('attendance' , function ($query) use($att_date) {
                $query->select('id','present','registration_id')
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
        PushStudentAbsentJob::dispatch($absentIds, $attendance_date);


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
                ]);


                // now start the command to proccess data
            $command = "php ".base_path()."/artisan attendance:seedStudent";

            $process = new Process($command);
            $process->start();

           // debug code
//            $process->wait();
//            echo $process->getOutput();
//            echo $process->getErrorOutput();

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }

            return redirect()->back();
        }

        $isProcessingFile = false;
        $pendingFile = AttendanceFileQueue::where('is_imported','=',0)
            ->orderBy('created_at', 'DESC')
            ->count();

        if($pendingFile){
            $isProcessingFile = true;

        }

        $queueFireUrl = route('student_attendance_seeder',['code' => 'hr799']);
        return view('backend.attendance.student.upload', compact(
            'isProcessingFile',
            'queueFireUrl'
        ));
    }

    /**
     * Uploaded file status
     * @param Request $request
     * @return array
     */
    public function fileQueueStatus(Request $request)
    {
        $pendingFile = AttendanceFileQueue::orderBy('created_at', 'DESC')
            ->first();

        if(empty($pendingFile)) {
            return [
                'msg' => 'No file in queue to proccess. Reload the page.',
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
