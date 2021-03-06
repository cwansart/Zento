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

Route::get('users/{id}/change_password', 'UserController@changePassword');
Route::put('users/{id}/change_password', 'UserController@updatePassword');
Route::delete('users/{id}/destroy_password', 'UserController@destroyPassword');

Route::get('users/get_address/{id}', 'UserController@getAddress');

Route::get('exams/get_unreg_users/{id}', 'ExamController@getUnregisteredUsers');
Route::put('exams/{id}/addUser', 'ExamController@addUser');
Route::delete('exams/{examid}/{userid}', 'ExamController@removeUser');

Route::get('seminars/get_unreg_users/{id}', 'SeminarController@getUnregisteredUsers');
Route::put('seminars/{id}/addUser', 'SeminarController@addUser');
Route::delete('seminars/{seminarid}/{userid}', 'SeminarController@removeUser');

Route::get('appointments/get_trainer/{id}', 'AppointmentController@getTrainer');
Route::get('appointments/notify_trainer', 'AppointmentController@notifyTrainer');

Route::get('lists/generate_list', 'ListController@generateList');

// resources
Route::resource('users', 'UserController');
Route::resource('exams', 'ExamController');
Route::resource('seminars', 'SeminarController');
Route::resource('appointments', 'AppointmentController');
Route::resource('lists', 'ListController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);
