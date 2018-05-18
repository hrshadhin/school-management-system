<?php

use App\Helpers\AppHelper;
/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(
    function ($request) {
        //
    }
);


App::after(
    function ($request, $response) {
        //
    }
);

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter(
    'auth', function () {

        if (Auth::user()) {
            Session::put('userRole', Auth::user()->group);
            $cHash =  Session::get('user_session_sha1');
            $commitHash = substr(strrev('f967c2d078f47fba0d4300ae6fc3e98b5332192a'), 0, 7);
            if ($cHash != $commitHash) {
                \Auth::logout();
                return Redirect::to('/')->with('error', 'CRV: Application encounted problems.Please contact ShanixLab at [hello@hrshadhin.me]');
               
            }
        }
        
        if (Auth::guest()) {
            if (Request::ajax()) {
                return Response::make('Unauthorized', 401);
            }
            else
            {
                return Redirect::guest('/');
            }
        }

    }
);


Route::filter(
    'auth.basic', function () {
        return Auth::basic();
    }
);

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter(
    'guest', function () {
        if (Auth::check()) { return Redirect::to('/');
        }
    }
);

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter(
    'csrf', function () {

        if (Session::token() != Input::get('_token')) {
            throw new Illuminate\Session\TokenMismatchException;
        }
    }
);

Route::filter(
    'userAccess', function () {
        if (Auth::user()) {
            if (Auth::user()->group != "Admin") {
                return Redirect::to('/dashboard')->with("accessdined", "You don't have permission to do that!!!");
            }
        }
    }
);

Route::filter(
    'admin_or_management', function () {
        if (Auth::user()) {
            if (Auth::user()->group != "Admin" && Auth::user()->group != "Management") {
                return Redirect::to('/dashboard')->with("accessdined", "You don't have permission to do that!!!");
            }
        }
    }
);

Route::filter(
    'management', function () {
        if (Auth::user()) {
            if (Auth::user()->group != "Admin") {
                return Redirect::to('/dashboard')->with("accessdined", "You don't have permission to do that!!!");
            }
        }
    }
);