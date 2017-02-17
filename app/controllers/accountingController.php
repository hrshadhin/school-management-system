<?php

class accountingController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('sectorDelete','incomeDelete','expenceDelete')));
	}
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function sectors()
	{

		$sectors=AccountSector::all();
		$sector = array();
		return View::Make('app.accountsector',compact('sectors','sector'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function sectorCreate()
	{
		$rules=[
			'name' => 'required',
			'type' => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/accounting/sectors')->withInput(Input::all())->withErrors($validator);
		}
		else {
			$sector = new AccountSector();
			$sector->name= Input::get('name');
			$sector->type=Input::get('type');
			$sector->save();
			return Redirect::to('/accounting/sectors')->with("success","Accounting Sector Created Succesfully.");

		}
	}


	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function sectorEdit($id)
	{
		$sectors= AccountSector::all();
		$sector = AccountSector::find($id);
		return View::Make('app.accountsector',compact('sectors','sector'));
	}


	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function sectorUpdate()
	{
		$rules=[
			'name' => 'required',
			'type' => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/accounting/sectoredit/'.Input::get('id'))->withInput(Input::all())->withErrors($validator);
		}
		else {
			$sector = AccountSector::find(Input::get('id'));
			$sector->name= Input::get('name');
			$sector->type=Input::get('type');
			$sector->save();
			return Redirect::to('/accounting/sectors')->with("success","Accounting Sector Updated Succesfully.");

		}
	}


	/**
	* Delete the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function sectorDelete($id)
	{
		$sector = AccountSector::find($id);
		$sector->delete();
		return Redirect::to('/accounting/sectors')->with("success","Accounting Sector Deleted Succesfully.");
	}


	public function  income()
	{
		$sectors = AccountSector::select('id','name')->where('type','=','Income')->orderby('id','asc')->get();
		return View::Make('app.accountIncome',compact('sectors'));

	}
	public function  incomeCreate()
	{
		$rules=[
			'name' => 'required',
			'amount' => 'required|between:0,99.99',
			'date'   => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/accounting/income')->withInput(Input::all())->withErrors($validator);
		}
		else {
			$sectors = Input::get('name');
			$amount = Input::get('amount');
			$date = Input::get('date');
			$desc = Input::get('description');
			$sectorIds= array_keys($sectors);
			// $amountIds = array_keys($amount);
			//$dateIds = array_keys($date);
			$dataToSave = array();
			foreach($sectorIds as $id)
			{
				if($amount[$id] !=="" && $date[$id] !=="") {
					if (is_numeric($amount[$id])) {
						$data = array("name" => $sectors[$id], "amount" => $amount[$id], "date" => $date[$id],"description"=>$desc[$id]);
						array_push($dataToSave, $data);
					}else
					{
						$errorMessages = new Illuminate\Support\MessageBag;
						$errorMessages->add('Invalid', 'Amount must be a number.');
						return Redirect::to('/accounting/income')->withInput(Input::all())->withErrors($errorMessages);
					}
				}

			}

			$counter=0;
			foreach($dataToSave as $singleData)
			{
				$income = new Accounting();
				$income->name = $singleData["name"];
				$income->type="Income";
				$income->amount = $singleData["amount"];
				$income->description = $singleData["description"];

				$income->date = $this->parseAppDate($singleData["date"]);
				$income->save();
				$counter++;
			}


			return Redirect::to('/accounting/income')->with("success",$counter."'s income saved Succesfully.");

		}

	}
	public  function incomeList()
	{
		$incomes = array();
		return View::Make('app.accountIncomeView',compact('incomes'));
	}
	public  function incomeListPost()
	{
		$year = trim(Input::get('year'));


		$incomes = DB::select(DB::raw("SELECT * FROM accounting WHERE type ='Income' and YEAR(date)='".$year."'"));
		return View::Make('app.accountIncomeView',compact('incomes'));
	}

	public function  incomeEdit($id)
	{
		$income = Accounting::find($id);
		return View::Make('app.accountIncomeEdit',compact('income'));
	}
	public function incomeUpdate()
	{
		$rules=[
			'name' => 'required',
			'amount' => 'required|between:0,99.99',
			'date'   => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/accounting/incomeedit/'.Input::get('id'))->withErrors($validator);
		}
		elseif(!is_numeric(Input::get('amount')))
		{
			$errorMessages = new Illuminate\Support\MessageBag;
			$errorMessages->add('Invalid', 'Amount must be a number.');
			return Redirect::to('/accounting/incomeedit/'.Input::get('id'))->withErrors($errorMessages);
		}
		else {
			$income = Accounting::find(Input::get('id'));
			$income->amount=Input::get('amount');
			$income->description=Input::get('description');
			$income->date=$this->parseAppDate(Input::get('date'));
			$income->save();

			return Redirect::to('/accounting/incomelist')->with("success","Income Updated Succesfully.");
		}
	}
	public function incomeDelete($id)
	{
		$income = Accounting::find($id);
		$income->delete();
		return Redirect::to('/accounting/incomelist')->with("success","Income Deleted Succesfully.");
	}

	public function  expence()
	{
		$sectors = AccountSector::select('id','name')->where('type','=','Expence')->orderby('id','asc')->get();
		return View::Make('app.accountExpence',compact('sectors'));

	}
	public function expenceCreate()
	{
		$rules=[
			'name' => 'required',
			'amount' => 'required|between:0,99.99',
			'date'   => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/accounting/expence')->withInput(Input::all())->withErrors($validator);
		}
		else {
			$sectors = Input::get('name');
			$amount = Input::get('amount');
			$date = Input::get('date');
			$desc = Input::get('description');
			$sectorIds= array_keys($sectors);
			// $amountIds = array_keys($amount);
			//$dateIds = array_keys($date);
			$dataToSave = array();
			foreach($sectorIds as $id)
			{
				if($amount[$id] !=="" && $date[$id] !=="") {
					if (is_numeric($amount[$id])) {
						$data = array("name" => $sectors[$id], "amount" => $amount[$id], "date" => $date[$id],"description"=>$desc[$id]);
						array_push($dataToSave, $data);
					}else
					{
						$errorMessages = new Illuminate\Support\MessageBag;
						$errorMessages->add('Invalid', 'Amount must be a number.');
						return Redirect::to('/accounting/expence')->withInput(Input::all())->withErrors($errorMessages);
					}
				}

			}

			$counter=0;
			foreach($dataToSave as $singleData)
			{
				$income = new Accounting();
				$income->name = $singleData["name"];
				$income->type="Expence";
				$income->amount = $singleData["amount"];
				$income->description = $singleData["description"];
				$income->date = $this->parseAppDate($singleData["date"]);
				$income->save();
				$counter++;
			}


			return Redirect::to('/accounting/expence')->with("success",$counter."'s Expence saved Succesfully.");

		}

	}
	public  function expenceList()
	{
		$expences = array();
		return View::Make('app.accountExpenceView',compact('expences'));
	}
	public  function expenceListPost()
	{
		$year = trim(Input::get('year'));


		$expences = DB::select(DB::raw("SELECT * FROM accounting WHERE type ='Expence' and YEAR(date)='".$year."'"));
		return View::Make('app.accountExpenceView',compact('expences'));
	}

	public function  expenceEdit($id)
	{
		$expence = Accounting::find($id);
		return View::Make('app.accountExpenceEdit',compact('expence'));
	}
	public function expenceUpdate()
	{
		$rules=[
			'name' => 'required',
			'amount' => 'required|between:0,99.99',
			'date'   => 'required'

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/accounting/expenceedit/'.Input::get('id'))->withErrors($validator);
		}
		elseif(!is_numeric(Input::get('amount')))
		{
			$errorMessages = new Illuminate\Support\MessageBag;
			$errorMessages->add('Invalid', 'Amount must be a number.');
			return Redirect::to('/accounting/expenceedit/'.Input::get('id'))->withErrors($errorMessages);
		}
		else {
			$income = Accounting::find(Input::get('id'));
			$income->amount=Input::get('amount');
			$income->description=Input::get('description');
			$income->date=$this->parseAppDate(Input::get('date'));
			$income->save();

			return Redirect::to('/accounting/expencelist')->with("success","Expence Updated Succesfully.");
		}
	}
	public function expenceDelete($id)
	{
		$income = Accounting::find($id);
		$income->delete();
		return Redirect::to('/accounting/expencelist')->with("success","Expence Deleted Succesfully.");
	}

	public  function getReport()
	{
		$formdata=array('','');
		$datas=array();
		return View::Make('app.accountingReport',compact('datas','formdata'));
	}
	public  function printReport($rtype,$fdate,$tdate)
	{

		if ($rtype=="" && $fdate=="" && $tdate=="")
		{
			return Redirect::to('/accounting/report')->with("noresult","Data Not Found!");
		}
		else {

			$datas = Accounting::select('name', 'amount', 'date','description')->where('type', '=', $rtype)->where('date', '>=', $fdate)->where('date', '<=', $tdate)->get();
			$total = DB::select(DB::raw("SELECT sum(amount) as total FROM accounting where type='".$rtype."' and date >='".$fdate."' and date <='".$tdate."'"));

			if(count($datas)>0)
			{

				$formdata=array($this->getAppdate($fdate),$this->getAppdate($tdate),$rtype);
				$institute=Institute::select('*')->first();
				return View::Make('app.accountreportprint', compact('datas','formdata','total','institute'));
			}
			else{
				echo '<script> alert("Data Not Found!!!");window.close();</script> ';
			}

		}
	}
	public  function  getReportsum()
	{
		return View::Make('app.accountingReportsum');

	}
	public  function  printReportsum($fdate,$tdate)
	{
		if ($fdate=="" && $tdate=="")
		{
			return Redirect::to('/accounting/reportsum')->with("noresult","Data Not Found!");
		}
		else {

			$incomes = Accounting::select('name', 'amount','description', 'date')->where('type', '=', 'Income')->where('date', '>=', $fdate)->where('date', '<=', $tdate)->get();
			$intotal = DB::select(DB::raw("SELECT sum(amount) as total FROM accounting where type='Income' and date >='".$fdate."' and date <='".$tdate."'"));
			$expences = Accounting::select('name', 'amount','description', 'date')->where('type', '=', 'Expence')->where('date', '>=', $fdate)->where('date', '<=', $tdate)->get();
			$extotal = DB::select(DB::raw("SELECT sum(amount) as total FROM accounting where type='Expence' and date >='".$fdate."' and date <='".$tdate."'"));
			$balance = array($intotal[0]->total-$extotal[0]->total);


			$formdata=array($this->getAppdate($fdate),$this->getAppdate($tdate));
			$institute=Institute::select('*')->first();
			return View::Make('app.accountreportprintsum', compact('datas','formdata','incomes','expences','intotal','extotal','balance','institute'));


		}
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
