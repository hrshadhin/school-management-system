<?php

class formfoo{
}

class libraryController extends \BaseController {
	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('userAccess',array('only'=> array('deleteBook','deleteissueBook')));

	}
	public function getAddbook()
	{
		$classes = array('All'=>'All')+ClassModel::lists('name','code');
		return View::Make('app.addbook',compact('classes'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function postAddbook()
	{
		$rules=[
			'code' => 'required|max:50',
			'title' => 'required|max:250',
			'author' => 'required|max:100',
			'type' => 'required',
			'class' => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/addbook')->withErrors($validator)->withInput();
		}
		else {
			$book=AddBook::select('*')->where('code',Input::get('code'))->get();
			if(count($book)>0)
			{
				$errorMessages = new Illuminate\Support\MessageBag;
				$errorMessages->add('deplicate', 'Book Code allready exists!!');
				return Redirect::to('/library/addbook')->withInput()->withErrors($errorMessages);
			}
			else {
				$book = new AddBook();
				$book->code = Input::get('code');
				$book->title = Input::get('title');
				$book->author = Input::get('author');
				$book->quantity = Input::get('quantity');
				$book->rackNo = Input::get('rackNo');
				$book->rowNo = Input::get('rowNo');
				$book->type = Input::get('type');
				$book->class = Input::get('class');
				$book->desc = Input::get('desc');
				$book->save();
				return Redirect::to('/library/addbook')->with("success", "Book added to library Succesfully.");

			}
		}

	}


	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function getviewbook()
	{
		$classes = array('All'=>'All')+ClassModel::lists('name','code');
		$formdata = new formfoo;
		$formdata->class = "";
		$books=array();
		return View::Make('app.booklist',compact('classes','formdata','books'));
	}
	public function postviewbook()
	{

		if(Input::get('classcode')=="All"){
			$books=AddBook::leftJoin('Class', function($join) {
				$join->on('Books.class', '=', 'Class.code');
			})
			->select('Books.id', 'Books.code', 'Books.title', 'Books.author','Books.quantity','Books.rackNo','Books.rowNo','Books.type','Books.desc',DB::raw("IFNULL(Class.Name,'All') as class"))

			->orderBy('id', 'desc')->paginate(50);

		}
		else {

			$books = DB::table('Books')
			->join('Class', 'Books.class', '=', 'Class.code')
			->select('Books.id', 'Books.code', 'Books.title', 'Books.author','Books.quantity','Books.rackNo','Books.rowNo','Books.type','Books.desc','Class.Name as class')
			->where('Books.class',Input::get('classcode'))->orderBy('id', 'desc')->paginate(50);
		}

		$books->setBaseUrl('view-show');
		$classes = array('All' => 'All')+ClassModel::lists('name','code');
		$formdata = new formfoo;
		$formdata->class = Input::get('classcode');
		return View::Make('app.booklist',compact('classes','formdata','books'));

	}


	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function getBook($id)
	{
		$classes = array('All' => 'All')+ClassModel::lists('name','code');
		$book= AddBook::select('*')->find($id);
		return View::Make('app.bookedit',compact('classes','book'));
	}


	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function postUpdateBook()
	{
		$rules=[
			'code' => 'required|max:50',
			'title' => 'required|max:250',
			'author' => 'required|max:100',
			'type' => 'required',
			'class' => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/edit/'.Input::get('id'))->withErrors($validator)->withInput();
		}
		else {

			$book = AddBook::find(Input::get('id'));
			//$book->code = Input::get('code');
			$book->title = Input::get('title');
			$book->author = Input::get('author');
			$book->quantity = Input::get('quantity');
			$book->rackNo = Input::get('rackNo');
			$book->rowNo = Input::get('rowNo');
			$book->type = Input::get('type');
			$book->class = Input::get('class');
			$book->desc = Input::get('desc');
			$book->save();
			return Redirect::to('/library/view')->with("success", "Book updated Succesfully.");

		}

	}


	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function deleteBook($id)
	{
		$book = AddBook::find($id);
		$book->delete();
		return Redirect::to('/library/view')->with("success", "Book Deleted Succesfully.");
	}

	public function getissueBook()
	{
		$students =['' => 'Select Student']+Student::select(DB::raw("CONCAT(firstName,' ',middleName,' ',lastName,'[',regiNo,']') as name,regiNo"))->lists('name','regiNo');
		$books = ['' => 'Select Book']+AddBook::select(DB::raw("CONCAT(title,'[',author,']') as name,code"))->lists('name','code');
		return View::Make('app.bookissue',compact('students','books'));
	}

	public function postissueBook()
	{

		$rules=[
			'regiNo' => 'required',
			'bookCode' => 'required',
			'quantity' => 'required',
			'issueDate' => 'required',
			'returnDate' => 'required',

		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect::to('/library/issuebook')->withErrors($validator)->withInput();
		}
		else {


			/*$availabeQuantity=DB::table('bookStock')->select('quantity')->where('code',Input::get('code'))->first();

			if(Input::get('quantity')>$availabeQuantity->quantity)
			{
			$errorMessages = new Illuminate\Support\MessageBag;
			$errorMessages->add('deplicate', 'This book quantity not availabe right now!');
			return Redirect::to('/library/issuebook')->withErrors($errorMessages)->withInput();

		}*/
		$data=Input::all();
		$issueData = [];
		$now=\Carbon\Carbon::now();
		foreach ($data['bookCode'] as $key => $value){
			$issueData[] = [
				'regiNo' => $data['regiNo'],
				'issueDate' => $this->parseAppDate($data['issueDate']),
				'code' => $value,
				'quantity' => $data['quantity'][$key],
				'returnDate' => $this->parseAppDate($data['returnDate'][$key]),
				'fine' => $data['fine'][$key],
				'created_at' => $now,
				'updated_at' => $now,
			];

		}
		Issuebook::insert($issueData);
		/*  $issuebook = new Issuebook();
		$issuebook->code = Input::get('code');
		$issuebook->quantity = Input::get('quantity');
		$issuebook->regiNo = Input::get('regiNo');
		$issuebook->issueDate = $this->parseAppDate(Input::get('issueDate'));
		$issuebook->returnDate = $this->parseAppDate(Input::get('returnDate'));
		$issuebook->fine = Input::get('fine');
		$issuebook->save();*/
		return Redirect::to('/library/issuebook')->with("success","Succesfully book borrowed for '".Input::get('regiNo')."'.");

	}

}
public function getissueBookview()
{

	return View::Make('app.bookissueview');
}
public function postissueBookview()
{

	if(Input::get('status')!="")
	{
		$books = Issuebook::select('*')
		->Where('Status','=',Input::get('status'))
		->get();
		return View::Make('app.bookissueview',compact('books'));
	}
	if(Input::get('regiNo')!="" || Input::get('code') !="" || Input::get('issueDate') !="" || Input::get('returnDate') !="")
	{

		$books = Issuebook::select('*')->where('regiNo','=',Input::get('regiNo'))
		->orWhere('code','=',Input::get('code'))
		->orWhere('issueDate','=',$this->parseAppDate(Input::get('issueDate')))
		->orWhere('returnDate','=',$this->parseAppDate(Input::get('returnDate')))

		->get();
		return View::Make('app.bookissueview',compact('books'));

	}
	else {

		return Redirect::to('/library/issuebookview')->with("error","Pleae fill up at least one feild!");

	}

}
public function getissueBookupdate($id)
{
	$book= Issuebook::find($id);
	return View::Make('app.bookissueedit',compact('book'));
}
public function postissueBookupdate()
{
	$rules=[
		'regiNo' => 'required|max:20',
		'code' => 'required|max:50',
		'issueDate' => 'required',
		'returnDate' => 'required',
		'status' => 'required',

	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/library/issuebookupdate/'.Input::get('id'))->withErrors($validator);
	}
	else {

		$book = Issuebook::find(Input::get('id'));
		$book->code = Input::get('code');
		$book->regiNo = Input::get('regiNo');
		$book->issueDate = $this->parseAppDate(Input::get('issueDate'));
		$book->returnDate = $this->parseAppDate(Input::get('returnDate'));
		$book->fine = Input::get('fine');
		$book->Status = Input::get('status');
		$book->save();
		return Redirect::to('/library/issuebookview')->with("success","Succesfully book record updated.");

	}
}

public function deleteissueBook($id)
{
	$book= Issuebook::find($id);
	$book->delete();
	return Redirect::to('/library/issuebookview')->with("success","Succesfully book record deleted.");
}
public function getsearch()
{
	$classes = array('All' => 'All')+ClassModel::lists('name','code');
	return View::Make('app.booksearch',compact('classes'));
}
public function postsearch()
{
	if(Input::get('code')!="" || Input::get('title')!="" || Input::get('author') !="")
	{
		$query=AddBook::leftJoin('Class', function($join) {
			$join->on('Books.class', '=', 'Class.code');

		})
		->join('bookStock','Books.code', '=', 'bookStock.code')
		->select('Books.id', 'Books.code', 'Books.title', 'Books.author','bookStock.quantity','Books.rackNo','Books.rowNo','Books.type','Books.desc',DB::raw("IFNULL			(Class.Name,'All') as class"));
		if(Input::get('code')!="") $query->where('Books.code','=',Input::get('code'));
		if(Input::get('title')!="")$query->orWhere('Books.title','LIKE','%'.Input::get('title').'%');
		if(Input::get('author') !="")$query->orWhere('Books.author','LIKE','%'.Input::get('author').'%');


		$books=$query->get();


		$classes = array('All' => 'All')+ClassModel::lists('name','code');
		return View::Make('app.booksearch',compact('books','classes'));

	}
	else {

		return Redirect::to('/library/search')->with("error","Pleae fill up at least one feild!");

	}
}
public function postsearch2()
{
	$rules=[
		'type' => 'required',
		'class' => 'required',


	];
	$validator = \Validator::make(Input::all(), $rules);
	if ($validator->fails())
	{
		return Redirect::to('/library/search')->withErrors($validator);
	}
	else {
		if(Input::get('class')=="All"){
			$books=AddBook::leftJoin('Class', function($join) {
				$join->on('Books.class', '=', 'Class.code');
			})
			->join('bookStock','Books.code', '=', 'bookStock.code')
			->select('Books.id', 'Books.code', 'Books.title', 'Books.author','bookStock.quantity','Books.rackNo','Books.rowNo','Books.type','Books.desc',DB::raw("IFNULL(Class.Name,'All') as class"))
			->where('Books.type',Input::get('type'))
			->get();

		}
		else {

			$books = DB::table('Books')
			->join('Class', 'Books.class', '=', 'Class.code')
			->join('bookStock','Books.code', '=', 'bookStock.code')
			->select('Books.id', 'Books.code', 'Books.title', 'Books.author','bookStock.quantity','Books.rackNo','Books.rowNo','Books.type','Books.desc','Class.Name as class')
			->where('Books.class',Input::get('class'))
			->where('Books.type',Input::get('type'))->get();
		}
		$classes = array('All' => 'All')+ClassModel::lists('name','code');
		return View::Make('app.booksearch',compact('books','classes'));

	}
}

public function getReports()
{

	return View::Make('app.libraryReports');
}

public function Reportprint($do)
{
	if($do=="today")
	{
		$todayReturn = DB::table('issueBook')
		->join('Student', 'Student.regiNo', '=', 'issueBook.regiNo')
		->join('Books','Books.code','=','issueBook.code')
		->join('Class','Class.code','=','Student.class')
		->select('Books.title', 'Books.author','Books.type','issueBook.quantity','issueBook.fine','Student.firstName','Student.middleName','Student.lastName','Student.rollNo','Class.name as class')
		->where('issueBook.returnDate',date('Y-m-d'))
		->where('issueBook.Status','Borrowed')
		->get();
		$rdata =array('name'=>'Today Return List','total'=>count($todayReturn));

		$datas=$todayReturn;
		$institute=Institute::select('*')->first();
		$pdf = PDF::loadView('app.libraryreportprinttex',compact('datas','rdata','institute'));
		return $pdf->stream('today-books-return-List.pdf');

	}
	else if($do=="expire")
	{
		$expires = DB::table('issueBook')
		->join('Student', 'Student.regiNo', '=', 'issueBook.regiNo')
		->join('Books','Books.code','=','issueBook.code')
		->join('Class','Class.code','=','Student.class')
		->select('Books.title', 'Books.author','Books.type','issueBook.quantity','issueBook.fine','Student.firstName','Student.middleName','Student.lastName','Student.rollNo','Class.name as class')
		->where('issueBook.returnDate','<',date('Y-m-d'))
		->where('issueBook.Status','Borrowed')
		->get();
		$rdata =array('name'=>'Today Expire List','total'=>count($expires));

		$datas=$expires;
		$institute=Institute::select('*')->first();
		$pdf = PDF::loadView('app.libraryreportprinttex',compact('datas','rdata','institute'));
		return $pdf->stream('books-expire-List.pdf');
	}
	else {
		$books = AddBook::select('*')->where('type',$do)->get();
		$rdata =array('name'=>$do,'total'=>count($books));

		$datas=$books;
		$institute=Institute::select('*')->first();
		$pdf = PDF::loadView('app.libraryreportbooks',compact('datas','rdata','institute'));
		return $pdf->stream('books-expire-List.pdf');
	}
	return $do;
}
public function getReportsFine()
{
	return View::Make('app.libraryfinereport');
}
public function ReportsFineprint($month)
{
	$sqlraw="select sum(fine) as totalFine from issueBook where Status='Returned' and EXTRACT(YEAR_MONTH FROM returnDAte) = EXTRACT(YEAR_MONTH FROM '".$month."')";
	$fines = DB::select(DB::RAW($sqlraw));
	if($fines[0]->totalFine)
	{

		$total=$fines[0]->totalFine;
	}
	else
	{
		$total=0;
	}
	$institute=Institute::select('*')->first();
	$rdata =array('month'=>date('F-Y', strtotime($month)),'name'=>'Monthly Fine Collection Report','total'=>$total);
	$pdf = PDF::loadView('app.libraryfinereportprint',compact('rdata','institute'));
	return $pdf->stream('libraryfinereportprint.pdf');


}
private function  parseAppDate($datestr)
{

	if($datestr=="" or $datestr== NULL)
	return $datestr="0000-00-00";
	$date = explode('/', $datestr);
	return $date[2].'-'.$date[1].'-'.$date[0];
}

public function checkBookAvailability($code,$quantity)
{
	$availabeQuantity=DB::table('bookStock')
	->select('quantity')
	->where('code',$code)->first();
	$result = "Yes";
	if($quantity>$availabeQuantity->quantity)
	$result = "No";
	return ["isAvailable" => $result ];
	

}

}
