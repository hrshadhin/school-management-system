<?php

namespace App\Console\Commands;

use App\AppMeta;
use App\AttendanceFileQueue;
use App\Http\Helpers\AppHelper;
use App\Jobs\PushStudentAbsentJob;
use App\Registration;
use App\StudentAttendance;
use App\Template;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SeedStudentAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:seedStudent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automated student attendance seeder from txt file.';

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

        $pendingFile = AttendanceFileQueue::where('is_imported','=',0)
            ->orderBy('created_at', 'DESC')
            ->first();

        if(!$pendingFile){
            Log::channel('studentattendancelog')->info('No pending task!');
            return false;
        }

        //set file format
        $this->fileFormatType = $pendingFile->file_format;
        $this->createdBy = $pendingFile->created_by;

        $filePath = storage_path('app/student-attendance/').$pendingFile->file_name;
        if(!file_exists($filePath)){
            Log::channel('studentattendancelog')->critical('File not found! '.$pendingFile->file_name);
            return false;
        }

        //data imported class
        $presentStudentsByClass = [];

        //process present attendance student
        try{

            $attendanceData = [];
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
                    Log::channel('studentattendancelog')->critical("Contain invalid data at line number ".$linecount);
                }

                $row = AppHelper::parseRow($line, $this->fileFormatType);
                if(count($row)){
                    if(!isset($attendanceData[$row['date']][$row['id']])){
                        $totalValidRows++;
                    }
                    $attendanceData[$row['date']][$row['id']] = true;
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


            $dateTimeNow = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
            $isFail = false;

            //now insert those data to db and
            foreach ($attendanceData as $kdate => $regiNumbers) {
                try
                {
                    // now fetch student id and class info
                    $regiNumbers = array_keys($regiNumbers);
                    $presentStudents = Registration::select('id','class_id','regi_no')
                        ->where('status', AppHelper::ACTIVE)
                        ->whereIn('regi_no', $regiNumbers)
                        ->get();

                    $insertCounter = 0;
                    foreach ($presentStudents as $student){

                        //extract class id from here
                        $presentStudentsByClass[$kdate][$student->class_id] = true;

                        $entryExists = StudentAttendance::whereDate('attendance_date', '=', $kdate)->where('registration_id', '=', $student->id)->count();
                        if(!$entryExists) {

                            $singleAttendance = [
                                "registration_id" => $student->id,
                                "attendance_date" => $kdate,
                                "present"   => "1",
                                "created_at" => $dateTimeNow,
                                "created_by" => $this->createdBy,
                            ];

                            StudentAttendance::insert($singleAttendance);

                            $pendingFile->imported_rows = $pendingFile->imported_rows + 1;
                            $pendingFile->save();

                            $insertCounter++;
                        }
                        else{
                            Log::channel('studentattendancelog')->warning('Attendance already exists for '.$student->regi_no.' and '.$kdate);
                        }

                    }

                    Log::channel('studentattendancelog')->info('Total '.$insertCounter.' student attendance insert for '.$kdate);

                }catch (\Exception $e) {
                    $isFail = true;
                    $msg =  "Date '".$kdate."' data insert problem. ".$e->getMessage();
                    Log::channel('studentattendancelog')->critical($msg);

                }

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
            Log::channel('studentattendancelog')->critical($errorMSG);
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
}
