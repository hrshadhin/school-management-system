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
use Exception;

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

        $pendingFile = AttendanceFileQueue::where('attendance_type',1)
            ->where('is_imported','=',0)
            ->orderBy('created_at', 'DESC')
            ->first();

        if(!$pendingFile){
            Log::channel('studentattendancelog')->info('No pending task!');
            return false;
        }

        //set file format
        $this->fileFormatType = intval($pendingFile->file_format);
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

                    $attendanceData[$row['date']][] = [
                            'studentId' => $row['id'],
                            'time' => $row['time']
                        ];

                }
            }
            fclose($handle);

            //now process data for one day
            foreach ($attendanceData as $key => $oneDayData) {
                //build student wise data
                $studentWiseData = [];
                foreach ($oneDayData as $data) {
                    $studentWiseData[$data['studentId']][] = $data['time'];
                }

                $atndDate = $key;
                //now clean student multiple entry
                $cleanstudentWiseData = [];
                foreach ($studentWiseData as $studentId => $entries) {
                    sort($entries);
                    $entryCount = count($entries);
                    $inTime = $entries[0];
                    $outTime = $entryCount > 1 ? $entries[$entryCount - 1] : $inTime;

                    $inTimeObject = Carbon::createFromFormat('YmdHis', $atndDate.$inTime);
                    $outTimeObject = Carbon::createFromFormat('YmdHis', $atndDate.$outTime);
                    $stayingTime  = $inTimeObject->diff($outTimeObject)->format('%H:%I');


                    $cleanstudentWiseData[$studentId] = [
                        'inTime' => $inTimeObject,
                        'outTime' => $outTimeObject,
                        'stayingHours' => $stayingTime
                    ];

                    $totalValidRows++;

                }
                //now push back one day data to $dateWiseDate  array
                $attendanceData[$atndDate] = $cleanstudentWiseData;
            }


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

            //pull shift running time
            //fetch institute shift running times
            $shiftData = AppHelper::getAppSettings('shift_data');
            if($shiftData){
                $shiftData = json_decode($shiftData, true);
            }
            $shiftRuningTimes = [];

            foreach ($shiftData as $shift => $times){
                $shiftRuningTimes[$shift] = [
                    'start' => $times['start'],
                    'end' => $times['end']
                ];
            }

            //now insert those data to db and
            foreach ($attendanceData as $kdate => $studentData) {
                try
                {
                    $atd = new \DateTime(date('Ymd', strtotime($kdate)));
                    $attendance_date = $atd->format('Y-m-d');

                    // now fetch student id and class info
                    $regiNumbers = array_keys($studentData);
                    $presentStudents = Registration::select('id','class_id','regi_no','academic_year_id','shift')
                        ->where('status', AppHelper::ACTIVE)
                        ->whereIn('regi_no', $regiNumbers)
                        ->get();

                    $insertCounter = 0;
                    foreach ($presentStudents as $student){

                        //extract class id from here
                        $presentStudentsByClass[$attendance_date][$student->class_id] = $student->academic_year_id;

                        $entryExists = StudentAttendance::whereDate('attendance_date', '=', $attendance_date)
                            ->where('registration_id', '=', $student->id)
                            ->where('academic_year_id', $student->academic_year_id)
                            ->where('class_id', $student->class_id)
                            ->count();

                        if(!$entryExists) {

                            //find is late or early out
                            $inTime = $studentData[$student->regi_no]['inTime'];
                            $outTime = $studentData[$student->regi_no]['outTime'];
                            $timeDiff  = $inTime->diff($outTime)->format('%H:%I');
                            $status = [];
                            //late or early out find
                            if($timeDiff != "00:00" && strlen($student->shift) && isset($shiftRuningTimes[$student->shift])){

                                $shiftStart = Carbon::createFromFormat('Y-m-dH:i:s', $attendance_date.$shiftRuningTimes[$student->shift]['start']);
                                $shiftEnd = Carbon::createFromFormat('Y-m-dH:i:s', $attendance_date.$shiftRuningTimes[$student->shift]['end']);

                                if($inTime->greaterThan($shiftStart)){
                                    $status[] = 1;
                                }

                                if($outTime->lessThan($shiftEnd)){
                                    $status[] = 2;
                                }



                            }

                            $singleAttendance = [
                                "academic_year_id" => $student->academic_year_id,
                                "class_id" => $student->class_id,
                                "registration_id" => $student->id,
                                "attendance_date" => $kdate,
                                "in_time" => $inTime,
                                "out_time" => $outTime,
                                "staying_hour" => $timeDiff,
                                "status" => implode(',',$status),
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

                foreach ($stClasses as $class_id => $academicYear){
                    $absentStudents = Registration::where('status', AppHelper::ACTIVE)
                        ->where('academic_year_id', $academicYear)
                        ->where('class_id', $class_id)
                        ->whereDoesntHave('attendance' , function ($query) use($pDate, $academicYear, $class_id) {
                            $query->select('registration_id')
                                ->where('academic_year_id', $academicYear)
                                ->where('class_id', $class_id)
                                ->whereDate('attendance_date', $pDate);
                        })
                        ->select('id','regi_no','roll_no','class_id','academic_year_id')
                        ->get();

                    //find is late or early out
                    $inTime = Carbon::createFromFormat('Y-m-dHis', $pDate.'000000');
                    $outTime = $inTime;
                    $timeDiff  = $inTime->diff($outTime)->format('%H:%I');
                    $status = [];

                    foreach ($absentStudents as $student){
                        $absentAttendances[] = [
                            "academic_year_id" => $student->academic_year_id,
                            "class_id" => $student->class_id,
                            "registration_id" => $student->id,
                            "attendance_date" => $pDate,
                            "in_time" => $inTime,
                            "out_time" => $outTime,
                            "staying_hour" => $timeDiff,
                            "status" => implode(',',$status),
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
