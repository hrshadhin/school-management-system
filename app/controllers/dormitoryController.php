<?php
use Illuminate\Database\Eloquent\Collection;
class dormitoryController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('delete','stddelete')));
	}
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$dormitories=Dormitory::all();
		$dormitory=array();
		return View::Make('app.dormitory',compact('dormitories','dormitory'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{
		$rules=[
			'name' => 'required',
			'numOfRoom' => 'required|integer',
			'address' => 'required',

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/dormitory')->withErrors($validator);
		}
		else {
			$dormitory = new Dormitory;
			$dormitory->name= Input::get('name');
			$dormitory->numOfRoom=Input::get('numOfRoom');
			$dormitory->address=Input::get('address');
			$dormitory->description=Input::get('description');
			$dormitory->save();
			return Redirect::to('/dormitory')->with("success","Dormitory Created Succesfully.");

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
		$dormitory = Dormitory::find($id);
		$dormitories=Dormitory::all();
		return View::Make('app.dormitory',compact('dormitories','dormitory'));
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
			'name' => 'required',
			'numOfRoom' => 'required|integer',
			'address' => 'required',

		];


		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/dormitory/edit/'.Input::get('id'))->withErrors($validator);
		}
		else {
			$dormitory = Dormitory::find(Input::get('id'));
			$dormitory->name= Input::get('name');
			$dormitory->numOfRoom=Input::get('numOfRoom');
			$dormitory->address=Input::get('address');
			$dormitory->description=Input::get('description');
			$dormitory->save();
			return Redirect::to('/dormitory')->with("success","Dormitory update Succesfully.");

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
		$dormitory = Dormitory::find($id);
		$dormitory->delete();
		return Redirect::to('/dormitory')->with("success","Dormitory deleted Succesfully.");
	}


	//student assign to dormitory part goes Here
	public function stdindex()
	{
		$classes = ClassModel::select('code','name')->orderby('code','asc')->get();
		$dormitories = Dormitory::select('id','name')->orderby('id','asc')->get();
		return View::Make('app.dormitory_stdadd',compact('classes','dormitories'));
	}


	public function stdcreate()
	{
		$rules=[
			'regiNo' => 'required',
			'joinDate' => 'required',
			'isActive' => 'required',
			'dormitory' => 'required',
			'roomNo' => 'required',
			'monthlyFee' => 'required|numeric',


		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/dormitory/assignstd')->withErrors($validator);
		}
		else {
			$dormStd = new DormitoryStudent;
			$dormStd->regiNo=Input::get('regiNo');
			$dormStd->joinDate=Input::get('joinDate');
			$dormStd->dormitory=Input::get('dormitory');
			$dormStd->roomNo=Input::get('roomNo');
			$dormStd->monthlyFee=Input::get('monthlyFee');
			$dormStd->isActive=Input::get('isActive');
			$dormStd->save();
			return Redirect::to('/dormitory/assignstd')->with("success","Student added to dormitory Succesfully.");

		}
	}

	public function stdShow()
	{

		$dormitories = Dormitory::lists('name','id');
		$students=array();
		$formdata = new formfoo();
		$formdata->dormitory=1;
		return View::Make('app.dormitory_stdlist',compact('students','dormitories','formdata'));
	}
	public function poststdShow()
	{
		$rules = ['dormitory' => 'required',];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('/dormitory/assignstd/list')->withInput(Input::all())->withErrors($validator);
		}
		else {
			$students = DB::table('Student')
			->join('Class', 'Student.class', '=', 'Class.code')
			->join('dormitory_student', 'Student.regiNo', '=', 'dormitory_student.regiNo')
			->select('dormitory_student.id', 'Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName', 'Student.fatherName', 'Student.motherName', 'Student.fatherCellNo', 'Student.motherCellNo', 'Student.localGuardianCell',
			'Class.Name as class','dormitory_student.roomNo', 'dormitory_student.monthlyFee','dormitory_student.joinDate','dormitory_student.leaveDate','dormitory_student.isActive')
			->where('dormitory_student.dormitory',Input::get('dormitory'))
			->get();
			$dormitories = Dormitory::lists('name','id');
			$formdata = new formfoo();
			$formdata->dormitory=Input::get('dormitory');
			return View::Make('app.dormitory_stdlist',compact('students','dormitories','formdata'));
		}
	}
	public function stdedit($id)
	{
		$student = DormitoryStudent::find($id);
		$dormitories=Dormitory::lists('name','id');
		return View::Make('app.dormitory_stdedit',compact('dormitories','student'));
	}


	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function stdupdate()
	{

		$rules=[
			'isActive' => 'required',
			'dormitory' => 'required',
			'roomNo' => 'required',
			'monthlyFee' => 'required|numeric',

		];


		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/dormitory/assignstd/edit/'.Input::get('id'))->withErrors($validator);
		}
		else {
			$dormStd = DormitoryStudent::find(Input::get('id'));
			if(Input::get('leaveDate')!=""){
				$dormStd->leaveDate=Input::get('leaveDate');
			}

			$dormStd->dormitory=Input::get('dormitory');
			$dormStd->roomNo=Input::get('roomNo');
			$dormStd->monthlyFee=Input::get('monthlyFee');
			$dormStd->isActive=Input::get('isActive');
			$dormStd->save();
			return Redirect::to('/dormitory/assignstd/list')->with("success","Dormitory student info update Succesfully.");

		}
	}


	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function stddelete($id)
	{
		$dormstd = DormitoryStudent::find($id);
		$dormstd->delete();
		return Redirect::to('/dormitory/assignstd/list')->with("success","Dormitory student deleted Succesfully.");
	}

	public function getstudents($dormid)
	{
		$students = DB::table('Student')
		->join('dormitory_student', 'Student.regiNo', '=', 'dormitory_student.regiNo')
		->select('Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName')
		->where('dormitory_student.dormitory',$dormid)
		->where('dormitory_student.isActive',"Yes")
		->orderby('dormitory_student.regiNo','asc')->get();
		return $students;
	}
	public function feeinfo($regiNo)
	{
		$fee = DormitoryStudent::select('monthlyFee')
		->where('regiNo',$regiNo)
		->get();

		$isPaid= DB::table('dormitory_fee')
		->select('regiNo','feeAmount')
		->where('regiNo',$regiNo)
		->whereRaw('EXTRACT(YEAR_MONTH FROM feeMonth) = EXTRACT(YEAR_MONTH FROM NOW())')
		->get();

		$info=array($fee[0]->monthlyFee);
		if(count($isPaid)>0)
		{
			array_push($info,"true");
		}
		else {
			array_push($info,"false");
		}
		return $info;
	}

	public function feeindex()
	{
		$dormitories=Dormitory::select('name','id')->orderby('id','asc')->get();
		return View::Make('app.dormitory_fee',compact('dormitories'));
	}
	public function feeadd()
	{
		$rules=[
			'regiNo' => 'required',
			'feeMonth' => 'required',
			'feeAmount' => 'required',

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/dormitory/fee')->withErrors($validator);
		}
		else {
			$dormFee = new DormitoryFee;
			$dormFee->regiNo=Input::get('regiNo');
			$dormFee->feeMonth=Input::get('feeMonth');
			$dormFee->feeAmount=Input::get('feeAmount');
			$dormFee->save();
			return Redirect::to('/dormitory/fee')->with("success","Fee added Succesfully.");

		}
	}

	public function reportstd()
	{
		$dormitories=Dormitory::select('name','id')->orderby('id','asc')->get();
		return View::Make('app.dormitory_rptstd',compact('dormitories'));
	}
	public function reportstdprint($dormId)
	{
		$datas = DB::table('Student')
		->join('Class', 'Student.class', '=', 'Class.code')
		->join('dormitory_student', 'Student.regiNo', '=', 'dormitory_student.regiNo')
		->select('dormitory_student.id', 'Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName', 'Student.fatherName', 'Student.motherName', 'Student.fatherCellNo', 'Student.motherCellNo', 'Student.localGuardianCell',
		'Class.Name as class','dormitory_student.roomNo','Student.section','Student.session' )
		->where('dormitory_student.dormitory',$dormId)
		->where('dormitory_student.isActive',"Yes")
		->get();
		$dormInfo = Dormitory::find($dormId);
		$institute=Institute::select('*')->first();
		$rdata =array('date'=>date('d/m/Y'),'name'=>$dormInfo->name,'totalr'=>$dormInfo->numOfRoom,'totals'=>count($datas));
		$pdf = PDF::loadView('app.dormitory_rptstdprint',compact('datas','rdata','institute'));
		return $pdf->stream('dormitory-students-List.pdf');
	}
	public function reportfee()
	{
		$dormitories=Dormitory::select('name','id')->orderby('id','asc')->get();
		return View::Make('app.dormitory_rptfee',compact('dormitories'));
	}
	public function reportfeeprint($dormId,$month)
	{

		$myquery="SELECT a.regiNo,a.roomNo,CONCAT(b.firstName,' ',b.middleName,' ',b.lastName) as name,c.name as class,'Paid' as isPaid FROM dormitory_student a
		JOIN Student b ON a.regiNo=b.regiNo
		JOIN Class c ON c.code=b.class
		where a.dormitory=".$dormId."
		and EXISTS (select b.feeMonth from dormitory_fee b where b.regiNo=a.regiNo and EXTRACT(YEAR_MONTH FROM b.feeMonth) = EXTRACT(YEAR_MONTH FROM '".$month."'))

		UNION SELECT a.regiNo,a.roomNo,CONCAT(b.firstName,' ',b.middleName,' ',b.lastName) as name,c.name as class,'Due' as isPaid FROM dormitory_student a
		JOIN Student b ON a.regiNo=b.regiNo
		JOIN Class c ON c.code=b.class
		WHERE a.dormitory=".$dormId."
		and NOT EXISTS (select b.feeMonth from dormitory_fee b where b.regiNo=a.regiNo and EXTRACT(YEAR_MONTH FROM b.feeMonth) = EXTRACT(YEAR_MONTH FROM '".$month."'))
		ORDER BY regiNo";

		$datas = DB::select(DB::raw($myquery));



		$dormInfo = Dormitory::find($dormId);
		$institute=Institute::select('*')->first();

		$rdata =array('month'=>date('F-Y', strtotime($month)),'name'=>$dormInfo->name,'total'=>count($datas));
		$pdf = PDF::loadView('app.dormitory_rptfeeprint',compact('datas','rdata','institute'));
		return $pdf->stream('dormitory-free-report.pdf');
	}
}
