<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Employee;
use App\IClass;
use App\PasswordReset;
use App\Permission;
use App\Registration;
use App\Role;
use App\Subject;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\AppHelper;

class UserController extends Controller
{

    protected $hasher;
    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
    }


    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function login()
    {   
        return view('backend.user.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {

        //validate form
        $this->validate(
            $request, [
            'username' => 'required',
            'password' => 'required',
            ]
        );

        $username = $request->get('username');
        $password = $request->get('password');
        $remember=$request->has('remember');

        if (Auth::attempt(['username' => $username, 'password' => $password, 'status' => AppHelper::ACTIVE], $remember)) {
            session(['user_session_sha1' => AppHelper::getUserSessionHash()]);
            session(['user_role_id' => auth()->user()->role->role_id]);

            $appSettings = AppHelper::getAppSettings(null, true);
            Cache::put('default_academic_year', AppHelper::getAcademicYear());

            $msgType = "success";
            $msg = "Welcome to admin panel.";

            if(!count($appSettings)){
                $msgType = "warning";
                $msg = "Please update institute information <a href='".route('settings.institute')."'> <b>Here</b></a>";
            }

            return redirect()->intended('dashboard')->with($msgType, $msg);

        }
        return redirect()->route('login')->with('error', 'Your email/password combination was incorrect OR account disabled!');
    }


    /**
     * Handle an user logout.
     *
     * @return Response
     */
    public function logout()
    {     
        Auth::logout();
        return redirect()->route('login')->with('success', 'Your are now logged out!');    
    }

    /**
     * Handle an user lock screen.
     *
     * @return Response
     */
    public function lock()
    {
        $username = auth()->user()->username;
        $name = auth()->user()->name;
        Auth::logout();
        return view('backend.user.lock', compact('username','name'));
    }

    /**
     * Handle an user forgot password.
     *
     * @return Response
     */
    public function forgot(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form

            $this->validate($request, [
                'email' => 'required|email',
                'captcha' => 'required|captcha'
            ]);

            $user = User::where('email', $request->get('email'))->first();
            if(!$user){
                return redirect()->route('forgot')->with('error', 'Account not found on this system!');
            }

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );


            if(Password::RESET_LINK_SENT){
                return redirect()->route('forgot')->with('success', 'A mail has been send to your e-mail address. Follow the given instruction to reset your password.');

            }

            return redirect()->route('forgot')->with('error', 'Password reset link could not send! Try again later or contact support.');


        }


        return view('backend.user.forgot');
    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Handle an user reset password.
     *
     * @return Response
     */


    public function reset(Request $request, $token)
    {

        //for save on POST request
        if ($request->isMethod('post')) {
            //validate form

            $this->validate($request, [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8|max:50',
            ]);

            $token = $request->get('token');
            $email = $request->get('email');
            $password = $request->get('password');
            $reset = PasswordReset::where('email', $email)->first();
            if($reset) {
                //token expiration checking, allow 24 hrs only
                $today =  Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
                $createdDate = Carbon::parse($reset->created_at);
                $hoursGone = $today->diffInHours($createdDate);
                if($this->hasher->check($token, $reset->token) && $hoursGone <= 24) {
                    $user = User::where('email', '=', $email)->first();
                    $user->password = bcrypt($password);
                    $user->save();
                    $reset->delete();

                    return redirect()->route('login')->with('success', 'Password successfully reset. Login now :)');

                }
            }

            return redirect()->route('forgot')->with('error', 'User not found with this mail or token invalid or expired!');


        }

        return view('backend.user.reset', compact('token'));
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function dashboard(Request $request)
    {
        $userRoleId = session('user_role_id',0);
        $teachers = 0;
        $employee = 0;
        $students = 0;
        $subjects = 0;
        $attendanceChartPresentData = [];
        $attendanceChartAbsentData = [];

        //only admin
        if($userRoleId == AppHelper::USER_ADMIN){
            //these models records count
            [$teachers, $employee, $students, $subjects] = $this->getStatisticData();
        }

        //all user except students
        if($userRoleId != AppHelper::USER_STUDENT) {
            //attendance chart data
            [$attendanceChartPresentData, $attendanceChartAbsentData] = $this->getClassWiseTodayAttendanceCount();
        }

        return view('backend.user.dashboard', compact(
            'teachers',
            'employee',
            'students',
            'subjects',
            'userRoleId',
            'attendanceChartPresentData',
            'attendanceChartAbsentData'
        ));
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function profile(Request $request)
    {

        $isPost = false;

        $user = User::where('id',auth()->user()->id)->with('role')->first();


        $userRole = Role::where('id',$user->role->role_id)->first();


        if ($request->isMethod('post')) {
            $isPost = true;
            //validate form
            $this->validate($request, [
                'username' => 'required|min:5',
                'email' => 'required|email',
                'name' => 'required|min:5|max:255',
                'phone_no' => 'nullable|max:15',
            ]);
            $isExists = false;
            $oldUsername = $user->username;
            $oldEmail = $user->email;
            $newUserName = $request->get('username');
            $newEmail = $request->get('email');
            if($oldUsername != $newUserName){
                $existUsers = User::where('username',$newUserName)->count();
                if($existUsers){
                    session()->flash('error', 'Username already exists for another account!');
                    $isExists = true;
                }

            }

            if($oldEmail != $newEmail){
                $existUsers = User::where('email',$newEmail)->count();
                if($existUsers){
                    session()->flash('error', 'Email already exists for another account!');
                    $isExists = true;
                }

            }

            if(!$isExists){
                $user->name = $request->get('name');
                $user->phone_no = $request->get('phone_no','');
                $user->email = $newEmail;
                $user->username = $newUserName;
                $user->save();

                return redirect()->route('profile')->with('success', 'Profile updated.');

            }

        }

        return view('backend.user.profile', compact('user','isPost', 'userRole'));
    }/**


     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function changePassword(Request $request)
    {

        if ($request->isMethod('post')) {
            Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
                return Hash::check($value, current($parameters));
            });
            $messages = [
                'old_password.old_password' => 'Old passord doesn\'t match!',

            ];

            $user = auth()->user();
            //validate form
            $this->validate($request, [
                'old_password' => 'required|min:6|max:50|old_password:'.$user->password,
                'password' => 'required|confirmed|min:6|max:50',
            ], $messages);

            $user->password = bcrypt($request->get('password'));
            $user->save();
            Auth::logout();
            return redirect()->route('login')->with('success', 'Password successfully change. Login now :)');


        }
        return view('backend.user.change_password');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $users = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.role_id', '<>', AppHelper::USER_ADMIN)
            ->select('users.*','roles.name as role')
            ->get();

        return view('backend.user.list', compact('users'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '<>', AppHelper::USER_ADMIN)->pluck('name', 'id');
        $user = null;
        $role = null;
        return view('backend.user.add', compact('roles','user', 'role'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email',
                'username' => 'required|min:5|max:255|unique:users,username',
                'password' => 'required|min:6|max:50',
                'phone_no' => 'nullable|max:15',
                'role_id' => 'required|numeric',

            ]
        );

        $data = $request->all();

        if($data['role_id'] == AppHelper::USER_ADMIN){
            return redirect()->route('user.create')->with("error",'Do not mess with the system!!!');

        }

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
                    'role_id' => $data['role_id']
                ]
            );

            DB::commit();


            //now notify the admins about this record
             $msg = $data['name']." user added by ".auth()->user()->name;
             $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('user.create')->with('success', 'User added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('user.create')->with("error",$message);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
//            ->where('user_roles.role_id', '<>', AppHelper::USER_ADMIN)
//            ->where('users.id', $id)
//            ->first();
//        if(!$user){
//            abort(404);
//        }
//
//        return view('backend.user.view', compact('teacher'));
//
//
//    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '<>', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }


        $roles = Role::where('id', '<>', AppHelper::USER_ADMIN)->pluck('name', 'id');
        $role = $user->role_id;

        return view('backend.user.add', compact('user','roles','role'));

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
        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '<>', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }
        //validate form
        $this->validate($request, [
        'name' => 'required|min:5|max:255',
        'email' => 'email|max:255|unique:users,email,'.$user->id,
        'role_id' => 'required|numeric',
         'phone_no' => 'nullable|max:15',

        ]);

        if($request->get('role_id') == AppHelper::USER_ADMIN){
            return redirect()->route('user.index')->with("error",'Do not mess with the system!!!');

        }


        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data['phone_no'] = $request->get('phone_no');
        $user->fill($data);
        $user->save();

        if($user->role_id != $request->get('role_id')){
            DB::table('user_roles')->where('user_id', $user->id)->update([
                'role_id' => $request->get('role_id'),
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->id
            ]);
        }

        return redirect()->route('user.index')->with('success', 'User updated!');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

         $user =  User::findOrFail($id);

        if($user->id == auth()->user()->id){
            return redirect()->route('user.index')->with('error', 'You can\'t update yourself!');

        }

         $userRole = UserRole::where('user_id', $user->id)->first();
         if($userRole && $userRole->role_id == AppHelper::USER_ADMIN){
             return redirect()->route('user.index')->with('error', 'Don not mess with the system');

         }

         $message = "Something went wrong!";
        DB::beginTransaction();
        try {

            DB::table('user_roles')->where('user_id', $user->id)->update([
                'deleted_by' => auth()->user()->id,
                'deleted_at' => Carbon::now()
            ]);

            //delink related child record
            //employee and student
            $user->employee()->update(['user_id' => null]);
            $user->student()->update(['user_id' => null]);

            $user->delete();

            DB::commit();

            //now notify the admins about this record
            $msg = $user->name." user deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            //flash this user permission cache
            Cache::forget('permission'.auth()->user()->id);
            Cache::forget('roles'.auth()->user()->id);

            return redirect()->route('user.index')->with('success', 'User deleted.');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
        }

        return redirect()->route('user.index')->with("error",$message);



    }

    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $user =  User::findOrFail($id);

        if(!$user){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        if($user->id == auth()->user()->id){
            return [
                'success' => false,
                'message' => 'You can\'t change your own status!'
            ];

        }

        $userRole = UserRole::where('user_id', $user->id)->first();

        if($userRole && $userRole->role_id == AppHelper::USER_ADMIN){
            return [
                'success' => false,
                'message' => 'Don not mess with the system!'
            ];

        }

        $user->status = (string)$request->get('status');
        $user->force_logout = (int)$request->get('status') ? 0 : 1;
        $user->save();

        //flash this user permission cache
        Cache::forget('permission'.auth()->user()->id);
        Cache::forget('roles'.auth()->user()->id);

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }


    /**
     * update permission
     * @return mixed
     */
    public function updatePermission(Request $request, $id)
    {
        $user =  User::findOrFail($id);
        if($user->id == auth()->user()->id){
            return redirect()->route('user.index')->with('error', 'You can\'t update your permission!');

        }

        $userRole = UserRole::where('user_id', $user->id)->first();

        if($userRole && $userRole->role_id == AppHelper::USER_ADMIN){
            return redirect()->route('user.index')->with('error', 'Don not mess with the system.');

        }

        //for save on POST request
        if ($request->isMethod('post')) {

            $permissionList = $request->get('permissions', []);

            $message = "Something went wrong!";
            DB::beginTransaction();
            try {

            //now delete previous permissions
            DB::table('users_permissions')->where('user_id', $user->id)->update([
                'deleted_by' => auth()->user()->id,
                'deleted_at' => Carbon::now()
            ]);

            //then insert new permissions
            $userPermissions = $this->proccessInputPermissions($permissionList, 'user_id', $user->id, auth()->user()->id);
            DB::table('users_permissions')->insert($userPermissions);

            DB::commit();

                //now notify the admins about this record
                $msg = $user->name." user permission updated by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end

                //flush the permission cache also other cache
                Cache::flush();

            return redirect()->route('user.index')->with('success', 'User Permission Updated.');

            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            }

            return redirect()->route('user.index')->with('error', $message);
        }



        $userPermissions = DB::table('users_permissions')->where('user_id', $user->id)
            ->whereNull('deleted_at')->pluck('permission_id')->toArray();

        $permissions = Permission::select('id','name','group')
            ->whereNotIn('group',['Administration', 'Administration Exclusive', 'Common'])
            ->orderBy('group','asc')->get();

        $permissionList = $this->formatPermissions($permissions, $userPermissions);

        return view('backend.user.permission', compact('permissionList', 'user'));

    }




    /**
     * role manage
     * @param $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roles(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);

            $id = $request->get('hiddenId',0);
            $role = Role::findOrFail($id);

            if(!$role->deletable){
                return redirect()->route('user.role_index')->with('error', 'You can\'t delete this role?');
            }

            //check if this role has active user
            $users = UserRole::where('role_id', $role->id)->count();
            if($users){
                return redirect()->route('user.role_index')->with('error', 'Role has users, So can\'t delete it!');
            }


            $message = "Something went wrong!";
            DB::beginTransaction();
            try {

                DB::table('roles_permissions')->where('role_id', $id)->update([
                    'deleted_by' => auth()->user()->id,
                    'deleted_at' => Carbon::now()
                ]);

                $role->delete();

                DB::commit();

                //now notify the admins about this record
                $msg = $role->name." role deleted by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end

                //flush the permission cache also other cache
                Cache::flush();

                return redirect()->route('user.role_index')->with('success', 'Role deleted!');

            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            }



            return redirect()->route('user.role_index')->with('error', $message);
        }

        //for get request
        $roles = Role::get();

        return view('backend.role.list', compact('roles'));
    }

    /**
     * role create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleCreate(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|min:4|max:255|unique:roles',
            ]);


            $role = Role::create([
                'name' => $request->get('name')
            ]);


            $permissionList = $request->get('permissions');

            if(count($permissionList)){

                $rolePermissions = $this->proccessInputPermissions($permissionList,'role_id', $role->id, auth()->user()->id);

                DB::table('roles_permissions')->insert($rolePermissions);

            }

            //now notify the admins about this record
            $msg = $request->get('name')." role created by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            //flush the permission cache also other cache
            Cache::flush();

            return redirect()->route('user.role_index')->with('success', 'Role Created.');
        }


       $permissions = Permission::select('id','name','group')
           ->whereNotIn('group',['Administration', 'Administration Exclusive', 'Common'])
           ->orderBy('group','asc')->get();

        $permissionList = $this->formatPermissions($permissions);
        $role = null;

        return view('backend.role.add', compact('permissionList', 'role'));
    }

    /**
     * role create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleUpdate(Request $request, $id)
    {
        //check if it is admin role then and not super admin, reject from modify
        if($id == AppHelper::USER_ADMIN){
            return redirect()->route('user.role_index')->with('error', 'Don not mess with the system');
        }

        //collect role info and permissions
        $role = Role::findOrFail($id);

        //for save on POST request
        if ($request->isMethod('post')) {

            $permissionList = $request->get('permissions', []);

            $message = "Something went wrong!";
            DB::beginTransaction();
            try {

                //now delete previous permissions
                DB::table('roles_permissions')->where('role_id', $id)->update([
                    'deleted_by' => auth()->user()->id,
                    'deleted_at' => Carbon::now()
                ]);

                //then insert new permissions
                $rolePermissions = $this->proccessInputPermissions($permissionList, 'role_id', $role->id, auth()->user()->id);
                DB::table('roles_permissions')->insert($rolePermissions);

                DB::commit();

                //now notify the admins about this record
                $msg = $role->name." role updated by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end

                //flush the permission cache also other cache
                Cache::flush();

                return redirect()->route('user.role_index')->with('success', 'Role Permission Updated.');

            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            }

            return redirect()->route('user.role_index')->with('error', $message);
        }


        $rolePermissions = DB::table('roles_permissions')->where('role_id', $role->id)->whereNull('deleted_at')->pluck('permission_id')->toArray();


        $excludePermissionGroups = ['Administration', 'Administration Exclusive', 'Common'];
        if($id == AppHelper::USER_ADMIN){
            $excludePermissionGroups = ['Common'];
        }
        $permissions = Permission::select('id','name','group')
            ->whereNotIn('group', $excludePermissionGroups)
            ->orderBy('group','asc')->get();

        $permissionList = $this->formatPermissions($permissions, $rolePermissions);

        return view('backend.role.add', compact('permissionList', 'role'));
    }

    private function formatPermissions($permissions, $rolePermissions=null){
        //now build the structure to view on blade
        //$permissionList[group_name][module_name][permission_verb][permission_ids]
        $permissionList = [];

        foreach ($permissions as $permission){

            $namePart = preg_split("/\s+(?=\S*+$)/",$permission->name);
            $moduleName = $namePart[0];
            $verb = $namePart[1];

            $permissionList[$permission->group][$moduleName][$verb]['ids'][] = $permission->id;

            if($rolePermissions){
                $permissionList[$permission->group][$moduleName][$verb]['checked'] = in_array($permission->id, $rolePermissions) ? 1 : 0;

            }
            else{
                $permissionList[$permission->group][$moduleName][$verb]['checked'] = 0;

            }
        }

        return $permissionList;

    }

    private function proccessInputPermissions($permissionList, $type, $roleOrUserId, $loggedInUser){

        $rolePermissions = [];

        $now = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        if(!empty($permissionList) && count($permissionList)) {

            foreach ($permissionList as $permissions) {
                $permissions = explode(',', $permissions);
                foreach ($permissions as $permission) {
                    $rolePermissions[] = [
                        $type => $roleOrUserId,
                        'permission_id' => $permission,
                        'created_at' => $now,
                        'updated_at' => $now,
                        'created_by' => $loggedInUser,
                        'updated_by' => $loggedInUser,
                    ];
                }
            }


        }

        //now add common permissions
        $permissions = Permission::select('id')->where('group', 'Common')->get();
        foreach ($permissions as $permission) {
            $rolePermissions[] = [
                $type => $roleOrUserId,
                'permission_id' => $permission->id,
                'created_at' => $now,
                'updated_at' => $now,
                'created_by' => $loggedInUser,
                'updated_by' => $loggedInUser,
            ];
        }

        return $rolePermissions;
    }

   /**
    *  Dashboard data helper methods
    */
   private function getAcademicYearForDashboard() {
       $academicYearId = 0;
       if (AppHelper::getInstituteCategory() == 'college') {
           $academicYearInfo = AcademicYear::where('status', AppHelper::ACTIVE)
               ->where('title', env('DASHBOARD_STUDENT_COUNT_DEFAULT_ACADEMIC_YEAR',date('Y')))->first();
           if ($academicYearInfo) {
               $academicYearId = $academicYearInfo->id;
           }
       } else {
           $academicYearId = AppHelper::getAcademicYear();
       }

       return $academicYearId;
   }

   private function getStatisticData() {
       $teachers = Cache::rememberForever('teacherCount' , function () {
           return   Employee::where('status', AppHelper::ACTIVE)->where('role_id', AppHelper::EMP_TEACHER)->count();
       });

       $employee = Cache::rememberForever('employeeCount' , function () {
           return Employee::where('status', AppHelper::ACTIVE)->count();
       });
       $academicYearId = $this->getAcademicYearForDashboard();
       $students = Cache::rememberForever('studentCount' , function () use($academicYearId) {
           return Registration::where('status', AppHelper::ACTIVE)
               ->where('academic_year_id', $academicYearId)
               ->count();
       });
       $subjects = Cache::rememberForever('SubjectCount' , function () {
           return Subject::where('status', AppHelper::ACTIVE)->count();
       });

       return [$teachers, $employee, $students, $subjects];
   }

   private function getClassWiseTodayAttendanceCount() {
       $academicYearId = $this->getAcademicYearForDashboard();
       $iclasses = Cache::rememberForever('student_attendance_count' , function () use($academicYearId) {
           return  IClass::where('status', AppHelper::ACTIVE)
               ->with(['attendance' => function ($query) use ($academicYearId) {
                   $query->selectRaw('class_id,present,count(registration_id) as total')
                       ->where('academic_year_id', $academicYearId)
                       ->whereDate('attendance_date', date('Y-m-d'))
//                        ->whereDate('attendance_date', '2019-03-02')
                       ->groupBy('class_id', 'present');
               }])
               ->select('id', 'name')
               ->orderBy('order','asc')
               ->get();
       });

       $attendanceChartPresentData = [];
       $attendanceChartAbsentData = [];
       foreach ($iclasses as $iclass) {
           $attendanceChartPresentData[$iclass->name] = 0;
           $attendanceChartAbsentData[$iclass->name] = 0;
           foreach ($iclass->attendance as $attendanceSummary) {
               if ($attendanceSummary->present == "Present") {
                   $attendanceChartPresentData[$iclass->name] = $attendanceSummary->total;
               } else {
                   $attendanceChartAbsentData[$iclass->name] = $attendanceSummary->total;

               }
           }
       }

       return [$attendanceChartPresentData, $attendanceChartAbsentData];
   }

}
