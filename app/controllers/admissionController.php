<?php
Class formfoo{


}
class admissionController extends \BaseController {
	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('applicants','postapplicants','applicantview','payment','delete')));
	}
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function regonline()
	{
		$classes = ClassModel::select('name','code')->get();

		return View::Make('app.admissionForm',compact('classes'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function Postregonline()
	{
		$rules=['name' => 'required',
		'nationality' => 'required',
		'dob' => 'required',
		'session' => 'required',
		'class' => 'required',
		'photo' => 'required|mimes:png,jpg,jpeg,bmp|max:204800',
		'signature' => 'required|mimes:png,jpg,jpeg,bmp|max:204800',
		'fatherName' => 'required',
		'fatherCellNo' => 'required',
		'motherName' => 'required',
		'motherCellNo' => 'required',
		'address' => 'required',
	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/regonline')->withInput(Input::all())->withErrors($validator);
	}
	else {
		$refNo=$this->getRefNo(Admission::count());
		$seatNofinal=0;
		while (1) {
			$seatNo=$this->getSeatNo(Input::get('class'));
			$seatNoExits = Admission::select('id')->where('class',Input::get('class'))
			->where('session',trim(Input::get('session')))->where('seatNo',$seatNo)->get();
			if(count($seatNoExits)<1)
			{
				$seatNofinal=$seatNo;
				break;
			}
		}
		$addStd= new Admission();
		$addStd->refNo=$refNo;
		$addStd->seatNo=$seatNofinal;
		$addStd->transactionNo="";
		$addStd->stdName=Input::get('name');
		$addStd->nationality=Input::get('nationality');
		$addStd->class=Input::get('class');
		$addStd->dob=Input::get('dob');
		$addStd->session=trim(Input::get('session'));
		$addStd->address=Input::get('address');
		$addStd->fatherName=Input::get('fatherName');
		$addStd->fatherCellNo=Input::get('fatherCellNo');
		$addStd->motherName=Input::get('motherName');
		$addStd->motherCellNo=Input::get('motherCellNo');
		$addStd->status="Application Submitted";

		$fileName=$refNo.'.'.Input::file('photo')->getClientOriginalExtension();
		$addStd->photo=$fileName;
		$addStd->save();
		Input::file('photo')->move(base_path() .'/public/admission',$fileName);

		$fileName=$refNo.'s.'.Input::file('signature')->getClientOriginalExtension();
		$addStd->signature=$fileName;
		$addStd->save();
		Input::file('signature')->move(base_path() .'/public/admission',$fileName);
		return Redirect::to('/regonline')->with("success","Registration for admission is successfull. Please deposite money to this (Biller ID) \"2346\" DBBL Rocket account with this serial number (Bill no) \"".$refNo."\"");

	}

}

private function getRefNo($rowCount)
{
	$refNo=$rowCount+1;
	if(strlen($refNo)==1)
	{
		$refNo = "00".$refNo;
	}
	elseif (strlen($refNo)==2) {
		$refNo = "0".$refNo;
	}
	return $refNo;
}
private function getSeatNo($class)
{
	$start=0;
	$end =0;
	if($class=="cl01")
	{
		$start=1;
		$end=2;
	}
	else if($class=="cl02")
	{
		$start=3;
		$end=4;
	}
	else if($class=="cl03")
	{
		$start=301;
		$end=5301;
	}
	else if($class=="cl04")
	{
		$start=6001;
		$end=6002;
	}
	else if($class=="cl05")
	{
		$start=6003;
		$end=6004;
	}
	else if($class=="cl06")
	{
		$start=6005;
		$end=6006;
	}
	else if($class=="cl07")
	{
		$start=6007;
		$end=6008;
	}
	else if($class=="cl08")
	{
		$start=6009;
		$end=6010;
	}
	else if($class=="cl09")
	{
		$start=6011;
		$end=6012;
	}
	else if($class=="cl10")
	{
		$start=6013;
		$end=6014;
	}
	else if($class=="cl11")
	{
		$start=6015;
		$end=6016;
	}
	else if($class=="cl12")
	{
		$start=6017;
		$end=6018;
	}
	else if($class=="cl13")
	{
		$start=6019;
		$end=6020;
	}
	else if($class=="cl14")
	{
		$start=6021;
		$end=6222;
	}
	else
	{
		$start=0;
		$end=0;
	}
	$randRoll =rand ($start,$end);

	return $randRoll;

}

public function applicants()
{
	$classes = ClassModel::lists('name','code');
	$formdata = new formfoo;
	$formdata->class = "";
	$formdata->session = "";
	$students=array();
	return View::Make('app.applicantList',compact('classes','formdata','students'));

}


public function postapplicants()
{

	$rules=['session' => 'required','class' => 'required'];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/applicants')->withInput(Input::all())->withErrors($validator);
	}
	else {


		$students = DB::table('admission')
		->join('Class', 'admission.class', '=', 'Class.code')
		->select('admission.id', 'admission.refNo', 'admission.seatNo', 'admission.stdName','admission.transactionNo','admission.signature','admission.address','admission.status','admission.created_at','Class.Name as class')
		->where('session',trim(Input::get('session')))->where('class',Input::get('class'))->get();


		$classes = ClassModel::lists('name','code');
		$formdata = new formfoo;
		$formdata->class=Input::get('class');
		$formdata->session=Input::get('session');
		return View::Make('app.applicantList',compact('classes','formdata','students'));
	}
}



public function applicantview($id)
{
	$student = DB::table('admission')
	->join('Class', 'admission.class', '=', 'Class.code')
	->select('admission.id', 'admission.refNo', 'admission.seatNo', 'admission.stdName','admission.transactionNo','admission.status','admission.created_at','Class.Name as class'
	,'admission.session','admission.nationality','admission.dob','admission.address','admission.signature','admission.fatherName','admission.fatherCellNo','admission.motherName','admission.motherCellNo','admission.photo'
	)
	->where('admission.id',$id)->first();

	return View::Make('app.applicant',compact('student'));
}


/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return Response
*/
public function payment()
{
	$rules=['transactionNo' => 'required'];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/applicants/view/'.Input::get('id'))->withInput(Input::all())->withErrors($validator);
	}
	else {
		$applicant = Admission::find(Input::get('id'));
		$applicant->transactionNo = Input::get('transactionNo');
		$applicant->status = "Payment Confirmed";
		$applicant->save();
		$res = array("Info update successfull");
		return $res;//Redirect::to('/applicants/view/'.Input::get('id'));
	}
}
public function delete($id)
{
	$applicant = Admission::find($id);
	$applicant->delete();
	return Redirect::to('/applicants');
}

public function admitcard()
{

	return View::Make('app.admitcard');
}
public function printAdmitCard()
{
	$rules=['transactionNo' => 'required','refNo'=>'required'];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/admitcard')->withInput(Input::all())->withErrors($validator);
	}
	else {
		$data = DB::table('admission')
		->join('Class', 'admission.class', '=', 'Class.code')
		->select('admission.id', 'admission.refNo', 'admission.seatNo', 'admission.stdName','admission.transactionNo','admission.status','admission.created_at','Class.Name as class'
		,'admission.session','admission.nationality','admission.dob','admission.address','admission.signature','admission.fatherName','admission.fatherCellNo','admission.motherName','admission.motherCellNo','admission.photo'
		)->where('admission.refNo',Input::get('refNo'))->where('admission.transactionNo',Input::get('transactionNo'))->first();
		if(count($data)>0)
		{
			//return View::Make('app.printAdmitCard');
			$institute=Institute::select('*')->first();
//            			return View::Make('app.printAdmitCard',compact('data','institute'));

            $pdf = PDF::loadView('app.printAdmitCard',compact('data','institute'));
			return $pdf->stream('admitcard.pdf');
		}
		else {

			return Redirect::to('/admitcard')->with("success","Your Admit Card Not Ready Yet!");

		}

	}
}
}
