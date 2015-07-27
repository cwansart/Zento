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

// set default site
Route::get('/', 'UserController@index');

Route::resource('users', 'UserController');
Route::resource('exams', 'ExamController');
Route::resource('seminars', 'SeminarController');
Route::resource('appointments', 'AppointmentController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);
