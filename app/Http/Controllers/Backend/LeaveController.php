<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\Http\Helpers\AppHelper;
use App\Leave;
use App\WorkOutside;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $employee = $request->get('employee_id', 0);
        $leave_type = $request->get('leave_type', 0);
        $leave_date = $request->get('leave_date', '');
        $status = $request->get('status', 0);
        $employees = Employee::pluck('name','id')->prepend('All', 0);;

        $leaves = collect();
        if($request->has('filter')) {
            //need to implement filters here
            $leaves = Leave::with('employee')
                ->whereEmployee($employee)
                ->whereLeaveType($leave_type)
                ->whereLeaveDate($leave_date)
                ->whereStatus($status)
                ->get();
        }





        return view('backend.hrm.leave.list', compact(
            'leaves',
            'employees',
            'employee',
            'leave_type',
            'leave_date',
            'status'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $employees = Employee::pluck('name','id');
        $leave = null;
        $leave_type = null;
        return view('backend.hrm.leave.add', compact('leave', 'employees', 'leave_type'));

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
            'document.max' => 'The :attribute size must be under 2mb.',
        ];

        $rules =  [
            'employee_id' => 'required|integer',
            'leave_date' => 'min:10',
            'leave_date_end' => 'nullable|min:10',
            'leave_type' => 'required|integer',
            'document' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,txt|max:2048',
            'description' => 'nullable|max:500',

        ];

        $this->validate($request, $rules);


        //custom validation goes here
        $dayCount = 1;
        $leaveDateStart = Carbon::createFromFormat('d/m/Y',$request->get('leave_date'));
        $leaveDateEnd = null;
        if(strlen($request->get('leave_date_end',''))) {
            $leaveDateEnd = Carbon::createFromFormat('d/m/Y', $request->get('leave_date_end'));
            $dayCount = $leaveDateEnd->diff($leaveDateStart)->format("%a")+1;

            if($leaveDateEnd<$leaveDateStart){
                return redirect()->back()->with('error','Leave End date can\'t be less than start date!');
            }
        }

        $dateList = [$leaveDateStart->format('Y-m-d')];
        if($leaveDateEnd){
            $startDate = $leaveDateStart->copy();
            $startDate->addDay(1);
            while ($startDate->lte($leaveDateEnd)){
                $dateList[] = $startDate->format('Y-m-d');
                $startDate->addDay(1);
            }
        }

        $haveWorkOutSide = WorkOutside::where('employee_id', $request->get('employee_id',0))
            ->whereIn('work_date', $dateList)
            ->count();

        if($haveWorkOutSide){
            $message = 'This employee has work outside schedule';
            if($leaveDateEnd){
                $message .= ' inside '.$leaveDateStart->format('d/m/Y').' to '.$leaveDateEnd->format('d/m/Y');
            }
            else{
                $message .= ' on '.$leaveDateStart->format('d/m/Y');
            }
            return redirect()->back()->with('error', $message);
        }

        $holidayBalance = true;
        if($request->get('leave_type',0) == 1) {
            $totalAllowCasualLeave = AppHelper::getAppSettings('total_casual_leave');

            $usedLeave = Leave::where('employee_id',$request->get('employee_id'))
                ->where('leave_type',1)->where('status','2')->count();

            if(($dayCount + $usedLeave) > $totalAllowCasualLeave) {
                $holidayBalance = false;
                $message = "Casual leave limit is over. He/She took $usedLeave/$totalAllowCasualLeave day's leave already.";
            }
        }

        if($request->get('leave_type',0) == 2) {
            $totalAllowSickLeave = AppHelper::getAppSettings('total_sick_leave');
            $usedLeave = Leave::where('employee_id',$request->get('employee_id'))
                ->where('leave_type',2)->where('status','2')->count();

            if(($dayCount + $usedLeave) > $totalAllowSickLeave) {
                $holidayBalance = false;
                $message = "Sick leave limit is over. He/She took $usedLeave/$totalAllowSickLeave day's leave already.";
            }
        }

        if(!$holidayBalance){
            return redirect()->back()->with('error', $message);
        }


        $data = $request->all();
        if($request->hasFile('document')) {
            $storagepath = $request->file('document')->store('public/leave');
            $fileName = basename($storagepath);
            $data['document'] = $fileName;
        }
        else{
            $data['document'] = $request->get('oldDocument','');
        }

        if(strlen($request->get('leave_date_end',''))){

            $start_time = strtotime($leaveDateStart);
            $end_time = strtotime($leaveDateEnd);
            for($i=$start_time; $i<=$end_time; $i+=86400)
            {
               $data['leave_date'] = date('d/m/Y', $i);
               Leave::create($data);

            }

            $message = $dayCount." days leave added!";

        }
        else {
            // now save employee
            Leave::create($data);
            $message = "Leave added!";
        }

        return redirect()->route('hrm.leave.create')->with('success', $message);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param   integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $leave_type = $leave->getOriginal('leave_type');
        return view('backend.hrm.leave.add', compact('leave', 'leave_type'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $leave = Leave::findOrFail($id);

        $rules =  [
            'status' => 'required|integer'
        ];

        if(!$request->has('update_status')){
            //validate form
            $messages = [
                'document.max' => 'The :attribute size must be under 2mb.',
            ];

            $rules =  [
                'leave_date' => 'min:10',
                'leave_type' => 'required|integer',
                'document' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,txt|max:2048',
                'description' => 'nullable|max:500',

            ];
        }

        $this->validate($request, $rules);

        if($request->has('update_status')){
            $leave->status = $request->get('status');
            $leave->save();
            return redirect()->route('hrm.leave.index')->with('success', 'Leave Updated!');
        }

        $leaveDate = Carbon::createFromFormat('d/m/Y',$request->get('leave_date'))->format('Y-m-d');
        $haveWorkOutSide = WorkOutside::where('employee_id', $leave->employee_id)
            ->whereDate('work_date', $leaveDate)
            ->count();
        if($haveWorkOutSide){
            $message = 'This employee has work outside schedule  on '.$request->get('leave_date');
            return redirect()->back()->with('error', $message);
        }

        $data = $request->all();
        unset($data['employee_id']);

        if($request->hasFile('document')) {
            $storagepath = $request->file('document')->store('public/leave');
            $fileName = basename($storagepath);
            $data['document'] = $fileName;

            //if file change then delete old one
            $oldFile = $request->get('oldDocument','');
            if( $oldFile != ''){
                $file_path = "public/leave/".$oldFile;
                Storage::delete($file_path);
            }
        }
        else{
            $data['document'] = $request->get('oldDocument','');
        }

        $leave->fill($data);
        $leave->save();


        return redirect()->route('hrm.leave.index')->with('success', 'Leave Updated!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();

        return redirect()->route('hrm.leave.index')->with('success', 'Leave deleted!');
    }
}
