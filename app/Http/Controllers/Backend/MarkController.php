<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Exam;
use App\ExamRule;
use App\Grade;
use App\Mark;
use App\Registration;
use App\Section;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
                ->get();

            $examRule = ExamRule::where('exam_id',$exam_id)
                ->where('subject_id', $subject_id)
                ->first();
            if(!$examRule) {
                return redirect()->back()->with('error', 'Exam rules not found for this subject and exam!');
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

            //check is result is published?
            $isPublish = DB::table('result_publish')
                ->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('exam_id', $exam_id)
                ->count();

            if($isPublish){
                $editMode = 0;
            }

        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
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

            $examRule = ExamRule::where('exam_id',$exam_id)
                ->where('subject_id', $subject_id)
                ->first();
            if(!$examRule) {
                return redirect()->back()->with('error', 'Exam rules not found for this subject and exam!');
            }

            $entryExists = Mark::where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                ->count();


            if($entryExists){
                return redirect()->back()->with('error','This subject marks already exists for this exam!');
            }

            //validation end


            $students = Registration::with(['info' => function($query){
                $query->select('name','id');
            }])->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->select( 'regi_no', 'roll_no', 'id','student_id')
                ->orderBy('roll_no','asc')
                ->get();



            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');

            $teacherId = 0;
            if(session('user_role_id',0) == AppHelper::USER_TEACHER){
                $teacherId = auth()->user()->teacher->id;
            }
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
     * Store a newly created resource in storage.
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
            'type' => 'required|array',
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
            ->count();

        if($entryExists){
            return redirect()->route('marks.create')->with('error','This subject marks already exists for this exam!');
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

        $distributedMarks = $request->get('type');
        $absent = $request->get('absent');
        $timeStampNow = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));
        $userId = auth()->user()->id;

        $marksData = [];
        $isInvalid = false;
        $message = '';

        foreach ($request->get('registrationIds') as $student){
            $marks = $distributedMarks[$student];
            [$isInvalid, $message, $totalMarks, $grade, $point] = $this->processMarksAndCalculateResult($examRule,
                $gradingRules, $distributeMarksRules, $marks);

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
                'marks' => json_encode($marks),
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

        foreach ($studentMarks as $type => $marks){
            $marks = floatval($marks);
            $totalMarks += $marks;

            // AppHelper::PASSING_RULES
            if(in_array($examRule->passing_rule, [2,3])){
                if($marks > $distributeMarksRules[$type]['total_marks']){
                    $isInvalid = true;
                    $message = AppHelper::MARKS_DISTRIBUTION_TYPES[$type]. " marks is too high from exam rules marks distribution!";
                    break;
                }

                if($marks < $distributeMarksRules[$type]['pass_marks']){
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

            return [$isInvalid, $message, $totalMarks, $grade, $point];
        }

        [$grade, $point] = $this->findGradePointFromMarks($gradingRules, $totalMarks);

        return [$isInvalid, $message, $totalMarks, $grade, $point];

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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marks = Mark::with(['subject' => function($query){
            $query->select('id','teacher_id');
        }])
            ->with(['student' => function($query){
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
            if($marks->subject->teacher_id != $teacherId){
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
        $marks = Mark::with(['subject' => function($query){
            $query->select('id','teacher_id','name');
            }])
            ->with(['class' => function($query){
                $query->select('id','name');
            }])
            ->with(['exam' => function($query){
                $query->select('id','name');
            }])
            ->where('id',$id)
            ->first();

        if(!$marks){
            abort(404);
        }

        //these code for security purpose,
        // if some user try to edir other user data
        if(session('user_role_id',0) == AppHelper::USER_TEACHER){
            $teacherId = auth()->user()->teacher->id;
            if($marks->subject->teacher_id != $teacherId){
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




        [$isInvalid, $message, $totalMarks, $grade, $point] = $this->processMarksAndCalculateResult($examRule,
            $gradingRules, $distributeMarksRules, $request->get('type'));

        if($isInvalid){
            return redirect()->back()->with('error', $message);
        }

        $data = [
            'marks' => json_encode($request->get('type')),
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
}
