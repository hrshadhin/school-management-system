<?php

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//front website routes
Route::group(
    ['namespace' => 'Frontend', 'middleware' => ['frontend']], function () {
    Route::get('/', 'HomeController@home')->name('home');
    Route::post('site/subscribe','HomeController@subscribe')
        ->name('site.subscribe');
    Route::get('/class', 'HomeController@classProfile')->name('site.class_profile');
    Route::get('/class-details/{name}', 'HomeController@classDetails')->name('site.class_details');
    Route::get('/teachers', 'HomeController@teacherProfile')->name('site.teacher_profile');
    Route::get('/events', 'HomeController@event')->name('site.event');
    Route::get('/events-details/{slug}', 'HomeController@eventDetails')->name('site.event_details');
    Route::get('/gallery', 'HomeController@gallery')->name('site.gallery_view');
    Route::get('/contact-us', 'HomeController@contactUs')->name('site.contact_us_view');
    Route::post('/contact-us', 'HomeController@contactUs')->name('site.contact_us_form');
    Route::get('/faq', 'HomeController@faq')->name('site.faq_view');
    Route::get('/timeline', 'HomeController@timeline')->name('site.timeline_view');

});

//change website locale
Route::get('/set-locale/{lang}', function ($lang) {
    //set user wanted locale to session
    Session::put('user_locale', $lang);
    return redirect()->back();
})->name('setLocale');

Route::group(['namespace' => 'Backend', 'middleware' => ['auth','permission']], function () {

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
    Route::post('site/service','SiteController@serviceContent')
        ->name('site.service');
    Route::get('site/statistic','SiteController@statisticContent')
        ->name('site.statistic');
    Route::post('site/statistic','SiteController@statisticContent')
        ->name('site.statistic');

    Route::get('site/testimonial','SiteController@testimonialIndex')
        ->name('site.testimonial');
    Route::post('site/testimonial','SiteController@testimonialIndex')
        ->name('site.testimonial_delete');
    Route::get('site/testimonial/create','SiteController@testimonialCreate')
        ->name('site.testimonial_create');
    Route::post('site/testimonial/create','SiteController@testimonialCreate')
        ->name('site.testimonial_create');

    Route::get('site/subscribe','SiteController@subscribe')
        ->name('site.subscribe');

    Route::resource('class_profile','ClassProfileController');
    Route::resource('teacher_profile','TeacherProfileController');
    Route::resource('event','EventController');
    Route::get('site/gallery','SiteController@gallery')
        ->name('site.gallery');
    Route::get('site/gallery/add-image','SiteController@galleryAdd')
        ->name('site.gallery_image');
    Route::post('site/gallery/add-image','SiteController@galleryAdd')
        ->name('site.gallery_image');
    Route::post('site/gallery/delete-images/{id}','SiteController@galleryDelete')
        ->name('site.gallery_image_delete');
    Route::get('site/contact-us','SiteController@contactUs')
        ->name('site.contact_us');
    Route::post('site/contact-us','SiteController@contactUs')
        ->name('site.contact_us');
    Route::get('site/fqa','SiteController@faq')
        ->name('site.faq');
    Route::post('site/fqa','SiteController@faq')
        ->name('site.faq');
    Route::post('site/faq/{id}','SiteController@faqDelete')
        ->name('site.faq_delete');
    Route::get('site/timeline','SiteController@timeline')
        ->name('site.timeline');
    Route::post('site/timeline','SiteController@timeline')
        ->name('site.timeline');
    Route::post('site/timeline/{id}','SiteController@timelineDelete')
        ->name('site.timeline_delete');
    Route::get('site/settings','SiteController@settings')
        ->name('site.settings');
    Route::post('site/settings','SiteController@settings')
        ->name('site.settings');
    Route::get('site/analytics','SiteController@analytics')
        ->name('site.analytics');
    Route::post('site/analytics','SiteController@analytics')
        ->name('site.analytics');
});


