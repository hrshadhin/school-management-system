<?php
Class formfoo{

}
use Illuminate\Support\Collection;
use Carbon\Carbon;
class attendanceController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('delete')));

	}

	public function index()
		{
			$classes=array();
			$classes2 = ClassModel::select('code','name')->orderby('code','asc')->get();
			$subjects = Subject::lists('name','code');
			$attendance=array();
			return View::Make('app.attendanceCreate',compact('classes2','classes','subjects','attendance'));
		}

		public function index_file()
		{
			return View::Make('app.attendanceCreateFile');
		}

		public function create()
		{
			$rules = [
				'class' => 'required',
				'section' => 'required',
				'shift' => 'required',
				'session' => 'required',
				'regiNo' => 'required',
				'date' => 'required',
			];
			$validator = \Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				return Redirect::to('/attendance/create')->withInput(Input::all())->withErrors($validator);
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
						else {
							array_push($stpresent, $st);
						}
					}
					$presentDate = $this->parseAppDate(Input::get('date'));
					DB::beginTransaction();
					try {
					foreach ($stpresent as $stp) {
						$attenData= [
							'date' => $presentDate,
							'regiNo' => $stp['regiNo'],
							'created_at' => Carbon::now()
						];
						Attendance::insert($attenData);

					}
					DB::commit();
				} catch (\Exception $e) {
					DB::rollback();
					$errorMessages = new Illuminate\Support\MessageBag;
					 $errorMessages->add('Error', 'Something went wrong!');
					return Redirect::to('/attendance/create')->withErrors($errorMessages);
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

								$response = $this->sendSMS($student->fatherCellNo,"ShanixLab", $msg);
								$smsLog = new SMSLog();
								$smsLog->type = "Attendance";
								$smsLog->sender = "SuperSoft";
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
		/**
		* Show the form for creating a new resource.
		*
		* @return Response
		*/
		public function create_file()
		{

			$file = Input::file('fileUpload');
			$ext = strtolower($file->getClientOriginalExtension());

			$validator = Validator::make(array('ext' => $ext),array('ext' => 'in:xls,xlsx')
			);
			if ($validator->fails()) {
				return Redirect::to('/attendance/create-file')->withErrors($validator);
			} else {
				try {
							$toInsert = 0;
	            $data = Excel::load(Input::file('fileUpload'), function ($reader) { })->get();

	        if(!empty($data) && $data->count()){
						DB::beginTransaction();
						try {
	            foreach ($data->toArray() as $raw) {
									if($raw['date_and_time'] && $raw['personnel_id']){
										$attenData= [
											'date' => $raw['date_and_time'],
											'regiNo' => $raw['personnel_id'],
											'created_at' => Carbon::now()
										];
										Attendance::insert($attenData);
										$toInsert++;
									}
	                }
									DB::commit();
								} catch (\Exception $e) {
									DB::rollback();
									$errorMessages = new Illuminate\Support\MessageBag;
									 $errorMessages->add('Error', 'Something went wrong!');
									return Redirect::to('/attendance/create-file')->withErrors($errorMessages);

									// something went wrong
								}

	            }

							if($toInsert){
	                return Redirect::to('/attendance/create-file')->with("success", $toInsert.' students attendance record upload successfully.');
	            }
							$errorMessages = new Illuminate\Support\MessageBag;
							 $errorMessages->add('Validation', 'File is empty!!!');
							return Redirect::to('/attendance/create-file')->withErrors($errorMessages);

	        } catch (\Exception $e) {
						$errorMessages = new Illuminate\Support\MessageBag;
						 $errorMessages->add('Error', 'Something went wrong!');
						return Redirect::to('/attendance/create-file')->withErrors($errorMessages);
	        }
			}

		}
	private function sendSMS($number,$sender,$msg)
	{
		return "SMS SEND";
		//need to change for production
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


				$myaccount=urlencode("shanixLab");
				$mypasswd=urlencode("1234");
				$sendBy=urlencode($sender);
				$api="http://api-link?user=".$myaccount."&password=".$mypasswd."&sender=".$sendBy."&SMSText=".$msg."&GSM=".$phonenumber."&type=longSMS";
				$client = new \Guzzle\Service\Client($api);
				//  Get your response:
				$response = $client->get()->send();
				$status=$response->getBody(true);
				if($status=="-5" || $status=="5")
				{
					return $status;
				}

				return "SMS SEND";

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
		$formdata->session=date('Y');
		$formdata->date=date('d-m-Y');
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

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/attendance/list/')->withErrors($validator);
		}
		else {
			$date = $this->parseAppDate(Input::get('date'));
			$attendance = Student::with(['attendance' => function($query) use($date){
				  $query->where('date','=',$date);
			}])
			->where('class','=',Input::get('class'))
			->where('section','=',Input::get('section'))
			->Where('shift','=',Input::get('shift'))
			->where('session','=',trim(Input::get('session')))
			->where('isActive', '=', 'Yes')
			->get();
			$formdata = new formfoo;
			$formdata->class=Input::get('class');
			$formdata->section=Input::get('section');
			$formdata->shift=Input::get('shift');
			$formdata->session=Input::get('session');
			$formdata->date=Input::get('date');
			$classes2 = ClassModel::select('code','name')->orderby('code','asc')->lists('name','code');

			return View::Make('app.attendanceList',compact('classes2','attendance','formdata'));
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


	public  function printlist($class,$section,$shift,$session,$date)
	{
		if($class!="" && $section !="" && $shift !="" && $date) {
			$className = ClassModel::select('name')->where('code',$class)->first();
			$date = $this->parseAppDate($date);
			$attendance = Student::with(['attendance' => function($query) use($date){
				  $query->where('date','=',$date);
			}])
			->where('class','=',$class)
			->where('section','=',$section)
			->Where('shift','=',$shift)
			->where('session','=',trim($session))
			->where('isActive', '=', 'Yes')
			->get();
			$date = $this->parseAppDate($date);
			$input =array($className->name,$section,$shift,$session,$date);
			$fileName=$className->name.'-'.$section.'-'.$shift.'-'.$section.'-'.$date;
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

	public function report()
	{
		return View::make('app.studentAttendance');
	}
	public function getReport()
	{
		$student= Student::where('regiNo','=',Input::get('regiNo'))
		->where('Student.isActive', '=', 'Yes')
		->first();

		if(count($student)>0){
			$student = Student::with('attendance')
			->where('regiNo','=',Input::get('regiNo'))
			->where('isActive', '=', 'Yes')
			->first();
			$class = ClassModel::where('code','=',$student->class)->first();
			if(count($student->attendance)>0)
				return View::make('app.stdattendance',compact('student','class'));
			return  Redirect::back()->with('noresult','Attendance Not Found!');

		}
		return  Redirect::back()->with('noresult','Student Not Found!');


	}

}
