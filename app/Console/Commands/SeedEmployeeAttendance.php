<?php

namespace App\Console\Commands;

use App\AppMeta;
use App\AttendanceFileQueue;
use App\Employee;
use App\EmployeeAttendance;
use App\Http\Helpers\AppHelper;
use App\Jobs\PushStudentAbsentJob;
use App\Registration;
use App\StudentAttendance;
use App\Template;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $this->fileFormatType = $pendingFile->file_format;
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
                    $totalValidRows++;
                }
            }
            fclose($handle);


            $pendingFile->total_rows = $totalValidRows;
            if(!$totalValidRows){
                $pendingFile->is_imported = -1;
                $pendingFile->save();
                throw new Exception('There are no valid data in this file.');
            }

            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();


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

                }

                //now push back one day data to $dateWiseDate  array
                $dateWiseData[$atndDate] = $cleanEmpWiseData;
            }

            //fetch all employees
            $employeesData = Employee::where('status', AppHelper::ACTIVE)->get()->reduce(function ($employeesData, $employee) {
                $employeesData[$employee->id_card] = [
                    'id' => $employee->id,
                    'in_time' => $employee->duty_start,
                    'out_time' => $employee->duty_end,
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

                    //check if this date data exists on db or not
                    $entryExists = $this->isAttendanceExists($attendance_date);
                    if ($entryExists) {
                        $msg =   "Date '".$atd->format('d/m/Y')."' > attendance override by multiple upload.";
                        Log::channel('employeeattendancelog')->warning($msg);
                        DB::table('employee_attendances')->whereDate('date', '=', $attendance_date)->delete();
                    }

                    DB::beginTransaction();
                    try {
                        //now build data array for insert into db table
                        foreach ($employeesData as $employee => $employeeData) {
                            $isPresent = "0";
                            $status = [];

                            $inTimeObject = Carbon::createFromFormat('YmdHis', $attendance_date."00:00:00");
                            $outTimeObject = Carbon::createFromFormat('YmdHis', $attendance_date."00:00:00");
                            $workingHours  = $inTimeObject->diff($outTimeObject)->format('%H:%I');

                            //check is this employee present
                            if (array_key_exists($employee, $employees)) {
                                $isPresent = "1";
                                $inTimeObject = $employees[$employee]['in_time'];
                                $outTimeObject = $employees[$employee]['out_time'];
                                $workingHours  = $employees[$employee]['workingHours'];

                                //late or early out find
                                if($inTimeObject->greaterThan($employeeData[$employee]['in_time'])){
                                    $status[] = 1;
                                }

                                if($outTimeObject->lessThan($employeeData[$employee]['out_time'])){
                                    $status[] = 2;
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
                                $absentIds[] = $employeeData['id'];
                            }

                        }

                        DB::commit();
                        $msg =  "Date '".$atd->format('d/m/Y')."' Total ".$totalEmployee." entry successfully stored.";
                        Log::channel('employeeattendancelog')->info($msg);


                    }catch (\Exception $e) {
                        DB::rollback();
                        $msg =  "Date '".$atd->format('d/m/Y')."' data insert problem. ".$e->getMessage();
                        Log::channel('employeeattendancelog')->error($msg);
                    }


                    //write log in more entry found rather than db employee list
                    $totalEmployeeInFile = count($employees);
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
        catch (Exception $e){
            $pendingFile->is_imported = -1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();
            $errorMSG = $e->getMessage();
            Log::channel('employeeattendancelog')->critical($errorMSG);
            return false;
        }

        //process absent attendance student
        $absentStudentIdsByDate = [];
        try {
            //find absent students
            foreach ($presentStudentsByClass as $pDate => $stClasses){
                $absentAttendances = [];
                $dateTimeNow = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

                foreach ($stClasses as $class_id => $value){
                    $absentStudents = Registration::where('status', AppHelper::ACTIVE)
                        ->where('class_id', $class_id)
                        ->whereDoesntHave('attendance' , function ($query) use($pDate) {
                            $query->select('registration_id')
                                ->whereDate('attendance_date', $pDate);
                        })
                        ->select('id','regi_no','roll_no')
                        ->get();

                    foreach ($absentStudents as $student){
                        $absentAttendances[] = [
                            "registration_id" => $student->id,
                            "attendance_date" => $pDate,
                            "present"   => "0",
                            "created_at" => $dateTimeNow,
                            "created_by" => $this->createdBy,
                        ];

                        $absentStudentIdsByDate[$pDate][] = $student->id;
                    }
                }

                StudentAttendance::insert($absentAttendances);
                Log::channel('studentattendancelog')->info('Total '.count($absentAttendances).' absent student attendance insert for '.$pDate);
            }
        }
        catch (Exception $e){
            $pendingFile->is_imported = -1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();
            $errorMSG = $e->getMessage();
            Log::channel('studentattendancelog')->critical($errorMSG);
            return false;
        }

        //send notification for absent
        try {
            foreach ($absentStudentIdsByDate as $attendance_date => $absentIds) {

                //todo: need uncomment these code on client deploy
//                $sendNotification = AppHelper::getAppSettings('student_attendance_notification');
//                if ($sendNotification != "0") {
//                    if ($sendNotification == "1") {
//                        //then send sms notification
//                        //get sms gateway information
//                        $gateway = AppMeta::where('id', AppHelper::getAppSettings('student_attendance_gateway'))->first();
//                        if (!$gateway) {
//                            Log::channel('studentabsentlog')->error("SMS Gateway not setup!");
//                        }
//
//                        //get sms template information
//                        $template = Template::where('id', AppHelper::getAppSettings('student_attendance_template'))->first();
//                        if (!$template) {
//                            Log::channel('studentabsentlog')->error("Template not setup!");
//                        }
//
//                        $res = AppHelper::sendAbsentNotificationForStudentViaSMS($absentIds, $attendance_date);
//
//                    }
//                }

                //push job to queue
                //todo: need comment these code on client deploy
                PushStudentAbsentJob::dispatch($absentIds, $attendance_date);
            }
            $pendingFile->is_imported = 1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();
        }
        catch (Exception $e){

            $pendingFile->is_imported = -1;
            $pendingFile->updated_by = $this->createdBy;
            $pendingFile->save();

            $errorMSG = $e->getMessage();
            Log::channel('studentattendancelog')->critical($errorMSG);
            return false;
        }


        $msg = "========File Queue Command Complete========";
        Log::channel('studentattendancelog')->info($msg);


    }

    private function isAttendanceExists($attendance_date) {
        return $attendances = EmployeeAttendance::whereDate('attendance_date', $attendance_date)
            ->CountOrGet(true);
    }
}
