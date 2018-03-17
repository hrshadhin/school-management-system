<?php
Class formfoo{

}
class markController extends \BaseController {


    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $classes = ClassModel::select('code','name')->orderby('code','asc')->get();
        $subjects = Subject::all();
        return View::Make('app.markCreate',compact('classes','subjects'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $rules=[
            'class' => 'required',
            'section' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'regiNo' => 'required',
            'exam' => 'required',
            'subject' => 'required',
            'written' => 'required',
            'mcq' => 'required',
            'practical' =>'required',
            'ca' =>'required'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/mark/create/')->withErrors($validator);
        }
        else {

            //check if this subject marks added before
            $isAddbefore = Marks::where('class','=',Input::get('class'))
                ->where('section','=',Input::get('section'))
                ->where('shift','=',Input::get('shift'))
                ->where('session','=',trim(Input::get('session')))
                ->where('exam','=',Input::get('exam'))
                ->where('subject','=',Input::get('subject'))
                ->first();

            if($isAddbefore){
                return Redirect::to('/mark/create')->with("error","Marks already added for this class,sesction,shift,session,subject and exam!");

            }

            //get the subject information
            $subjectInfo = Subject::where('code',Input::get('subject'))->where('class',Input::get('class'))->first();
            if($subjectInfo->gradeSystem=="1")
            {
                $gparules = GPA::select('gpa','grade','markfrom')->where('for',"1")->get();

            }
            else {
                $gparules = GPA::select('gpa','grade','markfrom')->where('for',"2")->get();
            }

            //collect inputs fields data
            $len = count(Input::get('regiNo'));
            $regiNos = Input::get('regiNo');
            $writtens=Input::get('written');
            $mcqs =Input::get('mcq');
            $practicals=Input::get('practical');
            $cas=Input::get('ca');
            $isabsent = Input::get('absent');
            $counter=0;

            for ( $i=0; $i< $len;$i++) {

                //add marks entry
                $marks = new Marks;
                $marks->class=Input::get('class');
                $marks->section=Input::get('section');
                $marks->shift=Input::get('shift');
                $marks->session=trim(Input::get('session'));
                $marks->regiNo=$regiNos[$i];
                $marks->exam=Input::get('exam');
                $marks->subject=Input::get('subject');
                $marks->written=$writtens[$i];
                $marks->mcq = $mcqs[$i];
                $marks->practical=$practicals[$i];
                $marks->ca=$cas[$i];

                $isFail = false;

                if($subjectInfo->wpass && $writtens[$i] < $subjectInfo->wpass){
                    $isFail = true;
                }

                if($subjectInfo->mpass && $mcqs[$i] < $subjectInfo->mpass){
                    $isFail = true;
                }

                if($subjectInfo->ppass && $practicals[$i] < $subjectInfo->ppass){
                    $isFail = true;
                }
                if($subjectInfo->spass && $cas[$i] < $subjectInfo->spass){
                    $isFail = true;
                }

                //round the fraction marks
                $totalMark = round($writtens[$i]+$mcqs[$i]+$practicals[$i]+$cas[$i]);

                if($totalMark < $subjectInfo->totalpass){
                    $isFail = true;
                }

                $marks->total= $totalMark;

                if($isFail){
                    $marks->grade='F';
                    $marks->point=0.00;
                }
                else{
                    foreach ($gparules as $gpa) {
                        if ($totalMark >= $gpa->markfrom){
                            $marks->grade=$gpa->gpa;
                            $marks->point=$gpa->grade;
                            break;
                        }
                    }
                }

                if($isabsent[$i] !== "")
                {
                    $marks->Absent=$isabsent[$i];
                }

                $marks->save();
                $counter++;
            }
        }

        return Redirect::to('/mark/create')->with("success",$counter."'s student mark save Successfully.");


    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {

        $formdata = new formfoo;
        $formdata->class="";
        $formdata->section="";
        $formdata->shift="";
        $formdata->session="";
        $formdata->subject="";
        $formdata->exam="";
        $classes = ClassModel::select('code','name')->orderby('code','asc')->get();
        //$subjects = Subject::lists('name','code');
        $marks=array();


        //$formdata["class"]="";
        return View::Make('app.markList',compact('classes','marks','formdata'));
    }

    public function getlist()
    {
        $rules=[
            'class' => 'required',
            'section' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'exam' => 'required',
            'subject' => 'required',

        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/mark/list/')->withErrors($validator);
        }
        else {
            $classes2 = ClassModel::orderby('code','asc')->lists('name','code');
            $subjects = Subject::where('class',Input::get('class'))->lists('name','code');
            $marks=	DB::table('Marks')
                ->join('Student', 'Marks.regiNo', '=', 'Student.regiNo')
                ->select('Marks.id','Marks.regiNo','Student.rollNo', 'Student.firstName','Student.middleName','Student.lastName', 'Marks.written','Marks.mcq','Marks.practical','Marks.ca','Marks.total','Marks.grade','Marks.point','Marks.Absent')
                ->where('Student.isActive', '=', 'Yes')
                ->where('Student.class','=',Input::get('class'))
                ->where('Marks.class','=',Input::get('class'))
                ->where('Marks.section','=',Input::get('section'))
                ->Where('Marks.shift','=',Input::get('shift'))
                ->where('Marks.session','=',trim(Input::get('session')))
                ->where('Marks.subject','=',Input::get('subject'))
                ->where('Marks.exam','=',Input::get('exam'))
                ->get();

            $formdata = new formfoo;
            $formdata->class=Input::get('class');
            $formdata->section=Input::get('section');
            $formdata->shift=Input::get('shift');
            $formdata->session=Input::get('session');
            $formdata->subject=Input::get('subject');
            $formdata->exam=Input::get('exam');

            if(count($marks)==0)
            {
                $noResult = array("noresult"=>"No Results Found!!");
                //return Redirect::to('/mark/list')->with("noresult","No Results Found!!");
                return View::Make('app.markList',compact('classes2','subjects','marks','noResult','formdata'));
            }

            return View::Make('app.markList',compact('classes2','subjects','marks','formdata'));
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
        $marks=	DB::table('Marks')
            ->join('Student', 'Marks.regiNo', '=', 'Student.regiNo')
            ->select('Marks.id','Marks.regiNo','Student.rollNo', 'Student.firstName','Student.middleName','Student.lastName','Marks.subject','Marks.class', 'Marks.written','Marks.mcq','Marks.practical','Marks.ca','Marks.total','Marks.grade','Marks.point','Marks.Absent')
            ->where('Marks.id','=',$id)
            ->first();

        return View::Make('app.markEdit',compact('marks'));


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
            'written' => 'required',
            'mcq' => 'required',
            'practical' =>'required',
            'ca' =>'required',
            'subject' => 'required',
            'class' => 'required'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/mark/edit/'.Input::get('id'))->withErrors($validator);
        }
        else {

            $marks = Marks::find(Input::get('id'));

            //get subject information
            $subjectInfo = Subject::select()->where('code',Input::get('subject'))->where('class',Input::get('class'))->first();
            if($subjectInfo->gradeSystem=="1")
            {
                $gparules = GPA::select('gpa','grade','markfrom')->where('for',"1")->get();

            }
            else {
                $gparules = GPA::select('gpa','grade','markfrom')->where('for',"2")->get();
            }

            $marks->written=Input::get('written');
            $marks->mcq = Input::get('mcq');
            $marks->practical=Input::get('practical');
            $marks->ca=Input::get('ca');

            $isFail = false;

            if($subjectInfo->wpass && $marks->written < $subjectInfo->wpass){
                $isFail = true;
            }

            if($subjectInfo->mpass && $marks->mcq < $subjectInfo->mpass){
                $isFail = true;
            }

            if($subjectInfo->ppass && $marks->practical < $subjectInfo->ppass){
                $isFail = true;
            }
            if($subjectInfo->spass && $marks->ca < $subjectInfo->spass){
                $isFail = true;
            }

            //round the fraction marks
            $totalMark = round($marks->written+$marks->mcq+$marks->practical+$marks->ca);
            if($totalMark < $subjectInfo->totalpass){
                $isFail = true;
            }

            $marks->total= $totalMark;

            if($isFail){
                $marks->grade='F';
                $marks->point=0.00;
            }
            else{
                foreach ($gparules as $gpa) {
                    if ($totalMark >= $gpa->markfrom){
                        $marks->grade=$gpa->gpa;
                        $marks->point=$gpa->grade;
                        break;
                    }
                }
            }

            $isAbsent = Input::get('Absent');
            if($isAbsent !== "")
            {
                $marks->Absent = $isAbsent;
            }

            $marks->save();

            return Redirect::to('/mark/list')->with("success","Marks Update Successfully.");

        }
    }
}
