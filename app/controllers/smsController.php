<?php

class smsController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('index','create','edit','update','smsLog','delete','deleteLog')));
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
		return View::Make('app.smssender',compact('smses','sms'));
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
		if ($validator->fails())
		{
			return Redirect::to('/sms')->withErrors($validator);
		}
		else {
			$sms = new SMS;
			$sms->type= Input::get('type');
			$sms->sender=Input::get('sender');
			$sms->message=Input::get('message');

			$sms->save();
			return Redirect::to('/sms')->with("success","SMS Format Created Succesfully.");

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
		$sms = SMS::find($id);
		$smses=SMS::all();
		return View::Make('app.smsFormat',compact('smses','sms'));
	}


	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
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
		if ($validator->fails())
		{
			return Redirect::to('/sms/edit/'.Input::get('id'))->withErrors($validator);
		}
		else {
			$sms = SMS::find(Input::get('id'));
			$sms->type= Input::get('type');
			$sms->sender=Input::get('sender');
			$sms->message=Input::get('message');
			$sms->save();
			return Redirect::to('/sms')->with("success","SMS Format Updated Succesfully.");

		}
	}


	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function delete($id)
	{
		$sms = SMS::find($id);
		$sms->delete();
		return Redirect::to('/sms')->with("success","SMS Format Deleted Succesfully.");
	}

	public function getsmssend()
	{

		$students=array();
		$classes = ClassModel::lists('name','code');
		$formdata = new formfoo;
		$formdata->class="";
		$formdata->section="";
		$formdata->shift="";
		$formdata->session="";
		return View::Make("app.smssender",compact('students','classes','formdata'));
	}
	public function postsend()
	{
		return "Do not mess with me";
	}

	public function getsmsLog()
	{
		$foo="0";
		$smslogs = array();
		return View::Make('app.smsLog',compact('smslogs','foo'));
	}
	public function postsmsLog()
	{
		$rules=[
			'fromDate' => 'required',
			'toDate' => 'required'



		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/smslog')->withErrors($validator);
		}
		else {
			$smslogs = SMSLog::select('*')->where(DB::raw('date(created_at)'),'>=',trim(Input::get('fromDate')))
			->where(DB::raw('date(created_at)'),'<=',trim(Input::get('toDate')))->get();
			$foo="1";
			return View::Make('app.smsLog',compact('smslogs','foo'));

		}

	}
	public function deleteLog($id)
	{
		$sms = SMSLog::find($id);
		$sms->delete();
		return Redirect::to('/smslog')->with("success","SMS Log Deleted Succesfully.");
	}

}
