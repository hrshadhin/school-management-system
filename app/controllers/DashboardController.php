<?php

class DashboardController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('index')));
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $error = Session::get('error');
        $success=Session::get('success');
       	$tclass = ClassModel::count();
       $tsubject = Subject::count();
       $tstudent=Student::count();
	    	return View::Make('dashboard',compact('error','success','tclass','tsubject','tstudent'));
	}




}
