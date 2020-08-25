<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index');




Route::get('/mentorac/{id}', 'MentorallconnectionController@index');
Route::get('/disconnect/{id}', 'MentorallconnectionController@destroy');

Route::get('/mentee/{id}', 'MenteeController@profile');

//* Routes for register
Route::get('/register_mentor', 'Auth\RegisterController@index');
Route::get('/register_mentee', 'Auth\RegisterController@index');
