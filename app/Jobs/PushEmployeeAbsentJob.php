<?php

namespace App\Jobs;

use App\AppMeta;
use App\Employee;
use App\Http\Helpers\AppHelper;
use App\Mail\EmployeeAbsent;
use App\Template;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PushEmployeeAbsentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $employeeIds = [];
    private $attendance_date = '';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employeeIds, $attendance_date)
    {
        $this->employeeIds = $employeeIds;
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
        $sendNotification = AppHelper::getAppSettings('employee_attendance_notification', true);
        if($sendNotification != "0") {

            if($sendNotification == "1"){
                //then send sms notification
                //get sms gateway information
                $gateway = AppMeta::where('id', AppHelper::getAppSettings('employee_attendance_gateway', true))->first();
                if(!$gateway){
                    Log::channel('employeeabsentlog')->error("SMS Gateway not setup!");
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
        $employees = $this->getEmployees();

        //get sms template information
        $template = Template::where('id', AppHelper::getAppSettings('employee_attendance_template', true))->first();
        if(!$template){
            Log::channel('employeeabsentlog')->error("Template not setup!");
            return;
        }


        foreach ($employees as $employee){

            $keywords = $employee->toArray();
            $keywords['date'] = $attendance_date;
            $keywords['username'] = $keywords['user']['username'];
            unset($keywords['user']);

            $message = $template->content;
            foreach ($keywords as $key => $value) {
                $message = str_replace('{{' . $key . '}}', $value, $message);
            }

            if($gateway) {
                $cellNumber = AppHelper::validateCellNo($employee->phone_no);
                if ($cellNumber) {
                    //send to a job handler
                    ProcessSms::dispatch($gateway, $cellNumber, $message)->onQueue('sms');
                } else {
                    Log::channel('smsLog')->error("Invalid Cell No! " . $employee->phone_no);
                }
            }
            else{
                // make email notification jobs here
                //check if have email for this employee
                if(strlen($employee->email)){
                    //send to a job handler
                    $emailBody = (new EmployeeAbsent($message))
                        ->onQueue('email');

                    Mail::to($employee->email)
                        ->queue($emailBody);
                }
                else{
                    Log::channel('employeeabsentlog')->error("Employee \" ".$employee->name ."\" has no email address!");
                }
            }
        }
    }

    private function getEmployees(){

        return Employee::whereIn('id', $this->employeeIds)
            ->where('status', AppHelper::ACTIVE)
            ->with('user')
            ->select('id','name','designation','dob','gender','religion','email','phone_no','address','joining_date','user_id')
            ->get();
    }
}
