<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teachers = Employee::where('emp_type', AppHelper::EMP_TEACHER)->get();

        return view('backend.teacher.list', compact('teachers'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teacher = null;
        $gender = 1;
        $religion = 1;
        return view('backend.teacher.add', compact('teacher', 'gender', 'religion'));
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
            'photo.dimensions' => 'The :attribute dimensions must be 600 X 600.',
        ];
        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=600,min_height=600,max_width=600,max_height=600',
                'designation' => 'max:255',
                'qualification' => 'max:255',
                'dob' => 'min:10',
                'gender' => 'required|integer',
                'religion' => 'required|integer',
                'email' => 'email|max:255|unique:employees,email|unique:users,email',
                'phone_no' => 'required|min:8|max:255',
                'address' => 'max:500',
                'id_card' => 'required|min:4|max:50|unique:employees,id_card',
                'joining_date' => 'min:10',
                'username' => 'required|min:5|max:255|unique:users,username',
                'password' => 'required|min:6|max:50',

            ]
        );

        if($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store('public/employee');
            $fileName = basename($storagepath);
            $data['photo'] = $fileName;
        }
        else{
            $data['photo'] = $request->get('oldPhoto','');
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
        $data['emp_type'] = AppHelper::EMP_TEACHER;

        DB::beginTransaction();
        try {
            //now create user
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
                    'role_id' => AppHelper::USER_TEACHER
                ]
            );
            $data['user_id'] = $user->id;
            // now save employee
            Employee::create($data);


            DB::commit();

            return redirect()->route('teacher.create')->with('success', 'Teacher added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return $message;
            return redirect()->route('teacher.create')->with("error",$message);
        }

        return redirect()->route('teacher.create');


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Employee::with('user')->where('emp_type', AppHelper::EMP_TEACHER)->where('id', $id)->first();
        if(!$teacher){
            abort(404);
        }

        return view('backend.teacher.view', compact('teacher'));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = Employee::where('emp_type', AppHelper::EMP_TEACHER)->where('id', $id)->first();

        if(!$teacher){
            abort(404);
        }
        $gender = $teacher->gender;
        $religion = $teacher->religion;

        return view('backend.teacher.add', compact('teacher', 'gender', 'religion'));

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
        $teacher = Employee::where('emp_type', AppHelper::EMP_TEACHER)->where('id', $id)->first();

        if(!$teacher){
            abort(404);
        }
        //validate form
        $messages = [
            'photo.max' => 'The :attribute size must be under 200kb.',
            'photo.dimensions' => 'The :attribute dimensions must be 600 X 600.',
        ];
        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=600,min_height=600,max_width=600,max_height=600',
                'designation' => 'max:255',
                'qualification' => 'max:255',
                'dob' => 'min:10',
                'gender' => 'required|integer',
                'religion' => 'required|integer',
                'email' => 'email|max:255|unique:employees,email,'.$teacher->id.'|unique:users,email,'.$teacher->user_id,
                'phone_no' => 'required|min:8|max:255',
                'address' => 'max:500',
                'id_card' => 'required|min:4|max:50|unique:employees,id_card,'.$teacher->id,
                'joining_date' => 'min:10',

            ]
        );

        if($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store('public/employee');
            $fileName = basename($storagepath);
            $data['photo'] = $fileName;
        }
        else{
            $data['photo'] = $request->get('oldPhoto','');
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

        $teacher->fill($data);
        $teacher->save();

        return redirect()->route('teacher.index')->with('success', 'Teacher updated!');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Employee::where('emp_type', AppHelper::EMP_TEACHER)->where('id', $id)->first();
        if(!$teacher){
            abort(404);
        }
        $teacher->delete();
        return redirect()->route('teacher.index')->with('success', 'Teacher deleted.');

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
}
