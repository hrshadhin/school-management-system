<?php

namespace App\Jobs;

use App\AppMeta;
use App\Http\Helpers\AppHelper;
use App\Mail\StudentAbsent;
use App\Registration;
use App\Template;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PushStudentAbsentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $studentIds = [];
    private $attendance_date = '';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($studentIds, $attendance_date)
    {
        $this->studentIds = $studentIds;
        $this->attendance_date = $attendance_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //check if notification need to send?
        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');
        if($sendNotification != "0") {

            if($sendNotification == "1"){
                //then send sms notification
                //get sms gateway information
                $gateway = AppMeta::where('id', AppHelper::getAppSettings('student_attendance_gateway'))->first();
                if(!$gateway){
                    Log::channel('studentabsentlog')->error("SMS Gateway not setup!");
                    return;
                }

                $this->makeNotificationJob($gateway);

            }

            if($sendNotification == "2"){
                //then send email notification
                $this->makeNotificationJob();
            }
        }
    }


    private function makeNotificationJob($gateway=null) {

        //decode if have $gateway
        if($gateway){
            $gateway = json_decode($gateway->meta_value);
        }

        $attendance_date = date('d/m/Y', strtotime($this->attendance_date));
        //pull students
        $students = $this->getStudents();

        //get sms template information
        $template = Template::where('id', AppHelper::getAppSettings('student_attendance_template'))->first();
        if(!$template){
            Log::channel('studentabsentlog')->error("Template not setup!");
            return;
        }


        foreach ($students as $student){
            $keywords['regi_no'] = $student->regi_no;
            $keywords['roll_no'] = $student->roll_no;
            $keywords['class'] = $student->class->name;
            $keywords['section'] = $student->section->name;
            $studentData = $student->toArray();
            $keywords = array_merge($keywords ,$studentData['student']);
            $keywords['date'] = $attendance_date;

            $message = $template->content;
            foreach ($keywords as $key => $value) {
                $message = str_replace('{{' . $key . '}}', $value, $message);
            }

            if($gateway) {
                $cellNumber = AppHelper::validateBangladeshiCellNo($studentData['student']['father_phone_no']);
                if ($cellNumber) {
                    //send to a job handler
                    ProcessSms::dispatch($gateway, $cellNumber, $message)->onQueue('sms');
                } else {
                    Log::channel('smsLog')->error("Invalid Cell No! " . $studentData['student']['father_phone_no']);
                }
            }
            else{
                // make email notification jobs here
                //check if have email for this student
                if(strlen($studentData['student']['email'])){
                    //send to a job handler
                    $emailBody = (new StudentAbsent($message))
                        ->onQueue('email');

                    Mail::to($studentData['student']['email'])
                        ->queue($emailBody);
                }
                else{
                    Log::channel('studentabsentlog')->error("Student \" ".$studentData['student']['name'] ."\" has no email address!");
                }
            }
        }
    }

    private function getStudents(){

        return Registration::whereIn('id', $this->studentIds)
            ->where('status', AppHelper::ACTIVE)
            ->with(['class' => function($query) {
                $query->select('name','id');
            }])
            ->with(['section' => function($query) {
                $query->select('name','id');
            }])
            ->with('student')
            ->select('id','regi_no','roll_no','student_id','class_id','section_id')
            ->get();
    }
}
