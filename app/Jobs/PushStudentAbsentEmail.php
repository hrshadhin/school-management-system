<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushStudentAbsentEmail implements ShouldQueue
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
        $attendance_date = date('d/m/Y', strtotime($date));
        $gateway = AppMeta::where('id', AppHelper::getAppSettings('student_attendance_gateway'))->first();
        $gateway = json_decode($gateway->meta_value);

        //pull students
        $students = Registration::whereIn('id', $studentIds)
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

        //compile message
        $template = Template::where('id', AppHelper::getAppSettings('student_attendance_template'))->first();

        foreach ($students as $student){
            $keywords['regi_no'] = $student->regi_no;
            $keywords['roll_no'] = $student->roll_no;
            $keywords['class'] = $student->class->name;
            $keywords['section'] = $student->section->name;
            $studentArray = $student->toArray();
            $keywords = array_merge($keywords ,$studentArray['student']);
            $keywords['date'] = $attendance_date;

            $message = $template->content;
            foreach ($keywords as $key => $value) {
                $message = str_replace('{{' . $key . '}}', $value, $message);
            }

            $cellNumber = AppHelper::validateBangladeshiCellNo($studentArray['student']['father_phone_no']);

            if($cellNumber){

                //with out job hndler
                $smsHelper = new SmsHelper($gateway);
                $res = $smsHelper->sendSms($cellNumber, $message);

                //send to a job handler
//                ProcessSms::dispatch($gateway, $cellNumber, $message)->onQueue('sms');
            }
            else{
                Log::channel('smsLog')->error("Invalid Cell No! ".$studentArray['student']['father_phone_no']);
            }
        }
    }
}
