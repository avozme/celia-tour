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

/////////////// RESTfull Zonas ////////////////
Route::resource('zone', 'ZoneController', [
    'names' => [
        'index' => 'zone.index',
        'store' => 'zone.store',
        //'create' => 'zone.create',
        'show' => 'zone.show',
        //'destroy' => 'zone.destroy',
        'update' => 'zone.update',
        'edit' => 'zone.edit',
    ]]);
Route::get("zone/create", 'ZoneController@create')->name('zone.create');

Route::resource('scene', 'SceneController');
