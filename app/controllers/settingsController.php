<?php

class settingsController extends \BaseController {
	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('save','index')));
	}
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$set= User::select("*")->where('id','=',Auth::id())->first();

		return View::Make('app.Settings',compact('set'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function save()
	{
		$rules=[
			'firstname' => 'required',
			'lastname' => 'required',
			'login' => 'required',
			//'email' => 'required',
			'desc' => 'required',
			'cpassword' => 'required',
			'npassword' => 'required',
			'cnpassword' => 'required'


		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/settings')->withinput(Input::all())->withErrors($validator);
		}
		else {
			if (Input::get('npassword') == Input::get('cnpassword')) {

				// $u = User::select('*')->where('password',Hash::make(Input::get('cpassword')))->first();
				//return Hash::make(Input::get('cpassword'));
				//if(count($u)>0) {
				$user = User::find(Input::get('id'));
				$user->firstname = Input::get('firstname');
				$user->lastname = Input::get('lastname');
				//  $user->login = Input::get('login');
				//$user->desc = Input::get('desc');
				// $user->email = Input::get('email');
				$user->password = Hash::make(Input::get('npassword'));
				$user->save();

				return Redirect::to('/settings')->with('success', 'Settings is changed please relogin the site.');
				/*}
				else
				{
				$errorMessages = new Illuminate\Support\MessageBag;
				$errorMessages->add('notmatch', 'Current Password did not match!');
				return Redirect::to('/settings')->withErrors($errorMessages);
			}*/
		}
		else
		{
			$errorMessages = new Illuminate\Support\MessageBag;
			$errorMessages->add('notmatch', 'New Password and confirm password did not match!');
			return Redirect::to('/settings')->withErrors($errorMessages);
		}
	}
}


}
