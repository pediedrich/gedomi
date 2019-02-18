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

Route::get('/', 'Auth\LoginController@showLoginForm')->middleware('guest');

Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::get('logout','Auth\LoginController@logout')->name('logout');

Route::post('login','Auth\LoginController@login')->name('login');

Route::view('change-password','auth.passwords.reset');
Route::get('change-password/{id?}','Auth\LoginController@FormResetPass')->name('change-password');
Route::post('reset-password/{user_id?}','Auth\LoginController@resetPass')->name('reset-password');

Route::resource('expedients','ExpedientController');


//Route::group(['middleware' => 'auth'], function () {
  //
  //
Route::resource('expedients','ExpedientController');
Route::post('expedients/{id}/file', ['as' => 'expedient.file', 'uses' => 'ExpedientController@addfile']);
Route::get('expedients/{expedient_id}/receive', ['as' => 'expedients.receive', 'uses' => 'ExpedientController@receive']);
Route::get('expedients/{id}/file/{file_id}', ['as' => 'expedients.file.download', 'uses' => 'ExpedientController@download']);
Route::get('expedients/{expedient_id}/file/{file_id}/destroy', ['as' => 'expedients.file.destroy', 'uses' => 'ExpedientController@destroyFile']);
Route::resource('files','FileController');

  //
Route::resource('users','UserController');
//Auth::routes();
//});

//Route::get('/home', 'HomeController@index')->name('home');
