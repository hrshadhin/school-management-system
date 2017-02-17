<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$error = Session::get('error');
		$institute=Institute::select('name')->first();
		if(!$institute)
		{
			$institute=new Institute;
			$institute->name="ShanixLab";
		}
		return View::make('login',compact('error','institute'));

	}

}
