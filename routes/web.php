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

/**
 * Rutas del Expediente
 */
Route::resource('expedients','ExpedientController');
// pases
Route::get('expedients/{expedient_id}/pass', ['as' => 'expedients.pass', 'uses' => 'ExpedientController@pass']);
Route::post('expedients/{expedient_id}/pass', ['as' => 'expedients.pass.confirmed', 'uses' => 'ExpedientController@passConfirmed']);
Route::get('expedients/{expedient_id}/receive', ['as' => 'expedients.receive', 'uses' => 'ExpedientController@receive']);
Route::get('expedients/{expedient_id}/rechazar',['as' => 'expedients.rechazar', 'uses' => 'ExpedientController@rechazar']);
Route::post('expedients/{expedient_id}/rechazar', ['as' => 'expedients.rechazado', 'uses' => 'ExpedientController@rechazado']);
// ingreso/egreso
Route::get('expedients/ingress/now', ['as' => 'expedients.ingress', 'uses' => 'ExpedientController@ingress']);
Route::get('expedients/{expedient_id}/ingress/confirmed', ['as' => 'expedients.ingress.confirmed', 'uses' => 'ExpedientController@ingressConfirmed']);
Route::post('expedients/{expedient_id}/ingress/confirmed', ['as' => 'expedients.ingress.confirmed', 'uses' => 'ExpedientController@ingressConfirmedTrue']);
Route::get('expedients/{expedient_id}/egress', ['as' => 'expedients.egress', 'uses' => 'ExpedientController@egress']);
// archivo
Route::post('expedients/{id}/file', ['as' => 'expedient.file', 'uses' => 'ExpedientController@addfile']);
Route::get('expedients/{id}/file/{file_id}', ['as' => 'expedients.file.download', 'uses' => 'ExpedientController@download']);
Route::get('expedients/{expedient_id}/file/{file_id}/destroy', ['as' => 'expedients.file.destroy', 'uses' => 'ExpedientController@destroyFile']);

/**
 * Rutas del Expediente
 */
Route::resource('files','FileController');
//
Route::resource('users','UserController');
//Auth::routes();
//});

//Route::get('/home', 'HomeController@index')->name('home');
