<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\Models\PasswordResets;
use App\Role;
use App\Student;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

            $appSettings = AppHelper::getAppSettings();

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
                'password' => 'required|confirmed|min:6|max:50',
            ]);

            $token = $request->get('token');
            $email = $request->get('email');
            $password = $request->get('password');
            $reset = PasswordResets::where('email', $email)->first();
            if($reset) {
                //token expiration checking, allow 24 hrs only
                $today =  Carbon::now(new \DateTimeZone('Asia/Dhaka'));
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

        $teachers = Employee::where('emp_type', AppHelper::EMP_TEACHER)->count();
        $students = Student::count();

        return view('backend.user.dashboard', compact('teachers','students'));
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function profile(Request $request)
    {

        $isPost = false;
        $user = auth()->user();
        $role = Role::where('id', $user->role->role_id)->first();


        if ($request->isMethod('post')) {
            $isPost = true;
            //validate form
            $this->validate($request, [
                'username' => 'required|min:5',
                'email' => 'required|email',
                'name' => 'required|min:5|max:255',
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
                $user->email = $newEmail;
                $user->username = $newUserName;
                $user->save();

                return redirect()->route('profile')->with('success', 'Profile updated.');

            }

        }

        return view('backend.user.profile', compact('user','isPost','role'));
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

            return redirect()->route('user.create')->with('success', 'User added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return $message;
            return redirect()->route('user.create')->with("error",$message);
        }

        return redirect()->route('user.create');


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
        $this->validate(
             $request, [
        'name' => 'required|min:5|max:255',
        'email' => 'email|max:255|unique:users,email,'.$user->id,
        'role_id' => 'required|numeric'

            ]
        );

        if($request->get('role_id') == AppHelper::USER_ADMIN){
            return redirect()->route('user.index')->with("error",'Do not mess with the system!!!');

        }


        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $user->fill($data);
        $user->save();

        if($user->role_id != $request->get('role_id')){
            $userRole = UserRole::where('user_id', $user->id)->first();
            $userRole->role_id = $request->get('role_id');
            $userRole->save();
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

         $userRole = UserRole::where('user_id', $user->id)->first();

         if($userRole && $userRole->role_id == AppHelper::USER_ADMIN){
             return redirect()->route('user.index')->with('Error', 'Don not mess with the system');

         }


        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted.');

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

        $user->status = (string)$request->get('status');
        $user->force_logout = (int)$request->get('status') ? 0 : 1;

        $user->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

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

            $role->delete();
            return redirect()->route('user.role_index')->with('success', 'Role deleted!');
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
            ;
            $this->validate($request, [
                'name' => 'required|min:4|max:255',
            ]);


            Role::create([
                'name' => $request->get('name')
            ]);

            return redirect()->route('user.role_index')->with('success', 'Role Created.');
        }


        return view('backend.role.add');
    }


}
