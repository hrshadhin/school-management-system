<?php
Class formfoo{

}
Class Meritdata{

}
class gradesheetController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth',array('except' => array('searchpub','postsearchpub','printsheet')));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $formdata = new formfoo;
        $formdata->class="";
        $formdata->section="";
        $formdata->shift="";
        $formdata->exam="";
        $formdata->session="";
        $students=array();
        $classes = ClassModel::lists('name','code');

        return View::Make('app.gradeSheet',compact('classes','formdata','students'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function stdlist()
    {
        $rules=[
            'class' => 'required',
            'section' => 'required',
            'exam' => 'required',
            'session' => 'required'


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $formdata = new formfoo;
            $formdata->class=Input::get('class');
            $formdata->section=Input::get('section');
            $formdata->exam=Input::get('exam');
            $formdata->session=Input::get('session');

            return Redirect::to('/gradesheet')->withErrors($validator);
        }
        else {

            $ispubl  = DB::table('MeritList')
                ->select('regiNo')
                ->where('class','=',Input::get('class'))
                ->where('session','=',trim(Input::get('session')))
                ->where('exam','=',Input::get('exam'))
                ->get();
            if(count($ispubl)>0) {
                $classes = ClassModel::lists('name', 'code');
                $students = DB::table('Student')
                    ->join('Marks', 'Student.regiNo', '=', 'Marks.regiNo')
                    ->select(DB::raw('DISTINCT(Student.regiNo)'), 'Student.rollNo', 'Student.firstName', 'Student.middleName', 'Student.lastName', 'Student.group', 'Marks.shift', 'Marks.class', 'Marks.section')
                    ->where('Student.isActive', '=', 'Yes')
                    ->where('Student.class', '=', Input::get('class'))
                    ->where('Marks.class', '=', Input::get('class'))
                    ->where('Marks.section', '=', Input::get('section'))
                    ->where('Marks.session', '=', trim(Input::get('session')))
                    ->where('Marks.exam', '=', Input::get('exam'))
                    ->get();

                $formdata = new formfoo;
                $formdata->class = Input::get('class');
                $formdata->section = Input::get('section');
                $formdata->session = Input::get('session');
                $formdata->exam = Input::get('exam');
                $formdata->postclass = array_get($classes, Input::get('class'));

                return View::Make('app.gradeSheet', compact('classes', 'formdata', 'students'));
            }
            else
            {
                return Redirect::to('/gradesheet')->withInput()->with("noresult", "Results Not Published Yet!");
            }


        }
    }

    public  function gradeCalculator($point,$gparules)
    {
        $grade=0;
        foreach ($gparules as $gpa) {
            if ($point >= $gpa->grade){
                $grade=$gpa->gpa;
                break;
            }
        }
        return $grade;
    }
    public  function pointCalculator($marks,$gparules)
    {

        $point=0;
        foreach ($gparules as $gpa) {


            if ($marks >= $gpa->markfrom){
                $point=$gpa->grade;
                break;
            }
        }

        return $point;
    }
    public  function gpaCalculator($marks,$gparules)
    {
        $gpacal= array();

        foreach ($gparules as $gpa) {
            if ($marks >= $gpa->markfrom){
                $gpacal[0]=$gpa->grade;
                $gpacal[1]=$gpa->gpa;
                break;
            }
        }
        return $gpacal;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function printsheet($regiNo,$exam,$class)
    {

        $student=	DB::table('Student')
            ->join('Class', 'Student.class', '=', 'Class.code')
            ->select( 'Student.regiNo','Student.rollNo','Student.dob', 'Student.firstName','Student.middleName','Student.lastName','Student.fatherName',
                'Student.motherName', 'Student.group','Student.shift','Student.class as classcode','Class.Name as class','Student.section','Student.session',
                'Student.extraActivity','Student.fourthSubject','Student.cphsSubject')
            ->where('Student.regiNo','=',$regiNo)
            ->where('Student.class','=',$class)
            ->where('Student.isActive', '=', 'Yes')
            ->first();

        if(count($student)>0) {
            $merit = DB::table('MeritList')
                ->select('regiNo', 'grade', 'point', 'totalNo')
                ->where('exam', $exam)
                ->where('class', $class)
                ->where('session', trim($student->session))
//			->where('regiNo',$regiNo)
                ->orderBy('point', 'DESC')
                ->orderBy('totalNo', 'DESC')->get();
            if (count($student) < 1 || count($merit) < 1) {
                return Redirect::back()->with('noresult', 'Result Not Found!');
            } else {
                $meritdata = new Meritdata();
                $position = 0;
                foreach ($merit as $m) {
                    $position++;
                    if ($m->regiNo === $regiNo) {
                        $meritdata->regiNo = $m->regiNo;
                        $meritdata->point = $m->point;
                        $meritdata->grade = $m->grade;
                        $meritdata->position = $position;
                        $meritdata->totalNo = $m->totalNo;
                        break;
                    }
                }

                //sub group need to implement
                $subjects = Subject::where('class', '=', $student->classcode)->get();
                //get class information
                $requestedClass = ClassModel::where('code',$student->classcode)->first();

                $overallSubject = array();
                $subcollection = array();

                $banglatotal = 0;
                $banglatotalhighest = 0;
                $banglaArray = array();
                $blextra = array();

                $englishtotal = 0;
                $englishtotalhighest = 0;
                $englishArray = array();
                $enextra = array();

                $totalHighest = 0;
                $isBanglaFail=false;
                $isEnglishFail=false;

                //2 paper written and mcq pass check
                $banglaWritten = 0;
                $banglaMcq = 0;
                $bnTotalExamMarks = 0;
                $bnWrittenPass = 0;
                $bnMcqPass = 0;

                $englishWritten = 0;
                $englishMcq = 0;
                $enTotalExamMarks = 0;
                $enWrittenPass = 0;
                $enMcqPass = 0;


                foreach ($subjects as $subject) {
                    $submarks = Marks::select('written', 'mcq', 'practical', 'ca', 'total', 'point', 'grade')->where('regiNo', '=', $student->regiNo)
                        ->where('subject', '=', $subject->code)->where('exam', '=', $exam)->where('class', '=', $class)->first();
                    $maxMarks = Marks::select(DB::raw('max(total) as highest'))->where('class', '=', $class)->where('session', '=', $student->session)
                        ->where('subject', '=', $subject->code)->where('exam', '=', $exam)->first();

                    $submarks["highest"] = $maxMarks->highest;
                    $submarks["subcode"] = $subject->code;
                    $submarks["subname"] = $subject->name;


                    if ($this->getSubGroup($subjects, $subject->code) === "Bangla") {

                        //check if this class have combine pass
                        if($requestedClass->combinePass){
                            $subInfo = self::getSubjectInfo($subjects,$subject->code);
                            $bnTotalExamMarks += $subInfo->totalfull;
                            $bnWrittenPass += $subInfo->wpass;
                            $bnMcqPass += $subInfo->mpass;

                            $banglaWritten += $submarks->written;
                            $banglaMcq += $submarks->mcq;

                            $banglatotal += $submarks->total;
                            $banglatotalhighest += $submarks->highest;

                            $bangla = array($submarks->subcode, $submarks->subname, $submarks->written, $submarks->mcq, $submarks->ca, $submarks->practical);
                            array_push($banglaArray, $bangla);

                        }
                        else{
                            // these are safe code if user make mistake in add subject
                            $totalHighest += $maxMarks->highest;
                            array_push($subcollection, $submarks);

                        }


                    }
                    else if ($this->getSubGroup($subjects, $subject->code) === "English") {
                        //check if this class have combine pass
                        if($requestedClass->combinePass){
                            $subInfo = self::getSubjectInfo($subjects,$subject->code);
                            $enTotalExamMarks += $subInfo->totalfull;
                            $enWrittenPass += $subInfo->wpass;
                            $enMcqPass += $subInfo->mpass;

                            $englishWritten += $submarks->written;
                            $englishMcq += $submarks->mcq;

                            $englishtotal += $submarks->total;
                            $englishtotalhighest += $submarks->highest;

                            $english = array($submarks->subcode, $submarks->subname, $submarks->written, $submarks->mcq, $submarks->ca, $submarks->practical);
                            array_push($englishArray, $english);
                        }
                        else{
                            // these are safe code if user make mistake in add subject
                            $totalHighest += $maxMarks->highest;
                            array_push($subcollection, $submarks);
                        }

                    }
                    else {

                        //check if 4th subject
                        if ($subject->type === "Electives") {

                            //if this is student 4th subject or student main subject by exchange
                            if($student->fourthSubject == $subject->code || $student->cphsSubject == $subject->code ){
                                $totalHighest += $maxMarks->highest;
                                array_push($subcollection, $submarks);
                            }
                        }
                        else{
                            $totalHighest += $maxMarks->highest;
                            array_push($subcollection, $submarks);
                        }
                    }


                }

                //check two paper pass
                //check written and mcq 2 papers additional pass or not.
                $gparules = GPA::select('gpa', 'grade', 'markfrom')->where('for',"1")->get();
                $subgrpbl = false;
                $subgrpen = false;
                if($requestedClass->combinePass){
                    $subgrpbl = true;
                    $subgrpen = true;

                    //let's do calculation for bangla
                    if ($banglaWritten < $bnWrittenPass) {
                        $isBanglaFail = true;
                    }
                    if ($bnMcqPass && $banglaMcq < $bnMcqPass) {
                        $isBanglaFail = true;
                    }

                    //now combine subject marks round policy
                    // and grading
                    $blt=0.00;
                    if($banglatotal>0) {
                        if ($bnTotalExamMarks >= 200) {
                            $blt = round($banglatotal / 2);
                        }
                        else {
                            $blt = round($banglatotal / 1.5);
                        }
                    }

                    $totalHighest += $banglatotalhighest;
                    $gcal = $this->gpaCalculator($blt, $gparules);

                    array_push($blextra, $banglatotal);
                    array_push($blextra, $banglatotalhighest);


                    if($isBanglaFail)
                    {
                        array_push($blextra, "0.00");
                        array_push($blextra, "F");
                    }
                    else {
                        array_push($blextra, number_format($gcal[0],2));
                        array_push($blextra, $gcal[1]);
                    }


                    //let's do calculation for english
                    if($englishWritten < $enWrittenPass){
                        $isEnglishFail = true;
                    }
                    if($enMcqPass && $englishMcq < $enMcqPass){
                        $isEnglishFail = true;
                    }

                    //now combine subject marks round policy
                    // and grading
                    $enmarks=0.00;
                    //for exception handle
                    if($englishtotal>0) {
                        if ($enTotalExamMarks >= 200) {
                            $enmarks = round($englishtotal / 2);
                        }
                        else {
                            $enmarks = round($englishtotal / 1.5);
                        }
                    }

                    $totalHighest += $englishtotalhighest;
                    $gcal = $this->gpaCalculator($enmarks, $gparules);
                    array_push($enextra, $englishtotal);
                    array_push($enextra, $englishtotalhighest);
                    if($isEnglishFail)
                    {
                        array_push($enextra, "0.00");
                        array_push($enextra, "F");

                    }
                    else {
                        array_push($enextra, number_format($gcal[0],2));
                        array_push($enextra, $gcal[1]);

                    }


                }




                $extra = array($exam, $subgrpbl, $totalHighest, $subgrpen, $student->extraActivity);
                $query="select left(MONTHNAME(STR_TO_DATE(m, '%m')),3) as month, count(regiNo) AS present from ( select 01 as m union all select 02 union all select 03 union all select 04 union all select 05 union all select 06 union all select 07 union all select 08 union all select 09 union all select 10 union all select 11 union all select 12 ) as months LEFT OUTER JOIN Attendance ON MONTH(Attendance.date)=m and Attendance.regiNo ='".$regiNo."' GROUP BY m";
                $attendance=DB::select(DB::RAW($query));
                return View::Make('app.stdgradesheet', compact('student', 'extra', 'meritdata', 'subcollection', 'blextra', 'banglaArray', 'enextra', 'englishArray','attendance'));

            }
        }
        else
        {
            //echo "<h1 style='text-align: center;color: red'>Result Not Found</h1>";
            return  Redirect::back()->with('noresult','Result Not Found!');

        }
    }


    public  function  getgenerate()
    {
        $classes = ClassModel::lists('name','code');
        return View::Make('app.resultgenerate',compact('classes'));
    }

    public  function getSubGroup($subjects,$subject)
    {
        $group="";
        foreach($subjects as $sub)
        {
            if($sub->code===$subject)
            {
                $group=$sub->subgroup;
                break;

            }
        }
        return $group;
    }
    public  function getSubjectTotalno($subjects,$subject)
    {
        $total="";
        foreach($subjects as $sub)
        {
            if($sub->code===$subject)
            {
                $total=$sub->totalfull;
                break;

            }
        }
        return $total;
    }

    public  function  postgenerate()
    {
        $rules = [
            'class' => 'required',
            'exam' => 'required',
            'session' => 'required'


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {

            return Redirect::to('/result/generate')->withErrors($validator)->withInput();
        } else {
            $isGenerated=DB::table('MeritList')
                ->select('regiNo')
                ->where('class', '=', Input::get('class'))
                ->where('session', '=', trim(Input::get('session')))
                ->where('exam', '=', Input::get('exam'))
                ->get();
            if(!count($isGenerated))
            {
                //get all subjects
                $subjects = Subject::where('class', '=', Input::get('class'))->get();

                //get all section for this requested class
                $sectionsHas = Student::select('section')->where('class', '=', Input::get('class'))->where('session', trim(Input::get('session')))->where('isActive', '=', 'Yes')->distinct()->orderBy('section', 'asc')->get();

                //get all section that submitted marks
                $sectionMarksSubmit = Marks::select('section')->where('class', '=', Input::get('class'))->where('session', trim(Input::get('session')))->where('exam',Input::get('exam'))->distinct()->get();


                //check is all section marks submitted for this requested class?
                if (count($sectionsHas)==count($sectionMarksSubmit))
                {
                    $isAllSubSectionMarkSubmit =false;
                    $notSubSection=[];

                    //go for check, that all sections all subject mark has submitted or not
                    foreach ($sectionsHas as $section) {
                        //get submitted subject for this section
                        $marksubmit = Marks::select('subject')->where('class', '=', Input::get('class'))->where('section',$section->section)->where('session', trim(Input::get('session')))->where('exam',Input::get('exam'))->distinct()->get();

                        //check is subjects and submited marks subject is equal or not
                        if(count($subjects) == count($marksubmit))
                        {
                            $isAllSubSectionMarkSubmit =true;
                            continue;
                        }
                        else{
                            $notSubSection[] = $section->section;
                            $isAllSubSectionMarkSubmit = false;
                        }
                    }

                    // all section marks submitted???
                    if ($isAllSubSectionMarkSubmit) {

                        //collect 4th subjects
                        $fourthsubjectCodes = [];
                        foreach ($subjects as $subject) {
                            if ($subject->type === "Electives") {
                                $fourthsubjectCodes[] = $subject->code;
                            }
                        }

                        //get all students for this session
                        $students = Student::select('regiNo')->where('class', '=', Input::get('class'))->where('session', '=', trim(Input::get('session')))
                            ->where('isActive', '=', 'Yes')->get();

                        //get class information
                        $requestedClass = ClassModel::where('code',Input::get('class'))->first();

                        if (count($students) != 0) {
                            //get marks submitted students
                            $marksSubmitStudents=Marks::select('Marks.regiNo')
                                ->join('Student', 'Marks.regiNo', '=', 'Student.regiNo')
                                ->where('Student.isActive', '=', 'Yes')
                                ->where('Student.class', '=', Input::get('class'))
                                ->where('Marks.class', '=', Input::get('class'))
                                ->where('Marks.session', '=', trim(Input::get('session')))
                                ->where('Marks.exam', '=', Input::get('exam'))
                                ->distinct()
                                ->get();

                            //check total students and submitted marks students is equal or not ??
                            if(count($students)==count($marksSubmitStudents))
                            {
                                //get gpa rules for final grade calculation
                                $gparules = GPA::select('gpa', 'grade', 'markfrom')->where('for',"1")->get();

                                $foobar = array();

                                //loop through all students
                                foreach ($students as $student) {

                                    $marks = Marks::where('regiNo', '=', $student->regiNo)
                                        ->where('exam', '=', Input::get('exam'))
                                        ->where('class', '=', Input::get('class'))
                                        ->where('session', '=', trim(Input::get('session')))
                                        ->get();

                                    $totalpoint = 0;
                                    $totalmarks = 0;

                                    //subject counter for final grade calculation
                                    $subcounter = 0;

                                    $banglamark = 0;
                                    $englishmark = 0;

                                    $bnTotalExamMarks = 0;
                                    $bnWrittenPass = 0;
                                    $bnMcqPass = 0;
                                    $banglaWritten = 0;
                                    $banglaMcq = 0;
                                    $banglaSBA = 0;

                                    $enTotalExamMarks = 0;
                                    $enWrittenPass = 0;
                                    $enMcqPass = 0;
                                    $englishWritten = 0;
                                    $englishMcq = 0;
                                    $englishSBA = 0;

                                    $isfail = false;

                                    foreach ($marks as $mark) {

                                        if ($this->getSubGroup($subjects, $mark->subject) === "Bangla") {

                                            //check if this class have combine pass
                                            if($requestedClass->combinePass){
                                                $subInfo = self::getSubjectInfo($subjects,$mark->subject);
                                                $bnTotalExamMarks += $subInfo->totalfull;

                                                $bnWrittenPass += $subInfo->wpass;
                                                $bnMcqPass += $subInfo->mpass;

                                                $banglaWritten += $mark->written;
                                                $banglaMcq += $mark->mcq;
                                                $banglaSBA += $mark->ca;

                                                $banglamark += $mark->total;

                                            }
                                            else{
                                                // these are safe code if user make mistake in add subject
                                                if($mark->grade=="F")
                                                {
                                                    $isfail = true;
                                                }

                                                $totalmarks += $mark->total;
                                                $totalpoint += $mark->point;
                                            }

                                        } else if ($this->getSubGroup($subjects, $mark->subject) === "English") {
                                            //check if this class have combine pass
                                            if($requestedClass->combinePass){
                                                $subInfo = self::getSubjectInfo($subjects,$mark->subject);
                                                $enTotalExamMarks += $subInfo->totalfull;

                                                $enWrittenPass += $subInfo->wpass;
                                                $enMcqPass += $subInfo->mpass;

                                                $englishWritten += $mark->written;
                                                $englishMcq += $mark->mcq;
                                                $englishSBA += $mark->ca;

                                                $englishmark += $mark->total;
                                            }
                                            else{
                                                // these are safe code if user make mistake in add subject
                                                if($mark->grade=="F")
                                                {
                                                    $isfail = true;
                                                }

                                                $totalmarks += $mark->total;
                                                $totalpoint += $mark->point;
                                            }

//
                                        } else {

                                            //subject counter for final grade calculation
                                            $subcounter++;

                                            //check if 4th subject
                                            if (in_array($mark->subject,$fourthsubjectCodes)) {
                                                //check if it is student fourth subject and have more point
                                                if ($mark->subject == $student->fourthSubject && $mark->point >= 2.00) {
                                                    // add point above 2.00
                                                    $totalpoint += ($mark->point - 2);

                                                    //subject counter for final grade calculation
                                                    $subcounter--;

                                                }
                                                //check if it is student exchange main subject
                                                if ($mark->subject == $student->cphsSubject) {
                                                    //check if fail
                                                    if($mark->grade=="F")
                                                    {
                                                        $isfail = true;
                                                    }
                                                    $totalpoint += $mark->point;

                                                }

                                                $totalmarks += $mark->total;


                                            } else {

                                                //check if it is student fourth subject and have more point
                                                if ($mark->subject == $student->fourthSubject) {
                                                    if($mark->point >= 2.00) {
                                                        // add point above 2.00
                                                        $totalpoint += ($mark->point - 2);
                                                    }
                                                    //subject counter for final grade calculation
                                                    $subcounter--;
                                                }
                                                else{
                                                    //check if fail
                                                    if($mark->grade=="F")
                                                    {
                                                        $isfail = true;
                                                    }
                                                    $totalpoint += $mark->point;
                                                }

                                                $totalmarks += $mark->total;


                                            }

                                        }

                                    }

                                    if($requestedClass->combinePass){
                                        //two combine subjects from 4 subject. so add 2
                                        $subcounter = $subcounter + 2;

                                        if ($banglamark > 0) {
                                            //let's do calculation for bangla
                                            if ($banglaWritten < $bnWrittenPass) {
                                                $isfail = true;
                                            }
                                            if ($bnMcqPass && $banglaMcq < $bnMcqPass) {
                                                $isfail = true;
                                            }


                                            //now combine subject marks round policy
                                            // and grading
                                            if ($bnTotalExamMarks >= 200) {
                                                $blmarks = round($banglamark / 2);
                                            } else {
                                                $blmarks = round($banglamark / 1.5);
                                            }

                                            $totalmarks += $banglamark;

                                            //bangla subject point
                                            $banglaXPoint = $this->pointCalculator($blmarks, $gparules);
                                            $totalpoint += $banglaXPoint;

                                        }
                                        else{
                                            $isfail= true;
                                        }


                                        //let's do calculation for english
                                        if ($englishmark > 0) {
                                            if($englishWritten < $enWrittenPass){
                                                $isfail = true;
                                            }
                                            if($enMcqPass && $englishMcq < $enMcqPass){
                                                $isfail = true;
                                            }

                                            //now combine subject marks round policy
                                            // and grading
                                            if ($enTotalExamMarks >= 200) {
                                                $enmarks = round($englishmark / 2);
                                            } else {
                                                $enmarks = round($englishmark / 1.5);
                                            }


                                            $totalmarks += $englishmark;

                                            //english subject point
                                            $englishXPoint = $this->pointCalculator($enmarks, $gparules);
                                            $totalpoint += $englishXPoint;
                                        }
                                        else{
                                            $isfail= true;
                                        }

                                    }

                                    $grandPoint = ($totalpoint / $subcounter);


                                    if ($isfail) {
                                        $grandGrade = "F";
                                        $grandPoint = 0.00;
                                    } else {
                                        $grandGrade = $this->gradnGradeCal($grandPoint, $gparules);
                                    }

                                    $merit = new MeritList;
                                    $merit->class = Input::get('class');
                                    $merit->session = trim(Input::get('session'));
                                    $merit->exam = Input::get('exam');
                                    $merit->regiNo = $student->regiNo;
                                    $merit->totalNo = round($totalmarks);
                                    $merit->point = ($grandPoint>5.00) ? 5.00 : $grandPoint;
                                    $merit->grade = $grandGrade;


                                    $merit->save();


                                }

                            }
                            else {

                                return Redirect::to('/result/generate')->withInput()->with("noresult", "All students examination marks not submitted yet!!");
                            }


                        }
                        else
                        {
                            return Redirect::to('/result/generate')->withInput()->with("noresult", "There is no students in this class!!");
                        }

                        return Redirect::to('/result/generate')->with("success", "Result Generate and Publish Successfull.");

                    }
                    else
                    {
                        return Redirect::to('/result/generate')->withInput()->with("noresult", "Section ".implode(',',$notSubSection)." all subjects marks not submitted yet!!");

                    }
                }
                else{
                    return Redirect::to('/result/generate')->withInput()->with("noresult", "All sections marks not submitted yet!!");
                }
            }
            else{
                return Redirect::to('/result/generate')->withInput()->with("noresult", "Result already generated for this class,session and exam!");

            }
        }
    }

    public function gradnGradeCal($grandPoint)
    {
        $grade="";
        if($grandPoint>=5.00)
        {
            $grade="A+";
            return $grade;
        }
        $lowarray = array("0.00","1.00","2.00","3.00","3.50","4.00");
        $higharray = array("1.00","2.00","3.00","3.50","4.00","5.00");
        $gradearray = array("F","D","C","B","A-","A");

        for($i=0;$i<count($lowarray);$i++)
        {
            if($grandPoint>=$lowarray[$i] && $grandPoint<$higharray[$i])
            {
                $grade=$gradearray[$i];
            }
        }

        return $grade;

    }

    public function search()
    {
        $formdata = new formfoo;
        $formdata->exam="";
        $classes = ClassModel::select('code','name')->orderby('code','asc')->get();
        return View::Make('app.resultsearch',compact('formdata','classes'));
    }
    public function postsearch()
    {
        $rules=[

            'exam' => 'required',
            'regiNo' => 'required',
            'class' => 'required'


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/result/search')->withErrors($validator)->withInput(Input::all());
        }
        else {


            return Redirect::to('/gradesheet/print/'.Input::get('regiNo').'/'.Input::get('exam').'/'.Input::get('class'));
        }



    }
    public function searchpub()
    {
        $formdata = new formfoo;
        $formdata->exam="";
        $classes = ClassModel::select('code','name')->orderby('code','asc')->get();
        return View::Make('app.resultsearchpublic',compact('formdata','classes'));
    }
    public function postsearchpub()
    {

        $rules=[

            'exam' => 'required',
            'regiNo' => 'required',
            'class' => 'required'


        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/results')->withErrors($validator)->withInput(Input::all());
        }
        else {


            return Redirect::to('/gradesheet/print/'.Input::get('regiNo').'/'.Input::get('exam').'/'.Input::get('class'));
        }
    }

    private static function getSubjectInfo($subjects,$code){
        $requestSubject = null;
        foreach($subjects as $sub)
        {
            if($sub->code===$code)
            {
                $requestSubject =$sub;
                break;
            }
        }
        return $requestSubject;
    }
}
