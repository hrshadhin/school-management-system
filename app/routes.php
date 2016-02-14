<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','HomeController@index');
Route::get('/dashboard','DashboardController@index');
Route::post('/users/login','UsersController@postSignin');
Route::get('/users/logout','UsersController@getLogout');
Route::get('/users','UsersController@show');
Route::post('/usercreate','UsersController@create');
Route::get('/useredit/{id}','UsersController@edit');
Route::post('/userupdate','UsersController@update');
Route::get('/userdelete/{id}','UsersController@delete');

//Route::get('/users/regi','UsersController@postRegi');

//Class routes
Route::get('/class/create','classController@index');
Route::post('/class/create','classController@create');
Route::get('/class/list','classController@show');
Route::get('/class/edit/{id}','classController@edit');
Route::post('/class/update','classController@update');
Route::get('/class/delete/{id}','classController@delete');
Route::get('/class/getsubjects/{class}','classController@getSubjects');

//Subject routes
Route::get('/subject/create','subjectController@index');
Route::post('/subject/create','subjectController@create');
Route::get('/subject/list','subjectController@show');
Route::get('/subject/edit/{id}','subjectController@edit');
Route::post('/subject/update','subjectController@update');
Route::get('/subject/delete/{id}','subjectController@delete');
Route::get('/subject/getmarks/{subject}','subjectController@getmarks');


//Student routes
Route::get('/student/getRegi/{class}/{session}/{section}','studentController@getRegi');
Route::get('/student/create','studentController@index');
Route::post('/student/create','studentController@create');
Route::get('/student/list','studentController@show');
Route::post('/student/list','studentController@getList');
Route::get('/student/view/{id}','studentController@view');

Route::get('/student/edit/{id}','studentController@edit');
Route::post('/student/update','studentController@update');
Route::get('/student/delete/{id}','studentController@delete');
Route::get('/student/getList/{class}/{section}/{shift}/{session}','studentController@getForMarks');

//student attendance
Route::get('/attendance/create','attendanceController@index');
Route::post('/attendance/create','attendanceController@create');
Route::get('/attendance/list','attendanceController@show');
Route::post('/attendance/list','attendanceController@getlist');
Route::get('/attendance/edit/{id}','attendanceController@edit');
Route::post('/attendance/update','attendanceController@update');
Route::get('/attendance/printlist/{class}/{section}/{shift}/{session}/{subject}/{date}','attendanceController@printlist');




//GPA Routes
Route::get('/gpa','gpaController@index');
Route::post('/gpa/create','gpaController@create');
Route::get('/gpa/list','gpaController@show');
Route::get('/gpa/edit/{id}','gpaController@edit');
Route::post('/gpa/update','gpaController@update');
Route::get('/gpa/delete/{id}','gpaController@delete');


//sms Routes
Route::get('/sms','smsController@index');
Route::post('/sms/create','smsController@create');
Route::get('/sms/list','smsController@show');
Route::get('/sms/edit/{id}','smsController@edit');
Route::post('/sms/update','smsController@update');
Route::get('/sms/delete/{id}','smsController@delete');

Route::get('/smslog','smsController@smsLog');
Route::get('/smslog/delete/{id}','smsController@deleteLog');

//Mark routes
Route::get('/mark/create','markController@index');
Route::post('/mark/create','markController@create');
Route::get('/mark/list','markController@show');
Route::post('/mark/list','markController@getlist');
Route::get('/mark/edit/{id}','markController@edit');
Route::post('/mark/update','markController@update');
Route::get('/mark/delete/{id}','markController@delete');

//Markssheet
Route::get('/result/generate','gradesheetController@getgenerate');
Route::post('/result/generate','gradesheetController@postgenerate');

Route::get('/result/search','gradesheetController@getsearch');

Route::get('/result/search','gradesheetController@search');
Route::post('/result/search','gradesheetController@postsearch');

Route::get('/gradesheet','gradesheetController@index');
Route::post('/gradesheet','gradesheetController@stdlist');
Route::get('/gradesheet/print/{regiNo}/{exam}/{class}','gradesheetController@printsheet');

//tabulation sheet
Route::get('/tabulation','tabulationController@index');
Route::post('/tabulation','tabulationController@getsheet');


//settings
Route::get('/settings','settingsController@index');
Route::post('/settings','settingsController@save');

//promotion
Route::get('/promotion','promotionController@index');
Route::post('/promotion','promotionController@store');

//Accounting
Route::get('/accounting/sectors','accountingController@sectors');
Route::post('/accounting/sectorcreate','accountingController@sectorCreate');
Route::get('/accounting/sectorlist','accountingController@sectorList');
Route::get('/accounting/sectoredit/{id}','accountingController@sectorEdit');
Route::post('/accounting/sectorupdate','accountingController@sectorUpdate');
Route::get('/accounting/sectordelete/{id}','accountingController@sectorDelete');

Route::get('/accounting/income','accountingController@income');
Route::post('/accounting/incomecreate','accountingController@incomeCreate');
Route::get('/accounting/incomelist','accountingController@incomeList');
Route::post('/accounting/incomelist','accountingController@incomeListPost');
Route::get('/accounting/incomeedit/{id}','accountingController@incomeEdit');
Route::post('/accounting/incomeupdate','accountingController@incomeUpdate');
Route::get('/accounting/incomedelete/{id}','accountingController@incomeDelete');

Route::get('/accounting/expence','accountingController@expence');
Route::post('/accounting/expencecreate','accountingController@expenceCreate');
Route::get('/accounting/expencelist','accountingController@expenceList');
Route::post('/accounting/expencelist','accountingController@expenceListPost');
Route::get('/accounting/expenceedit/{id}','accountingController@expenceEdit');
Route::post('/accounting/expenceupdate','accountingController@expenceUpdate');
Route::get('/accounting/expencedelete/{id}','accountingController@expenceDelete');

Route::get('/accounting/report','accountingController@getReport');
Route::get('/accounting/reportsum','accountingController@getReportsum');

Route::get('/accounting/reportprint/{rtype}/{fdate}/{tdate}','accountingController@printReport');
Route::get('/accounting/reportprintsum/{fdate}/{tdate}','accountingController@printReportsum');

//Fees Related routes

Route::get('/fees/setup','feesController@getsetup');
Route::post('/fees/setup','feesController@postsetup');
Route::get('/fees/list','feesController@getList');
Route::post('/fees/list','feesController@postList');

Route::get('/fee/edit/{id}','feesController@getEdit');
Route::post('/fee/edit','feesController@postEdit');
Route::get('/fee/delete/{id}','feesController@getDelete');

Route::get('/fee/collection','feesController@getCollection');
Route::post('/fee/collection','feesController@postCollection');
Route::get('/fee/getListjson/{class}/{type}','feesController@getListjson');
Route::get('/fee/getFeeInfo/{id}','feesController@getFeeInfo');

Route::get('/fee/getDue/{class}/{stdId}','feesController@getDue');

//Admisstion routes
Route::get('/regonline','admissionController@regonline');
Route::post('/regonline','admissionController@Postregonline');
Route::get('/applicants','admissionController@applicants');
Route::post('/applicants','admissionController@postapplicants');
Route::get('/applicants/view/{id}','admissionController@applicantview');
Route::get('/applicants/payment','admissionController@payment');
Route::get('/applicants/delete/{id}','admissionController@delete');
Route::get('/admitcard','admissionController@admitcard');
Route::post('/printadmitcard','admissionController@printAdmitCard');


//library routes
Route::get('/library/addbook','libraryController@getAddbook');
Route::post('/library/addbook','libraryController@postAddbook');
Route::get('/library/view','libraryController@getviewbook');
Route::post('/library/view','libraryController@postviewbook');
Route::get('/library/edit/{id}','libraryController@getBook');
Route::post('/library/update','libraryController@postUpdateBook');
Route::get('/library/delete/{id}','libraryController@deleteBook');
Route::get('/library/issuebook','libraryController@getissueBook');
Route::post('/library/issuebook','libraryController@postissueBook');
Route::get('/library/issuebookview','libraryController@getissueBookview');
Route::post('/library/issuebookview','libraryController@postissueBookview');
Route::get('/library/issuebookupdate/{id}','libraryController@getissueBookupdate');
Route::post('/library/issuebookupdate','libraryController@postissueBookupdate');
Route::get('/library/issuebookdelete/{id}','libraryController@deleteissueBook');

Route::get('/library/search','libraryController@getsearch');
Route::get('/library/search2','libraryController@getsearch');
Route::post('/library/search','libraryController@postsearch');
Route::post('/library/search2','libraryController@postsearch2');

Route::get('/library/reports','libraryController@getReports');

Route::get('/library/reportprint/{do}','libraryController@Reportprint');
