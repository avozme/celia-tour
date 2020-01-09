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

/////////////// RESTfull Recuersos ////////////////
Route::resource('resources', 'ResourcesController');

/////////////// RESTfull Zonas ////////////////
Route::get('zone/{id}/delete', 'ZoneController@destroy')->name('zone.delete');
Route::resource('zone', 'ZoneController');

Route::resource('scene', 'SceneController');

Route::resource('options', 'OptionsController', [
    'names' => [
        'update' => 'options.update',
        'edit' => 'options.edit',
    ]]);
