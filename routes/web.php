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

/////////////// RESTfull Visitas Guiadas ////////////////
Route::resource('guidedVisit', 'GuidedVisitController');
Route::get('guidedVisit/delete/{id}', 'GuidedVisitController@destroy')->name('guidedVisit.delete');

/////////////// RESTfull Recuersos ////////////////
Route::resource('resources', 'ResourceController');
Route::get('resources/delete/{id}', 'ResourceController@destroy')->name('resource.delete');
Route::get('resources/{id}/edit', 'ResourceController@edit')->name('resource.edit');
Route::post('resources/{id}', 'ResourceController@update')->name('resource.update');

/////////////// RESTfull Zonas ////////////////
Route::get('zone/{id}/delete', 'ZoneController@destroy')->name('zone.delete');
Route::resource('zone', 'ZoneController');
Route::get('zone/position/update/{opc}', 'ZoneController@updatePosition')->name('zone.updatePosition');

/////////////// RESTfull Scene ////////////////
//Route::get('scene/pruebas', 'SceneController@pruebas')->name("scene.pruebas");
Route::resource('scene', 'SceneController');
Route::post('scene/setViewDefault/{scene}', 'SceneController@setViewDefault')->name("scene.setViewDefault");

/////////////// RESTfull Hotspot ////////////////
Route::resource('hotspot', 'HotspotController');
Route::post('hotspot/updatePosition/{hotspot}', 'HotspotController@updatePosition')->name('hotspot.updatePosition');

/////////////// Rutas Saltos ////////////////
Route::get('jumpt/add', 'JumpController@store')->name('jump.store'); //STORE
Route::get('jump/{id}/edit', 'JumpController@edit')->name('jump.update'); //EDIT
Route::get('jump/{id}/delete', 'JumpController@destroy')->name('jump.delete'); //DELETE

/////////////// RESTfull Users ////////////////
Route::resource('user', 'UserController');
Route::put('user/{id}', 'UserController@update')->name('user.update');
Route::get('user/destroy/{id}', 'UserController@destroy')->name('user.destroy');

/////////////// RESTfull Options ////////////////
Route::get('options/edit', 'OptionsController@edit')->name('options.edit');
Route::post('options/update/{id}', 'OptionsController@update')->name('options.update');

/////////////// RESTfull Backup ////////////////
Route::post('backup/restore', 'BackupCrontroller@restore')->name('backup.restore');
Route::resource('backup', 'BackupCrontroller');

////////////// RESTfull Highlights /////////////
Route::get('highlight/{id}/delete', 'HighlightController@destroy')->name('highlight.destroy');
Route::resource('highlight', 'HighlightController');

/////////////// RESTfull Portkey ////////////////
Route::resource('portkey', 'PortkeyController');

/////////////// RESTfull Home/Login/Logout ////////////////
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
