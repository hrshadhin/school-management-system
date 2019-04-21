<?php

namespace App\Http\Controllers\Backend;

use App\AppMeta;
use App\Employee;
use App\Http\Helpers\AppHelper;
use App\Leave;
use App\Role;
use App\Template;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $employees = Employee::with('role')->get();

        return view('backend.hrm.employee.list', compact('employees'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = null;
        $gender = 1;
        $religion = 1;
        $role = 0;
        $shift = 1;
        $roles = Role::whereNotIn('id', [AppHelper::USER_ADMIN, AppHelper::USER_TEACHER, AppHelper::USER_STUDENT, AppHelper::USER_PARENTS])->pluck('name', 'id');
        return view('backend.hrm.employee.add', compact('employee', 'gender', 'religion', 'role', 'roles', 'shift'));
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
            'photo.max' => 'The :attribute size must be under 200kb.',
            'signature.max' => 'The :attribute size must be under 200kb.',
            'photo.dimensions' => 'The :attribute dimensions min 150 X 150.',
            'signature.dimensions' => 'The :attribute dimensions max 160 X 80.',
        ];

        $rules =  [
            'name' => 'required|min:5|max:255',
            'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150',
            'signature' => 'nullable|mimes:jpeg,jpg,png|max:200|dimensions:max_width=160,max_height=80',
            'designation' => 'max:255',
            'qualification' => 'max:255',
            'dob' => 'min:10',
            'gender' => 'required|integer',
            'religion' => 'required|integer',
            'email' => 'nullable|email|max:255|unique:employees,email|unique:users,email',
            'phone_no' => 'required|min:8|max:255',
            'address' => 'max:500',
            'id_card' => 'required|min:4|max:50|unique:employees,id_card',
            'joining_date' => 'min:10',
            'username' => 'nullable|min:5|max:255|unique:users,username',
            'password' => 'nullable|min:6|max:50',
            'shift' => 'nullable|integer',
            'duty_start' => 'nullable|max:8',
            'duty_end' => 'nullable|max:8',

        ];

        $this->validate($request, $rules);

        $createUser = false;

        if(strlen($request->get('username',''))){
            $rules['email' ] = 'email|max:255|unique:students,email|unique:users,email';
            $createUser = true;

        }


        if($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store('public/employee');
            $fileName = basename($storagepath);
            $data['photo'] = $fileName;
        }
        else{
            $data['photo'] = $request->get('oldPhoto','');
        }

        if($request->hasFile('signature')) {
            $storagepath = $request->file('signature')->store('public/employee/signature');
            $fileName = basename($storagepath);
            $data['signature'] = $fileName;
        }
        else{
            $data['signature'] = $request->get('oldSignature','');
        }

        $data['name'] = $request->get('name');
        $data['designation'] = $request->get('designation');
        $data['qualification'] = $request->get('qualification');
        $data['dob'] = $request->get('dob');
        $data['gender'] = $request->get('gender');
        $data['religion'] = $request->get('religion');
        $data['email'] = $request->get('email');
        $data['phone_no'] = $request->get('phone_no');
        $data['address'] = $request->get('address');
        $data['joining_date'] = $request->get('joining_date');
        $data['id_card'] = $request->get('id_card');
        $data['role_id'] = $request->get('role_id', 0);
        $data['shift'] = $request->get('shift');
        $data['duty_start'] = $request->get('duty_start');
        $data['duty_end'] = $request->get('duty_end');

        DB::beginTransaction();
        try {
            //now create user
            if ($createUser) {
                $user = User::create(
                    [
                        'name' => $data['name'],
                        'username' => $request->get('username'),
                        'email' => $data['email'],
                        'password' => bcrypt($request->get('password')),
                        'remember_token' => null,
                    ]
                );
                //now assign the user to role
                UserRole::create(
                    [
                        'user_id' => $user->id,
                        'role_id' => $data['role_id']
                    ]
                );
                $data['user_id'] = $user->id;
            }
            // now save employee
            Employee::create($data);

            DB::commit();

            //now notify the admins about this record
            $msg = $data['name']." Employee added by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('hrm.employee.create')->with('success', 'Employee added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return $message;
            return redirect()->route('hrm.employee.create')->with("error",$message);
        }

        return redirect()->route('hrm.employee.create');


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        // if print id card of this student then
        // Do here
        if($request->query->get('print_idcard',0)) {

            $templateId = AppHelper::getAppSettings('employee_idcard_template');
            $templateConfig = Template::where('id', $templateId)->where('type',3)->where('role_id', AppHelper::USER_TEACHER)->first();

            if(!$templateConfig){
                return redirect()->route('administrator.template.idcard.index')->with('error', 'Template not found!');
            }

            $templateConfig = json_decode($templateConfig->content);

            $format = "format_";
            if($templateConfig->format_id == 2){
                $format .="two";
            }
            else if($templateConfig->format_id == 3){
                $format .="three";
            }
            else {
                $format .="one";
            }

            //get institute information
            $instituteInfo = AppHelper::getAppSettings('institute_settings');


            $employees = Employee::where('id', $id)->get();

            if(!$employees){
                abort(404);
            }


            $side = 'both';
            return view('backend.report.hrm.employee.idcard.'.$format, compact(
                'templateConfig',
                'instituteInfo',
                'side',
                'employees'
            ));
        }

        $employee = Employee::with('user')->with('role')->where('id', $id)->first();
        if(!$employee){
            abort(404);
        }

        //get leave information
        $usedLeaves = Leave::where('employee_id',$employee->id)
           ->where('status','2')
            ->select('leave_type', DB::raw('count(*) as total'))
            ->groupBy('leave_type')
            ->pluck('total','leave_type')
            ->all();

        $policies = AppMeta::whereIn('meta_key',
            ['total_casual_leave', 'total_sick_leave']
        )->get();

        $metas = [];
        foreach ($policies as $policy){
            $metas[$policy->meta_key] = $policy->meta_value;
        }



        return view('backend.hrm.employee.view', compact('employee','usedLeaves', 'metas'));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::where('role_id', '!=', AppHelper::EMP_TEACHER)->where('id', $id)->first();

        if(!$employee){
            abort(404);
        }
        $gender = $employee->getOriginal('gender');
        $religion = $employee->getOriginal('religion');
        $role = $employee->role_id;
        $shift = $employee->getOriginal('shift');

        $roles = Role::whereNotIn('id', [AppHelper::USER_ADMIN, AppHelper::USER_TEACHER, AppHelper::USER_STUDENT, AppHelper::USER_PARENTS])->pluck('name', 'id');

        $users = [];
        if(!$employee->user_id){
            $users = User::doesnthave('employee')
            ->doesnthave('student')
               ->whereHas('role' , function ($query) {
                   $query->whereNotIn('role_id', [AppHelper::USER_ADMIN, AppHelper::USER_TEACHER, AppHelper::USER_STUDENT, AppHelper::USER_PARENTS]);
               })
               ->pluck('name', 'id');
        }

        return view('backend.hrm.employee.add', compact('employee', 'gender', 'religion', 'role', 'roles', 'shift','users'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::where('role_id', '!=', AppHelper::EMP_TEACHER)->where('id', $id)->first();

        if(!$employee){
            abort(404);
        }
        //validate form
        $messages = [
            'photo.max' => 'The :attribute size must be under 200kb.',
            'signature.max' => 'The :attribute size must be under 200kb.',
            'photo.dimensions' => 'The :attribute dimensions min 150 X 150.',
            'signature.dimensions' => 'The :attribute dimensions max 160 X 80.',
        ];
        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150',
                'signature' => 'mimes:jpeg,jpg,png|max:200|dimensions:max_width=160,max_height=80',
                'designation' => 'max:255',
                'qualification' => 'max:255',
                'dob' => 'min:10',
                'gender' => 'required|integer',
                'religion' => 'required|integer',
                'email' => 'nullable|email|max:255|unique:employees,email,'.$employee->id.'|unique:users,email,'.$employee->user_id,
                'phone_no' => 'required|min:8|max:255',
                'address' => 'max:500',
                'id_card' => 'required|min:4|max:50|unique:employees,id_card,'.$employee->id,
                'joining_date' => 'min:10',
                'shift' => 'nullable|integer',
                'duty_start' => 'nullable|max:8',
                'duty_end' => 'nullable|max:8',
                'user_id' => 'nullable|integer',

            ]
        );

        if($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store('public/employee');
            $fileName = basename($storagepath);
            $data['photo'] = $fileName;

            //if file change then delete old one
            $oldFile = $request->get('oldPhoto','');
            if( $oldFile != ''){
                $file_path = "public/employee/".$oldFile;
                Storage::delete($file_path);
            }
        }
        else{
            $data['photo'] = $request->get('oldPhoto','');
        }

        if($request->hasFile('signature')) {
            $storagepath = $request->file('signature')->store('public/employee/signature');
            $fileName = basename($storagepath);
            $data['signature'] = $fileName;

            //if file change then delete old one
            $oldFile = $request->get('oldSignature','');
            if( $oldFile != ''){
                $file_path = "public/employee/signature/".$oldFile;
                Storage::delete($file_path);
            }
        }
        else{
            $data['signature'] = $request->get('oldSignature','');
        }


        $data['name'] = $request->get('name');
        $data['designation'] = $request->get('designation');
        $data['qualification'] = $request->get('qualification');
        $data['dob'] = $request->get('dob');
        $data['gender'] = $request->get('gender');
        $data['religion'] = $request->get('religion');
        $data['email'] = $request->get('email');
        $data['phone_no'] = $request->get('phone_no');
        $data['address'] = $request->get('address');
        $data['joining_date'] = $request->get('joining_date');
        $data['id_card'] = $request->get('id_card');
        $data['role_id'] = $request->get('role_id', 0);
        $data['shift'] = $request->get('shift', 1);
        $data['duty_start'] = $request->get('duty_start', '');
        $data['duty_end'] = $request->get('duty_end', '');

        //
        if(!$employee->user_id && $request->get('user_id', 0)){
            $data['user_id'] = $request->get('user_id');
        }


        $employee->fill($data);
        $employee->save();

        return redirect()->route('hrm.employee.index')->with('success', 'Employee updated!');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('role_id', '!=', AppHelper::EMP_TEACHER)->where('id', $id)->first();

        if(!$employee){
            abort(404);
        }

        $message = "Something went wrong!";
        DB::beginTransaction();
        try {

            if($employee->user_id) {
                User::destroy($employee->user_id);
                DB::table('user_roles')->where('user_id', $employee->user_id)->update([
                    'deleted_by' => auth()->user()->id,
                    'deleted_at' => Carbon::now()
                ]);
            }
            $employee->delete();

            DB::commit();

            //now notify the admins about this record
            $msg = $employee->name." Employee deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('hrm.employee.index')->with('success', 'Employee deleted.');

        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
        }




        return redirect()->route('hrm.employee.index')->with('error', $message);

    }

    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $employee =  Employee::findOrFail($id);
        if(!$employee){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $employee->status = (string)$request->get('status');

        $employee->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }

    /**
     *  HRM policy setting
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function hrmPolicy(Request $request)
    {

        //for save on POST request
        if ($request->isMethod('post')) {

            $rules = [
                'total_casual_leave' => 'required|integer',
                'total_sick_leave' => 'required|integer'
                ];


            $this->validate($request, $rules);

            //now crate
            AppMeta::updateOrCreate(
                ['meta_key' => 'total_casual_leave'],
                ['meta_value' => $request->get('total_casual_leave', 0)]
            );
            AppMeta::updateOrCreate(
                ['meta_key' => 'total_sick_leave'],
                ['meta_value' => $request->get('total_sick_leave', 0)]
            );



            Cache::forget('app_settings');

            //now notify the admins about this record
            $msg = "HR policy updated by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('hrm.policy')->with('success', 'Policy updated!');
        }


        $policies = AppMeta::whereIn('meta_key',
            ['total_casual_leave', 'total_sick_leave']
        )->get();

        $metas = [];
        foreach ($policies as $policy){
            $metas[$policy->meta_key] = $policy->meta_value;
        }

        return view('backend.hrm.policy', compact(
            'metas'
        ));
    }
}
