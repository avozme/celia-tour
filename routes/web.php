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
Route::resource('resources', 'ResourcesController');
Route::get('resources/{id}/delete', 'ResourcesController@destroy')->name('resources.delete');
Route::get('resources/{id}/edit', 'ResourcesController@edit')->name('resources.edit');
Route::post('resources/{id}', 'ResourcesController@update')->name('resources.update');

/////////////// RESTfull Zonas ////////////////
Route::get('zone/{id}/delete', 'ZoneController@destroy')->name('zone.delete');
Route::resource('zone', 'ZoneController');

Route::resource('scene', 'SceneController');

Route::resource('options', 'OptionsController', [
    'names' => [
        'update' => 'options.update',
        'edit' => 'options.edit',
    ]]);
