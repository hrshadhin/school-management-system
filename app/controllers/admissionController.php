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
		return Redirect::to('/regonline')->with("success","Registration for admission is successfull. Please send money to this \"01711988177\" personal bKash number with this referance number \"".$refNo."\"");

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
	if($class=="cl1")
	{
		$start=1;
		$end=300;
	}
	else if($class=="cl2")
	{
		$start=301;
		$end=600;
	}
	else if($class=="cl3")
	{
		$start=601;
		$end=900;
	}
	else if($class=="cl4")
	{
		$start=901;
		$end=1200;
	}
	else if($class=="cl05")
	{
		$start=1201;
		$end=1500;
	}
	else if($class=="cl6")
	{
		$start=1501;
		$end=1800;
	}
	else if($class=="cl7")
	{
		$start=1801;
		$end=2100;
	}
	else if($class=="cl8")
	{
		$start=2101;
		$end=2400;
	}
	else if($class=="cl9")
	{
		$start=2401;
		$end=2700;
	}
	else if($class=="cl10")
	{
		$start=2701;
		$end=3000;
	}
	else if($class=="cl11")
	{
		$start=3001;
		$end=3300;
	}
	else if($class=="cl12")
	{
		$start=3301;
		$end=3600;
	}
	else if($class=="cl13")
	{
		$start=3601;
		$end=3900;
	}
	else if($class=="cl14")
	{
		$start=3901;
		$end=4200;
	}
	else
	{
		$start=5000;
		$end=10000;
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
