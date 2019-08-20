<?php

namespace App\Http\Controllers\Backend;

use App\AppMeta;
use App\AttendanceFileQueue;
use App\Employee;
use App\EmployeeAttendance;
use App\Http\Helpers\AppHelper;
use App\Jobs\PushEmployeeAbsentJob;
use App\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
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
                ->whereYear('attendance_date', date('Y'))
                ->select('attendance_date', 'present','employee_id')
                ->orderBy('attendance_date', 'asc')
                ->get();
            return response()->json($attendances);

        }

        // get query parameter for filter the fetch
        $employee_id = $request->query->get('employee_id',0);
        $attendance_date = $request->query->get('attendance_date',date('d/m/Y'));


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
        $employees = Employee::select('name','id','id_card')
        ->where('status', AppHelper::ACTIVE)
        ->get();

        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');


        return view('backend.attendance.employee.add', compact(
            'employees',
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


        $rules = [
            'attendance_date' => 'required|min:10|max:11',
            'employeeIds' => 'required',
            'inTime' => 'required',
            'outTime' => 'required'
        ];

        $this->validate($request, $rules);


        //check attendance exists or not
        $attendance_date = $request->get('attendance_date','');
        $attendances = $this->getAttendanceByFilters(null, $attendance_date, true);
        if($attendances){
            return redirect()->route('employee_attendance.create')->with("error","Attendance already exists!");
        }


        //process the insert data
        $employees = $request->get('employeeIds');
        $inTimes = $request->get('inTime');
        $outTimes = $request->get('outTime');

        $attendance_date = Carbon::createFromFormat('d/m/Y', $request->get('attendance_date'))->format('Y-m-d');

        //fetch employee working hours
        $workTimes = Employee::where('status', AppHelper::ACTIVE)->get()->reduce(function ($workTimes, $employee) use($request) {
            $workTimes[$employee->id] = [
                'in_time' => null,
                'out_time' => null
            ];
            if($employee->duty_start){
                $workTimes[$employee->id]['in_time'] = Carbon::createFromFormat('d/m/Y H:i:s',$request->get('attendance_date').' '.$employee->getOriginal('duty_start'));
            }

            if($employee->duty_end){
                $workTimes[$employee->id]['out_time'] = Carbon::createFromFormat('d/m/Y H:i:s',$request->get('attendance_date').' '.$employee->getOriginal('duty_end'));
            }

            return $workTimes;
        });


        $dateTimeNow = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
        $attendances = [];
        $absentIds = [];
        $parseError = false;
        foreach ($employees as $employee){

            $inTime = Carbon::createFromFormat('d/m/Y h:i a', $inTimes[$employee]);
            $outTime = Carbon::createFromFormat('d/m/Y h:i a', $outTimes[$employee]);

            if($outTime->lessThan($inTime)){
                $message = "Out time can't be less than in time!";
                $parseError = true;
            }

            $timeDiff  = $inTime->diff($outTime)->format('%H:%I');
            $isPresent = ($timeDiff == "00:00") ? "0" : "1";

            $status = [];
            //late or early out find
            if($timeDiff != "00:00" && isset($workTimes[$employee]) && $workTimes[$employee]['in_time'] && $workTimes[$employee]['out_time']){

                    if($inTime->greaterThan($workTimes[$employee]['in_time'])){
                        $status[] = 1;
                    }

                    if($outTime->lessThan($workTimes[$employee]['out_time'])){
                        $status[] = 2;
                    }



            }

            $attendances[] = [
                "employee_id" => $employee,
                "attendance_date" => $attendance_date,
                "in_time" => $inTime,
                "out_time" => $outTime,
                "working_hour" => $timeDiff,
                "status" => implode(',',$status),
                "present"   => $isPresent,
                "created_at" => $dateTimeNow,
                "created_by" => auth()->user()->id,
            ];

            if(!$isPresent){
                $absentIds[] = $employee;
            }
        }

        if($parseError){
            return redirect()->route('employee_attendance.create')->with("error",$message);
        }

//        dd($attendances);
//        dd($absentIds);

        DB::beginTransaction();
        try {

            EmployeeAttendance::insert($attendances);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('employee_attendance.create')->with("error",$message);
        }


        $message = "Attendance saved successfully.";
        //check if notification need to send?
        $sendNotification = AppHelper::getAppSettings('student_attendance_notification', true);
        if($sendNotification != "0" && $request->has('is_send_notification')) {
            PushEmployeeAbsentJob::dispatch($absentIds, $attendance_date)
                ->onQueue('absent');
        }


        return redirect()->route('employee_attendance.create')->with("success",$message);
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
                $storagepath = $request->file('file')->store('employee-attendance');
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
                    'send_notification' => $request->has('is_send_notification') ? 1 : 0,
                    'attendance_type' => 2,
                ]);

                //push command on queue
                Artisan::queue('attendance:seedEmployee')
                    ->onQueue('commands');

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }

            return redirect()->back();
        }

        $isProcessingFile = false;
        $pendingFile = AttendanceFileQueue::where('attendance_type',2)
            ->where('is_imported','=',0)
            ->orderBy('created_at', 'DESC')
            ->count();

        if($pendingFile){
            $isProcessingFile = true;

        }

        $queueFireUrl = route('employee_attendance_seeder',['code' => 'hr799']);
        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');

        return view('backend.attendance.employee.upload', compact(
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
        $pendingFile = AttendanceFileQueue::where('attendance_type',2)->orderBy('created_at', 'DESC')
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
                $status = "attendance has been imported. Now sending notification for absent employees";
            }
            return [
                'msg' => $status,
                'success' => false,
                'status' => $pendingFile->is_imported
            ];
        }
    }

}
