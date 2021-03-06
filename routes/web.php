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
Route::get('expedients/assign/list', ['as' => 'expedients.assign.list', 'uses' => 'ExpedientController@indexAssign']);
Route::get('expedients/search/list', ['as' => 'expedients.search.list', 'uses' => 'ExpedientController@indexSearch']);
// pases
Route::get('expedients/{expedient_id}/pass', ['as' => 'expedients.pass', 'uses' => 'ExpedientController@pass']);
Route::post('expedients/{expedient_id}/pass', ['as' => 'expedients.pass.confirmed', 'uses' => 'ExpedientController@passConfirmed']);
// reasignacion
Route::get('expedients/{expedient_id}/reassignPass', ['as' => 'expedients.reassignPass', 'uses' => 'ExpedientController@reassignPass']);
Route::post('expedients/{expedient_id}/reassignConfirmed', ['as' => 'expedients.reassign.confirmed', 'uses' => 'ExpedientController@reassignConfirmed']);
// recepcion
Route::get('expedients/{expedient_id}/receive', ['as' => 'expedients.receive', 'uses' => 'ExpedientController@receive']);
Route::get('expedients/{expedient_id}/rechazar',['as' => 'expedients.rechazar', 'uses' => 'ExpedientController@rechazar']);
Route::post('expedients/{expedient_id}/rechazar', ['as' => 'expedients.rechazado', 'uses' => 'ExpedientController@rechazado']);
// ingreso/egreso
Route::get('expedients/ingress/now', ['as' => 'expedients.ingress', 'uses' => 'ExpedientController@ingress']);
Route::get('expedients/{expedient_id}/ingress/confirmed', ['as' => 'expedients.ingress.confirmed', 'uses' => 'ExpedientController@ingressConfirmed']);
Route::post('expedients/{expedient_id}/ingress/confirmed', ['as' => 'expedients.ingress.confirmed', 'uses' => 'ExpedientController@ingressConfirmedTrue']);
Route::get('expedients/{expedient_id}/egress', ['as' => 'expedients.egress', 'uses' => 'ExpedientController@egress']);
Route::post('expedients/{expedient_id}/egress/confirmed', ['as' => 'expedients.egress.confirmed', 'uses' => 'ExpedientController@egressConfirmed']);
// archivo
Route::post('expedients/{id}/file', ['as' => 'expedient.file', 'uses' => 'ExpedientController@addfile']);
Route::get('expedients/{id}/file/{file_id}', ['as' => 'expedients.file.download', 'uses' => 'ExpedientController@download']);
Route::get('expedients/{expedient_id}/file/{file_id}/destroy', ['as' => 'expedients.file.destroy', 'uses' => 'ExpedientController@destroyFile']);
// Novedades
Route::get('expedient/{id}/novelties',['as' => 'expedient.novelties','uses' => 'NoveltyController@index']);
Route::get('expedient/{id}/novelty',['as' => 'expedient.novelty.create','uses' => 'NoveltyController@create']);
Route::post('expedient/{id}/novelty',['as' => 'expedient.novelty.store','uses' => 'NoveltyController@store']);
Route::get('expedient/novelty/{id}',['as' => 'expedient.novelty.edit','uses' => 'NoveltyController@edit']);
Route::post('expedient/novelty/{id}',['as' => 'expedient.novelty.update','uses' => 'NoveltyController@update']);
// Movimientos
Route::get('expedients/{id}/movements', ['as' => 'expedient.movements', 'uses' => 'MovementController@index']);
// Solo Letura
Route::get('expedients/{id}/show/read', ['as' => 'expedients.show.readOnly', 'uses' => 'ExpedientController@readOnly']);

/**
 * Files
 */
Route::resource('files','FileController');
/**
  * News
  */
Route::resource('novelties','NoveltyController');
/**
  * Movimientos
  */
Route::resource('movements','MovementController');
//
Route::resource('users','UserController');
//Auth::routes();
//});

//Route::get('/home', 'HomeController@index')->name('home');
