<?php

use Illuminate\Support\Facades\Session;
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

//front website routes
Route::group(
    ['namespace' => 'Frontend', 'middleware' => ['web', 'frontend']], function () {
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
    Route::post('/forgot', 'UserController@forgot')
        ->name('forgot');
    Route::get('/reset/{token}', 'UserController@reset')
        ->name('reset');
    Route::post('/reset/{token}', 'UserController@reset')
        ->name('reset');

}
);

Route::group(
    ['namespace' => 'Backend', 'middleware' => 'auth'], function () {
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/lock', 'UserController@lock')->name('lockscreen');
    Route::resource('user', 'UserController');
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');
    Route::get('/profile', 'UserController@profile')
        ->name('profile');
    Route::post('/profile', 'UserController@profile')
        ->name('profile');
    Route::get('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('/change-password', 'UserController@changePassword')
        ->name('change_password');


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
        ->name('site.testimonial');
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

    // application settings routes
    Route::get('settings/institute','SettingsController@institute')
        ->name('settings.institute');
    Route::post('settings/institute','SettingsController@institute')
        ->name('settings.institute');

    // administrator routes
        //academic year
    Route::get('administrator/academic_year','AdministratorController@academicYearIndex')
        ->name('administrator.academic_year');
    Route::post('administrator/academic_year','AdministratorController@academicYearIndex')
        ->name('administrator.academic_year');
    Route::get('administrator/academic_year/create','AdministratorController@academicYearCru')
        ->name('administrator.academic_year_create');
    Route::post('administrator/academic_year/create','AdministratorController@academicYearCru')
        ->name('administrator.academic_year_store');
    Route::get('administrator/academic_year/edit/{id}','AdministratorController@academicYearCru')
        ->name('administrator.academic_year_edit');
    Route::post('administrator/academic_year/update/{id}','AdministratorController@academicYearCru')
        ->name('administrator.academic_year_update');
    Route::post('administrator/academic_year/status/{id}','AdministratorController@academicYearChangeStatus')
        ->name('administrator.academic_year_status');

    // academic routes
    // class
    Route::get('academic/class','AcademicController@classIndex')
        ->name('academic.class');
    Route::post('academic/class','AcademicController@classIndex')
        ->name('academic.class');
    Route::get('academic/class/create','AcademicController@classCru')
        ->name('academic.class_create');
    Route::post('academic/class/create','AcademicController@classCru')
        ->name('academic.class_store');
    Route::get('academic/class/edit/{id}','AcademicController@classCru')
        ->name('academic.class_edit');
    Route::post('academic/class/update/{id}','AcademicController@classCru')
        ->name('academic.class_update');
    Route::post('academic/class/status/{id}','AcademicController@classStatus')
        ->name('academic.class_status');

    // section
    Route::get('academic/section','AcademicController@sectionIndex')
        ->name('academic.section');
    Route::post('academic/section','AcademicController@sectionIndex')
        ->name('academic.section');
    Route::get('academic/section/create','AcademicController@sectionCru')
        ->name('academic.section_create');
    Route::post('academic/section/create','AcademicController@sectionCru')
        ->name('academic.section_store');
    Route::get('academic/section/edit/{id}','AcademicController@sectionCru')
        ->name('academic.section_edit');
    Route::post('academic/section/update/{id}','AcademicController@sectionCru')
        ->name('academic.section_update');
    Route::post('academic/section/status/{id}','AcademicController@sectionStatus')
        ->name('academic.section_status');

    // teacher routes
    Route::resource('teacher', 'TeacherController');
    Route::post('teacher/status/{id}','TeacherController@changeStatus')
        ->name('teacher.status');

    //dev routes
    Route::get('/make-link',function(){
        App::make('files')->link(storage_path('app/public'), public_path('storage'));
        return 'Done link';
    });
    Route::get('/clear-cache', function() {
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('view:clear');
        $exitCode = Artisan::call('route:clear');
        return 'clear cache';
    });
}
);

//change website locale
Route::get(
    '/set-locale/{lang}', function ($lang) {
        //set user wanted locale to session
        Session::put('user_locale', $lang);
        return redirect()->back();
}
)->name('setLocale');
