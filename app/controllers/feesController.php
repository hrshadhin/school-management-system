<?php
class studentfdata{


}
class feesController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('getDelete','stdfeesdelete')));
	}
	public function getsetup()
	{

		$classes = ClassModel::select('code','name')->orderby('code','asc')->get();
		return View::Make('app.feesSetup',compact('classes'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function postSetup()
	{
		$rules=[

			'class' => 'required',
			'type' => 'required',
			'fee' => 'required|numeric',
			'title' => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/fees/setup')->withErrors($validator);
		}
		else {

			$fee = new FeeSetup();


			$fee->class = Input::get('class');
			$fee->type = Input::get('type');
			$fee->title = Input::get('title');
			$fee->fee = Input::get('fee');
			$fee->Latefee = Input::get('Latefee');
			$fee->description = Input::get('description');
			$fee->save();
			return Redirect::to('/fees/setup')->with("success","Fee Save Succesfully.");


		}
	}




	public function getList()
	{
		$fees=array();
		$classes = ClassModel::lists('name','code');

		$formdata = new formfoo;
		$formdata->class="";
		return View::Make('app.feeList',compact('classes','formdata','fees'));
	}
	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function postList()
	{
		$rules=[

			'class' => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/fees/list')->withErrors($validator);
		}
		else {

			$fees = FeeSetup::select("*")->where('class',Input::get('class'))->get();
			$classes = ClassModel::lists('name','code');
			$formdata = new formfoo;
			$formdata->class=Input::get('class');
			return View::Make('app.feeList',compact('classes','formdata','fees'));



		}
	}


	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function getEdit($id)
	{
		$classes = ClassModel::lists('name','code');
		$fee = FeeSetup::find($id);
		return View::Make('app.feeEdit',compact('fee','classes'));

	}


	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function postEdit()
	{
		$rules=[

			'class' => 'required',
			'type' => 'required',
			'fee' => 'required|numeric',
			'title' => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/fee/edit/'.Input::get('id'))->withErrors($validator);
		}
		else {

			$fee = FeeSetup::find(Input::get('id'));
			$fee->class = Input::get('class');
			$fee->type = Input::get('type');
			$fee->title = Input::get('title');
			$fee->fee = Input::get('fee');
			$fee->Latefee = Input::get('Latefee');
			$fee->description = Input::get('description');
			$fee->save();
			return Redirect::to('/fees/list')->with("success","Fee Updated Succesfully.");


		}
	}


	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function getDelete($id)
	{
		$fee = FeeSetup::find($id);
		$fee->delete();
		return Redirect::to('/fees/list')->with("success","Fee Deleted Succesfully.");
	}
	public function getCollection()
	{
		$classes = ClassModel::select('code','name')->orderby('code','asc')->get();
		return View::Make('app.feeCollection',compact('classes'));
	}
	public function postCollection()
	{

		$rules=[

			'class' => 'required',
			'student' => 'required',
			'date' => 'required',
			'paidamount' => 'required',
			'dueamount' => 'required',
			'ctotal' => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/fee/collection')->withInput(Input::all())->withErrors($validator);
		}
		else {
			try {
				$feeTitles = Input::get('gridFeeTitle');
				$feeAmounts = Input::get('gridFeeAmount');
				$feeLateAmounts = Input::get('gridLateFeeAmount');
				$feeTotalAmounts = Input::get('gridTotal');
				$feeMonths = Input::get('gridMonth');
				$counter = count($feeTitles);
				if($counter>0)
				{
					$rows = FeeCol::count();
					if($rows<9)
					{
						$billId='B00'.($rows+1);
					}
					else if($rows<100)
					{
						$billId='B0'.($rows+1);
					}
					else {
						$billId='B'.($rows+1);
					}
					DB::transaction(function() use ($billId,$counter,$feeTitles,$feeAmounts,$feeLateAmounts,$feeTotalAmounts,$feeMonths)
					{
						$feeCol = new FeeCol();
						$feeCol->billNo=$billId;
						$feeCol->class=Input::get('class');
						$feeCol->regiNo=Input::get('student');
						$feeCol->payableAmount=Input::get('ctotal');
						$feeCol->paidAmount=Input::get('paidamount');
						$feeCol->dueAmount=Input::get('dueamount');
						$feeCol->payDate=Input::get('date');
						$feeCol->save();

						for ($i=0;$i<$counter;$i++) {
							$feehistory = new FeeHistory();
							$feehistory->billNo=$billId;
							$feehistory->title=$feeTitles[$i];
							$feehistory->fee=$feeAmounts[$i];
							$feehistory->lateFee=$feeLateAmounts[$i];
							$feehistory->total=$feeTotalAmounts[$i];
							$feehistory->month=$feeMonths[$i];
							$feehistory->save();

						}
					});
					return Redirect::to('/fee/collection')->with("success","Fee collection succesfull.");
				}
				else {
					$messages = $validator->errors();
					$messages->add('Validator!', 'Please add atlest one fee!!!');
					return Redirect::to('/fee/collection')->withInput(Input::all())->withErrors($messages);

				}
			}
			catch(\Exception $e)
			{

				return Redirect::to('/fee/collection')->withErrors( $e->getMessage())->withInput();
			}

		}
	}

	public function getListjson($class,$type)
	{
		$fees= FeeSetup::select('id','title')->where('class','=',$class)->where('type','=',$type)->get();
		return $fees;
	}
	public function getFeeInfo($id)
	{
		$fee= FeeSetup::select('fee','Latefee')->where('id','=',$id)->get();
		return $fee;
	}

	public function getDue($class,$stdId)
	{
		$due = FeeCol::select(DB::RAW('IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0) as dueamount'))
		->where('class',$class)
		->where('regiNo',$stdId)
		->first();
		return $due->dueamount;

	}
	public function stdfeeview()
	{
		$classes = ClassModel::lists('name','code');
		$student = new studentfdata;
		$student->class="";
		$student->section="";
		$student->shift="";
		$student->session="";
		$student->regiNo="";
		$fees=array();
		return View::Make('app.feeviewstd',compact('classes','student','fees'));
	}
	public function stdfeeviewpost()
	{
		$classes = ClassModel::lists('name','code');
		$student = new studentfdata;
		$student->class=Input::get('class');
		$student->section=Input::get('section');
		$student->shift=Input::get('shift');
		$student->session=Input::get('session');
		$student->regiNo=Input::get('student');
		$fees=DB::Table('stdBill')
		->select(DB::RAW("billNo,payableAmount,paidAmount,dueAmount,DATE_FORMAT(payDate,'%D %M,%Y') AS date"))
		->where('class',Input::get('class'))
		->where('regiNo',Input::get('student'))
		->get();
		$totals = FeeCol::select(DB::RAW('IFNULL(sum(payableAmount),0) as payTotal,IFNULL(sum(paidAmount),0) as paiTotal,(IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0)) as dueamount'))
		->where('class',Input::get('class'))
		->where('regiNo',Input::get('student'))
		->first();

		return View::Make('app.feeviewstd',compact('classes','student','fees','totals'));
	}
	public function stdfeesdelete($billNo)
	{
		try {
			DB::transaction(function() use ($billNo)
			{
				FeeCol::where('billNo',$billNo)->delete();
				FeeHistory::where('billNo',$billNo)->delete();

			});
			return Redirect::to('/fees/view')->with("success","Fees deleted succesfull.");
		}
		catch(\Exception $e)
		{

			return Redirect::to('/fees/view')->withErrors( $e->getMessage())->withInput();
		}

	}
	public function reportstd($regiNo)
	{

		$datas=DB::Table('stdBill')
		->select(DB::RAW("payableAmount,paidAmount,dueAmount,DATE_FORMAT(payDate,'%D %M,%Y') AS date"))
		->where('regiNo',$regiNo)
		->get();
		$totals = FeeCol::select(DB::RAW('IFNULL(sum(payableAmount),0) as payTotal,IFNULL(sum(paidAmount),0) as paiTotal,(IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0)) as dueamount'))
		->where('regiNo',$regiNo)
		->first();
		$stdinfo=DB::table('Student')
		->join('Class', 'Student.class', '=', 'Class.code')
		->select('Student.regiNo', 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName',
		'Student.section','Student.shift','Student.session','Class.Name as class')
		->where('Student.regiNo',$regiNo)
		->first();
		$institute=Institute::select('*')->first();
		$rdata =array('payTotal'=>$totals->payTotal,'paiTotal'=>$totals->paiTotal,'dueAmount'=>$totals->dueamount);
		$pdf = PDF::loadView('app.feestdreportprint',compact('datas','rdata','stdinfo','institute'));
		return $pdf->stream('student-Payments.pdf');

	}
	public function report()
	{
		return View::Make('app.feesreport');
	}
	public function reportprint($sDate,$eDate)
	{
		$datas= FeeCol::select(DB::RAW('IFNULL(sum(payableAmount),0) as payTotal,IFNULL(sum(paidAmount),0) as paiTotal,(IFNULL(sum(payableAmount),0)- IFNULL(sum(paidAmount),0)) as dueamount'))
		->whereDate('created_at', '>=', date($sDate))
		->whereDate('created_at', '<=', date($eDate))
		->first();
		$institute=Institute::select('*')->first();
		$rdata =array('sDate'=>$this->getAppdate($sDate),'eDate'=>$this->getAppdate($eDate));
		$pdf = PDF::loadView('app.feesreportprint',compact('datas','rdata','institute'));
		return $pdf->stream('fee-collection-report.pdf');
	}

	public function billDetails($billNo)
	{
		$billDeatils = FeeHistory::select("*")
		->where('billNo',$billNo)
		->get();
		return $billDeatils;
	}
	private function  parseAppDate($datestr)
	{
		$date = explode('/', $datestr);
		return $date[2].'-'.$date[1].'-'.$date[0];
	}
	private function  getAppdate($datestr)
	{
		$date = explode('-', $datestr);
		return $date[2].'/'.$date[1].'/'.$date[0];
	}
}
