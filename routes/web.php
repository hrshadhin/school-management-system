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


Route::group(
    ['namespace' => 'Frontend', 'middleware' => ['web']], function () {
    Route::get('/', 'HomeController@home')->name('home');
}
);

/**
 * Admin panel routes goes below
 */
Route::group(
    ['namespace' => 'Backend', 'middleware' => ['web','guest']], function () {
    Route::get('/login', 'UserController@login')->name('login');
    Route::post('/login', 'UserController@authenticate');
    Route::get('/forgot', 'UserController@forgot')->name('forgot');
    Route::post('/forgot', 'UserController@forgotPost')
        ->name('forgot_post');
    Route::get('/reset/{token}', 'UserController@reset')
        ->name('reset');
    Route::post('/reset/{token}', 'UserController@resetPost')
        ->name('reset_post');
}
);

Route::group(
    ['namespace' => 'Backend', 'middleware' => 'auth'], function () {
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/lock', 'UserController@lock')->name('lockscreen');
    Route::resource('user', 'UserController');
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');


    /**
     * Website contents routes
     */
    Route::get('/site/dashboard', 'SiteController@dashboard')
        ->name('site.dashboard');
    Route::resource('slider','SliderController');
    Route::get('/site/about-content', 'SiteController@aboutContent')
        ->name('site.about_content');
    Route::post('/site/about-content', 'SiteController@aboutContent')
        ->name('site.about_content');
    Route::get('site/about-content/images','SiteController@aboutContentImage')
        ->name('site.about_content_image');
    Route::post('site/about-content/images','SiteController@aboutContentImage')
        ->name('site.about_content_image');
    Route::post('site/about-content/images/{id}','SiteController@aboutContentImageDelete')
        ->name('site.about_content_image_delete');
    Route::get('site/service','SiteController@serviceContent')
        ->name('site.service');
    Route::post('site/service','SiteController@statisticContent')
        ->name('site.service');
    Route::get('site/statistic','SiteController@statisticContent')
        ->name('site.statistic');
    Route::post('site/statistic','SiteController@statisticContent')
        ->name('site.statistic');

    Route::get('site/testimonial','SiteController@testimonialIndex')
        ->name('site.testimonial');
    Route::post('site/testimonial','SiteController@testimonialIndex')
        ->name('site.testimonial');
    Route::get('site/testimonial/create','SiteController@testimonialCreate')
        ->name('site.testimonial_create');
    Route::post('site/testimonial/create','SiteController@testimonialCreate')
        ->name('site.testimonial_create');

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
