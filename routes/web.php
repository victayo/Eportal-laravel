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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
   Route::get('/', 'AdminController@index') ;

   //========================== SCHOOLS ===========================================
    Route::group(['prefix' => 'school'], function(){
        Route::get('/', 'SchoolController@index')->name('admin.school.index');
        Route::match(['get', 'post'], 'create', 'SchoolController@create')->name('admin.school.create');
        Route::match(['get', 'post'], 'edit/{school}', 'SchoolController@update')->name('admin.school.edit');
        Route::post('delete', 'SchoolController@delete')->name('admin.school.delete');

        Route::get('/class', 'SchoolController@getClasses')->name('admin.school.classes');
        Route::match(['get', 'post'], 'class/add', 'SchoolController@addClasses')->name('admin.school.addClass');
        Route::post('class/remove', 'SchoolController@removeClasses')->name('admin.school.removeClass');
    });
    
    //============================ CLASSES ===========================================
    Route::group(['prefix' => 'class'], function(){
        Route::get('/', 'ClassController@index')->name('admin.class.index');
        Route::match(['get', 'post'], 'create', 'ClassController@store')->name('admin.class.create');
        Route::match(['get', 'post'], 'edit/{class}', 'ClassController@update')->name('admin.class.edit');
        Route::post('delete', 'ClassController@delete')->name('admin.class.delete');

        Route::get('/class', 'ClassController@getDepartments')->name('admin.class.departments');
        Route::match(['get', 'post'], 'department/add', 'ClassController@addDepartments')->name('admin.class.addDepartment');
        Route::post('department/remove', 'ClassController@removeDepartments')->name('admin.class.removeDepartment');
    });
});