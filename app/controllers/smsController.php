<?php

class smsController extends \BaseController
{

    public function __construct() 
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth');
        $this->beforeFilter('userAccess', array('only'=> array('index','create','edit','update','smsLog','delete','deleteLog')));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $smses=SMS::all();
        $sms = array();
        return View::Make('app.smsTypes', compact('smses', 'sms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $rules=[
        'type' => 'required',
        'sender' => 'required|max:100',
        'message' => 'required'


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/sms')->withErrors($validator);
        }
        else {
            $sms = new SMS;
            $sms->type= Input::get('type');
            $sms->sender=Input::get('sender');
            $sms->message=Input::get('message');

            $sms->save();
            return Redirect::to('/sms')->with("success", "SMS Format Created Succesfully.");

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $sms = SMS::find($id);
        $smses=SMS::all();
        return View::Make('app.smsTypes', compact('smses', 'sms'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update()
    {
        $rules=[
        'type' => 'required',
        'sender' => 'required|max:100',
        'message' => 'required'


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/sms/edit/'.Input::get('id'))->withErrors($validator);
        }
        else {
            $sms = SMS::find(Input::get('id'));
            $sms->type= Input::get('type');
            $sms->sender=Input::get('sender');
            $sms->message=Input::get('message');
            $sms->save();
            return Redirect::to('/sms')->with("success", "SMS Format Updated Succesfully.");

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function delete($id)
    {
        $sms = SMS::find($id);
        $sms->delete();
        return Redirect::to('/sms')->with(
            "success",
            "SMS Format Deleted Successfully."
        );
    }
    public function getTypeInfo($id)
    {
        return SMS::find($id);
    }
    public function getsmssend()
    {

        $types = SMS::all();
        $classes = ClassModel::select('code', 'name')->orderby('code', 'asc')->get();

        return View::Make("app.smssender", compact('types', 'classes'));
    }
    public function postsmssend()
    {
        $rules=[
        'class' => 'required',
        'session' => 'required',
        'sender' => 'required|max:100',
        'message' => 'required|max:160'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/sms-bulk')->withErrors($validator);
        }
        $inputs = Input::all();
        $smsType = $inputs['type'];
        if($inputs['type'] !="Custom") {
            $smsdbtype= SMS::find($inputs['type']);
            $smsType = $smsdbtype->type;
        }
        
        $students = Student::select('fatherCellNo', 'regiNo')
        ->where('class', $inputs['class'])
        ->where('session', trim($inputs['session']))->get()->toArray();

        if(count($students)) {
            foreach ($students as $student) {
                Queue::push(
                    function ($job) use ($student,$inputs,$smsType) {

                        $regiNo = $student['regiNo'];
                        $phonenumber = $student['fatherCellNo'];
                        $sender = $inputs['sender'];
                        $msg =$inputs['message'];
                        $type =$smsType;

                        $apiResult="Invalid Number";
                        $apiResult="Api Link Not Set!";

                    
                        // Uncomment below codes for production use 
                            
                                
                        /* $phonenumber=str_replace('+', '', $phonenumber);
                        if (strlen($phonenumber)=="11") {
                            $phonenumber="88".$phonenumber;
                        }
                        if (strlen($phonenumber)=="13") {
                            if (preg_match("/^88017/i", "$phonenumber") or preg_match("/^88016/i", "$phonenumber") or preg_match("/^88015/i", "$phonenumber") or preg_match("/^88011/i", "$phonenumber") or preg_match("/^88018/i", "$phonenumber") or preg_match("/^88019/i", "$phonenumber")) {


                                $myaccount=urlencode("shanixlab");
                                $mypasswd=urlencode("123456");
                                $sendBy=urlencode($sender);
                                $api="http://api_link_here?user=".$myaccount."&password=".$mypasswd."&sender=".$sendBy."&SMSText=".$msg."&GSM=".$phonenumber."&type=longSMS";
                                $client = new \Guzzle\Service\Client($api);
                                //  Get your response:
                                $response = $client->get()->send();
                                $status=$response->getBody(true);
                                $apiResult = "SMS SEND";
                                if($status=="-5" || $status=="5") {
                                    $apiResult = $status;
                                }
                            } 
                        }*/

                        $smsLog = new SMSLog();
                        $smsLog->type = $type;
                        $smsLog->sender = $sender;
                        $smsLog->message = $msg;
                        $smsLog->recipient = $phonenumber;
                        $smsLog->regiNo = $regiNo;
                        $smsLog->status = $apiResult;
                        $smsLog->save();
                        $job->delete();
                    }
                );

            }

            return Redirect::to('/sms-bulk')->with(
                "success", 
                count($students)." sms pushed to queue.SMS will recive shortly."
            );

        } else {
            // New MessageBag
            $errorMessages = new Illuminate\Support\MessageBag;
            $errorMessages->add('Not Found', 'There are no student on this session!');
            return Redirect::to('/sms-bulk')->withErrors($errorMessages->all());
        }

    }

    public function getsmsLog()
    {
        $foo="0";
        $smslogs = array();
        return View::Make('app.smsLog', compact('smslogs', 'foo'));
    }
    public function postsmsLog()
    {
        $rules=[
        'fromDate' => 'required',
        'toDate' => 'required'



        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/smslog')->withErrors($validator);
        }
        else {
            $smslogs = SMSLog::select('*')->where(DB::raw('date(created_at)'), '>=', trim(Input::get('fromDate')))
            ->where(DB::raw('date(created_at)'), '<=', trim(Input::get('toDate')))->get();
            $foo="1";
            return View::Make('app.smsLog', compact('smslogs', 'foo'));

        }

    }
    public function deleteLog($id)
    {
        $sms = SMSLog::find($id);
        $sms->delete();
        return Redirect::to('/smslog')->with("success", "SMS Log Deleted Succesfully.");
    }

}
