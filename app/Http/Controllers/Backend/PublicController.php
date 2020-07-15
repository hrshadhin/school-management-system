<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Exam;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Registration;
use App\Section;
use App\Student;
use App\StudentAttendance;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{

    public function studentProfile(Request $request) {

        // sanity check
        if(session('user_role_id',0) != AppHelper::USER_STUDENT){
            abort(401);
        }

        $studentInfo = Student::where('user_id', auth()->user()->student->user_id)
            ->first();
        if(!$studentInfo){
            abort(401);
        }

        $student = Registration::where('student_id', $studentInfo->id)
            ->where('is_promoted', '0')
            ->with('student')
            ->with('class')
            ->with('section')
            ->with('acYear')
            ->first();
        if(!$student){
            abort(404);
        }

        $username = '';
        if($student->student->user_id){
            $user = User::find($student->student->user_id);
            $username = $user->username;
        }

        //find siblings
        if(strlen($student->student->siblings)){
            $siblingsRegiNumbers = array_map('trim', explode(',', $student->student->siblings));
            if(count($siblingsRegiNumbers)) {
                $siblingStudents = Registration::whereIn('regi_no', $siblingsRegiNumbers)
                    ->with(['info' => function($q){
                        $q->select('id','name');
                    }])
                    ->select('id','student_id')
                    ->get()
                    ->reduce(function ($siblingStudents, $record){
                        $siblingStudents[] = $record->info->name;
                        return $siblingStudents;
                    });

                $student->student->siblings = $siblingStudents ? implode(',', $siblingStudents) : '';
            }
        }

        return view('backend.student.view', compact('student', 'username'));

    }

    private function checkSanity4Student($id) {
        // sanity check
        if(session('user_role_id',0) == AppHelper::USER_STUDENT){
            $studentInfo = auth()->user()->student;
            if(!$studentInfo || $studentInfo->id != $id){
                abort(401);
            }
        }
        //end check
    }
    /**
     * Student attendance list
     */

    public function getStudentAttendance(Request $request) {

        $studentId = $request->query->get('student_id',0);
        $student = Registration::where('status', AppHelper::ACTIVE)
            ->where('id', $studentId)
            ->first();
        // sanity check
        $this->checkSanity4Student($student->student_id);
        //end check

        $attendances = StudentAttendance::where('registration_id', $student->id)
            ->select('attendance_date', 'present','registration_id')
            ->orderBy('attendance_date', 'asc')
            ->get();
        return response()->json($attendances);


    }

    /**
     *  Check have empty seat in section for this academic year
     * @return \Illuminate\Http\Response
     */
    public function checkSectionHaveEmptySeat(Request $request)
    {
        if(AppHelper::getInstituteCategory() != 'college') {
            // now check is academic year set or not
            $settings = AppHelper::getAppSettings();
            if (!isset($settings['academic_year']) || (int)($settings['academic_year']) < 1) {
                return response()->json([
                    'success' => false,
                    'clear' => true,
                    'message' => 'Academic year not set yet! Please go to settings and set it.'
                ]);
            }

            $acYearId = $settings['academic_year'];
        }
        else {
            $acYearId = $request->get('academic_year');
        }

        /**
         *  Wrong class and section bug fix code
         */
        $classId = $request->get("class_id",0);
        $sectionId = $request->get("section_id",0);
        $section = Section::where('id', $sectionId)->where('status', AppHelper::ACTIVE)
            ->where('class_id', $classId)->select('id','capacity','class_id')->first();
        if(!$section){
            return response()->json([
                'success' => false,
                'clear' => true,
                'message' => 'Wrong class and section selection!'
            ]);
        }
        //end

        //Other validations
        $studentInDesireSection = Registration::where('academic_year_id', $acYearId)
            ->where('class_id', $section->class_id)
            ->where('section_id', $section->id)
            ->count();
        $studentInDesireSection += 1;
        if($studentInDesireSection > $section->capacity){
            return response()->json([
                'success' => false,
                'clear' => false,
                'message' => 'This section is full! Register student in another section.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    public function getAcademicYearsForPromotion(Request $request) {
        //for promotion
        $currentAcademicYearId = $request->query->get('current_academic_year_id',0);
        $currentAcademicYear = AcademicYear::where('status', AppHelper::ACTIVE)
            ->where('id', $currentAcademicYearId)->first();
        $academicYears = AcademicYear::where('status', AppHelper::ACTIVE)
            ->when($currentAcademicYearId, function ($query) use($currentAcademicYear){
                $query->where('id', '!=', $currentAcademicYear->id)
                    ->whereDate('start_date','>', $currentAcademicYear->end_date->format('Y-m-d'));
            })
            ->orderBy('start_date','asc')
            ->select('id','title as text')
            ->get();

        return response()->json($academicYears);

    }

    public function getClassSubjectCountNewAlgo(Request $request) {
        $classId = $request->query->get('classId',0);
        $examId = $request->query->get('examId',0);

        if($examId){

            $totalSubjects = DB::table('student_subjects')
                ->select(DB::raw("registration_id, count(subject_id) as total"))
                ->groupBy('registration_id')
                ->get()
                ->max('total');

        }
        else {
            $totalSubjects = Subject::where('status', AppHelper::ACTIVE)
                ->where('class_id', $classId)->count();
        }

        $data = [];
        for ($i=0; $i <= $totalSubjects; $i++){
            $data[] = ['id' => $i, 'text' => $i];
        }

        return response()->json($data);

    }

    public function getStudentResults(Request $request) {
        $studentId = $request->query->get('student_id',0);
        $student = Registration::where('status', AppHelper::ACTIVE)
            ->where('id', $studentId)
            ->first();
        // sanity check
        $this->checkSanity4Student($student->student_id);
        //end check

        if($student) {
            $publishedExams = DB::table('result_publish')
                ->where('academic_year_id', $student->academic_year_id)
                ->where('class_id', $student->class_id)
                ->pluck('exam_id');

            $examsData = Exam::where('class_id', $student->class_id)
                ->whereIn('id', $publishedExams)
                ->with(['marks' => function($q) use($student){
                    $q->where('registration_id', $student->id)
                        ->select('registration_id','exam_id','subject_id','marks','total_marks','grade','point')
                        ->with(['subject' => function($q) {
                            $q->select('name','code','id');
                        }]);
                }])
                ->with(['result' => function($q) use($student){
                    $q->where('registration_id', $student->id)
                        ->select('registration_id','exam_id','total_marks','grade','point');
                }])
                ->select('name','id','marks_distribution_types')
                ->orderBy('id','asc')
                ->get();

            $examWithResults = [];

            foreach ($examsData as $datum) {
                $marksDistribution = [];
                foreach (json_decode($datum->marks_distribution_types) as $mdtypes){
                    $marksDistribution[$mdtypes] = AppHelper::MARKS_DISTRIBUTION_TYPES[$mdtypes];
                }

                $examWithResults[] = [
                    'exam' => $datum->name,
                    'marks' => $datum->marks,
                    'result' => $datum->result->first(),
                    'marks_distribution' => $marksDistribution
                ];
            }

            $response = [
                'success' => true,
                'message' => '',
                'data' => $examWithResults
            ];
        }
        else{
            $response = [
                'success' => false,
                'message' => 'Student Not Found!',
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function getStudentSubject(Request $request) {
        $studentId = $request->query->get('student_id',0);
        $student = Registration::where('status', AppHelper::ACTIVE)
            ->where('id', $studentId)
            ->first();
        // sanity check
        $this->checkSanity4Student($student->student_id);
        //end check

        if($student) {
            $subjects = $student->subjects->map(function ($subject){
               return [
                   "name" => $subject->name,
                    "code" => $subject->code,
                   "type"   => AppHelper::SUBJECT_TYPE[$subject->pivot->subject_type]
                   ];
            });

            $response = [
                'success' => true,
                'message' => '',
                'data' => $subjects
            ];
        }
        else{
            $response = [
                'success' => false,
                'message' => 'Student Not Found!',
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function getClassSubjectSettings($classId)
    {
        $classInfo = IClass::where('id', $classId)
            ->first();
        $settings = $classInfo->only([
            'have_selective_subject',
            'max_selective_subject',
            'have_elective_subject'
        ]);
        return response()->json($settings);
    }
}
