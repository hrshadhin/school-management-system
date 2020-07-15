<?php

use App\Http\Helpers\AppHelper;
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

/**
 * Admin panel routes goes below
 */
Route::group(
    ['namespace' => 'Backend', 'middleware' => ['guest']], function () {
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

Route::get('/public/exam', 'Backend\ExamController@indexPublic')->name('public.exam_list');
Route::any('/online-result', 'Backend\ReportController@marksheetPublic')->name('report.marksheet_pub');

Route::group(
    ['namespace' => 'Backend', 'middleware' => ['auth', 'permission']], function () {
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/lock', 'UserController@lock')->name('lockscreen');
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');

    //user management
    Route::resource('user', 'UserController');
    Route::get('/profile', 'UserController@profile')
        ->name('profile');
    Route::post('/profile', 'UserController@profile')
        ->name('profile');
    Route::get('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('user/status/{id}', 'UserController@changeStatus')
        ->name('user.status');
    Route::any('user/{id}/permission', 'UserController@updatePermission')
        ->name('user.permission');

    //user notification
    Route::get('/notification/unread', 'NotificationController@getUnReadNotification')
        ->name('user.notification_unread');
    Route::get('/notification/read', 'NotificationController@getReadNotification')
        ->name('user.notification_read');
    Route::get('/notification/all', 'NotificationController@getAllNotification')
        ->name('user.notification_all');

    //system user management
    Route::get('/administrator/user', 'AdministratorController@userIndex')
        ->name('administrator.user_index');
    Route::get('/administrator/user/create', 'AdministratorController@userCreate')
        ->name('administrator.user_create');
    Route::post('/administrator/user/store', 'AdministratorController@userStore')
        ->name('administrator.user_store');
    Route::get('/administrator/user/{id}/edit', 'AdministratorController@userEdit')
        ->name('administrator.user_edit');
    Route::post('/administrator/user/{id}/update', 'AdministratorController@userUpdate')
        ->name('administrator.user_update');
    Route::post('/administrator/user/{id}/delete', 'AdministratorController@userDestroy')
        ->name('administrator.user_destroy');
    Route::post('administrator/user/status/{id}', 'AdministratorController@userChangeStatus')
        ->name('administrator.user_status');

    Route::any('/administrator/user/reset-password', 'AdministratorController@userResetPassword')
        ->name('administrator.user_password_reset');



    //user role manage
    Route::get('/role', 'UserController@roles')
        ->name('user.role_index');
    Route::post('/role', 'UserController@roles')
        ->name('user.role_destroy');
    Route::get('/role/create', 'UserController@roleCreate')
        ->name('user.role_create');
    Route::post('/role/store', 'UserController@roleCreate')
        ->name('user.role_store');
    Route::any('/role/update/{id}', 'UserController@roleUpdate')
        ->name('user.role_update');


    // application settings routes
    Route::get('settings/institute', 'SettingsController@institute')
        ->name('settings.institute');
    Route::post('settings/institute', 'SettingsController@institute')
        ->name('settings.institute');

    //report settings
    Route::get('settings/report', 'SettingsController@report')
        ->name('settings.report');
    Route::post('settings/report', 'SettingsController@report')
        ->name('settings.report');


    // administrator routes
    //academic year
    Route::get('administrator/academic_year', 'AdministratorController@academicYearIndex')
        ->name('administrator.academic_year');
    Route::post('administrator/academic_year', 'AdministratorController@academicYearIndex')
        ->name('administrator.academic_year_destroy');
    Route::get('administrator/academic_year/create', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_create');
    Route::post('administrator/academic_year/create', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_store');
    Route::get('administrator/academic_year/edit/{id}', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_edit');
    Route::post('administrator/academic_year/update/{id}', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_update');
    Route::post('administrator/academic_year/status/{id}', 'AdministratorController@academicYearChangeStatus')
        ->name('administrator.academic_year_status');


    // academic routes
    // class
    Route::get('academic/class', 'AcademicController@classIndex')
        ->name('academic.class');
    Route::post('academic/class', 'AcademicController@classIndex')
        ->name('academic.class_destroy');
    Route::get('academic/class/create', 'AcademicController@classCru')
        ->name('academic.class_create');
    Route::post('academic/class/create', 'AcademicController@classCru')
        ->name('academic.class_store');
    Route::get('academic/class/edit/{id}', 'AcademicController@classCru')
        ->name('academic.class_edit');
    Route::post('academic/class/update/{id}', 'AcademicController@classCru')
        ->name('academic.class_update');
    Route::post('academic/class/status/{id}', 'AcademicController@classStatus')
        ->name('academic.class_status');

    // section
    Route::get('academic/section', 'AcademicController@sectionIndex')
        ->name('academic.section');
    Route::post('academic/section', 'AcademicController@sectionIndex')
        ->name('academic.section_destroy');
    Route::get('academic/section/create', 'AcademicController@sectionCru')
        ->name('academic.section_create');
    Route::post('academic/section/create', 'AcademicController@sectionCru')
        ->name('academic.section_store');
    Route::get('academic/section/edit/{id}', 'AcademicController@sectionCru')
        ->name('academic.section_edit');
    Route::post('academic/section/update/{id}', 'AcademicController@sectionCru')
        ->name('academic.section_update');
    Route::post('academic/section/status/{id}', 'AcademicController@sectionStatus')
        ->name('academic.section_status');

    // subject
    Route::get('academic/subject', 'AcademicController@subjectIndex')
        ->name('academic.subject');
    Route::post('academic/subject', 'AcademicController@subjectIndex')
        ->name('academic.subject_destroy');
    Route::get('academic/subject/create', 'AcademicController@subjectCru')
        ->name('academic.subject_create');
    Route::post('academic/subject/create', 'AcademicController@subjectCru')
        ->name('academic.subject_store');
    Route::get('academic/subject/edit/{id}', 'AcademicController@subjectCru')
        ->name('academic.subject_edit');
    Route::post('academic/subject/update/{id}', 'AcademicController@subjectCru')
        ->name('academic.subject_update');
    Route::post('academic/subject/status/{id}', 'AcademicController@subjectStatus')
        ->name('academic.subject_status');


    // teacher routes
    Route::resource('teacher', 'TeacherController');
    Route::post('teacher/status/{id}', 'TeacherController@changeStatus')
        ->name('teacher.status');

    // student routes
    Route::resource('student', 'StudentController');
    Route::post('student/status/{id}', 'StudentController@changeStatus')
        ->name('student.status');
    Route::get('student-list-by-filter', 'StudentController@studentListByFitler')
        ->name('student.list_by_filter');

    // student attendance routes
    Route::get('student-attendance', 'StudentAttendanceController@index')->name('student_attendance.index');
    Route::any('student-attendance/create', 'StudentAttendanceController@create')->name('student_attendance.create');
    Route::post('student-attendance/store', 'StudentAttendanceController@store')->name('student_attendance.store');
    Route::post('student-attendance/status/{id}', 'StudentAttendanceController@changeStatus')
        ->name('student_attendance.status');

    // HRM
    //Employee
    Route::resource('hrm/employee', 'EmployeeController', ['as' => 'hrm']);
    Route::post('hrm/employee/status/{id}', 'EmployeeController@changeStatus')
        ->name('hrm.employee.status');
    // Leave
    Route::resource('hrm/leave', 'LeaveController', ['as' => 'hrm']);
    // policy
    Route::get('hrm/policy', 'EmployeeController@hrmPolicy')
        ->name('hrm.policy');
    Route::post('hrm/policy', 'EmployeeController@hrmPolicy')
        ->name('hrm.policy');

    // employee attendance routes
    Route::get('employee-attendance', 'EmployeeAttendanceController@index')->name('employee_attendance.index');
    Route::get('employee-attendance/create', 'EmployeeAttendanceController@create')->name('employee_attendance.create');
    Route::post('employee-attendance/create', 'EmployeeAttendanceController@store')->name('employee_attendance.store');
    Route::post('employee-attendance/status/{id}', 'EmployeeAttendanceController@changeStatus')
        ->name('employee_attendance.status');


    //exam
    Route::get('exam', 'ExamController@index')
        ->name('exam.index');
    Route::get('exam/create', 'ExamController@create')
        ->name('exam.create');
    Route::post('exam/store', 'ExamController@store')
        ->name('exam.store');
    Route::get('exam/edit/{id}', 'ExamController@edit')
        ->name('exam.edit');
    Route::post('exam/update/{id}', 'ExamController@update')
        ->name('exam.update');
    Route::post('exam/status/{id}', 'ExamController@changeStatus')
        ->name('exam.status');
    Route::post('exam/delete/{id}', 'ExamController@destroy')
        ->name('exam.destroy');
    //grade
    Route::get('exam/grade', 'ExamController@gradeIndex')
        ->name('exam.grade.index');
    Route::post('exam/grade', 'ExamController@gradeIndex')
        ->name('exam.grade.destroy');
    Route::get('exam/grade/create', 'ExamController@gradeCru')
        ->name('exam.grade.create');
    Route::post('exam/grade/create', 'ExamController@gradeCru')
        ->name('exam.grade.store');
    Route::get('exam/grade/edit/{id}', 'ExamController@gradeCru')
        ->name('exam.grade.edit');
    Route::post('exam/grade/update/{id}', 'ExamController@gradeCru')
        ->name('exam.grade.update');
    //exam rules
    Route::get('exam/rule', 'ExamController@ruleIndex')
        ->name('exam.rule.index');
    Route::post('exam/rule', 'ExamController@ruleIndex')
        ->name('exam.rule.destroy');
    Route::get('exam/rule/create', 'ExamController@ruleCreate')
        ->name('exam.rule.create');
    Route::post('exam/rule/create', 'ExamController@ruleCreate')
        ->name('exam.rule.store');
    Route::get('exam/rule/edit/{id}', 'ExamController@ruleEdit')
        ->name('exam.rule.edit');
    Route::post('exam/rule/update/{id}', 'ExamController@ruleEdit')
        ->name('exam.rule.update');

    //Marks
    Route::any('marks', 'MarkController@index')
        ->name('marks.index');
    Route::any('marks/create', 'MarkController@create')
        ->name('marks.create');
    Route::post('marks/store', 'MarkController@store')
        ->name('marks.store');
    Route::get('marks/edit/{id}', 'MarkController@edit')
        ->name('marks.edit');
    Route::post('marks/update/{id}', 'MarkController@update')
        ->name('marks.update');
    //result
    Route::any('result', 'MarkController@resultIndex')
        ->name('result.index');
    Route::any('result/generate', 'MarkController@resultGenerate')
        ->name('result.create');
    Route::any('result/delete', 'MarkController@resultDelete')
        ->name('result.delete');

    // Promotion
    Route::any('promotion', 'MarkController@promotion')
        ->name('promotion.create');
    Route::post('do-promotion', 'MarkController@doPromotion')
        ->name('promotion.store');


    // Reporting
    Route::any('report/student-monthly-attendance', 'ReportController@studentMonthlyAttendance')
        ->name('report.student_monthly_attendance');
    Route::any('report/student-list', 'ReportController@studentList')
        ->name('report.student_list');
    Route::any('report/employee-list', 'ReportController@employeeList')
        ->name('report.employee_list');
    Route::any('report/employee-monthly-attendance', 'ReportController@employeeMonthlyAttendance')
        ->name('report.employee_monthly_attendance');

});

//non privilege routes
Route::group(['namespace' => 'Backend', 'middleware' => ['auth']], function () {
    Route::get('/st-profile', 'PublicController@studentProfile')
        ->name('public.student_profile');
    Route::get('public/get-student-attendance', 'PublicController@getStudentAttendance')
        ->name('public.get_student_attendance');
    Route::get('public/check-section-empty-seat', 'PublicController@checkSectionHaveEmptySeat')
        ->name('public.section_capacity_check');
    Route::get('public/promotional-year-list', 'PublicController@getAcademicYearsForPromotion')
        ->name('public.get_promotional_year_list');
    Route::get('public/class-subject-count', 'PublicController@getClassSubjectCountNewAlgo')
        ->name('public.class_subject_count');

    Route::get('/public/get-student-result', 'PublicController@getStudentResults')
        ->name('public.get_student_result');
    Route::get('/public/get-student-subject', 'PublicController@getStudentSubject')
        ->name('public.get_student_subject');
    Route::get('/public/get-subject-settings/{classId}', 'PublicController@getClassSubjectSettings')
        ->name('public.get_class_subject_settings');
    Route::get('/public/get-section', 'AcademicController@sectionIndex')
        ->name('public.section');


    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
        ->name('app_log');
});


//web artisan routes

//dev routes
Route::get('/make-link/{code}', function ($code) {
    //check access
    AppHelper::check_dev_route_access($code);

    //remove first
    if (is_link(public_path('storage'))) {
        unlink(public_path('storage'));
    }

    //create symbolic link for public image storage
    App::make('files')->link(storage_path('app/public'), public_path('storage'));
    return 'Done link';
});

Route::get('/cache-clear/{code}', function ($code) {
    //check access
    AppHelper::check_dev_route_access($code);

    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return 'clear cache';
});

//create triggers
Route::get('/create-triggers/{code}', function ($code) {
    //check access
    AppHelper::check_dev_route_access($code);

    AppHelper::createTriggers();
    return 'Triggers created :)';
});
