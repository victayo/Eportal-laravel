<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//=========================== USER ==============================================//
Route::group(['namespace' => 'User', 'prefix' => 'user'], function (){
    Route::post('register', 'RegisterController@studentRegister');
});

//=========================== SCHOOL ============================================//

Route::group(['namespace' => 'School', 'prefix' => 'school'], function(){
    Route::get('/', 'SchoolController@index');
    Route::get('/{school}', 'SchoolController@show')->where('school', '[0-9]+');
    Route::post('/', 'SchoolController@store');
    Route::post('/{school}', 'SchoolController@update');
    Route::delete('/{school}', 'SchoolController@delete');
    
    Route::get('/class', 'SchoolController@getClasses');
    Route::post('/class/add', 'SchoolController@addClass');
    Route::post('/class/remove', 'SchoolController@removeClass');

    Route::get('/user', 'UserController@getUsers');
    Route::post('/user/add', 'UserController@addUsers');
    Route::post('/user/remove', 'UserController@removeUsers');
});

//=========================== CLASS ============================================//

Route::group(['namespace' => 'EportalClass', 'prefix' => 'class'], function(){
    Route::get('/', 'ClassController@index');
    Route::get('/{class}', 'ClassController@show')->where('class', '[0-9]+');
    Route::post('/', 'ClassController@store');
    Route::post('/{class}', 'ClassController@update');
    Route::delete('/{class}', 'ClassController@delete');

    Route::get('/department', 'ClassController@getDepartments');
    Route::post('/department/add', 'ClassController@addDepartment');
    Route::post('department/remove', 'ClassController@removeDepartment');
});

//=========================== DEPARTMENT ============================================//

Route::group(['namespace' => 'Department', 'prefix' => 'department'], function(){
    Route::get('/', 'DepartmentController@index');
    Route::get('/{department}', 'DepartmentController@show')->where('department', '[0-9]+');
    Route::post('/', 'DepartmentController@store');
    Route::post('/{department}', 'DepartmentController@update');
    Route::delete('/{department}', 'DepartmentController@delete');

    Route::get('/subject', 'DepartmentController@getSubjects');
    Route::post('/subject/add', 'DepartmentController@addSubject');
    Route::post('subject/remove', 'DepartmentController@removeSubject');
});

//=========================== SUBJECT ============================================//

Route::group(['namespace' => 'Subject', 'prefix' => 'subject'], function(){
    Route::get('/', 'SubjectController@index');
    Route::get('/{subject}', 'SubjectController@show');
    Route::post('/', 'SubjectController@store');
    Route::post('/{subject}', 'SubjectController@update');
    Route::delete('/{subject}', 'SubjectController@delete');
});

//=========================== SESSION ============================================//

Route::group(['namespace' => 'Session', 'prefix' => 'session'], function(){
    Route::get('/', 'SessionController@index');
    Route::get('/{session}', 'SessionController@show')->where('session', '[0-9]+');
    Route::post('/', 'SessionController@store');
    Route::post('/{session}', 'SessionController@update')->where('session', '[0-9]+');
    Route::delete('/{session}', 'SessionController@delete')->where('session', '[0-9]+');

    Route::get('/term', 'SessionController@getTerms');
    Route::post('/term/add', 'SessionController@addTerm');
    Route::post('/term/remove', 'SessionController@removeTerm');
});

//=========================== TERM ============================================//

Route::group(['namespace' => 'Term', 'prefix' => 'term'], function(){
    Route::get('/', 'TermController@index');
    Route::get('/{term}', 'TermController@show');
    Route::post('/', 'TermController@store');
    Route::post('/{term}', 'TermController@update');
    Route::delete('/{term}', 'TermController@delete');
});

