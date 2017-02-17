<?php

class promotionController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
	}
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$classes = ClassModel::all();

		return View::Make('app.promotion',compact('classes'));
	}




	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{      $rules = [
		'nclass' => 'required',
		'nsection' => 'required',
		'nshift' => 'required',
		'nsession' => 'required'

	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails()) {
		return Redirect::to('/promotion')->withInput(Input::all())->withErrors($validator);
	} else {
		if(Input::get('class')==Input::get('nclass'))
		{
			$errorMessages = new Illuminate\Support\MessageBag;
			$errorMessages->add('validation', 'Promotion From and Promotion To class shouldn not be same!');
			return Redirect::to('/promotion')->withInput(Input::all())->withErrors($errorMessages);
		}
		else
		{
			$promotion = Input::get('promot');
			$promotion=array_keys($promotion);
			$newrollNo= Input::get('newrollNo');
			$ids= array_keys($newrollNo);
			if(count($promotion)<1)
			{
				$errorMessages = new Illuminate\Support\MessageBag;
				$errorMessages->add('validation', 'Select Student!');
				return Redirect::to('/promotion')->withInput(Input::all())->withErrors($errorMessages);
			}
			$realPromot=array();
			for($i=0;$i<count($promotion);$i++)
			{

				$rollnumber=$this->checkRollno($promotion[$i],$ids,$newrollNo);
				if($rollnumber=='')
				{
					$errorMessages = new Illuminate\Support\MessageBag;
					$errorMessages->add('validation', 'New Roll number can not be empty!');
					return Redirect::to('/promotion')->withInput(Input::all())->withErrors($errorMessages);
				}
				if($rollnumber!='No')
				{
					$foo =array($promotion[$i],$rollnumber);
					array_push($realPromot,$foo);
				}
			}
			//get new regiNo and student info

			foreach($realPromot as $rpromt) {
				$studentIno = Student::select('*')->where('regiNo', $rpromt[0])->first();



				$newStudent = new Student();
				if (Input::get('nclass') == "cl10" || Input::get('nclass') == "cl12") {
					$newStudent->regiNo = $rpromt[0];
				} else
				{

					$newRegNo = $this->getRegi(Input::get('nclass'), Input::get('nsession'), Input::get('nsection'));
					$newStudent->regiNo = $newRegNo[0];
				}

				$newStudent->rollNo=$rpromt[1];
				$newStudent->session=trim(Input::get('nsession'));
				$newStudent->class=Input::get('nclass');
				$newStudent->section=Input::get('nsection');
				$newStudent->shift=Input::get('nshift');
				$newStudent->group=$studentIno->group;
				$newStudent->firstName=$studentIno->firstName;
				$newStudent->middleName=$studentIno->middleName;
				$newStudent->lastName=$studentIno->lastName;
				$newStudent->gender=$studentIno->gender;
				$newStudent->religion=$studentIno->religion;
				$newStudent->bloodgroup=$studentIno->bloodgroup;
				$newStudent->nationality=$studentIno->nationality;
				$newStudent->dob=$studentIno->dob;
				$newStudent->photo=$studentIno->photo;
				$newStudent->extraActivity=$studentIno->extraActivity;
				$newStudent->remarks=$studentIno->remarks;
				$newStudent->fatherName=$studentIno->fatherName;
				$newStudent->fatherCellNo=$studentIno->fatherCellNo;
				$newStudent->motherName=$studentIno->motherName;
				$newStudent->motherCellNo=$studentIno->motherCellNo;
				$newStudent->localGuardian=$studentIno->localGuardian;
				$newStudent->localGuardianCell=$studentIno->localGuardianCell;
				$newStudent->presentAddress=$studentIno->presentAddress;
				$newStudent->parmanentAddress=$studentIno->parmanentAddress;
				$newStudent->isActive="Yes";
				$newStudent->save();


			}

			return Redirect::to('/promotion')->with('success', count($realPromot).' Students Promoted.');

		}
	}


}
private  function checkRollno($regiNo,$ids,$newRollNo)

{

	for($i=0;$i<count($ids);$i++)
	{

		if($regiNo==$ids[$i])
		{
			return $newRollNo[$ids[$i]];
		}
	}
	return 'No';
}


private  function getRegi($class,$session,$section)
{
	$ses =trim($session);

	$stdcount = Student::select(DB::raw('count(*) as total'))->where('class','=',$class)->where('session','=',$ses)->first();


	$stdseccount = Student::select(DB::raw('count(*) as total'))->where('class','=',$class)->where('session','=',$ses)->where('section','=',$section)->first();

	$r = intval($stdcount->total)+1;

	if(strlen($r)<2)
	{
		$r='0'.$r;
	}
	$c = intval($stdseccount->total)+1;
	$cl=substr($class,2);

	$foo = array();
	if(strlen($cl)<2) {
		$foo[0]= substr($ses, 2) .'0'.$cl.$r;
	}
	else
	{
		$foo[0]=  substr($ses, 2) .$cl.$r;
	}
	if(strlen($c)<2) {
		$foo[1] ='0'.$c;
	}
	else
	{
		$foo[1] =$c;
	}

	return $foo;

}

}
