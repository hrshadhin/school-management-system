<?php
Class formfoo{

}
use Illuminate\Support\Collection;
class attendanceController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('index','create','show','edit','update','delete','getlist')));
        $this->beforeFilter('userAccess',array('only'=> array('delete')));

    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $classes=array();
        $classes2 = ClassModel::select('code','name')->orderby('code','asc')->get();
        $subjects = Subject::lists('name','code');
        $attendance=array();
        return View::Make('app.attendanceCreate',compact('classes2','classes','subjects','attendance'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
    {



        $rules = [
            'class' => 'required',
            'section' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'regiNo' => 'required',
            'date' => 'required',
            'subject' => 'required'

        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/attendance/create')->withInput(Input::all())->withErrors($validator);
        } else {

            $exits = Attendance::select('date')
                ->where('class', Input::get('class'))
                ->where('section', Input::get('section'))
                ->where('shift', Input::get('shift'))
                ->where('session', trim(Input::get('session')))
                ->where('subject', Input::get('subject'))
                ->where('date', $this->parseAppDate(Input::get('date')))->get();
            if (count($exits) > 0) {
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Duplicate', 'Attendance already saved!!');
                return Redirect::to('/attendance/create')->withErrors($errorMessages);
            } else {

                $absentStudents = array();
                $students = Input::get('regiNo');
                $presents = Input::get('present');
                $all = false;
                if ($presents == null) {
                    $all = true;
                } else {
                    $ids = array_keys($presents);

                }
                $stpresent = array();

                foreach ($students as $student) {

                    $st = array();
                    $st['regiNo'] = $student;
                    if ($all) {
                        $st['status'] = 'No';


                    } else {
                        $st['status'] = $this->checkPresent($student, $ids);


                    }
                    if ($st['status'] == "No") {
                        array_push($absentStudents, $student);
                    }
                    array_push($stpresent, $st);
                }

                foreach ($stpresent as $stp) {
                    $attendance = new Attendance;
                    $attendance->class = Input::get('class');
                    $attendance->section = Input::get('section');
                    $attendance->shift = Input::get('shift');
                    $attendance->session = trim(Input::get('session'));
                    $attendance->subject = Input::get('subject');
                    $attendance->regiNo = $stp['regiNo'];
                    $attendance->status = $stp['status'];
                    $attendance->date = $this->parseAppDate(Input::get('date'));

                    $attendance->save();

                }
                //get sms format
                //loop absent student and get father's no and send sms
                $isSendSMS = Input::get('isSendSMS');
                if ($isSendSMS == null) {
                    return Redirect::to('/attendance/create')->with("success", "Students attendance save Succesfully.");

                } else {

                     if(count($absentStudents) > 0) {

                         foreach ($absentStudents as $absst) {
                             $student=	DB::table('Student')
                                 ->join('Class', 'Student.class', '=', 'Class.code')
                                 ->select( 'Student.regiNo','Student.rollNo','Student.firstName','Student.middleName','Student.lastName','Student.fatherCellNo','Class.Name as class')
                                 ->where('Student.regiNo','=',$absst)
                                 ->where('class',Input::get('class'))
                                 ->first();
                             $msg = "Dear Parents your Child (Name-".$student->firstName." ".$student->middleName." ".$student->lastName.", Class- ".$student->class." , Roll- ".$student->rollNo." ) is Absent in School today.";
                           //  $fatherCellNo = Student::select('fatherCellNo','')->where('regiNo', $absst)->first();

                             $response = $this->sendSMS($student->fatherCellNo,"Supersoft", $msg);
                             $smsLog = new SMSLog();
                             $smsLog->type = "Attendance";
                             $smsLog->sender = "Supersoft";
                             $smsLog->message = $msg;
                             $smsLog->recipient = $student->fatherCellNo;
                             $smsLog->regiNo = $absst;
                             $smsLog->status = $response;
                             $smsLog->save();
                         }
                         return Redirect::to('/attendance/create')->with("success", "Students attendance saved and " . count($absentStudents) . " sms send to father numbers.");
                     }
                    else
                    {
                        return Redirect::to('/attendance/create')->with("success", "Students attendance save Succesfully.");

                    }

                }
            }
        }

	}
    private function sendSMS($number,$sender,$msg)
    {
        $phonenumber = $number;


        $phonenumber=str_replace('+','',$phonenumber);
        if (strlen($phonenumber)=="11")
        {
            $phonenumber="88".$phonenumber;
        }
        if (strlen($phonenumber)=="13")
        {
            if (preg_match ("/^88017/i", "$phonenumber") or preg_match ("/^88016/i", "$phonenumber") or preg_match ("/^88015/i", "$phonenumber") or preg_match ("/^88011/i", "$phonenumber") or preg_match ("/^88018/i", "$phonenumber") or preg_match ("/^88019/i", "$phonenumber"))
            {


                $myaccount=urlencode("supersoft");
                $mypasswd=urlencode("0qMLQO");
                $sendBy=urlencode($sender);
                $api="http://api.infobip.com/api/v3/sendsms/plain?user=".$myaccount."&password=".$mypasswd."&sender=".$sendBy."&SMSText=".$msg."&GSM=".$phonenumber."&type=longSMS";
                $client = new \Guzzle\Service\Client($api);
                //  Get your response:
                $response = $client->get()->send();

                $body=$response->xml();
                $status=$body->result->status;
                if($status=="0")
                {
                  return "SMS SEND";
                }

                return $status;

            }
            else
            {
                return "Invalid Number";
            }
        }
        else
        {
            return "Invalid Number";
        }
    }
    private function  parseAppDate($datestr)
    {
        $date = explode('-', $datestr);
        return $date[2].'-'.$date[1].'-'.$date[0];
    }
    private  function checkPresent($regiNo,$ids)

   {

       for($i=0;$i<count($ids);$i++)
       {

           if($regiNo==$ids[$i])
           {
             return 'Yes';
           }
       }
       return 'No';
   }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
        $formdata = new formfoo;
        $formdata->class="";
        $formdata->section="";
        $formdata->shift="";
        $formdata->session="";
        $formdata->subject="";
        $formdata->date="";
        $classes = ClassModel::select('code','name')->orderby('code','asc')->get();

        $attendance=array();


        //$formdata["class"]="";
        return View::Make('app.attendanceList',compact('classes','attendance','formdata'));
	}

    public function getlist()
    {

        $rules=[
            'class' => 'required',
            'section' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'date' => 'required',
            'subject' => 'required',

        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/attendance/list/')->withErrors($validator);
        }
        else {
            $classes2 = ClassModel::orderby('code','asc')->lists('name','code');
            $subjects = Subject::where('class',Input::get('class'))->lists('name','code');
            $attendance=	DB::table('Attendance')
                ->join('Student', 'Attendance.regiNo', '=', 'Student.regiNo')
                ->select('Attendance.id','Attendance.regiNo','Student.rollNo', 'Student.firstName','Student.middleName','Student.lastName', 'Attendance.status')
                ->where('Attendance.class','=',Input::get('class'))
                ->where('Attendance.section','=',Input::get('section'))
                ->Where('Attendance.shift','=',Input::get('shift'))
                ->where('Attendance.session','=',trim(Input::get('session')))
                ->where('Attendance.subject','=',Input::get('subject'))
                ->where('Attendance.date','=',$this->parseAppDate(Input::get('date')))
                ->get();

            $formdata = new formfoo;
            $formdata->class=Input::get('class');
            $formdata->section=Input::get('section');
            $formdata->shift=Input::get('shift');
            $formdata->session=Input::get('session');
            $formdata->subject=Input::get('subject');
            $formdata->date=Input::get('date');

            if(count($attendance)==0)
            {
                $noResult = array("noresult"=>"No Attendance Found!!");
                return View::Make('app.attendanceList',compact('classes2','attendance','subjects','formdata','noResult'));
                //return Redirect::to('/attendance/list')->withInput(Input::all())->with("noresult","No Attendance Found!!");
            }

            return View::Make('app.attendanceList',compact('classes2','attendance','subjects','formdata'));
        }
    }
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $attendance=DB::table('Attendance')
            ->join('Student', 'Attendance.regiNo', '=', 'Student.regiNo')
            ->select('Attendance.id','Attendance.regiNo','Student.rollNo', 'Student.firstName','Student.middleName','Student.lastName', 'Attendance.status')
            ->where('Attendance.id','=',$id)
            ->first();
        return View::Make('app.attendanceEdit',compact('attendance'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$attd = Attendance::find(Input::get('id'));
        $ispresent = Input::get('ispresent');
        if($ispresent==null)
        {
            $attd->status="No";

        }
        else
        {
            $attd->status="Yes";

        }
        $attd->save();
        echo '<script> alert("attendacne updated successfully.");window.close();</script>';
	}


public  function printlist($class,$section,$shift,$session,$subject,$date)
{
    if($class!="" && $section !="" && $shift !="" && $subject !="" && $date) {
        $className = ClassModel::select('name')->where('code',$class)->first();
        $subjectName = Subject::select('name')->where('code',$subject)->first();
        $attendance = DB::table('Attendance')
            ->join('Student', 'Attendance.regiNo', '=', 'Student.regiNo')
            ->select('Attendance.id', 'Attendance.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName', 'Attendance.status')
            ->where('Attendance.class', '=', $class)
            ->where('Attendance.section', '=',$section)
            ->Where('Attendance.shift', '=', $shift)
            ->where('Attendance.session', '=', trim($session))
            ->where('Attendance.subject', '=', $subject)
            ->where('Attendance.date', '=', $this->parseAppDate($date))
            ->get();

        $input =array($className->name,$section,$shift,$session,$subjectName->name,$date);
        $fileName=$className->name.'-'.$section.'-'.$shift.'-'.$section.'-'.$subjectName->name.'-'.$date;
        Excel::create($fileName, function($excel) use($input,$attendance) {

            $excel->sheet('New sheet', function($sheet) use ($input,$attendance) {

                $sheet->loadView('app.attendanceExcel',compact('attendance','input'));

            });

        })->download('xlsx');
       // return "true";
    }
    else
    {
        return "Please fill up form correctly!";
    }
}


}
