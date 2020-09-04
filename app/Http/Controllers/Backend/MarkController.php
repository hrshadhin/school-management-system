<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Exam;
use App\ExamRule;
use App\Grade;
use App\Mark;
use App\Registration;
use App\Result;
use App\Section;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $marks = null;
        $acYear = null;
        $class_id = null;
        $section_id = null;
        $subject_id = null;
        $exam_id = null;
        $sections = [];
        $academic_years = [];
        $subjects = [];
        $examRule = null;
        $exams = [];
        $editMode = 1;

        if ($request->isMethod('post')) {

            //inputs
            if(AppHelper::getInstituteCategory() == 'college') {
                $acYear = $request->get('academic_year_id', 0);
            }
            else{
                $acYear = AppHelper::getAcademicYear();
            }
            $class_id = $request->get('class_id',0);
            $section_id = $request->get('section_id',0);
            $subject_id = $request->get('subject_id',0);
            $exam_id = $request->get('exam_id',0);
            $teacherId = 0;
            if(session('user_role_id',0) == AppHelper::USER_TEACHER){
                $teacherId = auth()->user()->teacher->id;
            }

            //validate
            $examRule = ExamRule::where('exam_id',$exam_id)
                ->where('subject_id', $subject_id)
                ->first();
            if(!$examRule) {
                return redirect()->back()->with('error', 'Exam rules not found for this subject and exam!');
            }

            //check is result is published?
            $isPublish = DB::table('result_publish')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('exam_id', $exam_id)
                ->count();

            if($isPublish){
                $editMode = 0;
            }

            $marks = Mark::with(['student' => function($query){
                $query->with(['info' => function($query){
                    $query->select('name','id');
                }])->select('regi_no','student_id','roll_no','id');
            }])->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                ->select( 'registration_id', 'marks', 'total_marks', 'grade', 'point', 'present','id')
                ->get()
                ->sortBy('student.roll_no');


            //detect which form submitted
             if($request->has('for_what')){

                 if($isPublish){
                     return redirect()->route('marks.index')->with('error', 'Can\'t edit marks, because result is published for this exam!');
                 }

                 if($request->get('for_what', '') == "bulk_edit"){
                     //now notify the admins about this record
                     $msg = "Class {$examRule->class->name},  {$examRule->subject->name} subject marks updated for {$examRule->exam->name} exam  by ".auth()->user()->name;
                     $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                     // Notification end
                     return view('backend.exam.marks.bulk_edit', compact('marks', 'examRule'));
                 }
                 else if($request->get('for_what', '') == "update_all"){

                     $grade = Grade::where('id', $examRule->grade_id)->first();
                     if(!$grade){
                         return redirect()->route('marks.index')->with('error', 'Grading information not found!');
                     }

                     $gradingRules = json_decode($grade->rules);

                     [$isUpdated, $message] = $this->updateAllMarks($marks, $examRule, $gradingRules);

                     if($isUpdated){
                         //now notify the admins about this record
                         $msg = "Class {$examRule->class->name},  {$examRule->subject->name} subject marks updated for {$examRule->exam->name} exam  by ".auth()->user()->name;
                         $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                         // Notification end
                         return back()->with('success', 'Subject marks updated successfully!');
                     }

                     return redirect()->route('marks.index')->with('error', $message);
                 }
             }


            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

            $subjectsQuery = Subject::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id);
            if($teacherId){
                $subjectsQuery->join('teacher_subjects','teacher_subjects.subject_id','subjects.id')
                    ->where('teacher_subjects.teacher_id', $teacherId);
            }
            $subjects = $subjectsQuery->pluck('name', 'id');

            $exams = Exam::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }




        return view('backend.exam.marks.list', compact('marks',
            'acYear',
            'class_id',
            'section_id',
            'subject_id',
            'exam_id',
            'classes',
            'sections',
            'subjects',
            'academic_years',
            'exams',
            'examRule',
            'editMode'
        ));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $students = collect();
        $acYear = null;
        $class_id = null;
        $section_id = null;
        $subject_id = null;
        $exam_id = null;
        $sections = [];
        $academic_years = [];
        $subjects = [];
        $examRule = null;
        $exams = [];

        if ($request->isMethod('post')) {
            if(AppHelper::getInstituteCategory() == 'college') {
                $acYear = $request->get('academic_year_id', 0);
            }
            else{
                $acYear = AppHelper::getAcademicYear();
            }
            $class_id = $request->get('class_id',0);
            $section_id = $request->get('section_id',0);
            $subject_id = $request->get('subject_id',0);
            $exam_id = $request->get('exam_id',0);



            // some validation before full the student
            $examInfo = Exam::where('status', AppHelper::ACTIVE)
                ->where('id', $exam_id)
                ->first();
            if(!$examInfo) {
                return redirect()->back()->with('error', 'Exam Not Found');
            }

            //check is result is published?
            $isPublish = DB::table('result_publish')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('exam_id', $examInfo->id)
                ->count();

            if($isPublish){
                return redirect()->back()->with('error', 'Marks entry not possible! Because result is published for this exam!');
            }

            $examRule = ExamRule::where('exam_id',$exam_id)
                ->where('subject_id', $subject_id)
                ->first();
            if(!$examRule) {
                return redirect()->back()->with('error', 'Exam rules not found for this subject and exam!');
            }
            $teacherId = 0;
            if(session('user_role_id',0) == AppHelper::USER_TEACHER){
                $teacherId = auth()->user()->teacher->id;
                $subjectIds = DB::table('teacher_subjects')
                    ->where('teacher_id', $teacherId)->pluck('subject_id')->toArray();
                if(!in_array($subject_id, $subjectIds)){
                    abort(401);
                }
            }

            //validation end

            $students = Registration::with(['info' => function($query){
                    $query->select('name','id');
                }])
               ->whereHas('subjects', function($q) use($subject_id){
                   $q->where('subject_id', $subject_id);
                })
               ->whereDoesntHave('marks', function ($q) use($subject_id, $acYear, $class_id, $exam_id){
                   $q->where('subject_id', $subject_id)
                       ->where('exam_id', $exam_id)
                       ->where('class_id', $class_id)
                       ->where('academic_year_id', $acYear);
               })
//                ->with('subjects')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('status', AppHelper::ACTIVE)
                ->select( 'regi_no', 'roll_no', 'id','student_id')
                ->orderBy('roll_no','asc')
                ->take(env('PER_PAGE_MARKS_ENTRY',25))
                ->get();

            if(!$students->count()) {
                return redirect()->back()->with('warning', 'There\'s no student left for entry marks!');
            }

            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

            $subjects = Subject::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->when($teacherId, function ($query) use($teacherId){
                    $query->where('teacher_id', $teacherId);
                })
                ->pluck('name', 'id');

            $exams = Exam::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }


        return view('backend.exam.marks.add', compact('students',
            'acYear',
            'class_id',
            'section_id',
            'subject_id',
            'exam_id',
            'classes',
            'sections',
            'subjects',
            'academic_years',
            'exams',
            'examRule'
        ));
    }


    /**
     *  Old store logic in 2.0
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateRules = [
            'academic_year_id' => 'nullable|integer',
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'exam_id' => 'required|integer',
            'registrationIds' => 'required|array',
            'marks_type' => 'required|array',
            'absent' => 'nullable|array',
        ];

        $this->validate($request, $validateRules);

        if(AppHelper::getInstituteCategory() == 'college') {
            $acYear = $request->get('academic_year_id');
        }
        else{
            $acYear = AppHelper::getAcademicYear();
        }

        $class_id = $request->get('class_id',0);
        $section_id = $request->get('section_id',0);
        $subject_id = $request->get('subject_id',0);
        $exam_id = $request->get('exam_id',0);

        // some validation before entry the mark
        $examInfo = Exam::where('status', AppHelper::ACTIVE)
            ->where('id', $exam_id)
            ->first();
        if(!$examInfo) {
            return redirect()->route('marks.create')->with('error', 'Exam Not Found');
        }

        $examRule = ExamRule::where('exam_id',$exam_id)
            ->where('subject_id', $subject_id)
            ->first();
        if(!$examRule) {
            return redirect()->route('marks.create')->with('error', 'Exam rules not found for this subject and exam!');
        }

        $entryExists = Mark::where('academic_year_id', $acYear)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('subject_id', $subject_id)
            ->where('exam_id', $exam_id)
            ->whereIn('registration_id', $request->get('registrationIds'))
            ->count();

        if($entryExists){
            return redirect()->route('marks.create')->with('error','This subject marks already exists for this exam & students!');
        }
        //validation end

        //pull grading information
        $grade = Grade::where('id', $examRule->grade_id)->first();
        if(!$grade){
            return redirect()->route('marks.create')->with('error','Grading information not found!');
        }
        $gradingRules = json_decode($grade->rules);

        //exam distributed marks rules
        $distributeMarksRules = [];
        foreach (json_decode($examRule->marks_distribution) as $rule){
            $distributeMarksRules[$rule->type] = [
                'total_marks' => $rule->total_marks,
                'pass_marks' => $rule->pass_marks
            ];
        }

        $distributedMarks = $request->get('marks_type');
        $absent = $request->get('absent');
        $timeStampNow = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));
        $userId = auth()->user()->id;

        $marksData = [];
        $isInvalid = false;
        $message = '';

        foreach ($request->get('registrationIds') as $student){
            $marks = $distributedMarks[$student];
            [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks] = $this->processMarksAndCalculateResult(
                $examRule,
                $gradingRules,
                $distributeMarksRules,
                $marks);

            if($isInvalid){
                break;
            }

            $data = [
                'academic_year_id' => $acYear,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'registration_id' => $student,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'marks' => json_encode($typeWiseMarks),
                'total_marks' => $totalMarks,
                'grade' => $grade,
                'point' => $point,
                'present' => isset($absent[$student]) ? '0' : '1',
                "created_at" => $timeStampNow,
                "created_by" => $userId,
            ];

            $marksData[] = $data;
        }


        if($isInvalid){
            return redirect()->route('marks.create')->with('error', $message);
        }


        DB::beginTransaction();
        try {

            Mark::insert($marksData);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('marks.create')->with("error",$message);
        }

        $sectionInfo = Section::where('id', $section_id)->first();
        $subjectInfo = Subject::with(['class' => function($query){
            $query->select('name','id');
        }])->where('id', $subject_id)->first();
        //now notify the admins about this record
        $msg = "Class {$subjectInfo->class->name}, section {$sectionInfo->name}, {$subjectInfo->name} subject marks added for {$examInfo->name} exam  by ".auth()->user()->name;
        $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
        // Notification end

        return redirect()->route('marks.create')->with("success","Exam marks added successfully!");


    }


    /**
     * Process student entry marks and
     * calculate grade point
     *
     * @param $examRule collection
     * @param $gradingRules array
     * @param $distributeMarksRules array
     * @param $strudnetMarks array
     */
    private function processMarksAndCalculateResult($examRule, $gradingRules, $distributeMarksRules, $studentMarks) {
        $totalMarks = 0;
        $isFail = false;
        $isInvalid = false;
        $message = "";
        $typeWiseMarks = [];

        foreach ($distributeMarksRules as $type => $marksRule){
            if(!isset($studentMarks[$type])){
                $typeWiseMarks[$type] = 0;
                continue;
            }

            $marks = floatval($studentMarks[$type]);
            $typeWiseMarks[$type] = $marks;
            $totalMarks += $marks;

            // AppHelper::PASSING_RULES
            if(in_array($examRule->passing_rule, [2,3])){
                if($marks > $marksRule['total_marks']){
                    $isInvalid = true;
                    $message = AppHelper::MARKS_DISTRIBUTION_TYPES[$type]. " marks is too high from exam rules marks distribution!";
                    break;
                }

                if($marks < $marksRule['pass_marks']){
                    $isFail = true;
                }
            }
        }

        //fraction number make ceiling
        $totalMarks = ceil($totalMarks);

        // AppHelper::PASSING_RULES
        if(in_array($examRule->passing_rule, [1,3])){
            if($totalMarks < $examRule->over_all_pass){
                $isFail = true;
            }
        }

        if($isFail){
            $grade = 'F';
            $point = 0.00;

            return [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks];
        }

        [$grade, $point] = $this->findGradePointFromMarks($gradingRules, $totalMarks);

        return [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks];

    }

    private function findGradePointFromMarks($gradingRules, $marks) {
        $grade = 'F';
        $point = 0.00;
        foreach ($gradingRules as $rule){
            if ($marks >= $rule->marks_from && $marks <= $rule->marks_upto){
                $grade = AppHelper::GRADE_TYPES[$rule->grade];
                $point = $rule->point;
                break;
            }
        }
        return [$grade, $point];
    }

    private function findGradeFromPoint($point, $gradingRules) {
        $grade = 'F';

        foreach ($gradingRules as $rule){
            if($point >= floatval($rule->point)){
                $grade = AppHelper::GRADE_TYPES[$rule->grade];
                break;
            }
        }

        return $grade;

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marks = Mark::with(['student' => function($query){
                $query->with(['info' => function($query){
                    $query->select('name','id');
                }])->select('regi_no','student_id','roll_no','id');
            }])
            ->where('id',$id)
            ->select( 'id','academic_year_id','class_id','subject_id','exam_id','registration_id', 'marks', 'total_marks', 'present')
            ->first();

        if(!$marks){
            abort(404);
        }

        //these code for security purpose,
        // if some user try to edir other user data
        if(session('user_role_id',0) == AppHelper::USER_TEACHER){
            $teacherId = auth()->user()->teacher->id;
            $subjectIds = DB::table('teacher_subjects')
                ->where('teacher_id', $teacherId)->pluck('subject_id')->toArray();
            if(!in_array($marks->subject_id, $subjectIds)){
                abort(401);
            }
        }

        //check is result is published?
        $isPublish = DB::table('result_publish')
            ->where('academic_year_id', $marks->academic_year_id)
            ->where('class_id', $marks->class_id)
            ->where('exam_id', $marks->exam_id)
            ->count();

        if($isPublish){
            return redirect()->route('marks.index')->with('error', 'Can\'t edit marks, because result is published for this exam!');
        }

        $examRule = ExamRule::where('exam_id', $marks->exam_id)
            ->where('subject_id', $marks->subject_id)
            ->first();
        if(!$examRule) {
            return redirect()->route('marks.index')->with('error', 'Exam rules not found for this subject and exam!');
        }


        return view('backend.exam.marks.edit', compact('marks',
            'examRule'
        ));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marks = Mark::with(['subject' => function ($query) {
            $query->select('id', 'name');
        }])
        ->with(['class' => function ($query) {
            $query->select('id', 'name');
        }])
        ->with(['exam' => function ($query) {
            $query->select('id', 'name');
        }])
        ->where('id', $id)
        ->first();

        if(!$marks){
            abort(404);
        }

        //these code for security purpose,
        // if some user try to edir other user data
        if(session('user_role_id',0) == AppHelper::USER_TEACHER){
            $teacherId = auth()->user()->teacher->id;
            $subjectIds = DB::table('teacher_subjects')
                ->where('teacher_id', $teacherId)->pluck('subject_id')->toArray();
            if(!in_array($marks->subject_id, $subjectIds)){
                abort(401);
            }
        }

        //check is result is published?
        $isPublish = DB::table('result_publish')
            ->where('academic_year_id', $marks->academic_year_id)
            ->where('class_id', $marks->class_id)
            ->where('exam_id', $marks->exam_id)
            ->count();

        if($isPublish){
            return redirect()->route('marks.index')->with('error', 'Can\'t edit marks, because result is published for this exam!');
        }

        $examRule = ExamRule::where('exam_id', $marks->exam_id)
            ->where('subject_id', $marks->subject_id)
            ->first();
        if(!$examRule) {
            return redirect()->route('marks.index')->with('error', 'Exam rules not found for this subject and exam!');
        }

        $validateRules = [
            'type' => 'required|array',
            'absent' => 'nullable',
        ];

        $this->validate($request, $validateRules);

        //pull grading information
        $grade = Grade::where('id', $examRule->grade_id)->first();
        if(!$grade){
            return redirect()->route('marks.create')->with('error','Grading information not found!');
        }
        $gradingRules = json_decode($grade->rules);

        //exam distributed marks rules
        $distributeMarksRules = [];
        foreach (json_decode($examRule->marks_distribution) as $rule){
            $distributeMarksRules[$rule->type] = [
                'total_marks' => $rule->total_marks,
                'pass_marks' => $rule->pass_marks
            ];
        }


        [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks] = $this->processMarksAndCalculateResult($examRule,
            $gradingRules, $distributeMarksRules, $request->get('type'));

        if($isInvalid){
            return redirect()->back()->with('error', $message);
        }

        $data = [
            'marks' => json_encode($typeWiseMarks),
            'total_marks' => $totalMarks,
            'grade' => $grade,
            'point' => $point,
            'present' => $request->has('absent') ? '0' : '1',
        ];

        $marks->fill($data);
        $marks->save();

        //now notify the admins about this record
        $msg = "Class {$marks->class->name},  {$marks->subject->name} subject marks updated for {$marks->exam->name} exam  by ".auth()->user()->name;
        $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
        // Notification end

        return redirect()->route('marks.index')->with('success', 'Marks entry updated!');


    }


    /**
     * Published Result list
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function resultIndex(Request $request){


        $acYear = $request->get('academic_year_id', 0);
        $class_id = $request->get('class_id', 0);
        $section_id = $request->get('section_id', 0);
        $exam_id = $request->get('exam_id', 0);
        $students = collect();
        $sections = [];
        $exams = [];

        //in post request get the result and show it
        if ($request->isMethod('post')) {

            $validateRules = [
                'academic_year_id' => 'nullable|integer',
                'class_id' => 'required|integer',
                'exam_id' => 'required|integer',
            ];

            $this->validate($request, $validateRules);

            //check is result is published?
            $isPublish = DB::table('result_publish')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('exam_id', $exam_id)
                ->count();

            if(!$isPublish){
                return redirect()->back()->with('error', 'Result not published for this class and exam yet!');
            }

            $students = Registration::where('status', AppHelper::ACTIVE)
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->when($section_id, function ($query) use($section_id){
                    $query->where('section_id', $section_id);
                })
                ->select('id','student_id','regi_no','roll_no','section_id')
                ->with(['result' => function($query) use($exam_id){
                    $query->select('registration_id','total_marks','grade', 'point')
                        ->where('exam_id', $exam_id);
                }])
                ->with(['info' => function($query){
                    $query->select('name','id');
                }])
                ->with(['section' => function($query){
                    $query->select('name','id');
                }])
                ->get();

            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

            $exams = Exam::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

        }
        else {
            if (AppHelper::getInstituteCategory() != 'college') {
                $acYear = AppHelper::getAcademicYear();
            }
        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');


        $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');


        return view('backend.exam.result.list', compact('students',
            'acYear',
            'class_id',
            'classes',
            'section_id',
            'sections',
            'academic_years',
            'exams',
            'exam_id'
        ));
    }

    /**
     * Published Result Generate
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function resultGenerate(Request $request){

        //in post request get the result and show it
        if ($request->isMethod('post')) {
            $rules = [
                'class_id' => 'required|integer',
                'exam_id' => 'required|integer',
                'publish_date' => 'required|min:10|max:11',
            ];

            //if it college then need another 2 feilds
            if(AppHelper::getInstituteCategory() == 'college') {
                $rules['academic_year_id'] = 'required|integer';
            }

            $this->validate($request, $rules);


            if (AppHelper::getInstituteCategory() == 'college') {
                $acYear = $request->get('academic_year_id', 0);
            } else {
                $acYear = AppHelper::getAcademicYear();
            }
            $class_id = $request->get('class_id', 0);
            $exam_id = $request->get('exam_id', 0);
            $publish_date = Carbon::createFromFormat('d/m/Y', $request->get('publish_date', date('d/m/Y')));

            //validation start
            //check is result is published?
            $isPublish = DB::table('result_publish')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('exam_id', $exam_id)
                ->count();

            if($isPublish){
                return redirect()->back()->with('error', 'Result already published for this class and exam!');
            }


            //this class all section mark submitted
//            $unsubmittedSections = Section::where('status', AppHelper::ACTIVE)
//                ->where('class_id', $class_id)
//                ->whereDoesntHave('marks', function ($query) use($exam_id, $acYear, $class_id) {
//                    $query->select('section_id')
//                        ->where('academic_year_id', $acYear)
//                        ->where('class_id', $class_id)
//                        ->where('exam_id', $exam_id)
//                        ->groupBy('section_id');
//                })
//                ->count();
//
//            if($unsubmittedSections){
//                return redirect()->back()->with('error', 'All sections marks are not submitted yet!');
//            }


            //this class all subject mark submitted
//            $subjectsCount = Subject::where('status', AppHelper::ACTIVE)
//                ->where('class_id', $class_id)->count();
//
//            $submittedSubjectMarksBySection = Section::where('status', AppHelper::ACTIVE)
//                ->where('class_id', $class_id)
//                ->with(['marks' => function ($query) use($exam_id, $acYear, $class_id) {
//                    $query->select('subject_id','section_id')
//                        ->where('academic_year_id', $acYear)
//                        ->where('class_id', $class_id)
//                        ->where('exam_id', $exam_id)
//                        ->groupBy('subject_id','section_id');
//                }])
//                ->get();
//
//            $havePedningSectionMarks = false;
//            $pendingSections = [];
//            foreach ($submittedSubjectMarksBySection as $section){
//                if(count($section->marks) != $subjectsCount){
//                    $pendingSections[] = $section->name;
//                    $havePedningSectionMarks = true;
//                }
//            }
//
//            if($havePedningSectionMarks){
//                $message = "Section ".implode(',' , $pendingSections)." all subjects marks not submitted yet!";
//                return redirect()->back()->with('error', $message);
//            }
            //validation end

            //now generate the result
            // pull default grading system
            $grade_id = AppHelper::getAppSettings('result_default_grade_id');
            $grade = Grade::where('id', $grade_id)->first();
            if(!$grade){
                return redirect()->back()->with('error', 'Result grade system not set! Set it from institute settings.');
            }
            // pull exam info
            $examInfo = Exam::where('status', AppHelper::ACTIVE)
                ->where('id', $exam_id)
                ->first();
            if(!$examInfo) {
                return redirect()->back()->with('error', 'Exam Not Found');
            }

            // pull exam rules subject wise and find combine subject
            $examRules = ExamRule::where('class_id', $class_id)
                ->where('exam_id', $examInfo->id)
                ->select('subject_id','combine_subject_id','passing_rule','marks_distribution','total_exam_marks','over_all_pass')
                ->with(['subject' => function($query){
                    $query->select('id','type','exclude_in_result');
                }])
                ->get()
                ->reduce(function ($examRules, $rule){
                    $examRules[$rule->subject_id] =[
                        'combine_subject_id' => $rule->combine_subject_id,
                        'passing_rule' => $rule->passing_rule,
                        'marks_distribution' => json_decode($rule->marks_distribution),
                        'total_exam_marks' => $rule->total_exam_marks,
                        'over_all_pass' => $rule->over_all_pass,
                        'subject_type' => $rule->subject->getOriginal('type'),
                        'exclude_in_result' => $rule->subject->exclude_in_result,
                    ];
                    return $examRules;
                });


            //pull students with marks
            $students = Registration::where('status', AppHelper::ACTIVE)
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->select('id','roll_no','regi_no')
                ->with(['marks' => function($query) use($acYear,$class_id,$exam_id){
                    $query->select('registration_id','subject_id','marks', 'total_marks', 'point', 'present')
                        ->where('academic_year_id', $acYear)
                        ->where('class_id', $class_id)
                        ->where('exam_id', $exam_id);
                }])
                ->get();

            $markMissingStudents = [];
            $isDataMissing = false;
            $marksMissingStudentInfo = 0;
            $resultInsertData = [];
            $combineResultInsertData = [];
            $gradingRules = json_decode($grade->rules);
            $userId = auth()->user()->id;

            //loop  the students
            foreach ($students as $student){
                try {
                    $totalMarks = 0;
                    $totalPoint = 0;
                    $totalSubject = 0;
                    $combineSubjectsMarks = [];
                    $isFail = false;
                    $subjectFailCount = 0;

                    //student have in this exam or not
                    $studentSubjects = $student->subjects->reduce(function ($studentSubjects, $subject){
                        $studentSubjects[$subject->id] =  $subject->pivot->subject_type;
                        return $studentSubjects;
                    });
                    $studentMarksSubjectCount = count($student->marks);
                    if ($studentMarksSubjectCount != count($studentSubjects)) {
                        $markMissingStudents[] = $student->regi_no;
                        continue;
                    }

                    foreach ($student->marks as $marks) {
                        /**
                         * If subject need to be exclude in
                         *  Result calculation then skip it here
                         */
                        if($examRules[$marks->subject_id]['exclude_in_result']){
                            continue;
                        }


                        //find combine subjects
                        $isAndInCombineSubject = $this->isAndInCombine($marks->subject_id, $examRules);
                        if ($isAndInCombineSubject) {
                            $combineSubjectsMarks[$marks->subject_id] = $marks;

                            //skip for next subject
                            continue;
                        }

                        //find 4th subject AppHelper::SUBJECT_TYPE
                        $is4thSubject = ($studentSubjects[$marks->subject_id] == 2) ? 1 : 0;
                        if ($is4thSubject) {
                            if($marks->point >= $examInfo->elective_subject_point_addition) {
                                $totalPoint += ($marks->point - $examInfo->elective_subject_point_addition);
                            }
                            $totalMarks += $marks->total_marks;

                            //skip for next subject
                            continue;
                        }

                        //process not combine and 4th subjects
                        if (!$isAndInCombineSubject && !$is4thSubject) {

                            $totalMarks += $marks->total_marks;
                            $totalPoint += $marks->point;
                            $totalSubject++;
                            if (intval($marks->point) == 0) {
                                $isFail = true;
                                $subjectFailCount++;
                            }

                        }
                    }


                    //now process combine subjects
                    foreach ($examRules as $subject_id => $data) {
                        if ($data['combine_subject_id'] != null) {
                            $totalSubject++;
                            $subjectMarks = $combineSubjectsMarks[$subject_id];
                            $pairSubjectMarks = $combineSubjectsMarks[$data['combine_subject_id']];

                            [$pairFail, $combineTotalMarks, $pairTotalMarks] = $this->processCombineSubjectMarks($subjectMarks, $pairSubjectMarks, $data, $examRules[$data['combine_subject_id']]);

                            $totalMarks += $combineTotalMarks;

                            if ($pairFail) {
                                //AppHelper::GRADE_TYPES
                                $pairGrade = "F";
                                $pairPoint = 0.00;
                                $isFail = true;
                                $subjectFailCount++;
                            } else {

                                [$pairGrade, $pairPoint] = $this->findGradePointFromMarks($gradingRules, $pairTotalMarks);
                                $totalPoint += $pairPoint;
                            }

                            //need to store in db for marks sheet print
                            $combineResultInsertData[] = [
                                'registration_id' => $student->id,
                                'subject_id' => $subject_id,
                                'exam_id' => $examInfo->id,
                                'total_marks' => $combineTotalMarks,
                                'grade' => $pairGrade,
                                'point' => $pairPoint,
                            ];

                        }
                    }


                    $finalPoint = ($totalPoint / $totalSubject);
                    if ($isFail) {
                        //AppHelper::GRADE_TYPES
                        $finalGrade = 'F';
                    } else {
                        $finalGrade = $this->findGradeFromPoint($finalPoint, $gradingRules);
                    }

                    $timeStampNow = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));
                    $resultInsertData[] = [
                        'academic_year_id' => $acYear,
                        'class_id' => $class_id,
                        'registration_id' => $student->id,
                        'exam_id' => $examInfo->id,
                        'total_marks' => $totalMarks,
                        'grade' => $finalGrade,
                        'point' => $finalPoint,
                        'subject_fail_count' => $subjectFailCount,
                        "created_at" => $timeStampNow,
                        "created_by" => $userId,
                    ];

                }
                catch (\Exception $e){
                    $isDataMissing = true;
                    $marksMissingStudentInfo = "Regi. No. {$student->regi_no} , roll no {$student->roll_no} student subject marks can't be not processed! Need manual review.";
                    break;
                }

            }



            if($isDataMissing){
                return redirect()->back()->with("error",$marksMissingStudentInfo);
            }

            //if student not present exam time on this school
            $message = '';
            if(count($markMissingStudents)){
                $message = "Student with these ".implode(',',$markMissingStudents)." registration numbers are not attend in this exam!";
            }


            //now insert into db with transaction enabled

            DB::beginTransaction();
            try {

                Result::insert($resultInsertData);
                DB::table('result_publish')->insert([
                    'academic_year_id' => $acYear,
                    'class_id' => $class_id,
                    'exam_id' => $exam_id,
                    'publish_date' => $publish_date->format('Y-m-d')
                ]);
                DB::table('result_combines')->insert($combineResultInsertData);
                DB::commit();
            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
                return redirect()->back()->with("error",$message);
            }

            return redirect()->back()->with("success","Result generated successfully.".$message);
        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $academic_years = [];
        //if its college then have to get those academic years
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }
        $exams = [];


        return view('backend.exam.result.generate', compact('classes', 'academic_years','exams'));
    }


    private function isAndInCombine($subject_id, $rules){
        $isCombine = false;
        foreach ($rules as $subject => $data){
            if($subject == $subject_id && $data['combine_subject_id']){
                $isCombine = true;
                break;
            }

            if($data['combine_subject_id'] == $subject_id){
                $isCombine = true;
                break;
            }
        }

        return $isCombine;
    }


    private function processCombineSubjectMarks($subjectMarks, $pairSubjectMarks, $subjectRule, $pairSubjectRule){
        $pairFail = false;

        $combineTotalMarks = ($subjectMarks->total_marks + $pairSubjectMarks->total_marks);

        if($subjectRule['total_exam_marks'] == $pairSubjectRule['total_exam_marks']){
            //dividing factor
            $totalMarks = ($combineTotalMarks/2);
        }
        else{
            //if both subject exam marks not same then it must be 2:1 ratio
            //Like: subject marks 100 pair subject marks 50
            $totalMarks = ($combineTotalMarks/ 1.5);
        }

        //fraction number make ceiling
        $totalMarks = ceil($totalMarks);

        $passingRule = $subjectRule['passing_rule'];
        // AppHelper::PASSING_RULES
        if(in_array($passingRule, [1,3])){
            if($totalMarks < $subjectRule['over_all_pass']){
                $pairFail = true;
            }
        }

        //if any subject absent then its fail
        if($subjectMarks->present == 0 || $pairSubjectMarks->present == 0){
            $pairFail = true;
        }

        // AppHelper::PASSING_RULES
        if(!$pairFail && in_array($passingRule, [2,3])){

            //acquire marks
            $combineDistributedMarks = [];
            foreach (json_decode($subjectMarks->marks) as $key => $distMarks){
                $combineDistributedMarks[$key] = floatval($distMarks);

            }

            foreach (json_decode($pairSubjectMarks->marks) as $key => $distMarks){
                $combineDistributedMarks[$key] += floatval($distMarks);

            }


            //passing rules marks
            $combineDistributeMarks = [];
            foreach ($subjectRule['marks_distribution'] as $distMarks){
                $combineDistributeMarks[$distMarks->type] = floatval($distMarks->pass_marks);
            }

            foreach ($pairSubjectRule['marks_distribution'] as $key => $distMarks){
                $combineDistributeMarks[$distMarks->type] += floatval($distMarks->pass_marks);

            }

            //now check for pass
            foreach ($combineDistributeMarks as $key => $value){
                if($combineDistributedMarks[$key] < $value){
                    $pairFail = true;
                }
            }

        }


        return [$pairFail, $combineTotalMarks, $totalMarks];

    }

    /**
     * Published Result Delete
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function resultDelete(Request $request){

        //in post request get the result and show it
        if ($request->isMethod('post')) {
            $rules = [
                'class_id' => 'required|integer',
                'exam_id' => 'required|integer',
            ];

            //if it college then need another 2 feilds
            if(AppHelper::getInstituteCategory() == 'college') {
                $rules['academic_year_id'] = 'required|integer';
            }

            $this->validate($request, $rules);


            if (AppHelper::getInstituteCategory() == 'college') {
                $acYear = $request->get('academic_year_id', 0);
            } else {
                $acYear = AppHelper::getAcademicYear();
            }
            $class_id = $request->get('class_id', 0);
            $exam_id = $request->get('exam_id', 0);

            //validation start
            //check is result is published?
            $isPublish = DB::table('result_publish')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('exam_id', $exam_id)
                ->count();

            if(!$isPublish){
                return redirect()->back()->with('error', 'Result not published for this class and exam!');
            }


            //now delete data from db with transaction enabled
            DB::beginTransaction();
            try {

                $studentIds = Result::where('academic_year_id', $acYear)
                    ->where('class_id', $class_id)
                    ->where('exam_id', $exam_id)
                    ->pluck('registration_id');

                DB::table('results')
                    ->where('academic_year_id', $acYear)
                    ->where('class_id', $class_id)
                    ->where('exam_id', $exam_id)
                    ->delete();

                DB::table('result_publish')
                    ->where('academic_year_id', $acYear)
                    ->where('class_id', $class_id)
                    ->where('exam_id', $exam_id)
                    ->delete();

                DB::table('result_combines')
                    ->where('exam_id', $exam_id)
                    ->whereIn('registration_id', $studentIds)
                    ->delete();

                DB::commit();
            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
                return redirect()->back()->with("error",$message);
            }

            return redirect()->back()->with("success","Result deleted successfully.");
        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $academic_years = [];
        //if its college then have to get those academic years
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }
        $exams = [];

        return view('backend.exam.result.delete', compact('classes', 'academic_years','exams'));
    }


    /**
     * Promote Student to next Academic Year form
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function promotion(Request $request){

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $academic_years = AcademicYear::where('status', '1')->orderBy('start_date','asc')->pluck('title', 'id');



        return view('backend.exam.promotion.form', compact('classes', 'academic_years'));
    }

    /**
     * Promote Student to next Academic Year
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function doPromotion(Request $request){
        $validateRules = [
            'current_academic_year_id' => 'required|integer',
            'current_class_id' => 'required|integer',
            'exam_id' => 'required|integer',
            'fail_count' => 'required|integer',
            'promote_academic_year_id' => 'required|integer',
            'promote_class_id' => 'required|integer',
        ];


        $validator = Validator::make($request->all(), $validateRules);
        if ($validator->fails()) {
            return redirect()->route('promotion.create')
                ->withErrors($validator);
        }
        //inputs
        $current_academic_year_id = $request->get('current_academic_year_id');
        $current_class_id = $request->get('current_class_id');
        $exam_id = $request->get('exam_id');
        $fail_count = $request->get('fail_count');
        $promote_academic_year_id = $request->get('promote_academic_year_id');
        $promote_class_id = $request->get('promote_class_id');

        if($current_academic_year_id == $promote_academic_year_id){
            return redirect()->back()->with('error', 'Current and promoting academic year can not be same!');
        }

        if($current_class_id == $promote_class_id){
            return redirect()->back()->with('error', 'Current and promoting class can not be same!');
        }


        $isPublish = DB::table('result_publish')
            ->where('academic_year_id', $current_academic_year_id)
            ->where('class_id', $current_class_id)
            ->where('exam_id', $exam_id)
            ->count();

        if(!$isPublish){
            return redirect()->route('promotion.create')->with('error', 'Result not published for this class and exam!');
        }


        //check have student for promotion
        $promotableStudents = Registration::where('status', AppHelper::ACTIVE)
            ->where('academic_year_id', $current_academic_year_id)
            ->where('class_id', $current_class_id)
            ->where('is_promoted', '0')
            ->count();

        if(!$promotableStudents){
            return redirect()->back()->with('error', 'There are no student left to promote from this class!');
        }

        //lower class promotion protection
        $currentClassInfo = IClass::where('id', $current_class_id)->first();
        $promoteClassInfo = IClass::where('id', $promote_class_id)->first();
        if($currentClassInfo->order > $promoteClassInfo->order){
            return redirect()->back()->with('error', 'Can not promote student from higher to lower class!');
        }
        //validation end

        //pull merit students
        $meritWiseStudents =  Result::where('academic_year_id', $current_academic_year_id)
            ->where('class_id', $current_class_id)
            ->where('exam_id', $exam_id)
            ->orderBy('subject_fail_count','asc')
            ->orderBy('point','desc')
            ->orderBy('total_marks','desc')
            ->select('registration_id','subject_fail_count')
            ->with(['student' => function($q){
                $q->select('id','roll_no','student_id','shift','card_no');
            }])
            ->get();

        //get promote class section wise capacity
        $totalClassSeatCapacity = 0;
        $promoteClassSectionCollection = Section::where('status', AppHelper::ACTIVE)
            ->where('class_id', $promote_class_id)
            ->orderBy('name','asc')
            ->get(['id','name','capacity']);
        $promoteClassSections = [];
        foreach($promoteClassSectionCollection as $record){
            $promoteClassSections[] = [
                'capacity' => $record->capacity,
                'id' => $record->id
            ];
            $totalClassSeatCapacity += $record->capacity;
        };
        //get current class section wise capacity
        $currentClassSections = Section::where('status', AppHelper::ACTIVE)
            ->where('class_id', $current_class_id)
            ->orderBy('name','asc')
            ->get(['id','name','capacity'])
            ->reduce(function ($currentClassSections, $record){
                $currentClassSections[] = [
                    'capacity' => $record->capacity,
                    'id' => $record->id
                ];

                return $currentClassSections;
            });

        $nextClassPromotingStudents = [];
        $currentClassPromotingStudents = [];
        $promoteableStudentCount = 0;
        $readmitableStudentCount = 0;
        foreach ($meritWiseStudents as $record){
            if($record->subject_fail_count <= $fail_count){
                $nextClassPromotingStudents[] = $record;
                $promoteableStudentCount++;
            }
            else {
                $currentClassPromotingStudents[] = $record;
                $readmitableStudentCount++;
            }
        }

        //force validate for unwanted error
        if($promoteableStudentCount < 1 && $readmitableStudentCount < 1) {
            return redirect()->back()->with('error', 'Class'.$currentClassInfo->name.' has no student to promote or re-admit.');
        }
        if($promoteableStudentCount > $totalClassSeatCapacity){
            return redirect()->back()->with('error', 'Class'.$promoteClassInfo->name.' has less capacity than promoting students! Create another section and try again.');
        }

        // pull subjects of promoting class[ core only]
        $subjects = Subject::select('id')
            ->where('class_id', $promote_class_id)
            ->where('type', 1)
            ->where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->get()
            ->mapWithKeys(function ($sub) {
                return [$sub->id => ['subject_type' => "1"]];
            })->toArray();

        $need_to_assign_subject = false;
        if(count($subjects)>0){
            $need_to_assign_subject = true;
        }

        //start promoting the students
        $acYearInfo = AcademicYear::where('id', $current_academic_year_id)->first();
        $newClassInfo = IClass::where('id', $promote_class_id)->first();
        $newAcYearInfo = AcademicYear::where('id', $promote_academic_year_id)->first();
        $prefixRegi = substr($acYearInfo->start_date->format('y'),1,1);


        DB::beginTransaction();
        try {

            //first promote next class
            if($promoteableStudentCount > 0) {
                $rollNo = 1;
                $sectionIndex = 0;
                $totalPromoted = 0;
                foreach ($nextClassPromotingStudents as $oldStudent) {
                    $regiNo = $newAcYearInfo->start_date->format('y') . (string)$newClassInfo->numeric_value;
                    $totalStudent = Registration::where('academic_year_id', $newAcYearInfo->id)
                        ->where('class_id', $newClassInfo->id)->withTrashed()->count();
                    $regiNo .= str_pad(++$totalStudent, 3, '0', STR_PAD_LEFT);

                    if ($promoteClassSections[$sectionIndex]['capacity'] == $totalPromoted) {
                        $rollNo = 1;
                        $sectionIndex++;
                        $totalPromoted = 0;
                    }

                    $registrationData = [
                        'regi_no' => $regiNo,
                        'student_id' => $oldStudent->student->student_id,
                        'class_id' => $newClassInfo->id,
                        'section_id' => $promoteClassSections[$sectionIndex]['id'],
                        'academic_year_id' => $newAcYearInfo->id,
                        'roll_no' => $rollNo,
                        'shift' => $oldStudent->student->shift,
                        'card_no' => $oldStudent->student->card_no,
                        'board_regi_no' => $oldStudent->student->board_regi_no,
                        'house' => $oldStudent->student->house,
                        'old_registration_id' => $oldStudent->registration_id
                    ];

                    $newStudent = Registration::create($registrationData);
                    # now assign subjects to him
                    if ($need_to_assign_subject) {
                        $newStudent->subjects()->sync($subjects);
                    }

                    $rollNo++;
                    $totalPromoted++;
                }
            }

            //re-admission start
            if($readmitableStudentCount > 0) {
                $rollNo = null;
                $sectionIndex = 0;
                $totalPromoted = 0;
                $oldAndNewStudents = [];
                foreach ($currentClassPromotingStudents as $oldStudent) {
                    $regiNo = $prefixRegi;
                    $regiNo .= $newAcYearInfo->start_date->format('y') . (string)$currentClassInfo->numeric_value;
                    $totalStudent = Registration::where('academic_year_id', $newAcYearInfo->id)
                        ->where('class_id', $currentClassInfo->id)->withTrashed()->count();
                    $regiNo .= str_pad(++$totalStudent, 3, '0', STR_PAD_LEFT);

                    if ($currentClassSections[$sectionIndex]['capacity'] == $totalPromoted) {
                        $rollNo = null;
                        $sectionIndex++;
                        $totalPromoted = 0;
                    }

                    $registrationData = [
                        'regi_no' => $regiNo,
                        'student_id' => $oldStudent->student->student_id,
                        'class_id' => $currentClassInfo->id,
                        'section_id' => $currentClassSections[$sectionIndex]['id'],
                        'academic_year_id' => $newAcYearInfo->id,
                        'roll_no' => $rollNo,
                        'shift' => $oldStudent->student->shift,
                        'card_no' => $oldStudent->student->card_no,
                        'board_regi_no' => $oldStudent->student->board_regi_no,
                        'house' => $oldStudent->student->house,
                        'old_registration_id' => $oldStudent->registration_id
                    ];

                    $newStudent = Registration::create($registrationData);
                    $oldAndNewStudents[$oldStudent->registration_id] = $newStudent;

                    $totalPromoted++;
                }

                //now add subject for old student
                $oldStudentsId = array_keys($oldAndNewStudents);
                $studentsSubjects = DB::table('student_subjects')
                    ->whereIn('registration_id', $oldStudentsId)
                    ->get()
                    ->groupBy('registration_id');

                foreach ($oldAndNewStudents as $oldId => $student) {
                    if (!isset($studentsSubjects[$oldId])) {
                        continue;
                    }

                    $subjectWithType = $studentsSubjects[$oldId]->mapWithKeys(function ($record) {
                        return [$record->subject_id => ['subject_type' => $record->subject_type]];
                    })->toArray();
                    $student->subjects()->sync($subjectWithType);
                }
            }
            // re-admission done

            if($promoteableStudentCount > 0 || $readmitableStudentCount > 0) {
                //mark all old student as promoted
                DB::table('registrations')->where('status', AppHelper::ACTIVE)
                    ->where('academic_year_id', $current_academic_year_id)
                    ->where('class_id', $current_class_id)
                    ->update(['is_promoted' => '1']);

                // now commit the database
                DB::commit();
            }
        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('promotion.create')->with("error",$message);
        }

        //invalid dashboard cache
        Cache::forget('studentCount');
        Cache::forget('student_count_by_class');
        Cache::forget('student_count_by_section');

        //now notify the admins about this record
        $msg = "{$promoteableStudentCount} students promoted to {$newClassInfo->name} class";
        if($readmitableStudentCount){
            $msg .= " and {$readmitableStudentCount} students re-admited to {$currentClassInfo->name} class";
        }
        $whom =" by ".auth()->user()->name;
        $nothing = AppHelper::sendNotificationToAdmins('info', $msg.$whom);
        // Notification end

        return redirect()->route('promotion.create')->with('success', $msg);
    }
}
