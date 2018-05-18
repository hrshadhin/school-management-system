<?php


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\AppHelper;



class UsersController extends \BaseController
{
    public function __construct() 
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('show','create','edit','update')));
        $this->beforeFilter('userAccess', array('only'=> array('show','create','edit','update','delete')));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function postSignin() 
    {
        if (\Auth::attempt(array('login'=>Input::get('login'), 'password'=>Input::get('password')))) {
            $name=Auth::user()->firstname.' '.Auth::user()->lastname;
            Session::put('name', $name);

            Session::put('user_session_sha1', AppHelper::getUserSessionHash());


            $institute=Institute::select('name')->first();
      
            if(!$institute) {
                if (Auth::user()->group != "Admin") {
                    return Redirect::to('/')
                    ->withInput(Input::all())->with('error', 'Institute Information not setup yet!Please contact administrator.');
                }
                else {
                    $institute=new Institute;
                    $institute->name="ShanixLab";
                    Session::put('inName', $institute->name);
                    return Redirect::to('/institute')->with('error', 'Please provide institute information!');

                }
            }
            else {
                Session::put('inName', $institute->name);
                Session::put('inNameShort', AppHelper::getShortName($institute->name));
                return Redirect::to('/dashboard')->with('success', 'You are now logged in.');
            }

        } else {
            return Redirect::to('/')
            ->withInput(Input::all())->with('error', 'Your username/password combination was incorrect');

        }

    }



    public function getLogout() 
    {
        Session::flush();
        \Auth::logout();
        return Redirect::to('/')->with('message', 'Your are now logged out!');
    }

    public  function show()
    {
        $users= User::all();
        $user=array();
        return View::Make('app.users', compact('users', 'user'));
    }
    public  function create()
    {
        $rules=[
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'group' => 'required',
        'desc' => 'required',
        'login' => 'required',
        'password' => 'required'

        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/users')->withInput(Input::all())->withErrors($validator);
        }
        else {

            $uexits = User::select('*')->where('email', '=', Input::get('email'))->orwhere('login', '=', Input::get('login'))->get();
            if(count($uexits)>0) {
                $errorMessages = new Illuminate\Support\MessageBag;
                $errorMessages->add('deplicate', 'User all ready exists with this email or login');
                return Redirect::to('/users')->withInput(Input::all())->withErrors($errorMessages);

            }
            {
            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->login = Input::get('login');
            $user->desc = Input::get('desc');
            $user->email = Input::get('email');
            $user->group = Input::get('group');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            return Redirect::to('/users')->with("success", "User Created Succesfully.");
            }


        }
    }
    public function edit($id)
    {
        $user = User::find($id);
        $users= User::all();
        return View::Make('app.users', compact('users', 'user'));

    }
    public  function update()
    {
        $rules=[
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'group' => 'required',
        'desc' => 'required',
        'login' => 'required',
        'password' => 'required'

        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/usersedit/'.Input::get('id'))->withErrors($validator);
        }
        else {

            $uexits = User::select('*')->where('email', '=', Input::get('email'))->first();
            if(count($uexits)>0) {
                if ($uexits->id != Input::get('id')) {
                    $errorMessages = new Illuminate\Support\MessageBag;
                    $errorMessages->add('deplicate', 'User all ready exists with this email');
                    return Redirect::to('/users')->withInput(Input::all())->withErrors($errorMessages);
                } else {
                    $user = User::find(Input::get('id'));
                    $user->firstname = Input::get('firstname');
                    $user->lastname = Input::get('lastname');
                    // $user->login = Input::get('login');
                    $user->desc = Input::get('desc');
                    $user->email = Input::get('email');
                    $user->group = Input::get('group');
                    $user->password = Hash::make(Input::get('password'));
                    $user->save();
                    return Redirect::to('/users')->with("success", "User Updated Succesfully.");
                }
            }
            else
            {
                $user = User::find(Input::get('id'));
                $user->firstname = Input::get('firstname');
                $user->lastname = Input::get('lastname');
                // $user->login = Input::get('login');
                $user->desc = Input::get('desc');
                $user->email = Input::get('email');
                $user->group = Input::get('group');
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                return Redirect::to('/users')->with("success", "User Updated Succesfully.");
            }

        }
    }

    public function delete($id)
    {
        $user= User::find($id);
        $user->delete();
        return Redirect::to('/users')->with("success", "User Deleted Succesfully.");

    }
}
