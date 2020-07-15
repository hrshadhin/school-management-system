<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Employee;
use App\Exam;
use App\ExamRule;
use App\Http\Helpers\AppHelper;
use App\Http\Helpers\ReportHelper;
use App\IClass;
use App\EmployeeAttendance;
use App\Leave;
use App\Mark;
use App\Registration;
use App\Result;
use App\Section;
use App\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    /**
     * Student attendance Monthly Section wise
     *  @return \Illuminate\View\View
     */
    public function studentMonthlyAttendance(Request $request){

        if($request->isMethod('post')){
            $rules = [
                'class_id' => 'required|integer',
                'section_id' => 'required|integer',
                'academic_year' => 'required|integer',
                'month' => 'required|min:7|max:7',
            ];


            $this->validate($request, $rules);

            $month = Carbon::createFromFormat('m/Y', $request->get('month'))->timezone(env('APP_TIMEZONE','Asia/Dhaka'));
            $classId = $request->get('class_id', 0);
            $sectionId = $request->get('section_id', 0);
            $academicYearId = $request->get('academic_year', 0);

            $monthStart = $month->startOfMonth()->copy();
            $monthEnd = $month->endOfMonth()->copy();

            $students = Registration::where('status', AppHelper::ACTIVE)
                ->where('class_id', $classId)
                ->where('academic_year_id', $academicYearId)
                ->where('section_id', $sectionId)
                ->with(['info' => function($query){
                    $query->select('name','id');
                }])
                ->select('id','student_id','roll_no','regi_no')
                ->orderBy('roll_no','asc')
                ->get();

            $studentIds = $students->pluck('id');
            $attendanceData = StudentAttendance::select('registration_id','attendance_date','present','status')
                ->whereIn('registration_id', $studentIds)
                ->whereDate('attendance_date', '>=', $monthStart->format('Y-m-d'))
                ->whereDate('attendance_date', '<=', $monthEnd->format('Y-m-d'))
                ->get()
                ->reduce(function ($attendanceData, $attendance){
                    $inLate = 0;
                    if(strpos($attendance->status, '1') !== false){
                        $inLate = 1;
                    }
                    $attendanceData[$attendance->registration_id][$attendance->getOriginal('attendance_date')] = [
                        'present' => $attendance->getOriginal('present'),
                        'inLate'  => $inLate
                    ];

                    return $attendanceData;
                });

            $wekends = AppHelper::getAppSettings('weekends');
            if($wekends){
                $wekends = json_decode($wekends);
            }


            $monthDates = AppHelper::generateDateRangeForReport($monthStart, $monthEnd, true, $wekends);

            $headerData = new \stdClass();
            $headerData->reportTitle = 'Student Monthly Attendance';
            $headerData->reportSubTitle = 'Month: '.$month->format('F,Y');
            $fileName = $headerData->reportTitle."_".$headerData->reportSubTitle;
            $headerData->reportFileName = ReportHelper::replaceSpaceCharInString($fileName, ' ', '_');


            $filters = [];
            $academicYearInfo = AcademicYear::where('id', $academicYearId)->first();
            $filters[] = "Academic year: ".$academicYearInfo->title;

            $section = Section::where('id', $sectionId)
                ->with(['class' => function($q){
                    $q->select('name','id');
                }])
                ->select('id','class_id','name')
                ->first();

            $filters[] = "Class: ".$section->class->name;
            $filters[] = "Section: ".$section->name;


            return view('backend.report.student.attendance.monthly_print',compact(
                'headerData',
                'monthDates',
                'students',
                'attendanceData',
                'filters'
            ));
        }



        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');

        return view('backend.report.student.attendance.monthly', compact(
            'academic_years',
            'classes'
        ));

    }

    /**
     * Student list print
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function studentList(Request $request){

        $activeTab = 1;

        if($request->isMethod('post')) {

            if($request->get('form_name') == 'class') {
                $rules = [
                    'academic_year' => 'required|integer',
                    'class_id' => 'required|integer',
                    'section_id' => 'nullable|integer',
                ];
            }
            else {

                $rules = [
                    'academic_year' => 'required|integer',
                    'gender' => 'required|integer',
                    'religion' => 'required|integer',
                    'blood_group' => 'required|integer',
                ];
            }


            $this->validate($request, $rules);

            $academicYearId = $request->get('academic_year', 0);
            $filters = [];
            $academicYearInfo = AcademicYear::where('id', $academicYearId)->first();
            $filters[] = "Academic year: ".$academicYearInfo->title;


            $students = collect();
            $showSection = false;
            $showClass = false;

            if($request->get('form_name') == 'class') {

                //filter input
                $classId = $request->get('class_id',0);
                $sectionId = intval($request->get('section_id',0));

                $students =  Registration::where('status', AppHelper::ACTIVE)
                    ->where('academic_year_id', $academicYearId)
                    ->where('class_id', $classId)
                    ->if($sectionId, 'section_id', '=', $sectionId)
                    ->with('info')
                    ->when($sectionId, function ($q){
                        $q->with(['section' => function($qq){
                            $qq->select('id','name');
                        }]);
                    })
                    ->orderBy('regi_no','asc')
                    ->orderBy('roll_no','asc')
                    ->get();

                $classInfo = IClass::where('id', $classId)->first();
                $filters[] = "Class: ".$classInfo->name;

                if($sectionId){
                    $sectionInfo = Section::where('id', $sectionId)
                        ->select('id','name')
                        ->first();
                    $filters[] = "Section: ".$sectionInfo->name;
                }
                else{
                    $showSection = true;
                }

            }
            else{

                //filter input
                $gender = intval($request->get('gender',0));
                $religion = intval($request->get('religion',0));
                $bloodGroup = intval($request->get('blood_group',0));

                $students =  Registration::where('status', AppHelper::ACTIVE)
                    ->where('academic_year_id', $academicYearId)
                    ->with('info')
                    ->with(['class' => function($query){
                        $query->select('name','id');
                    }])
                    ->with(['section' => function($query){
                        $query->select('name','id');
                    }])
                    ->whereHas('student', function ($q) use($gender, $religion, $bloodGroup){
                        $q->if($religion,'religion','=',$religion)
                            ->if($gender, 'gender', '=', $gender)
                            ->if($bloodGroup, 'blood_group', '=', $bloodGroup);
                    })
                    ->orderBy('class_id','asc')
                    ->orderBy('section_id','asc')
                    ->orderBy('regi_no','asc')
                    ->orderBy('roll_no','asc')
                    ->get();


                $filters[] = "Gender: ".($gender ? AppHelper::GENDER[$gender] : 'All' );
                $filters[] = "Religion: ".($religion ? AppHelper::RELIGION[$religion] : 'All');
                $filters[] = "Blood Group: ".($bloodGroup ? AppHelper::BLOOD_GROUP[$bloodGroup] : 'All');

                $showClass = true;
                $showSection = true;
            }


            $headerData = new \stdClass();
            $headerData->reportTitle = 'Student List';
            $headerData->reportSubTitle = '';
            $fileName = $headerData->reportTitle;
            $headerData->reportFileName = ReportHelper::replaceSpaceCharInString($fileName, ' ', '_');


            return view('backend.report.student.list_print', compact('headerData', 'students','filters','showClass','showSection'));
        }

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');

        return view('backend.report.student.list', compact(
            'academic_years',
            'classes',
            'activeTab'
        ));
    }

    /**
     *  Marksheet public print
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function marksheetPublic(Request $request){

        if($request->isMethod('post')) {

            $rules = [
                'academic_year' => 'required|integer',
                'class_id' => 'required|integer',
                'exam_id' => 'required|integer',
                'regi_no' => 'required',
            ];

            if(!$request->exists('authorized_form',0)){
                $rules['captcha'] = 'required|captcha';
            }

            $v = Validator::make($request->all(), $rules);
            if(!$v->passes()){
                return redirect()->route('report.marksheet_pub')->withErrors($v);
            }


            $classId = $request->get('class_id', 0);
            $examId = $request->get('exam_id', 0);
            $regiNo = $request->get('regi_no', '');
            $academicYear = $request->get('academic_year', 0);


            $exam = Exam::where('id', $examId)
                ->where('class_id', $classId)
                ->select('id','name','marks_distribution_types')
                ->first();

            if(!$exam){
                return redirect()->back()->with('error', 'Exam not found!');
            }

            $student = Registration::where('status', AppHelper::ACTIVE)
                ->where('academic_year_id', $academicYear)
                ->where('class_id', $classId)
                ->where(function ($q) use ($regiNo){
                    $q->where('regi_no', $regiNo)
                        ->orWhere('roll_no', $regiNo);
                })
                ->with(['info' => function($query){
                    $query->select('name','dob','father_name','mother_name','id');
                }])
                ->with(['class' => function($query){
                    $query->select('name','id');
                }])
                ->with(['section' => function($query){
                    $query->select('name','id');
                }])
                ->with(['acYear' => function($q){
                    $q->select('title','id','start_date','end_date');
                }])
                ->select('id','student_id','class_id','section_id','shift','regi_no','roll_no','academic_year_id')
                ->first();

            if(!$student){
                return redirect()->back()->with('error', 'Student not found!');
            }

            $publishedResult = DB::table('result_publish')
                ->where('academic_year_id', $student->acYear->id)
                ->where('academic_year_id', $student->acYear->id)
                ->where('class_id', $classId)
                ->where('exam_id', $exam->id)
                ->whereDate('publish_date','<=', Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'))->format('Y-m-d'))
                ->select('publish_date')
                ->first();

            if(!$publishedResult){
                return redirect()->back()->with('error', 'Result not published for this class and exam!');
            }

            //result
            $result =  Result::where('class_id', $request->get('class_id'))
                ->where('registration_id', $student->id)
                ->where('exam_id', $exam->id)
                ->select('registration_id','grade', 'point', 'total_marks')
                ->first();
            $result->published_at = Carbon::createFromFormat('Y-m-d', $publishedResult->publish_date)
                ->format('d/m/Y');



            // now pull marks
            //subject wise highest marks
            $subjectWiseHighestMarks =  Mark::where('marks.academic_year_id', $student->acYear->id)
                ->where('marks.class_id', $request->get('class_id'))
                ->where('marks.exam_id', $exam->id)
                ->selectRaw('max(total_marks) as total, subject_id')
                ->groupBy('subject_id')
                ->get()
                ->reduce(function ($subjectWiseHighestMarks, $mark){
                    $subjectWiseHighestMarks[$mark->subject_id] = $mark->total;
                    return $subjectWiseHighestMarks;
                });

            //student
            $examMakrs = Mark::join('subjects', 'marks.subject_id', 'subjects.id')
                ->where('marks.registration_id', $student->id)
                ->where('marks.academic_year_id', $student->acYear->id)
                ->where('marks.class_id', $classId)
                ->where('marks.exam_id', $exam->id)
                ->select('subject_id','marks','total_marks','grade','point','present','subjects.name as subject_name',
                    'subjects.type as subject_type','subjects.code as subject_code','subjects.order as order')
                ->orderBy('order','asc')
                ->get();

            $coreSubjectsMarks = [];
            foreach ($examMakrs as $marks){
                $coreSubjectsMarks[] = [
                    'id' => $marks->subject_id,
                    'code' => $marks->subject_code,
                    'name' => $marks->subject_name,
                    'marks' => json_decode($marks->marks, true),
                    'highest_marks' => $subjectWiseHighestMarks[$marks->subject_id],
                    'total_marks' => $marks->total_marks,
                    'grade' => $marks->grade,
                    'point' => $marks->point
                ];
            }


            //marks distribution types
            $marksDistributionTypes = json_decode($exam->marks_distribution_types, true);
            $subjectWiseMarksDistributionTypeEmptyList = ExamRule::where('exam_id', $exam->id)
                ->select('subject_id', 'marks_distribution')
                ->get()
                ->reduce(function ($subjectWiseMarksDistributionTypeEmptyList, $rule) {

                    $emptyList = [];
                    foreach (json_decode($rule->marks_distribution) as $distribution) {
                        if($distribution->total_marks == 0) {
                            $emptyList[$distribution->type] = 0;
                        }
                    }

                    $subjectWiseMarksDistributionTypeEmptyList[$rule->subject_id] = $emptyList;

                    return $subjectWiseMarksDistributionTypeEmptyList;
                });


            // report settings
            $headerData = new \stdClass();
            $headerData->reportTitle = 'Marksheet';
            $headerData->reportSubTitle = $exam->name.'-'.$student->acYear->title;
            $fileName = $headerData->reportTitle."_Class_{$student->class->name}_Section_{$student->section->name}_Roll_{$student->roll_no}";
            $headerData->reportFileName = ReportHelper::replaceSpaceCharInString($fileName, ' ', '_');


            return view('backend.report.exam.marksheet_pub_print', compact(
                'headerData',
                'exam',
                'marksDistributionTypes',
                'subjectWiseMarksDistributionTypeEmptyList',
                'student',
                'coreSubjectsMarks',
                'result'
            ));
        }

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        $exams = [];

        $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');

        return view('backend.report.exam.marksheet_pub', compact(
            'exams',
            'classes',
            'academic_years'
        ));
    }

    /**
     * employee list print
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function employeeList(Request $request){
        if($request->isMethod('post')) {

            $this->validate($request,[]);

            $employees = Employee::with(['role' => function($q){
                $q->select('id','name');
            }])->select(
                'id',
                'role_id',
                'id_card',
                'name',
                'designation',
                'qualification',
                'dob',
                'gender',
                'religion',
                'email',
                'phone_no',
                'address',
                'joining_date',
                'shift',
                'duty_start',
                'duty_end',
                'status'
            )
                ->orderBy('order','asc')
                ->get();

            $headerData = new \stdClass();
            $headerData->reportTitle = 'Employee List';
            $headerData->reportSubTitle = '';


            return view('backend.report.hrm.employee.list_print', compact('headerData','employees'));
        }

        return view('backend.report.hrm.employee.list');
    }


    /**
     *  Employee attendance Monthly
     *  @return \Illuminate\View\View
     */
    public function employeeMonthlyAttendance(Request $request){

        if($request->isMethod('post')){
            $rules = [
                'month' => 'required|min:7|max:7',
            ];


            $this->validate($request, $rules);

            $month = Carbon::createFromFormat('m/Y', $request->get('month'))->timezone(env('APP_TIMEZONE','Asia/Dhaka'));

            $monthStart = $month->startOfMonth()->copy();
            $monthEnd = $month->endOfMonth()->copy();

            $employees = Employee::select('id','name','id_card')
                ->orderBy('order','asc')
                ->get();

            $employeeIds = $employees->pluck('id');
            $attendanceData = EmployeeAttendance::select('employee_id','attendance_date','present','status')
                ->whereIn('employee_id', $employeeIds)
                ->whereDate('attendance_date', '>=', $monthStart->format('Y-m-d'))
                ->whereDate('attendance_date', '<=', $monthEnd->format('Y-m-d'))
                ->get()
                ->reduce(function ($attendanceData, $attendance){
                    $inLate = 0;
                    if(strpos($attendance->status, '1') !== false){
                        $inLate = 1;
                    }
                    $attendanceData[$attendance->employee_id][$attendance->getOriginal('attendance_date')] = [
                        'present' => $attendance->getOriginal('present'),
                        'inLate'  => $inLate
                    ];

                    return $attendanceData;
                });

            //get all leaves of employees for requested month
            $employeesLeaves = Leave::where('status',2) //1= pending, 2= approved, 3= Rejected
            ->whereDate('leave_date','>=', $monthStart->format('Y-m-d'))
                ->whereDate('leave_date','<=', $monthEnd->format('Y-m-d'))
                ->get(['employee_id','leave_date'])
                ->reduce(function ($employeesLeaves, $leave) {
                    $employeesLeaves[$leave->employee_id][$leave->getOriginal('leave_date')] = 1; //just true
                    return $employeesLeaves;
                });


            $wekends = AppHelper::getAppSettings('weekends');
            if($wekends){
                $wekends = json_decode($wekends);
            }


            $monthDates = AppHelper::generateDateRangeForReport($monthStart, $monthEnd, true, $wekends);

            $headerData = new \stdClass();
            $headerData->reportTitle = 'Employee Monthly Attendance';
            $headerData->reportSubTitle = 'Month: '.$month->format('F,Y');
            $fileName = $headerData->reportTitle."_".$headerData->reportSubTitle;
            $headerData->reportFileName = ReportHelper::replaceSpaceCharInString($fileName, ' ', '_');


            return view('backend.report.hrm.employee.attendance.monthly_print',compact(
                'headerData',
                'monthDates',
                'employees',
                'attendanceData',
                'employeesLeaves'
            ));
        }

        return view('backend.report.hrm.employee.attendance.monthly');

    }

}
