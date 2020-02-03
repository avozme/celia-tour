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
Route::get('guidedVisit/delete/{id}', 'GuidedVisitController@destroy')->name('guidedVisit.delete');
Route::get('guidedVisit/scenes/{id}', 'GuidedVisitController@scenes')->name('guidedVisit.scenes');
Route::post('guidedVisit/scenesStore/{id}', 'GuidedVisitController@scenesStore')->name('guidedVisit.scenesStore');
Route::post('guidedVisit/scenesPosition/{id}', 'GuidedVisitController@scenesPosition')->name('guidedVisit.scenesPosition');
Route::get('guidedVisit/deleteScenes/{id}', 'GuidedVisitController@destroyScenes')->name('guidedVisit.deleteScenes');
Route::resource('guidedVisit', 'GuidedVisitController');

/////////////// RESTfull Recursos ////////////////
Route::post('resources/getvideos', 'ResourceController@getVideos')->name('resource.getvideos');
Route::post('resources/getaudios', 'ResourceController@getAudios')->name('resource.getaudios');

Route::resource('resources', 'ResourceController');
Route::get('resources/delete/{id}', 'ResourceController@destroy')->name('resource.delete');
Route::get('resources/{id}/edit', 'ResourceController@edit')->name('resource.edit');
Route::post('resources/{id}', 'ResourceController@update')->name('resource.update');
Route::post('/images-save', 'ResourceController@store');

/////////////// RESTfull Zonas ////////////////
Route::get('zone/{id}/map', 'ZoneController@map')->name('zone.map');
Route::get('zone/{id}/delete', 'ZoneController@destroy')->name('zone.delete');
Route::resource('zone', 'ZoneController');
Route::get('zone/position/update/{opc}', 'ZoneController@updatePosition')->name('zone.updatePosition');

/////////////// RESTfull Scene ////////////////
Route::get('scene/update', 'SceneController@update')->name("scene.updatee");
Route::get('scene/show/{id}', 'SceneController@show')->name("scene.show");
Route::get('scene/pruebas', 'SceneController@pruebas')->name("scene.pruebas");
Route::resource('scene', 'SceneController');
Route::post('scene/setViewDefault/{scene}', 'SceneController@setViewDefault')->name("scene.setViewDefault");

/////////////// RESTfull Hotspot ////////////////
Route::resource('hotspot', 'HotspotController');
Route::post('hotspot/updatePosition/{hotspot}', 'HotspotController@updatePosition')->name('hotspot.updatePosition');
Route::post('hotspot/updateIdType/{hotspot}', 'HotspotController@updateIdType')->name('hotspot.updateIdType');


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

/////////////// RESTfull Resources Gallery ////////////////
Route::resource('gallery', 'GalleryController');
Route::get('gallery/{id}/edit', 'GalleryController@edit')->name('gallery.edit');
Route::post('gallery/{id}', 'GalleryController@update')->name('gallery.update');
Route::get('gallery/delete/{id}', 'GalleryController@destroy')->name('gallery.delete');
Route::get('gallery/{id}/edit_resources', 'GalleryController@edit_resources')->name('gallery.edit_resources');
Route::post('gallery/{id}/update_resources', 'GalleryController@update_resources')->name('gallery.update_resources');
