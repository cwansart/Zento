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

// set default site
Route::get('/', 'UserController@index');

// special routes
Route::get('edit_profile', 'UserController@editProfile');
Route::put('edit_profile', 'UserController@updateProfile');

Route::get('exams/get_unreg_users/{id}', 'ExamController@getUnregisterdUsers');
Route::put('exams/{id}/addUser', 'ExamController@addUser');
Route::delete('exams/{examid}/{userid}', 'ExamController@removeUser');

Route::get('seminars/get_unreg_users/{id}', 'SeminarController@getUnregisterdUsers');
Route::put('seminars/{id}/addUser', 'SeminarController@addUser');
Route::delete('seminars/{seminarid}/{userid}', 'SeminarController@removeUser');

// resources
Route::resource('users', 'UserController');
Route::resource('exams', 'ExamController');
Route::resource('seminars', 'SeminarController');
Route::resource('appointments', 'AppointmentController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);
