<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\AppHelper;
use App\Registration;
use App\Role;
use App\Template;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\map;

class AdministratorController extends Controller
{
    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $year = AcademicYear::findOrFail($request->get('hiddenId'));

            // now check is academic year set or not
            $settings = AppHelper::getAppSettings();
            $haveStudent = Registration::where('academic_year_id', $year->id)->count();
            if((isset($settings['academic_year']) && (int)$settings['academic_year'] == $year->id) || ($haveStudent > 0)){
                return redirect()->route('administrator.academic_year')->with('error', 'Can not delete it because this year have student or have in default setting.');
            }
            $year->delete();

            return redirect()->route('administrator.academic_year')->with('success', 'Record deleted!');
        }

        //for get request
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();


        return view('backend.administrator.academic.list', compact('academicYears'));
    }

    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            ;
            $this->validate($request, [
                'title' => 'required|min:4|max:255',
                'start_date' => 'required|min:10|max:255',
                'end_date' => 'required|min:10|max:255',
            ]);

            $data = $request->all();
            $datetime = Carbon::createFromFormat('d/m/Y',$data['start_date']);
            $data['start_date'] = $datetime;
            $datetime = Carbon::createFromFormat('d/m/Y',$data['end_date']);
            $data['end_date'] = $datetime;
            if(!$id){
                $data['status'] = '1';
            }

            AcademicYear::updateOrCreate(
                ['id' => $id],
                $data
            );
            $msg = "Academic year ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('administrator.academic_year')->with('success', $msg);
        }

        //for get request
        $academicYear = AcademicYear::find($id);

        return view('backend.administrator.academic.add', compact('academicYear'));
    }

    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearChangeStatus(Request $request, $id=0)
    {
        $year =  AcademicYear::findOrFail($id);
        if(!$year){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $settings = AppHelper::getAppSettings();
        if(isset($settings['academic_year']) && (int)$settings['academic_year'] == $year->id){
            return [
                'success' => false,
                'message' => 'Can not change status! Year is using as academic year right now.'
            ];
        }

        $year->status = (string)$request->get('status');

        $year->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex()
    {

        $users = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->select('users.*','roles.name as role')
            ->get();

        return view('backend.administrator.user.list', compact('users'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userCreate()
    {
        $user = null;
        return view('backend.administrator.user.add', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userStore(Request $request)
    {

        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email',
                'username' => 'required|min:5|max:255|unique:users,username',
                'password' => 'required|min:6|max:50',
                'phone_no' => 'nullable|max:15',

            ]
        );

        $data = $request->all();


        DB::beginTransaction();
        try {
            //now create user
            $user = User::create(
                [
                    'name' => $data['name'],
                    'username' => $request->get('username'),
                    'email' => $data['email'],
                    'phone_no' => $data['phone_no'],
                    'password' => bcrypt($request->get('password')),
                    'remember_token' => null,
                ]
            );
            //now assign the user to role
            UserRole::create(
                [
                    'user_id' => $user->id,
                    'role_id' => AppHelper::USER_ADMIN
                ]
            );

            DB::commit();

            return redirect()->route('administrator.user_create')->with('success', 'System User added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return $message;
            return redirect()->route('administrator.user_create')->with("error",$message);
        }

        return redirect()->route('administrator.user_create');


    }

    public function useredit($id)
    {

        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }


        return view('backend.administrator.user.add', compact('user'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }
        //validate form
        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email,'.$user->id,
                'phone_no' => 'nullable|max:15',
            ]
        );


        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data['phone_no'] = $request->get('phone_no');
        $user->fill($data);
        $user->save();

        return redirect()->route('administrator.user_index')->with('success', 'System User updated!');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function userDestroy($id)
    {

        $user =  User::findOrFail($id);
        $userRole = UserRole::where('user_id', $user->id)->first();

        if(!$userRole){
            return redirect()->route('administrator.user_index')->with('error', 'Don not mess with the system');

        }

        //check if have any other system user or not
        $systemUsers = UserRole::where('role_id', AppHelper::USER_ADMIN)->count();
        if($systemUsers < 2){
            return redirect()->route('administrator.user_index')->with('error', 'System has only one admin user, you can\'t delete it!');
        }

        $user->delete();
        return redirect()->route('administrator.user_index')->with('success', 'Admin user deleted.');

    }

    /**
     * status change
     * @return mixed
     */
    public function userChangeStatus(Request $request, $id=0)
    {

        $user =  User::findOrFail($id);

        if(!$user){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $status = (string)$request->get('status');

        if($status == '0') {
            //check if have any other system user or not
            $systemUsers = UserRole::where('role_id', AppHelper::USER_ADMIN)->get();
            $ids = $systemUsers->map(function ($ur) use ($systemUsers) {
                return $ur->user_id;
            });
            $users = User::where('status', '1')->whereIn('id', $ids)->count();
            if ($users < 2) {
                return [
                    'success' => false,
                    'message' => 'System has only one admin user, you can\'t disable it!'
                ];
            }
        }

        $user->status = $status;
        $user->force_logout = (int)$status ? 0 : 1;
        $user->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }


    /* Handle an user password change
    *
    * @return Response
    */
    public function userResetPassword(Request $request)
    {

        if ($request->isMethod('post')) {

            $user = User::findOrFail($request->get('user_id'));
            //validate form
            $this->validate($request, [
                'password' => 'required|confirmed|min:6|max:50',
            ]);

            $user->password = bcrypt($request->get('password'));
            $user->force_logout = 1;
            $user->save();

            return redirect()->route('administrator.user_password_reset')->with('success', 'Password successfully changed.');

        }

        $users = User::select(DB::raw("CONCAT(name,'[',username,']') AS name"),'id')->where('status', '1')->pluck('name','id');

        return view('backend.administrator.user.change_password', compact('users'));
    }


    /**
     * Mail and sms template  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templateMailAndSmsIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $template = Template::findOrFail($request->get('hiddenId'));

            // now check is tempalte currently used ??
            $studnetAttendaceTeplate = AppHelper::getAppSettings('student_attendance_template');
            $employeeAttendaceTeplate = AppHelper::getAppSettings('employee_attendance_template');

            if($template->id == $studnetAttendaceTeplate || $template->id == $employeeAttendaceTeplate){
                return redirect()->route('administrator.template.mailsms.index')->with('error', 'Can not delete it because this template is being used.');
            }
            $template->delete();

            return redirect()->route('administrator.template.mailsms.index')->with('success', 'Template deleted!');
        }

        //if it is ajax request then send json response with formated data
        if($request->ajax()){

            $userRole = $request->query->get('user','');

            $for = AppHelper::USER_TEACHER;
            if($userRole == "student"){
                $for = AppHelper::USER_STUDENT;
            }


            $templates = Template::where('type',$request->query->get('type',0))
                ->where('role_id', $for)->get();

            $data = [];
            foreach ($templates as $template){
                $data[] = [
                    'id' => $template->id,
                    'text' => $template->name
                ];
            }

            return response()->json($data);
        }


        //for get request
        // AppHelper::TEMPLATE_TYPE  1=SMS , 2=EMAIL
        $templates = Template::whereIn('type',[1,2])->get();

        return view('backend.administrator.templates.mail_and_sms.list', compact('templates'));
    }

    /**
     * Mail and sms template  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templateMailAndSmsCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'type' => 'required',
                'name' => 'required|min:4|max:255',
                'role_id' => 'required|integer',
            ]);


            $data = [
                'name' => $request->get('name'),
                'type' =>  (integer)$request->get('type'),
                'role_id' => $request->get('role_id'),
                'content' => ($request->get('type') == "2") ? $request->get('content_email') : $request->get('content')
            ];


            Template::updateOrCreate(
                ['id' => $id],
                $data
            );
            $msg = "Template ";
            $msg .= $id ? 'updated.' : 'added.';

            if($id){
                return redirect()->route('administrator.template.mailsms.index')->with('success', $msg);
            }
            return redirect()->route('administrator.template.mailsms.create')->with('success', $msg);
        }

        $role = -1;
        $template = Template::find($id);
        if($template) {
            $role = $template->getOriginal('role_id');
        }

        return view('backend.administrator.templates.mail_and_sms.add', compact('role', 'template'));
    }


    /**
     * ID card template  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templateIdcardIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $template = Template::findOrFail($request->get('hiddenId'));

            // now check is tempalte currently used ??
            $studnetIdcardTeplate = AppHelper::getAppSettings('student_idcard_template');
            $employeeIdcardTeplate = AppHelper::getAppSettings('teacher_idcard_template');

            if($template->id == $studnetIdcardTeplate || $template->id == $employeeIdcardTeplate){
                return redirect()->route('administrator.template.idcard.index')->with('error', 'Can not delete it because this template is being used.');
            }

            $template->delete();

            return redirect()->route('administrator.template.idcard.index')->with('success', 'Template deleted!');
        }

        //if it is ajax request then send json response with formated data
        if($request->ajax()){

            $userRole = $request->query->get('user','');
            $isSingle = $request->query->get('pk',0);

            if($isSingle){
                //if single template call then its preview
                //sow only select on and return json
                $template = Template::where('type',3)
                    ->where('id', $isSingle)->first();
                if(!$template){
                    return response('Template Not Exists!', 404);
                }
                $data = json_decode($template->content);

                return response()->json($data);

            }

            $for = AppHelper::USER_TEACHER;
            if($userRole == "student"){
                $for = AppHelper::USER_STUDENT;
            }

            $templates = Template::where('type',3)
                ->where('role_id', $for)->get();

            $data = [];
            foreach ($templates as $template){
                $data[] = [
                    'id' => $template->id,
                    'text' => $template->name
                ];
            }

            return response()->json($data);
        }


        //for get request
        // AppHelper::TEMPLATE_TYPE  1=SMS , 2=EMAIL, 3=Id card
        $templates = Template::whereIn('type',[3])->get();

        return view('backend.administrator.templates.idcard.list', compact('templates'));
    }

    /**
     * ID card template  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templateIdcardCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {

            $rules = [
                'type' => 'required',
                'name' => 'required|min:4|max:255',
                'role_id' => 'required|integer',
                'logo' => 'mimes:jpeg,jpg,png|max:200|dimensions:max_width=100,max_height=116',
                'signature' => 'mimes:jpeg,jpg,png|max:200|dimensions:max_width=119,max_height=33',
            ];

            $message = [
                'logo.max' => 'The :attribute size must be under 200kb.',
                'logo.dimensions' => 'The :attribute dimensions max 100 X 116.',
                'signature.max' => 'The :attribute size must be under 200kb.',
                'signature.dimensions' => 'The :attribute dimensions max 119 X 33.',
            ];

            if($request->get('type',0) == 3){
                $rules[] = [
                    'title_bg_image' => 'mimes:jpeg,jpg,png|max:200|dimensions:max_width=320,max_height=92|dimensions:min_width=320,min_height=92',
                ];

                $message = [
                    'title_bg_image.max' => 'The :attribute size must be under 200kb.',
                    'title_bg_image.dimensions' => 'The :attribute dimensions exact 320 X 92.',
                ];
            }

            $this->validate($request, $rules, $message);

            $contents = $request->except([
                '_token',
                'type',
                'name',
                'role_id',
                'logo',
                'signature',
                'title_bg_image',
                ]);


            if($id){
                $oldTemplate = Template::findOrFail($id);
                $oldContent = json_decode($oldTemplate->content);
            }

            //now upload logo and signature
            if($request->hasFile('logo')) {
                $logoString = base64_encode(file_get_contents($request->file('logo')));
                $contents['logo'] = $logoString;
            }
            else{
                if($id){
                    $contents['logo'] = $oldContent->logo;
                }
            }

            if($request->hasFile('signature')) {
                $logoString = base64_encode(file_get_contents($request->file('signature')));
                $contents['signature'] = $logoString;
            }
            else{
                if($id){
                    $contents['signature'] = $oldContent->signature;
                }
            }

            if($request->hasFile('title_bg_image')) {
                $signatureString = base64_encode(file_get_contents($request->file('title_bg_image')));
                $contents['title_bg_image'] = $signatureString;
            }else{
                if($id){
                    $contents['title_bg_image'] = $oldContent->title_bg_image;
                }
                else{
                    $contents['title_bg_image'] = null;
                }

            }

            $data = [
                'name' => $request->get('name'),
                'type' =>  (integer)$request->get('type'),
                'role_id' => $request->get('role_id'),
                'content' => json_encode($contents)
            ];


            Template::updateOrCreate(
                ['id' => $id],
                $data
            );
            $msg = "Template ";
            $msg .= $id ? 'updated.' : 'added.';

            if($id){
                return redirect()->route('administrator.template.idcard.index')->with('success', $msg);
            }
            return redirect()->route('administrator.template.idcard.create')->with('success', $msg);
        }

        //for get request
        $template = Template::find($id);
        $formatNo = null;
        $role = null;
        $content = null;

        $roles = [  AppHelper::USER_TEACHER => "Employee", AppHelper::USER_STUDENT => "Student" ];

        if($template) {
            $role = $template->getOriginal('role_id');
            $content = json_decode($template->content);
            $formatNo = $content->format_id;
        }

        return view('backend.administrator.templates.idcard.add', compact( 'template', 'formatNo', 'roles', 'role', 'content'));
    }







}
