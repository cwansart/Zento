<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

// special routes
Route::get('exams/get_unreg_users/{id}', 'ExamController@getUnregisterdUsers');
Route::get('seminars/get_unreg_users/{id}', 'SeminarController@getUnregisterdUsers');

// set default site
Route::get('/', 'UserController@index');

Route::get('edit_profile', 'UserController@editProfile');
Route::put('edit_profile', 'UserController@updateProfile');
Route::put('exams/{id}/updateExam', 'ExamController@updateExam');
Route::get('logout', 'UserController@logout');
Route::delete('exams/{examid}/{userid}', 'ExamController@destroyResult');
Route::delete('seminars/{seminarid}/{userid}', 'SeminarController@removeUser');

Route::resource('users', 'UserController');
Route::resource('exams', 'ExamController');
Route::resource('seminars', 'SeminarController');
Route::get('appointments/{id}', 'AppointmentController@showEvent')->where('id', '[0-9]+');
Route::resource('appointments', 'AppointmentController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);
