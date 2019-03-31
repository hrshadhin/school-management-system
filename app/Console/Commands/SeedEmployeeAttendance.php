<?php

namespace App\Console\Commands;

use App\AppMeta;
use App\AttendanceFileQueue;
use App\Employee;
use App\EmployeeAttendance;
use App\Http\Helpers\AppHelper;
use App\Jobs\PushEmployeeAbsentJob;
use App\Jobs\PushStudentAbsentJob;
use App\Registration;
use App\StudentAttendance;
use App\Template;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SeedEmployeeAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:seedEmployee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automated employee attendance seeder from txt file.';

    protected $fileFormatType = 0;
    protected $createdBy = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $pendingFile = AttendanceFileQueue::where('attendance_type',2)
            ->where('is_imported','=',0)
            ->orderBy('created_at', 'DESC')
            ->first();

        if(!$pendingFile){
            Log::channel('employeeattendancelog')->info('No pending task!');
            return false;
        }

        //set file format
        $this->fileFormatType = intval($pendingFile->file_format);
        $this->createdBy = $pendingFile->created_by;

        $filePath = storage_path('app/employee-attendance/').$pendingFile->file_name;
        if(!file_exists($filePath)){
            Log::channel('employeeattendancelog')->critical('File not found! '.$pendingFile->file_name);
            return false;
        }

        //data imported class
        $presentStudentsByClass = [];

        //process present attendance student
        try{

            $dateWiseData = [];
            $totalValidRows = 0;
            //open the file and get line and process it
            $linecount = 0;
            $handle = fopen($filePath, "r");
            while(!feof($handle)){
                $line = fgets($handle, 4096);
                $linecount = $linecount + substr_count($line, PHP_EOL);

                if(!$linecount){
                    throw new Exception("File is empty.");
                }

                $valid = AppHelper::isLineValid($line);
                if(!$valid){
                    Log::channel('employeeattendancelog')->critical("Contain invalid data at line number ".$linecount);
                }

                $row = AppHelper::parseRowForEmployee($line, $this->fileFormatType);

                if(count($row)){
                    $dateWiseData[$row['date']][] = [
                        'empId' => $row['id'],
                        'time' => $row['time']
                    ];

                }
            }
            fclose($handle);



            $isFail = false;

            //now process data for one day
            foreach ($dateWiseData as $key => $oneDayData) {
                //build employee wise data
                $empWiseData = [];
                foreach ($oneDayData as $data) {
                    $empWiseData[$data['empId']][] = $data['time'];
                }

                $atndDate = $key;

                //now clean employee multiple entry
                $cleanEmpWiseData = [];
                foreach ($empWiseData as $empId => $entries) {
                    sort($entries);
                    $entryCount = count($entries);
                    $inTime = $entries[0];
                    $outTime = $entryCount > 1 ? $entries[$entryCount - 1] : $inTime;

                    $inTimeObject = Carbon::createFromFormat('YmdHis', $atndDate.$inTime);
                    $outTimeObject = Carbon::createFromFormat('YmdHis', $atndDate.$outTime);
                    $workTime  = $inTimeObject->diff($outTimeObject)->format('%H:%I');


                    $cleanEmpWiseData[$empId] = [
                        'inTime' => $inTimeObject,
                        'outTime' => $outTimeObject,
                        'workingHours' => $workTime
                    ];

                    $totalValidRows++;

                }

                //now push back one day data to $dateWiseDate  array
                $dateWiseData[$atndDate] = $cleanEmpWiseData;
            }

            $pendingFile->total_rows = $totalValidRows;
            $pendingFile->imported_rows = 0;
            if(!$totalValidRows){
                $pendingFile->is_imported = -1;
                $pendingFile->save();
                throw new Exception('There are no valid data in this file.');
            }

            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();


            //fetch all employees
            $employeesData = Employee::where('status', AppHelper::ACTIVE)->get()->reduce(function ($employeesData, $employee) {
                $employeesData[$employee->id_card] = [
                    'id' => $employee->id,
                    'in_time' => $employee->getOriginal('duty_start'),
                    'out_time' => $employee->getOriginal('duty_end'),
                ];
                return $employeesData;
            });

            $totalEmployee = count(array_keys($employeesData));
            $absentIds = [];

            if($totalEmployee){
                //ready to insert data to db
                $dateTimeNow = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

                foreach ($dateWiseData as $date => $employees) {
                    $atd = new \DateTime(date('Ymd', strtotime($date)));
                    $attendance_date = $atd->format('Y-m-d');
                    $attendances = [];

                    //check if this date data exists on db or not
                    $entryExists = $this->isAttendanceExists($attendance_date);
                    if ($entryExists) {
                        $msg =   "Date '".$atd->format('d/m/Y')."' > attendance override by multiple upload.";
                        Log::channel('employeeattendancelog')->warning($msg);
                        DB::table('employee_attendances')->whereDate('attendance_date', '=', $attendance_date)->delete();
                    }

                    DB::beginTransaction();
                    try {
                        //now build data array for insert into db table
                        foreach ($employeesData as $employee => $employeeData) {
                            $isPresent = "0";
                            $status = [];

                            $inTimeObject = Carbon::createFromFormat('Y-m-dH:i:s', $attendance_date."00:00:00");
                            $outTimeObject = Carbon::createFromFormat('Y-m-dH:i:s', $attendance_date."00:00:00");
                            $workingHours  = $inTimeObject->diff($outTimeObject)->format('%H:%I');

                            //check is this employee present
                            if (array_key_exists($employee, $employees)) {
                                $isPresent = "1";
                                $inTimeObject = $employees[$employee]['inTime'];
                                $outTimeObject = $employees[$employee]['outTime'];
                                $workingHours  = $employees[$employee]['workingHours'];

                                //late or early out find
                                if($employeeData['in_time'] && $employeeData['out_time']) {
                                    $empIntime = Carbon::createFromFormat('Y-m-d H:i:s',$attendance_date.' '.$employeeData['in_time']);
                                    if ($inTimeObject->greaterThan($empIntime)) {
                                        $status[] = 1;
                                    }

                                    $empOuttime = Carbon::createFromFormat('Y-m-d H:i:s',$attendance_date.' '.$employeeData['out_time']);
                                    if ($outTimeObject->lessThan($empOuttime)) {
                                        $status[] = 2;
                                    }
                                }

                            }

                            $attendances[] = [
                                "employee_id" => $employeeData['id'],
                                "attendance_date" => $attendance_date,
                                "in_time" => $inTimeObject,
                                "out_time" => $outTimeObject,
                                "working_hour" => $workingHours,
                                "status" => implode(',',$status),
                                "present"   => $isPresent,
                                "created_at" => $dateTimeNow,
                                "created_by" => $this->createdBy,
                            ];

                            if(!$isPresent){
                                $absentIds[$attendance_date][] = $employeeData['id'];
                            }

                        }
                        EmployeeAttendance::insert($attendances);
                        DB::commit();
                        $msg =  "Date '".$atd->format('d/m/Y')."' Total ".$totalEmployee." entry successfully stored.";
                        Log::channel('employeeattendancelog')->info($msg);


                    }
                    catch (\Exception $e) {
                        DB::rollback();
                        $msg =  "Date '".$atd->format('d/m/Y')."' data insert problem. ".$e->getMessage();
                        Log::channel('employeeattendancelog')->error($msg);
                    }



                    $totalEmployeeInFile = count($employees);
                    $pendingFile->imported_rows += $totalEmployeeInFile;
                    $pendingFile->save();

                    //write log in more entry found rather than db employee list
                    if($totalEmployee<$totalEmployeeInFile){
                        $msg =   "Date '".$atd->format('d/m/Y')."' > ".($totalEmployeeInFile-$totalEmployee)." employee not found in db but found in attendance file!";
                        Log::channel('employeeattendancelog')->warning($msg);
                    }


                }
            }
            else{
                $isFail = true;
                Log::channel('employeeattendancelog')->critical("Employee not found on Database!");
            }


            if($isFail) {
                $pendingFile->is_imported = - 1;
                $pendingFile->updated_by = $this->createdBy;
                $pendingFile->save();
            }

        }
        catch (\Exception $e){
            $pendingFile->is_imported = -1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();
            $errorMSG = $e->getMessage();
            Log::channel('employeeattendancelog')->critical($errorMSG);
            return false;
        }

        //send notification for absent
        try {
            foreach ($absentIds as $attendance_date => $employeeIds) {
                //todo: need uncomment these code on client deploy
//                $sendNotification = AppHelper::getAppSettings('employee_attendance_notification');
//                if ($sendNotification != "0") {
//                    if ($sendNotification == "1") {
//                        //then send sms notification
//                        //get sms gateway information
//                        $gateway = AppMeta::where('id', AppHelper::getAppSettings('employee_attendance_gateway'))->first();
//                        if (!$gateway) {
//                            Log::channel('employeeattendancelog')->error("SMS Gateway not setup!");
//                        }
//
//                        //get sms template information
//                        $template = Template::where('id', AppHelper::getAppSettings('employee_attendance_template'))->first();
//                        if (!$template) {
//                            Log::channel('employeeattendancelog')->error("Template not setup!");
//                        }
//
//                        $res = AppHelper::sendAbsentNotificationForEmployeeViaSMS($employeeIds, $attendance_date);
//
//                    }
//                }

                //push job to queue
                //todo: need comment these code on client deploy
                PushEmployeeAbsentJob::dispatch($employeeIds, $attendance_date);
            }
            $pendingFile->is_imported = 1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();
        }
        catch (\Exception $e){

            $pendingFile->is_imported = -1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();

            $errorMSG = $e->getMessage();
            Log::channel('employeeattendancelog')->critical($errorMSG);
            return false;
        }


        $msg = "========File Queue Command Complete========";
        Log::channel('employeeattendancelog')->info($msg);


    }

    private function isAttendanceExists($attendance_date) {
        return $attendances = EmployeeAttendance::whereDate('attendance_date', $attendance_date)
            ->CountOrGet(true);
    }
}
