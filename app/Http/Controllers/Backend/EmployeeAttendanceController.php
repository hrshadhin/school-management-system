<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\EmployeeAttendance;
use App\Http\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        //if employee id present  that means come from employee profile
        // show fetch the attendance and send json response
        if ($request->ajax() && $request->query->get('employee_id', 0)) {
            $id = $request->query->get('employee_id', 0);
            $attendances = EmployeeAttendance::where('employee_id', $id)
                ->whereYear('attendance_date', date('Y'))
                ->select('attendance_date', 'present', 'employee_id')
                ->orderBy('attendance_date', 'asc')
                ->get();
            return response()->json($attendances);
        }

        // get query parameter for filter the fetch
        $employee_id = $request->query->get('employee_id', 0);
        $attendance_date = $request->query->get('attendance_date', date('d/m/Y'));


        //if its a ajax request that means come from attendance add exists checker
        if ($request->ajax()) {
            $attendances = $this->getAttendanceByFilters(null, $attendance_date, true);
            return response()->json($attendances);
        }


        $employees = Employee::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');


        //now fetch attendance data
        $attendances = [];
        if (strlen($attendance_date) >= 10) {

            $attendances = $this->getAttendanceByFilters($employee_id, $attendance_date);
        }



        return view('backend.attendance.employee.list', compact(
            'employees',
            'employee_id',
            'attendance_date',
            'attendances'
        ));
    }

    private function getAttendanceByFilters($employee_id = null, $attendance_date, $isCount = false)
    {
        $att_date = Carbon::createFromFormat('d/m/Y', $attendance_date)->toDateString();
        return $attendances = EmployeeAttendance::with('employee')
            ->whereDate('attendance_date', $att_date)
            ->Employee($employee_id)
            ->CountOrGet($isCount);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::select('name', 'id', 'id_card')
            ->where('status', AppHelper::ACTIVE)
            ->get();

        $sendNotification = AppHelper::getAppSettings('student_attendance_notification');


        return view('backend.attendance.employee.add', compact(
            'employees',
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


        $rules = [
            'attendance_date' => 'required|min:10|max:11',
            'employeeIds' => 'required',
            'inTime' => 'required',
            'outTime' => 'required'
        ];

        $this->validate($request, $rules);


        //check attendance exists or not
        $attendance_date = $request->get('attendance_date', '');
        $attendances = $this->getAttendanceByFilters(null, $attendance_date, true);
        if ($attendances) {
            return redirect()->route('employee_attendance.create')->with("error", "Attendance already exists!");
        }


        //process the insert data
        $employees = $request->get('employeeIds');
        $inTimes = $request->get('inTime');
        $outTimes = $request->get('outTime');

        $attendance_date = Carbon::createFromFormat('d/m/Y', $request->get('attendance_date'))->format('Y-m-d');

        //fetch employee working hours
        $workTimes = Employee::where('status', AppHelper::ACTIVE)->get()->reduce(function ($workTimes, $employee) use ($request) {
            $workTimes[$employee->id] = [
                'in_time' => null,
                'out_time' => null
            ];
            if ($employee->duty_start) {
                $workTimes[$employee->id]['in_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->get('attendance_date') . ' ' . $employee->getOriginal('duty_start'));
            }

            if ($employee->duty_end) {
                $workTimes[$employee->id]['out_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->get('attendance_date') . ' ' . $employee->getOriginal('duty_end'));
            }

            return $workTimes;
        });


        $dateTimeNow = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));
        $attendances = [];
        $absentIds = [];
        $parseError = false;
        $message = "";
        foreach ($employees as $employee) {

            $inTime = Carbon::createFromFormat('d/m/Y h:i a', $inTimes[$employee]);
            $outTime = Carbon::createFromFormat('d/m/Y h:i a', $outTimes[$employee]);

            if ($outTime->lessThan($inTime)) {
                $message = "Out time can't be less than in time!";
                $parseError = true;
            }

            $timeDiff  = $inTime->diff($outTime)->format('%H:%I');
            $isPresent = ($timeDiff == "00:00") ? "0" : "1";

            $status = [];
            //late or early out find
            if ($timeDiff != "00:00" && isset($workTimes[$employee]) && $workTimes[$employee]['in_time'] && $workTimes[$employee]['out_time']) {

                if ($inTime->greaterThan($workTimes[$employee]['in_time'])) {
                    $status[] = 1;
                }

                if ($outTime->lessThan($workTimes[$employee]['out_time'])) {
                    $status[] = 2;
                }
            }

            $attendances[] = [
                "employee_id" => $employee,
                "attendance_date" => $attendance_date,
                "in_time" => $inTime,
                "out_time" => $outTime,
                "working_hour" => $timeDiff,
                "status" => implode(',', $status),
                "present"   => $isPresent,
                "created_at" => $dateTimeNow,
                "created_by" => auth()->user()->id,
            ];

            if (!$isPresent) {
                $absentIds[] = $employee;
            }
        }

        if ($parseError) {
            return redirect()->route('employee_attendance.create')->with("error", $message);
        }


        DB::beginTransaction();
        try {

            EmployeeAttendance::insert($attendances);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
            return redirect()->route('employee_attendance.create')->with("error", $message);
        }

        $m = "Attendance saved successfully.";
        return redirect()->route('employee_attendance.create')->with("success", $m);
    }

    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id = 0)
    {

        $attendance =  EmployeeAttendance::findOrFail($id);
        if (!$attendance) {
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $attendance->present = (string) $request->get('status');

        $attendance->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];
    }

}
