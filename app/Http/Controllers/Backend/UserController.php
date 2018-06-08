<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


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

        $username = $request->input('username');
        $password = $request->input('password');
        $remember=$request->has('remember');

        if (Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            return redirect()->intended('dashboard');

        }

        return back()->with('error', 'Your email/password combination was incorrect OR account disabled!');
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
        $username = \auth()->user()->username;
        Auth::logout();
        return view('backend.user.lock', compact('username'));
    }

    /**
     * Handle an user forgot password.
     *
     * @return Response
     */
    public function forgot()
    {
       
        return view('backend.user.forgot');
    }

    /**
     * Handle an user forgot password.
     *
     * @return Response
     */
    public function forgotPost()
    {
       
        return view('backend.user.forgot');
    }

    /**
     * Handle an user reset password.
     *
     * @return Response
     */
    public function reset()
    {
       
        return view('backend.user.reset');
    }

    /**
     * Handle an user reset password.
     *
     * @return Response
     */
    public function resetPost()
    {
       
        return view('backend.user.reset');
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
