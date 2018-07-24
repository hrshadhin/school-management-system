<?php

namespace App\Http\Controllers\Backend;

use App\Models\PasswordResets;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

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

        if (Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            return redirect()->intended('site/dashboard')->with('success', 'Welcome to admin panel.');

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
                'password' => 'required|confirmed|min:6',
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

                    return redirect()->route('login')->with('success', 'Password succesfully reset. Login now :)');

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
    public function dashboard()
    {
        return view('backend.user.dashboard');
    }
}
