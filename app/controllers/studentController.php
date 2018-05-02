<?php

class foobar{

}
Class formfoo{

}
class studentController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('delete')));
	}
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$classes = ClassModel::select('name','code')->get();


		return View::Make('app.studentCreate',compact('classes'));
	}

	public  function getRegi($class,$session,$section)
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

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{

		$rules=['regiNo' => 'required',
		'fname' => 'required',
		'lname' => 'required',
		'gender' => 'required',
		'religion' => 'required',
		'bloodgroup' => 'required',
		'nationality' => 'required',
		'dob' => 'required',
		'session' => 'required',
		'class' => 'required',
		'section' => 'required',
		'rollNo' => 'required',
		'shift' => 'required',
		'photo' => 'required|mimes:jpeg,jpg,png',
		'fatherName' => 'required',
		'fatherCellNo' => 'required',
		'motherName' => 'required',
		'motherCellNo' => 'required',
		'presentAddress' => 'required',
		'parmanentAddress' => 'required'
	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/student/create')->withErrors($validator);
	}
	else {
		$fileName=Input::get('regiNo').'.'.Input::file('photo')->getClientOriginalExtension();

		$student = new Student;
		$student->regiNo= Input::get('regiNo');
		$student->firstName= Input::get('fname');
		$student->middleName= Input::get('mname');
		$student->lastName= Input::get('lname');
		$student->gender= Input::get('gender');
		$student->religion= Input::get('religion');
		$student->bloodgroup= Input::get('bloodgroup');
		$student->nationality= Input::get('nationality');
		$student->dob= Input::get('dob');
		$student->session= trim(Input::get('session'));
		$student->class= Input::get('class');
		$student->section= Input::get('section');
		$student->group= Input::get('group');
		$student->rollNo= Input::get('rollNo');
		$student->shift= Input::get('shift');

		$student->photo= $fileName;
		$student->nationality= Input::get('nationality');
		$student->extraActivity= Input::get('extraActivity');
		$student->remarks= Input::get('remarks');

		$student->fatherName= Input::get('fatherName');
		$student->fatherCellNo= Input::get('fatherCellNo');
		$student->motherName= Input::get('motherName');
		$student->motherCellNo= Input::get('motherCellNo');
		$student->localGuardian= Input::get('localGuardian');
		$student->localGuardianCell= Input::get('localGuardianCell');

		$student->presentAddress= Input::get('presentAddress');
		$student->parmanentAddress= Input::get('parmanentAddress');
		$student->isActive= "Yes";

		$hasStudent = Student::where('regiNo','=',Input::get('regiNo'))->where('class','=',Input::get('class'))->first();
		if ($hasStudent)
		{
			$messages = $validator->errors();
			$messages->add('Duplicate!', 'Student already exits with this registration no.');
			return Redirect::to('/student/create')->withErrors($messages)->withInput();
		}
		else {
			$student->save();
			Input::file('photo')->move(base_path() .'/public/images',$fileName);
			return Redirect::to('/student/create')->with("success","Student Admited Succesfully.");
		}


	}
}


/**
* Display the specified resource.
*
* @param  int  $id
* @return Response
*/
public function show()
{
	$students=array();
	$classes = ClassModel::lists('name','code');
	$formdata = new formfoo;
	$formdata->class="";
	$formdata->section="";
	$formdata->shift="";
	$formdata->session="";
	return View::Make("app.studentList",compact('students','classes','formdata'));
}
public function getList()
{
	$rules = [
		'class' => 'required',
		'section' => 'required',
		'shift' => 'required',
		'session' => 'required'


	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails()) {
		return Redirect::to('/student/list')->withInput(Input::all())->withErrors($validator);
	} else {
		$students = DB::table('Student')
		->join('Class', 'Student.class', '=', 'Class.code')
		->select('Student.id', 'Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName', 'Student.fatherName', 'Student.motherName', 'Student.fatherCellNo', 'Student.motherCellNo', 'Student.localGuardianCell',
		'Class.Name as class', 'Student.presentAddress', 'Student.gender', 'Student.religion','Student.fourthSubject')
		->where('isActive', '=', 'Yes')
		->where('class',Input::get('class'))
		->where('section',Input::get('section'))
		->where('shift',Input::get('shift'))
		->where('session',trim(Input::get('session')))
		->get();
		if(count($students)<1)
		{
			return Redirect::to('/student/list')->withInput(Input::all())->with('error','No Students Found!');

		}
		else {
			$classes = ClassModel::lists('name','code');
			$formdata = new formfoo;
			$formdata->class=Input::get('class');
			$formdata->section=Input::get('section');
			$formdata->shift=Input::get('shift');
			$formdata->session=trim(Input::get('session'));
			return View::Make("app.studentList", compact('students','classes','formdata'));
		}
	}

}

public function view($id)
{
	$student=	DB::table('Student')
	->join('Class', 'Student.class', '=', 'Class.code')
	->select('Student.id', 'Student.regiNo','Student.rollNo','Student.firstName','Student.middleName','Student.lastName',
	'Student.fatherName','Student.motherName', 'Student.fatherCellNo','Student.motherCellNo','Student.localGuardianCell',
	'Class.Name as class','Student.presentAddress','Student.gender','Student.religion','Student.section','Student.shift','Student.session',
	'Student.group','Student.dob','Student.bloodgroup','Student.nationality','Student.photo','Student.extraActivity','Student.remarks',
	'Student.localGuardian','Student.parmanentAddress','Student.fourthSubject','Student.cphsSubject')
	->where('Student.id','=',$id)->first();

	return View::Make("app.studentView",compact('student'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function edit($id)
{
	$classes = ClassModel::lists('name','code');
	$student= Student::find($id);
	return View::Make("app.studentEdit",compact('student','classes'));
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
		'fname' => 'required',
		'lname' => 'required',
		'gender' => 'required',
		'religion' => 'required',
		'bloodgroup' => 'required',
		'nationality' => 'required',
		'dob' => 'required',
		'session' => 'required',
		'class' => 'required',
		'section' => 'required',
		'rollNo' => 'required',
		'shift' => 'required',
		'fatherName' => 'required',
		'fatherCellNo' => 'required',
		'motherName' => 'required',
		'motherCellNo' => 'required',
		'presentAddress' => 'required',
		'parmanentAddress' => 'required'
	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/student/edit/'.Input::get('id'))->withErrors($validator);
	}
	else {

	    $isValid = true;
        $messages = $validator->errors();
	    //checking for 4th and exchange subject
        $fourthSub = Input::get('fourthSubject');
        $cphsSub = Input::get('cphsSubject');

        if(mb_strlen($cphsSub)) {
            if(!mb_strlen($fourthSub)){
                $messages->add('Notvalid!', 'Entered 4th subject code!');
                $isValid = false;
            }
            else {
                $cphsSubjectInfo = Subject::where('class', '=', Input::get('class'))
                    ->where('code', '=', $cphsSub)
                    ->first();
                if (!count($cphsSubjectInfo)) {
                    $messages->add('Notvalid!', 'Entered alternative subject code not found!');
                    $isValid = false;
                }
            }
        }

        if(mb_strlen($fourthSub)) {
            //now get subject info for 4th subject
            $fSubjectInfo = Subject::where('class', '=', Input::get('class'))
                ->where('code', '=', $fourthSub)
                ->first();

            if (!count($fSubjectInfo)) {
                $messages->add('Notvalid!', 'Entered 4th subject code not found!');
                $isValid = false;
            }

            if ($fSubjectInfo->type != "Electives" && !mb_strlen($cphsSub)) {
                $messages->add('Notvalid!', 'Please enter alternative subject code!');
                $isValid = false;
            }
        }

        if(!$isValid){
            return Redirect::to('/student/edit/'.Input::get('id'))->withErrors($messages);
        }
        //validation code ends heare

		$student = Student::find(Input::get('id'));

		if(Input::hasFile('photo'))
		{

			if(substr(Input::file('photo')->getMimeType(), 0, 5) != 'image')
			{
				$messages = $validator->errors();
				$messages->add('Notvalid!', 'Photo must be a image,jpeg,jpg,png!');
				return Redirect::to('/student/edit/'.Input::get('id'))->withErrors($messages);
			}
			else {

				$fileName=Input::get('regiNo').'.'.Input::file('photo')->getClientOriginalExtension();
				$student->photo = $fileName;
				Input::file('photo')->move(base_path() .'/public/images',$fileName);
			}

		}
		else {
			$student->photo= Input::get('oldphoto');

		}
		//$student->regiNo=Input::get('regiNo');
		$student->rollNo=Input::get('rollNo');
		$student->firstName= Input::get('fname');
		$student->middleName= Input::get('mname');
		$student->lastName= Input::get('lname');
		$student->gender= Input::get('gender');
		$student->religion= Input::get('religion');
		$student->bloodgroup= Input::get('bloodgroup');
		$student->nationality= Input::get('nationality');
		$student->dob= Input::get('dob');
		$student->session= trim(Input::get('session'));
		$student->class= Input::get('class');
		$student->section= Input::get('section');
		$student->group= Input::get('group');
		$student->nationality= Input::get('nationality');
		$student->extraActivity= Input::get('extraActivity');
		$student->remarks= Input::get('remarks');

		$student->fatherName= Input::get('fatherName');
		$student->fatherCellNo= Input::get('fatherCellNo');
		$student->motherName= Input::get('motherName');
		$student->motherCellNo= Input::get('motherCellNo');
		$student->localGuardian= Input::get('localGuardian');
		$student->localGuardianCell= Input::get('localGuardianCell');
		$student->presentAddress= Input::get('presentAddress');
		$student->parmanentAddress= Input::get('parmanentAddress');
		$student->fourthSubject= Input::get('fourthSubject');
		$student->cphsSubject= Input::get('cphsSubject');

		$student->save();

		return Redirect::to('/student/list')->with("success","Student Updated Succesfully.");
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
	$student = Student::find($id);
	$student->isActive= "No";
	$student->save();

	return Redirect::to('/student/list')->with("success","Student Deleted Succesfully.");
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return Response
*/
public function getForMarks($class,$section,$shift,$session)
{
	$students= Student::selectRaw("regiNo,CAST(rollNo AS SIGNED) as rollNo,firstName,middleName,lastName")
        ->where('isActive','=','Yes')
        ->where('class','=',$class)
        ->where('section','=',$section)
        ->where('shift','=',$shift)
        ->where('session','=',$session)
        ->orderBy('rollNo','asc')->get();
	return $students;
}
}
