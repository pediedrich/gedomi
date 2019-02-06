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
    return view('auth.login');
});

Route::post('login','Auth\LoginController@login')->name('login');
Route::resource('expedients','ExpedientController');
Route::post('expedients/{id}/file', ['as' => 'expedient.file', 'uses' => 'ExpedientController@addfile']);
Route::get('expedients/{id}/file/{file_id}', ['as' => 'expedients.file.download', 'uses' => 'ExpedientController@download']);
Route::resource('files','FileController');


//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
