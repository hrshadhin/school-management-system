<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Exam;
use App\ExamRule;
use App\Mark;
use App\Registration;
use App\Section;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $marks = collect();
        $acYear = null;
        $class_id = null;
        $section_id = null;
        $subject_id = null;
        $exam_id = null;
        $sections = [];
        $academic_years = [];
        $subjects = [];
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
            $teacherId = 0;
            if(session('user_role_id',0) == AppHelper::USER_TEACHER){
                $teacherId = auth()->user()->teacher->id;
            }


            $marks = Mark::with(['student' => function($query){
                $query->with('info')->select('regi_no','student_id','roll_no','id');
            }])->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                ->select( 'marks', 'total_marks', 'grade', 'point', 'present')
                ->get();


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
            'exams'
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

        return $request->all();
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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

    }
}
