<?php
use Carbon\Carbon;

class foobar{

}
Class formfoo{

}
class teacherController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth');
        $this->beforeFilter('admin_or_management');
        $this->beforeFilter('management',array(
            'only'=> array('index','create','edit','update','delete','createAttendance','postCreateAttendance','leaveCreate',
                'leaveStore','holidayCreate','holidayIndex','holidayDelete')
        ));

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::Make('app.teacher.create');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $rules=[
            'regNo' => 'required',
            'fullName' => 'required',
            'gender' => 'required',
            'egroup' => 'required',
            'religion' => 'required',
            'bloodgroup' => 'required',
            'nationality' => 'required',
            'dob' => 'required',
            'joinDate' => 'required',
            'photo' => 'required|mimes:jpeg,jpg,png',
            'cellNo' => 'required',
            'educationQualification' => 'required',
            'presentAddress' => 'required',
            'parmanentAddress' => 'required'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/teacher/create')->withErrors($validator);
        }
        else {
            $fileName=Input::get('regNo').'.'.Input::file('photo')->getClientOriginalExtension();

            $teacher = new Teachers;
            $teacher->regNo= Input::get('regNo');
            $teacher->fullName= Input::get('fullName');
            $teacher->gender= Input::get('gender');
            $teacher->egroup= Input::get('egroup');
            $teacher->religion= Input::get('religion');
            $teacher->bloodgroup= Input::get('bloodgroup');
            $teacher->nationality= Input::get('nationality');
            $teacher->dob= Input::get('dob');
            $teacher->joinDate= Input::get('joinDate');
            $teacher->photo= $fileName;
            $teacher->educationQualification= Input::get('educationQualification');
            $teacher->cellNo= Input::get('cellNo');
            $teacher->details= Input::get('details');
            $teacher->presentAddress= Input::get('presentAddress');
            $teacher->parmanentAddress= Input::get('parmanentAddress');
            $teacher->isActive=1;

            $hasTeacher = Teachers::where('regNo','=',Input::get('regNo'))->where('isActive',1)->first();
            if ($hasTeacher)
            {
                $messages = $validator->errors();
                $messages->add('Duplicate!', 'Teacher already exits with this employee no.');
                return Redirect::to('/teacher/create')->withErrors($messages)->withInput();
            }
            else {
                Input::file('photo')->move(base_path() .'/public/images/teachers',$fileName);
                $teacher->save();
                return Redirect::to('/teacher/create')->with("success","Teacher added succesfully.");
            }


        }
    }


    /**
     *
     * @return Response
     */
    public function show()
    {

        $teachers = Teachers::where('isActive',1)->orderBy('regNo','asc')->get();
        return View::Make("app.teacher.list", compact('teachers'));



    }

    public function view($id)
    {
        $teacher = Teachers::where('regNo',$id)->where('isActive',1)->first();
        $cl = Leaves::where('regNo',$id)->where('lType','CL')->whereYear('leaveDate','=',date('Y'))->where('status',2)->count();
        $ml = Leaves::where('regNo',$id)->where('lType','ML')->whereYear('leaveDate','=',date('Y'))->where('status',2)->count();
        $ul = Leaves::where('regNo',$id)->where('lType','UL')->whereYear('leaveDate','=',date('Y'))->where('status',2)->count();

        return View::Make("app.teacher.details",compact('teacher','cl','ml','ul'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $teacher = Teachers::where('regNo',$id)->where('isActive',1)->first();
        return View::Make("app.teacher.edit",compact('teacher'));
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
//            'regNo' => 'required',
            'fullName' => 'required',
            'gender' => 'required',
            'egroup' => 'required',
            'religion' => 'required',
            'bloodgroup' => 'required',
            'nationality' => 'required',
            'dob' => 'required',
            'joinDate' => 'required',
//            'photo' => 'required|mimes:jpeg,jpg,png',
            'cellNo' => 'required',
            'educationQualification' => 'required',
            'presentAddress' => 'required',
            'parmanentAddress' => 'required'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/teacher/edit/'.Input::get('id'))->withErrors($validator);
        }
        else {

            $teacher = Teachers::where('regNo',Input::get('id'))->first();

            if(Input::hasFile('photo'))
            {

                if(substr(Input::file('photo')->getMimeType(), 0, 5) != 'image')
                {
                    $messages = $validator->errors();
                    $messages->add('Notvalid!', 'Photo must be a image,jpeg,jpg,png!');
                    return Redirect::to('/teacher/edit/'.Input::get('id'))->withErrors($messages);
                }
                else {

                    $fileName=Input::get('regNo').'.'.Input::file('photo')->getClientOriginalExtension();
                    $teacher->photo = $fileName;
                    Input::file('photo')->move(base_path() .'/public/images/teachers',$fileName);
                }

            }
            else {
                $teacher->photo= Input::get('oldphoto');

            }
//            $student->regiNo=Input::get('regiNo');
//            $teacher->regNo= Input::get('regNo');
            $teacher->fullName= Input::get('fullName');
            $teacher->gender= Input::get('gender');
            $teacher->egroup= Input::get('egroup');
            $teacher->religion= Input::get('religion');
            $teacher->bloodgroup= Input::get('bloodgroup');
            $teacher->nationality= Input::get('nationality');
            $teacher->dob= Input::get('dob');
            $teacher->joinDate= Input::get('joinDate');
            $teacher->educationQualification= Input::get('educationQualification');
            $teacher->cellNo= Input::get('cellNo');
            $teacher->details= Input::get('details');
            $teacher->presentAddress= Input::get('presentAddress');
            $teacher->parmanentAddress= Input::get('parmanentAddress');
            $teacher->update();

            return Redirect::to('/teacher/list')->with("success","Teacher Updated Succesfully.");
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
        $teacher = Teachers::where('regNo',$id)->first();
        $teacher->isActive= 0;
        $teacher->save();

        return Redirect::to('/teacher/list')->with("success","Teacher Deleted Succesfully.");
    }

    /**
     * add atteance from file
     * @return Response
     */
    public function createAttendance()
    {
        return View::Make('app.teacher.attendance_create');
    }

    /**
     * add atteance from file
     * @return Response
     */
    public function postCreateAttendance()
    {

        $file = Input::file('fileUpload');
        $ext = strtolower($file->getClientOriginalExtension());

        $validator = Validator::make(array('ext' => $ext),array('ext' => 'in:csv,xls,xlsx')
        );
        if ($validator->fails()) {
            return Redirect::to('/teacher-attendance/create')->withErrors($validator);
        } else {
            try {
                $toInsert = 0;
                $data = Excel::load(Input::file('fileUpload'), function ($reader) { })->get();

                if(!empty($data) && $data->count()){
                    DB::beginTransaction();
                    try {
                        foreach ($data->toArray() as $row) {
                            if(count(array_keys($row))>=15){
                                $attenData= [
                                    'regNo' => $row['regno'],
                                    'date' => \Carbon\Carbon::createFromFormat('d-m-Y',$row['date']),
                                    'vEMPNO' => $row['vempno'],
                                    'dIN_TIME' => \Carbon\Carbon::createFromFormat('d-m-Y H:i:s',$row['din_time']),
                                    'dOUT_TIME' => \Carbon\Carbon::createFromFormat('d-m-Y H:i:s',$row['dout_time']),
                                    'nWorkingHOUR' => $row['nworkinghour'],
                                    'nLATE' => $row['nlate'],
                                    'vSTATUS' => $row['vstatus'],
                                    'REMARKS' => $row['remarks'],
                                    'vDEPT_NAME' => $row['vdept_name'],
                                    'vSECTION_NAME' => $row['vsection_name'],
                                    'vDES_NAME' => $row['vdes_name'],
                                    'vSHIFT_CODE' => $row['vshift_code'],
                                    'vWEEKLY_OFF' => $row['vweekly_off'],
                                    'created_at' => \Carbon\Carbon::createFromFormat('d-m-Y H:i:s',$row['created_at'])
                                ];

                                TeacherAttendance::insert($attenData);
                                $toInsert++;
                            }
                        }
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                        $errorMessages = new Illuminate\Support\MessageBag;
                        $errorMessages->add('Error', $e->getMessage());
                        return Redirect::to('/teacher-attendance/create')->withErrors($errorMessages);

                        // something went wrong
                    }

                }

                if($toInsert){
                    return Redirect::to('/teacher-attendance/create')->with("success", $toInsert.' Teacher attendance record upload successfully.');
                }
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Validation', 'File is empty or invalid data! Please follow help note.');
                return Redirect::to('/teacher-attendance/create')->withErrors($errorMessages);

            } catch (\Exception $e) {
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error', $e->getMessage());
                return Redirect::to('/teacher-attendance/create')->withErrors($errorMessages);
            }
        }
    }

    /**
     * add atteance from file
     * @return Response
     */
    public function attenaceList()
    {
        $searchType = Input::get('searchType','1');
        $egroup = Input::get('egroup',null);
        $regNo = Input::get('teacher',null);
        $isPrint = Input::get('print_view',null);
        $dateFrom = Input::get('dateFrom',date('Y-m-d',strtotime(date('Y-m-d')."-7 day")));
        $dateTo = Input::get('dateTo',date('Y-m-d'));

        if($regNo && $regNo !='0'){
            $attendance = TeacherAttendance::with('teacher')
                ->where('regNo',$regNo)
                ->whereDate('date','>=',$dateFrom)
                ->whereDate('date','<=',$dateTo)
                ->orderBy('date','desc')
                ->get();

        }
        else{
            if($egroup && $egroup !='0'){
                $attendance = TeacherAttendance::with('teacher')
                    ->whereHas('teacher', function($q) use ($egroup) {
                        $q->where('egroup', '=', $egroup);
                    })
                    ->whereDate('date','>=',$dateFrom)
                    ->whereDate('date','<=',$dateTo)
                    ->orderBy('date','desc')
                    ->get();
            }
            else{
                $attendance = TeacherAttendance::with('teacher')
                    ->whereDate('date','>=',$dateFrom)
                    ->whereDate('date','<=',$dateTo)
                    ->orderBy('date','desc')
                    ->get();
            }

        }

        //=======================Holiday and work outside code start =========================
        //find request month first and last date
        $firstDate = $dateFrom;
        $lastDate = $dateTo;

        //get holidays of request month
        $holiDays = Holidays::where('status',1)
            ->whereDate('holiDate','>=',$firstDate)
            ->whereDate('holiDate','<=',$lastDate)
            ->lists('status','holiDate');

//        //find fridays of requested month
//        $fridays = [];
//        $startDate = Carbon::parse($firstDate)->next(Carbon::FRIDAY); // Get the first friday.
//        $endDate = Carbon::parse($lastDate);
//
//        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
//            $fridays[$date->format('Y-m-d')] = 1;
//        }

//        //get all leaves of employees for requested month
//        $leaves = Leaves::where('status',2)
//            ->whereDate('leaveDate','>=',$firstDate)
//            ->whereDate('leaveDate','<=',$lastDate)
//            ->get();
//        $empLeaves=[];
//        foreach ($leaves as $leave){
//            $empLeaves[$leave->regNo][$leave->leaveDate->format('Y-m-d')] = $leave->status;
//        }

        //get all work outside of employees for requested month
        $works = Workoutside::where('status',1)
            ->whereDate('workDate','>=',$firstDate)
            ->whereDate('workDate','<=',$lastDate)
            ->get();
        $empWorks=[];
        foreach ($works as $work){
            $empWorks[$work->regNo][$work->workDate->format('Y-m-d')] = $work->status;
        }
        //=======================Holiday and work outside code end =========================



        if($isPrint){
            $institute=Institute::select('*')->first();
            if(!count($institute)){
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error','Please setup institute information!');
                return Redirect::to('/teacher-attendance/list')->withErrors($errorMessages);
            }

            return View::Make('app.teacher.attendance_report',compact('institute','teachers','attendance',
                'regNo','egroup','searchType','dateFrom','dateTo','holiDays','empWorks'
            ));

        }
        $teachers = ['0'=>'All']+Teachers::select('regNo','fullName')->where('isActive',1)->orderby('regNo','asc')->lists('fullName','regNo');
        return View::Make('app.teacher.attendanceList',
            compact('teachers','attendance','regNo','egroup','searchType',
                'dateFrom','dateTo','holiDays','empWorks'
            ));
    }



    /**
     * report
     * @return Response
     */
    public function absenteeismReport()
    {

        $isPrint = Input::get('print_view',null);
        $dateFrom = Input::get('dateFrom',date('Y-m-d',strtotime(date('Y-m-d')."-7 day")));
        $dateTo = Input::get('dateTo',date('Y-m-d'));

        if($isPrint){
            $egroup = Input::get('egroup',null);

            $data=[];

            if($egroup=="Teacher"){
                $teachers = Teachers::select('regNo')->where('egroup','Teacher')->lists('regNo');

                $data = TeacherAttendance::selectRaw("date, COUNT(CASE WHEN vSTATUS='P' THEN vSTATUS ELSE NULL END) present, COUNT(CASE WHEN vSTATUS='A' THEN vSTATUS ELSE NULL END) absent, COUNT(vSTATUS) as total")
                    ->whereDate('date','>=',$dateFrom)
                    ->whereDate('date','<=',$dateTo)
                    ->whereIn('regNo',$teachers)
                    ->groupBy('date')
                    ->get();
            }
            else{
                $staffs = Teachers::select('regNo')->where('egroup','Staff')->lists('regNo');

                $data = TeacherAttendance::selectRaw("date, COUNT(CASE WHEN vSTATUS='P' THEN vSTATUS ELSE NULL END) present, COUNT(CASE WHEN vSTATUS='A' THEN vSTATUS ELSE NULL END) absent, COUNT(vSTATUS) as total")
                    ->whereDate('date','>=',$dateFrom)
                    ->whereDate('date','<=',$dateTo)
                    ->whereIn('regNo',$staffs)
                    ->groupBy('date')
                    ->get();
            }

            $institute=Institute::select('*')->first();
            if(!count($institute)){
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error','Please setup institute information!');
                return Redirect::to('/teacher-attendance/list')->withErrors($errorMessages);
            }
            return View::Make('app.teacher.absenteeism_report',compact('institute','egroup','data','dateFrom','dateTo'));

        }



        return View::Make('app.teacher.absenteeism',compact('dateFrom','dateTo'));
    }/**



 * report
 * @return Response
 */
    public function monthlyAttendanceReport()
    {

        $isPrint = Input::get('print_view',null);
        $yearMonth = Input::get('yearMonth',date('Y-m'));

        //find request month first and last date
        $firstDate = $yearMonth."-01";
        $oneMonthEnd = strtotime("+1 month", strtotime($firstDate));
        $lastDate = date('Y-m-d',strtotime("-1 day",$oneMonthEnd));

        //get holidays of request month
        $holiDays = Holidays::where('status',1)
            ->whereDate('holiDate','>=',$firstDate)
            ->whereDate('holiDate','<=',$lastDate)
            ->lists('status','holiDate');

        //find fridays of requested month
        $fridays = [];
        $startDate = Carbon::parse($firstDate)->next(Carbon::FRIDAY); // Get the first friday.
        $endDate = Carbon::parse($lastDate);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $fridays[$date->format('Y-m-d')] = 1;
        }

        //get all leaves of employees for requested month
        $leaves = Leaves::where('status',2)
            ->whereDate('leaveDate','>=',$firstDate)
            ->whereDate('leaveDate','<=',$lastDate)
            ->get();
        $empLeaves=[];
        foreach ($leaves as $leave){
            $empLeaves[$leave->regNo][$leave->leaveDate->format('Y-m-d')] = $leave->status;
        }

        //get all work outside of employees for requested month
        $works = Workoutside::where('status',1)
            ->whereDate('workDate','>=',$firstDate)
            ->whereDate('workDate','<=',$lastDate)
            ->get();
        $empWorks=[];
        foreach ($works as $work){
            $empWorks[$work->regNo][$work->workDate->format('Y-m-d')] = $work->status;
        }


        if($isPrint){
            $myPart = mb_split('-',$yearMonth);
            if(count($myPart)!=2){
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error','Please don\'t mess with inputs!!!');
                return Redirect::to('/teacher-attendance/monthly-report')->withErrors($errorMessages);
            }

            $SelectCol = self::getSelectColumns($myPart[0],$myPart[1]);
            $fullSql ="SELECT t.fullName as name,t.regNo,".$SelectCol." FROM TeacherAttendance as ta join Teachers as t ON ta.regNo=t.regNo AND t.isActive=1 GROUP BY ta.regNo;";
//            dd($fullSql);
            $data = DB::select($fullSql);
//            return $data;
            $keys = array_keys((array)$data[0]);
//            return $data;
            $institute=Institute::select('*')->first();
            if(!count($institute)){
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error','Please setup institute information!');
                return Redirect::to('/teacher-attendance/monthly-report')->withErrors($errorMessages);
            }

            return View::Make('app.teacher.monthly_attendance_report',compact('institute','data','keys','yearMonth','fridays','holiDays','empLeaves','empWorks'));

        }
        return View::Make('app.teacher.monthly_attendance',compact('yearMonth'));
    }



    private static function getSelectColumns($year,$month){
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);
        $selectCol = "";
        for($i=$start_time; $i<$end_time; $i+=86400)
        {
            $d = date('Y-m-d', $i);
            $selectCol .= "MAX(IF(date = '".$d."', vSTATUS, 0)) AS '".$d."',";
        }
        if(strlen($selectCol)){
            $selectCol = substr($selectCol,0,-1);
        }

        return $selectCol;
    }


    /*
     * Holidays manage codes gores below
     *
     */

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function holidayIndex()
    {
        $holidays = Holidays::where('status',1)->get();
        return View::Make('app.teacher.holiday.list',compact('holidays'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function holidayCreate()
    {
        $rules=[
            'holiDate' => 'required'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/holiday/create')->withErrors($validator);
        }
        else {

            $holiDayStart = \Carbon\Carbon::createFromFormat('d/m/Y',Input::get('holiDate'));
            $holiDayEnd = null;
            if(strlen(Input::get('holiDateEnd'))) {
                $holiDayEnd = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('holiDateEnd'));
            }

            $dateList = [];

            $desc = Input::get('description');

            if($holiDayEnd){
                if($holiDayEnd<$holiDayStart){
                    $messages = $validator->errors();
                    $messages->add('Wrong Input!', 'Date End can\'t be less than start date!');
                    return Redirect::to('/holidays')->withErrors($messages)->withInput();
                }

                $start_time = strtotime($holiDayStart);
                $end_time = strtotime($holiDayEnd);
                for($i=$start_time; $i<=$end_time; $i+=86400)
                {
                    $dateList[] = [
                        'holiDate' => date('Y-m-d', $i),
                        'createdAt' => \Carbon\Carbon::now(),
                        'description' => $desc,
                        'status'  => 1
                    ];

                }

            }
            else{
                $dateList[] =  [
                    'holiDate' => $holiDayStart->format('Y-m-d'),
                    'createdAt' => \Carbon\Carbon::now(),
                    'description' => $desc,
                    'status'  => 1
                ];
            }

            Holidays::insert($dateList);

            return Redirect::to('/holidays')->with("success","Holidays added succesfully.");



        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function holidayDelete($id)
    {
        $holiDay = Holidays::findOrFail($id);
        $holiDay->status= 0;
        $holiDay->save();

        return Redirect::to('/holidays')->with("success","Holiday Deleted Succesfully.");
    }


    /*
     * Leave manage codes gores below
     *
     */
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function leaveIndex()
    {

        $type = Input::get('lType',null);
        $employee = Input::get('employee',null);
        $status = Input::get('status',1);


        if($status!='0'){
            $query = Leaves::where('status',$status);
        }
        else{
            $query = Leaves::whereIn('status',[1,2,3]);
        }

        if($type && strlen($type)){
            $query = $query->where('lType',$type);
        }
        if($employee && strlen($employee)){
            $query = $query->where('regNo',$employee);
        }
        $leaves = $query->with('teacher')->orderBy('leaveDate','desc')->get();
        $teachers = ['0'=>'All']+Teachers::select('regNo','fullName')->where('isActive',1)->orderby('regNo','asc')->lists('fullName','regNo');
        return View::Make('app.teacher.leave.list',compact('leaves','teachers','employee','type','status'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function leaveCreate()
    {
        $teachers = Teachers::select('regNo','fullName')->where('isActive',1)->orderby('regNo','asc')->lists('fullName','regNo');
        return View::Make('app.teacher.leave.create',compact('teachers'));

    }

    /**
     * Store the form for creating a new resource.
     *
     * @return Response
     */
    public function leaveStore()
    {

        $rules=[
            'employee' => 'required',
            'lType' => 'required',
            'leaveDate' => 'required',
            'paper' => 'mimes:jpeg,jpg,png,pdf,doc,docx,odt,txt,text|max:2048',


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/leaves/create')->withErrors($validator);
        }
        else {
            $dayCount = 1;
            $leaveDateStart = \Carbon\Carbon::createFromFormat('d/m/Y',Input::get('leaveDate'));
            $leaveDateEnd = null;
            if(strlen(Input::get('leaveDateEnd'))) {
                $leaveDateEnd = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('leaveDateEnd'));

                $dayCount = $leaveDateEnd->diff($leaveDateStart)->format("%a")+1;
            }



            $leaveList = [];

            $lType = Input::get('lType');
            $employee = Input::get('employee');
            $desc = Input::get('description');
            $fileName=null;

            //===============Has days for leave checking ======================
            $hasDayLeft = true;
            $lerrMsg = "";
            if($lType=="CL"){
                $cl = Leaves::where('regNo',$employee)->where('lType','CL')->whereYear('leaveDate','=',date('Y'))->where('status',2)->count();
                if(($cl+$dayCount)>20){
                    $hasDayLeft =false;
                    $lerrMsg="Casual leave limit is over.He/She took ".strval($cl)." day's leave already.";
                }
            }
            if($lType=="ML"){
                $ml = Leaves::where('regNo',$employee)->where('lType','ML')->whereYear('leaveDate','=',date('Y'))->where('status',2)->count();
                if(($ml+$dayCount)>10){
                    $hasDayLeft =false;
                    $lerrMsg="Sick leave limit is over.He/She took ".strval($ml)." day's leave already.";
                }
            }
//            $ul = Leaves::where('regNo',$employee)->where('lType','UL')->whereYear('leaveDate','=',date('Y'))->where('status',2)->count();
            if(!$hasDayLeft){
                $messages = $validator->errors();
                $messages->add('Limit Over', $lerrMsg);
                return Redirect::to('/leaves/create')->withErrors($messages)->withInput();
            }

            //========================END====================

            if(Input::hasFile('paper')){
                $fileName=uniqid().'.'.Input::file('paper')->getClientOriginalExtension();
                Input::file('paper')->move(base_path() .'/public/images/teachers',$fileName);
            }

            if($leaveDateEnd){
                if($leaveDateEnd<$leaveDateStart){
                    $messages = $validator->errors();
                    $messages->add('Wrong Input!', 'Date End can\'t be less than start date!');
                    return Redirect::to('/leaves/create')->withErrors($messages)->withInput();
                }

                $start_time = strtotime($leaveDateStart);
                $end_time = strtotime($leaveDateEnd);
                for($i=$start_time; $i<=$end_time; $i+=86400)
                {
                    $leaveList[] = [
                        'regNo' => $employee,
                        'lType' => $lType,
                        'leaveDate' => date('Y-m-d', $i),
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                        'description' => $desc,
                        'paper' => $fileName,
                        'status'  => 1
                    ];

                }

            }
            else{
                $leaveList[] =  [
                    'regNo' => $employee,
                    'lType' => $lType,
                    'leaveDate' => $leaveDateStart->format('Y-m-d'),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    'description' => $desc,
                    'paper' => $fileName,
                    'status'  => 1
                ];
            }

            Leaves::insert($leaveList);

            return Redirect::to('/leaves/create')->with("success","Leave added to pending list, need Principal approval.");


        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function leaveUpdate($id,$status)
    {

        $leave = Leaves::where('status',1)->where('id',$id)->first();
        if(!$leave){
            return Redirect::to('/leaves')->with("error","Leave not found!");

        }
        $leave->status= $status;
        $leave->save();

        return Redirect::to('/leaves')->with("success","Leave updated succesfully.");


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function leaveDelete($id)
    {
        $leave = Leaves::where('status',1)->where('id',$id)->first();

        if(!$leave){
            return Redirect::to('/leaves')->with("error","Leave not found!");

        }
        $leave->status= 0;
        $leave->save();

        return Redirect::to('/leaves')->with("success","Leave Deleted Succesfully.");
    }



    /*
     * work out side manage codes gores below
     *
     */
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function workOutsideIndex()
    {

        $employee = Input::get('employee',null);
//        $status = Input::get('status',1);

        $query = Workoutside::where('status',1);
//        if($status!='0'){
//            $query = Leaves::where('status',$status);
//        }
//        else{
//            $query = Leaves::whereIn('status',[1,2,3]);
//        }

        if($employee && strlen($employee)){
            $query = $query->where('regNo',$employee);
        }
        $workOutsides = $query->with('teacher')->orderBy('workDate','desc')->get();
        $teachers = ['0'=>'All']+Teachers::select('regNo','fullName')->where('isActive',1)->orderby('regNo','asc')->lists('fullName','regNo');
        return View::Make('app.teacher.workoutside.list',compact('workOutsides','teachers','employee'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function workOutsideCreate()
    {
        $teachers = Teachers::select('regNo','fullName')->where('isActive',1)->orderby('regNo','asc')->lists('fullName','regNo');
        return View::Make('app.teacher.workoutside.create',compact('teachers'));

    }

    /**
     * Store the form for creating a new resource.
     *
     * @return Response
     */
    public function workOutsideStore()
    {

        $rules=[
            'employee' => 'required',
            'workDate' => 'required',
            'paper' => 'mimes:jpeg,jpg,png,pdf,doc,docx,odt,txt,text|max:2048',

        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/workoutside/create')->withErrors($validator);
        }
        else {

            $leaveDateStart = \Carbon\Carbon::createFromFormat('d/m/Y',Input::get('workDate'));
            $leaveDateEnd = null;
            if(strlen(Input::get('leaveDateEnd'))) {
                $leaveDateEnd = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('leaveDateEnd'));
            }

            $leaveList = [];

            $employee = Input::get('employee');
            $desc = Input::get('description');
            $fileName=null;

            if(Input::hasFile('paper')){
                $fileName=uniqid().'.'.Input::file('paper')->getClientOriginalExtension();
                Input::file('paper')->move(base_path() .'/public/images/teachers',$fileName);
            }

            if($leaveDateEnd){
                if($leaveDateEnd<$leaveDateStart){
                    $messages = $validator->errors();
                    $messages->add('Wrong Input!', 'Date End can\'t be less than start date!');
                    return Redirect::to('/workoutside/create')->withErrors($messages)->withInput();
                }

                $start_time = strtotime($leaveDateStart);
                $end_time = strtotime($leaveDateEnd);
                for($i=$start_time; $i<=$end_time; $i+=86400)
                {
                    $leaveList[] = [
                        'regNo' => $employee,
                        'workDate' => date('Y-m-d', $i),
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                        'description' => $desc,
                        'paper' => $fileName,
                        'status'  => 1
                    ];

                }

            }
            else{
                $leaveList[] =  [
                    'regNo' => $employee,
                    'workDate' => $leaveDateStart->format('Y-m-d'),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    'description' => $desc,
                    'paper' => $fileName,
                    'status'  => 1
                ];
            }

            Workoutside::insert($leaveList);

            return Redirect::to('/workoutside/create')->with("success","Work outside entry added.");


        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
//    public function workOutsideUpdate($id,$status)
//    {
//
//        $leave = Leaves::where('status',1)->where('id',$id)->first();
//        if(!$leave){
//            return Redirect::to('/leaves')->with("error","Leave not found!");
//
//        }
//        $leave->status= $status;
//        $leave->save();
//
//        return Redirect::to('/leaves')->with("success","Leave updated succesfully.");
//
//
//    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function workOutsideDelete($id)
    {
        $work = Workoutside::where('status',1)->where('id',$id)->first();

        if(!$work){
            return Redirect::to('/workoutside')->with("error","Work outside entry not found!");

        }
        $work->status= 0;
        $work->save();

        return Redirect::to('/workoutside')->with("success","Work outside entry deleted succesfully.");
    }


    public function monthlyAttendanceReport2()
    {

        $isPrint = Input::get('print_view',null);
        $yearMonth = Input::get('yearMonth',date('Y-m'));


        if($isPrint){

            //find request month first and last date
            $firstDate = $yearMonth."-01";
            $oneMonthEnd = strtotime("+1 month", strtotime($firstDate));
            $lastDate = date('Y-m-d',strtotime("-1 day",$oneMonthEnd));

            //get holidays of request month
            $holiDays = Holidays::where('status',1)
                ->whereDate('holiDate','>=',$firstDate)
                ->whereDate('holiDate','<=',$lastDate)
                ->lists('status','holiDate');

            //find fridays of requested month
            $fridays = [];
            $startDate = Carbon::parse($firstDate)->next(Carbon::FRIDAY); // Get the first friday.
            $endDate = Carbon::parse($lastDate);

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                $fridays[$date->format('Y-m-d')] = 1;
            }

            //get all leaves of employees for requested month
            $leaves = Leaves::where('status',2)
                ->whereDate('leaveDate','>=',$firstDate)
                ->whereDate('leaveDate','<=',$lastDate)
                ->get();
            $empLeaves=[];
            foreach ($leaves as $leave){
                $empLeaves[$leave->regNo][$leave->leaveDate->format('Y-m-d')] = $leave->status;
            }

            //get all work outside of employees for requested month
            $works = Workoutside::where('status',1)
                ->whereDate('workDate','>=',$firstDate)
                ->whereDate('workDate','<=',$lastDate)
                ->get();
            $empWorks=[];
            foreach ($works as $work){
                $empWorks[$work->regNo][$work->workDate->format('Y-m-d')] = $work->status;
            }

            $myPart = mb_split('-',$yearMonth);
            if(count($myPart)!=2){
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error','Please don\'t mess with inputs!!!');
                return Redirect::to('/teacher-attendance/monthly-report-2')->withErrors($errorMessages);
            }

            $SelectCol = self::getSelectColumns($myPart[0],$myPart[1]);
            $fullSql ="SELECT t.fullName as name,t.regNo,'status/time',".$SelectCol." FROM TeacherAttendance as ta join Teachers as t ON ta.regNo=t.regNo AND t.isActive=1 GROUP BY ta.regNo;";
            $data = DB::select($fullSql);
            $keys = array_keys((array)$data[0]);

            $regNumbers = [];

            foreach ($data as $datum){
                $regNumbers[] = $datum->regNo;
            }

            $attendance = TeacherAttendance::whereIn('regNo',$regNumbers)
                ->whereDate('date','>=',$firstDate)
                ->whereDate('date','<=',$lastDate)
                ->orderBy('date','asc')
                ->get();

            $prityData = [];
            foreach ($attendance as $atd){
                $prityData[$atd->regNo][$atd->date->format('Y-m-d')] = [
                    'in' => $atd->dIN_TIME,
                    'out' => $atd->dOUT_TIME,
                    'work' => $atd->nWorkingHOUR,
                ];
            }


            $institute=Institute::select('*')->first();
            if(!count($institute)){
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('Error','Please setup institute information!');
                return Redirect::to('/teacher-attendance/monthly-report-2')->withErrors($errorMessages);
            }

            return View::Make('app.teacher.monthly_attendance_report_two',compact('institute','data','keys','yearMonth','fridays','holiDays','empLeaves','empWorks','prityData'));

        }

        return View::Make('app.teacher.monthly_attendance_two',compact('yearMonth'));
    }

}
