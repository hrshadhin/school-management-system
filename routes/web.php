<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/', function () {
        return view('welcome');
    }
);

Route::group(
    ['namespace' => 'backend', 'middleware' => ['web','guest']], function () {
        Route::get('/login', 'UserController@login')->name('login');
        Route::post('/login', 'UserController@authenticate');        
        Route::get('/forgot', 'UserController@forgot')->name('forgot');        
        Route::post('/forgot', 'UserController@forgotPost')->name('forgot_post');        
        Route::get('/reset/{token}', 'UserController@reset')->name('reset');        
        Route::post('/reset/{token}', 'UserController@resetPost')->name('reset_post');        
    }
);

Route::group(
    ['namespace' => 'backend', 'middleware' => 'auth'], function () {
        Route::get('/logout', 'UserController@logout')->name('logout');
        Route::get('/lock', 'UserController@lock')->name('lockscreen');
        Route::resource('user', 'UserController');
        Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');
    }
);

//
//        Route::get(
//            '/set-locale/{lang}', function ($lang) {
//                //set user wanted locale to session
//                session('user_locale', $lang);
//                dd(session('user_locale'));
//                return redirect()->back();
//            }
//        );
