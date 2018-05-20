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
Route::get(
    '/set-locale/{lang}', function ($lang) {
        //set user wanted locale to session
        session('user_locale', $lang);
        dd(session('user_locale'));
        return redirect()->back();
    }
);
