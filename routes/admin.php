<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'AdminController@index');

//========================== USERS ===========================================
Route::group(['prefix' => 'user'], function () {
    Route::match(['get', 'post'], 'register', 'UserController@register')->name('admin.user.register');
});

//========================== SESSIONS ===========================================
Route::group(['prefix' => 'session'], function () {
    Route::get('/', 'SessionController@index')->name('admin.session.index');
    Route::match(['get', 'post'], 'create', 'SessionController@store')->name('admin.session.create');
    Route::match(['get', 'post'], 'edit/{session}', 'SessionController@update')->name('admin.session.edit');
    Route::post('delete', 'SessionController@delete')->name('admin.session.delete');

    Route::get('/term', 'SessionController@getTerms')->name('admin.session.terms');
    Route::match(['get', 'post'], 'term/add', 'SessionController@addTerms')->name('admin.session.addTerm');
    Route::post('class/remove', 'SessionController@removeTerms')->name('admin.session.removeTerm');
});

//============================ TERMS ===========================================
Route::group(['prefix' => 'term'], function () {
    Route::get('/', 'TermController@index')->name('admin.term.index');
    Route::match(['get', 'post'], 'create', 'TermController@store')->name('admin.term.create');
    Route::match(['get', 'post'], 'edit/{term}', 'TermController@update')->name('admin.term.edit');
    Route::post('delete', 'TermController@delete')->name('admin.term.delete');
});

//========================== SCHOOLS ===========================================
Route::group(['prefix' => 'school'], function () {
    Route::get('/', 'SchoolController@index')->name('admin.school.index');
    Route::match(['get', 'post'], 'create', 'SchoolController@store')->name('admin.school.create');
    Route::match(['get', 'post'], 'edit/{school}', 'SchoolController@update')->name('admin.school.edit');
    Route::post('delete', 'SchoolController@delete')->name('admin.school.delete');

    Route::get('/class', 'SchoolController@getClasses')->name('admin.school.classes');
    Route::match(['get', 'post'], 'class/add', 'SchoolController@addClasses')->name('admin.school.addClass');
    Route::post('class/remove', 'SchoolController@removeClasses')->name('admin.school.removeClass');
});

//============================ CLASSES ===========================================
Route::group(['prefix' => 'class'], function () {
    Route::get('/', 'ClassController@index')->name('admin.class.index');
    Route::match(['get', 'post'], 'create', 'ClassController@store')->name('admin.class.create');
    Route::match(['get', 'post'], 'edit/{class}', 'ClassController@update')->name('admin.class.edit');
    Route::post('delete', 'ClassController@delete')->name('admin.class.delete');

    Route::get('/class', 'ClassController@getDepartments')->name('admin.class.departments');
    Route::match(['get', 'post'], 'department/add', 'ClassController@addDepartments')->name('admin.class.addDepartment');
    Route::post('department/remove', 'ClassController@removeDepartments')->name('admin.class.removeDepartment');
});

//============================ DEPARTMENTS ===========================================
Route::group(['prefix' => 'department'], function () {
    Route::get('/', 'DepartmentController@index')->name('admin.department.index');
    Route::match(['get', 'post'], 'create', 'DepartmentController@store')->name('admin.department.create');
    Route::match(['get', 'post'], 'edit/{department}', 'DepartmentController@update')->name('admin.department.edit');
    Route::post('delete', 'DepartmentController@delete')->name('admin.department.delete');

    Route::get('/department', 'DepartmentController@getSubjects')->name('admin.department.subjects');
    Route::match(['get', 'post'], 'subject/add', 'DepartmentController@addSubjects')->name('admin.department.addSubject');
    Route::post('subject/remove', 'DepartmentController@removeSubjects')->name('admin.department.removeSubject');
});

//============================ SUBJECTS ===========================================
Route::group(['prefix' => 'subject'], function () {
    Route::get('/', 'SubjectController@index')->name('admin.subject.index');
    Route::match(['get', 'post'], 'create', 'SubjectController@store')->name('admin.subject.create');
    Route::match(['get', 'post'], 'edit/{subject}', 'SubjectController@update')->name('admin.subject.edit');
    Route::post('delete', 'SubjectController@delete')->name('admin.subject.delete');
});