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
        Route::get('/', 'SchoolController@index')->name('admin.school');
        Route::get('edit', 'SchoolController@update')->name('admin.school.edit');
        Route::get('delete', 'SchoolController@create')->name('admin.school.delete');
    });
});