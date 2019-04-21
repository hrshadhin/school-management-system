<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\WorkOutside;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class WorkOutsideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employee = $request->get('employee_id', 0);
        $work_date = $request->get('work_date', '');
        $employees = Employee::pluck('name','id')->prepend('All', 0);;

        $works = collect();
        if($request->has('filter')) {
            //need to implement filters here
            $works = WorkOutside::with('employee')
                ->whereEmployee($employee)
                ->whereWorkDate($work_date)
                ->get();
        }

        return view('backend.hrm.work_outside.list', compact(
            'works',
            'employees',
            'employee',
            'work_date'
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
        $work = null;
        return view('backend.hrm.work_outside.add', compact('work', 'employees'));

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
            'work_date' => 'min:10',
            'work_date_end' => 'nullable|min:10',
            'document' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,txt|max:2048',
            'description' => 'nullable|max:500',

        ];

        $this->validate($request, $rules);


        //custom validation goes here
        $dayCount = 1;
        $leaveDateStart = Carbon::createFromFormat('d/m/Y',$request->get('work_date'));
        $leaveDateEnd = null;
        if(strlen($request->get('work_date_end',''))) {
            $leaveDateEnd = Carbon::createFromFormat('d/m/Y', $request->get('work_date_end'));
            $dayCount = $leaveDateEnd->diff($leaveDateStart)->format("%a")+1;

            if($leaveDateEnd<$leaveDateStart){
                return redirect()->back()->with('error','Work End date can\'t be less than start date!');
            }
        }


        $data = $request->all();
        if($request->hasFile('document')) {
            $storagepath = $request->file('document')->store('public/work_outside');
            $fileName = basename($storagepath);
            $data['document'] = $fileName;
        }
        else{
            $data['document'] = $request->get('oldDocument','');
        }

        if(strlen($request->get('work_date_end',''))){

            $start_time = strtotime($leaveDateStart);
            $end_time = strtotime($leaveDateEnd);
            for($i=$start_time; $i<=$end_time; $i+=86400)
            {
                $data['work_date'] = date('d/m/Y', $i);
                WorkOutside::create($data);

            }

            $message = $dayCount." days work outside added!";

        }
        else {
            // now save employee
            WorkOutside::create($data);
            $message = "Work outside added!";
        }

        return redirect()->route('hrm.work_outside.create')->with('success', $message);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkOutside  $workOutside
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $work = WorkOutside::findOrFail($id);
        return view('backend.hrm.work_outside.add', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkOutside  $workOutside
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $work = WorkOutside::findOrFail($id);

            //validate form
            $messages = [
                'document.max' => 'The :attribute size must be under 2mb.',
            ];

            $rules =  [
                'work_date' => 'min:10',
                'document' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,txt|max:2048',
                'description' => 'nullable|max:500',

            ];


        $this->validate($request, $rules);

        $data = $request->all();
        unset($data['employee_id']);

        if($request->hasFile('document')) {
            $storagepath = $request->file('document')->store('public/work_outside');
            $fileName = basename($storagepath);
            $data['document'] = $fileName;

            //if file change then delete old one
            $oldFile = $request->get('oldDocument','');
            if( $oldFile != ''){
                $file_path = "public/work_outside/".$oldFile;
                Storage::delete($file_path);
            }
        }
        else{
            $data['document'] = $request->get('oldDocument','');
        }

        $work->fill($data);
        $work->save();


        return redirect()->route('hrm.work_outside.index')->with('success', 'Record Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkOutside  $workOutside
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = WorkOutside::findOrFail($id);
        $work->delete();

        return redirect()->route('hrm.work_outside.index')->with('success', 'Record deleted!');
    }
}
