<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Registration;
use App\Section;
use App\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // get query parameter for filter the fetch
        $class_id = $request->query->get('class', 0);
        $section_id = $request->query->get('section', 0);
        $acYear = $request->query->get('academic_year', 0);
        $attendance_date = $request->query->get('attendance_date', date('d/m/Y'));
        //if its college then have to get those academic years
        $academic_years = [];
        if (AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        } else {

            $acYear = $request->query->get('academic_year', AppHelper::getAcademicYear());
        }



        //if its a ajax request that means come from attendance add exists checker
        if ($request->ajax()) {
            $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, true);
            return response()->json($attendances);
        }


        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->pluck('name', 'id');
        $sections = [];

        //now fetch attendance data
        $attendances = [];
        if ($class_id && $section_id && $acYear && strlen($attendance_date) >= 10) {
            $att_date = Carbon::createFromFormat('d/m/Y', $attendance_date)->toDateString();
            $attendances = Registration::where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('status', AppHelper::ACTIVE)
                ->with(['student' => function ($query) {
                    $query->select('name', 'id');
                }])
                ->with(['attendanceSingleDay' => function ($query) use ($att_date, $class_id, $acYear) {
                    $query->select('id', 'present', 'registration_id', 'in_time', 'out_time', 'staying_hour')
                        ->where('academic_year_id', $acYear)
                        ->where('class_id', $class_id)
                        ->whereDate('attendance_date', $att_date);
                }])
                ->whereHas('attendance', function ($query) use ($att_date, $class_id, $acYear) {
                    $query->select('id', 'registration_id')
                        ->where('academic_year_id', $acYear)
                        ->where('class_id', $class_id)
                        ->whereDate('attendance_date', $att_date);
                })
                ->select('id', 'regi_no', 'roll_no', 'student_id')
                ->orderBy('roll_no', 'asc')
                ->get();

            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');
        }



        return view('backend.attendance.student.list', compact(
            'academic_years',
            'classes',
            'sections',
            'acYear',
            'class_id',
            'section_id',
            'attendance_date',
            'attendances'
        ));
    }

    private function getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, $isCount = false)
    {
        $att_date = Carbon::createFromFormat('d/m/Y', $attendance_date)->toDateString();
        return $attendances = Registration::where('academic_year_id', $acYear)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('status', AppHelper::ACTIVE)
            ->with(['student' => function ($query) {
                $query->select('name', 'id');
            }])
            ->whereHas('attendance', function ($query) use ($att_date, $class_id, $acYear) {
                $query->select('id', 'registration_id')
                    ->where('academic_year_id', $acYear)
                    ->where('class_id', $class_id)
                    ->whereDate('attendance_date', $att_date);
            })
            ->select('id', 'regi_no', 'roll_no', 'student_id')
            ->orderBy('roll_no', 'asc')
            ->CountOrGet($isCount);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $students = collect();
        $academic_year = '';
        $class_name = '';
        $section_name = '';
        $academic_years = [];
        $attendance_date = date('d/m/Y');
        $acYear = null;
        $class_id = null;
        $section_id = null;
        $sendNotification = 0;

        if ($request->isMethod('post')) {

            if (AppHelper::getInstituteCategory() == 'college') {
                $acYear = $request->get('academic_year', 0);
            } else {
                $acYear = AppHelper::getAcademicYear();
            }
            $class_id = $request->get('class_id', 0);
            $section_id = $request->get('section_id', 0);
            $attendance_date = $request->get('attendance_date', '');

            $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, true);
            if ($attendances) {
                return redirect()->route('student_attendance.create')->with("error", "Attendance already exists!");
            }

            $students = Registration::with(['info' => function ($query) {
                $query->select('name', 'id');
            }])->where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->select('regi_no', 'roll_no', 'id', 'student_id')
                ->orderBy('roll_no', 'asc')
                ->get();


            $classInfo = IClass::where('status', AppHelper::ACTIVE)
                ->where('id', $class_id)
                ->first();
            $class_name = $classInfo->name;
            $sectionsInfo = Section::where('status', AppHelper::ACTIVE)
                ->where('id', $section_id)
                ->where('class_id', $class_id)
                ->first();
            $section_name = $sectionsInfo->name;


            if (AppHelper::getInstituteCategory() == 'college') {
                $acYearInfo = AcademicYear::where('status', '1')->where('id', $acYear)->first();
                $academic_year = $acYearInfo->title;
            }

            $sendNotification = AppHelper::getAppSettings('student_attendance_notification');
        }

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        if (AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }


        return view('backend.attendance.student.add', compact(
            'academic_years',
            'classes',
            'sections',
            'students',
            'class_name',
            'academic_year',
            'section_name',
            'attendance_date',
            'class_id',
            'section_id',
            'acYear',
            'sendNotification'
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
        //validate form
        $messages = [
            'registrationIds.required' => 'This section has no students!'
        ];
        $rules = [
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'attendance_date' => 'required|min:10|max:11',
            'registrationIds' => 'required|array'

        ];
        //if it college then need another 2 feilds
        if (AppHelper::getInstituteCategory() == 'college') {
            $rules['academic_year'] = 'required|integer';
        }

        $this->validate($request, $rules, $messages);


        //check attendance exists or not
        $class_id = $request->get('class_id', 0);
        $section_id = $request->get('section_id', 0);
        $attendance_date = $request->get('attendance_date', '');
        if (AppHelper::getInstituteCategory() == 'college') {
            $acYear =  $request->get('academic_year', 0);
        } else {

            $acYear = AppHelper::getAcademicYear();
        }
        $attendances = $this->getAttendanceByFilters($class_id, $section_id, $acYear, $attendance_date, true);

        if ($attendances) {
            return redirect()->route('student_attendance.create')->with("error", "Attendance already exists!");
        }


        //process the insert data
        $students = $request->get('registrationIds');
        $present = $request->get('present', []);
        $attendance_date = Carbon::createFromFormat('d/m/Y', $request->get('attendance_date'))->format('Y-m-d');
        $dateTimeNow = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));


        //fetch institute shift running times
        $shiftData = AppHelper::getAppSettings('shift_data');
        if ($shiftData) {
            $shiftData = json_decode($shiftData, true);
        }

        $shiftRuningTimes = [];

        foreach ($shiftData as $shift => $times) {
            $shiftRuningTimes[$shift] = [
                'start' => Carbon::createFromFormat('Y-m-d h:i a', $attendance_date . ' ' . $times['start']),
                'end' => Carbon::createFromFormat('Y-m-d h:i a', $attendance_date . ' ' . $times['end'])
            ];
        }

        $studentsShift = Registration::whereIn('id', $students)
            ->get(['id', 'shift'])
            ->reduce(function ($studentsShift, $student) {
                $studentsShift[$student->id] = $student->shift;
                return $studentsShift;
            });

        $attendances = [];
        $absentIds = [];
        $parseError = false;
        $message = "";
        $timeZero = Carbon::createFromFormat('Y-m-dHis', $attendance_date.'000000');

        foreach ($students as $student) {

            $inTime = $shiftRuningTimes[$studentsShift[$student]]['start'];
            $outTime = $shiftRuningTimes[$studentsShift[$student]]['end'];
            $timeDiff  = $inTime->diff($outTime)->format('%H:%I');

            $isPresent = '1';
            if(!isset($present[$student])){
                $inTime = $timeZero;
                $outTime = $timeZero;
                $timeDiff = '00:00:00';
                $isPresent = '0';
            }

            $status = [];

            $attendances[] = [
                "academic_year_id" => $acYear,
                "class_id" => $class_id,
                "registration_id" => $student,
                "attendance_date" => $attendance_date,
                "in_time" => $inTime,
                "out_time" => $outTime,
                "staying_hour" => $timeDiff,
                "status" => implode(',', $status),
                "present"   => $isPresent,
                "created_at" => $dateTimeNow,
                "created_by" => auth()->user()->id,
            ];

            if (!$isPresent) {
                $absentIds[] = $student;
            }
        }

        if ($parseError) {
            return redirect()->route('employee_attendance.create')->with("error", $message);
        }


        DB::beginTransaction();
        try {

            StudentAttendance::insert($attendances);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
            return redirect()->route('student_attendance.create')->with("error", $message);
        }


        //now invalid cache
        Cache::forget('student_attendance_count');

        $m = "Attendance saved successfully.";
        return redirect()->route('student_attendance.create')->with("success", $m);
    }

    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request  $request, $id = 0)
    {

        $attendance =  StudentAttendance::findOrFail($id);
        if (!$attendance) {
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $attendance->present = (string)    $request->get('status');

        $attendance->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];
    }
}
