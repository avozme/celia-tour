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

/******************** FRONTEND **********************/
Route::get('', 'FrontendController@index')->name('frontend.index');
Route::get('visitalibre', 'FrontendController@freeVisit')->name('frontend.freevisit');
Route::get('destacados', 'FrontendController@highlights')->name('frontend.highlights');
Route::get('guiada', 'FrontendController@guidedVisit')->name('frontend.guidedvisit');
Route::get('creditos', 'FrontendController@credits')->name('frontend.credits');
Route::get('privacidad', 'FrontendController@privacy')->name('frontend.privacy');
Route::get('cookies', 'FrontendController@cookies')->name('frontend.cookies');
Route::get('historia', 'FrontendController@history')->name('frontend.history');


/******************** BACKEND **********************/

/////////////// RESTfull Visitas Guiadas ////////////////
Route::post('guidedVisit/{id}', 'GuidedVisitController@update')->name('guidedVisit.update');
Route::get('guidedVisit/openUpdate/{id}', 'GuidedVisitController@openUpdate')->name('guidedVisit.openUpdate');
Route::get('guidedVisit/delete/{id}', 'GuidedVisitController@destroy')->name('guidedVisit.delete');
Route::get('guidedVisit/scenes/{id}', 'GuidedVisitController@scenes')->name('guidedVisit.scenes');
Route::post('guidedVisit/scenesStore/{id}', 'GuidedVisitController@scenesStore')->name('guidedVisit.scenesStore');
Route::post('guidedVisit/scenesPosition/{id}', 'GuidedVisitController@scenesPosition')->name('guidedVisit.scenesPosition');
Route::get('guidedVisit/deleteScenes/{id}', 'GuidedVisitController@destroyScenes')->name('guidedVisit.deleteScenes');
Route::resource('guidedVisit', 'GuidedVisitController')->except([
    'show', 'update', 'destroy'
]);

/////////////// RESTfull Recursos ////////////////
Route::post('resources/deleteSubtitle', 'ResourceController@deleteSubtitle')->name('resource.deleteSubtitle');
Route::post('resources/getvideos', 'ResourceController@getVideos')->name('resource.getvideos');
Route::post('resources/getaudios', 'ResourceController@getAudios')->name('resource.getaudios');
Route::get('resources/getroute/{id}', 'ResourceController@getRoute')->name('resource.getroute');
Route::resource('resources', 'ResourceController');
Route::post('resources/delete/{id}', 'ResourceController@destroy')->name('resource.delete');
Route::get('resources/{id}/edit', 'ResourceController@edit')->name('resource.edit');
Route::patch('resources/{id}', 'ResourceController@update')->name('resource.update');
Route::post('/images-save', 'ResourceController@store');
Route::post('/video-save', 'ResourceController@store_video')->name('resource.video-save');
Route::post('/resources/buscador', 'ResourceController@buscador')->name('resource.buscar');

/////////////// RESTfull Zonas ////////////////
Route::get('zone/{id}/map', 'ZoneController@map')->name('zone.map');
Route::post('zone/{id}/delete', 'ZoneController@destroy')->name('zone.delete');
Route::post('zone/{id}/checkScenes', 'ZoneController@checkScenes')->name('zone.checkScenes');
Route::resource('zone', 'ZoneController');
Route::get('zone/position/update/{opc}', 'ZoneController@updatePosition')->name('zone.updatePosition');

/////////////// RESTfull Scene ////////////////
Route::put('scene/{id}/update', 'SceneController@update')->name("scene.update");
Route::get('scene/show/{id}', 'SceneController@show')->name("scene.show");
Route::post('scene/{id}/checkSs', 'SceneController@checkSecondaryScenes')->name("scene.checkSs");
Route::post('scene/{id}/checkHotspots', 'SceneController@checkHotspots')->name("scene.checkHotspots");
Route::post('scene/{id}/checkStatus', 'SceneController@checkStatus')->name("scene.checkStatus"); //Comprobar si es escena principal o cover
Route::resource('scene', 'SceneController');
Route::post('scene/setViewDefault/{scene}', 'SceneController@setViewDefault')->name("scene.setViewDefault");
Route::post('scene/updateTopLeft', 'SceneController@updateTopLeft')->name("scene.updateTopLeft");
Route::post('scene/getZone/{id}', 'SceneController@getZone')->name("scene.getZone");

/////////////// RESTfull Hotspot ////////////////
Route::resource('hotspot', 'HotspotController');
Route::post('hotspot/updatePosition/{hotspot}', 'HotspotController@updatePosition')->name('hotspot.updatePosition');
Route::post('hotspot/updateIdType/{hotspot}', 'HotspotController@updateIdType')->name('hotspot.updateIdType');
Route::post('hotspot/updateHlPoint/{id}', 'HotspotController@updateHlPoint')->name('hotspot.updateHlPoint');

/////////////// Rutas Saltos ////////////////
Route::get('resources/getdestination/{jump}', 'JumpController@getDestination')->name('jump.getdestination');
Route::get('jump/{id}/edit', 'JumpController@edit')->name('jump.update'); //EDIT
Route::get('jump/{id}/delete', 'JumpController@destroy')->name('jump.delete'); //DELETE
Route::post('jump/store', 'JumpController@store')->name('jump.store'); //STORE
Route::post('jump/{id}/editPitchYaw', 'JumpController@editPitchYaw')->name('jump.editPitchYaw'); //PITCH YAW DESTINATION
Route::post('jump/{id}/editDestinationScene', 'JumpController@editDestinationScene')->name('jump.editDestinationScene'); //ID SCENE DESTINATION
Route::post('jump/{id}/getSceneDestId', 'JumpController@getSceneDestId')->name("jump.destid");


/////////////// RESTfull Users ////////////////
Route::resource('user', 'UserController');
Route::put('user/{id}', 'UserController@update')->name('user.update');
Route::get('user/destroy/{id}', 'UserController@destroy')->name('user.destroy');
Route::post('user/getInfo/{id}', 'UserController@getInfo')->name('user.getInfo');

/////////////// RESTfull Options ////////////////
Route::get('options/edit', 'OptionsController@edit')->name('options.edit');
Route::post('options/update/{id}', 'OptionsController@update')->name('options.update');
Route::post('options/update_cover/{id}/{id1}', 'OptionsController@update_cover')->name('options.update_cover');

/////////////// RESTfull Backup ////////////////
Route::post('backup/restore', 'BackupCrontroller@restore')->name('backup.restore');
Route::resource('backup', 'BackupCrontroller');

////////////// RESTfull Highlights /////////////
Route::resource('highlight', 'HighlightController');
Route::post('highlight/{id}/show', 'HighlightController@show')->name('highlight.showw');
Route::get('highlight/index/{id}', 'HighlightController@index');
Route::get('highlight/delete/{id}', 'HighlightController@destroy')->name('highlight.borrar');
Route::get('highlight/position/update/{opc}', 'HighlightController@updatePosition')->name('highlight.updatePosition');

/////////////// RESTfull Portkey ////////////////
Route::post('portkey/getScenes/{id}', 'PortkeyController@getScenes')->name('portkey.getScenes');
Route::get('portkey/delete/{id}', 'PortkeyController@destroy')->name('portkey.delete');
Route::get('portkey/portkeyScene/{id}', 'PortkeyController@mostrarRelacion')->name('portkey.mostrar');
Route::post('portkey/portkeyScene/guardar/{id}', 'PortkeyController@storeScene')->name('portkey.guardar');
Route::get('portkey/portkeyScene/{id}/delete/{id2}', 'PortkeyController@deleteScene')->name('portkey.borrar');
Route::resource('portkey', 'PortkeyController');

Route::get('portkey/openUpdate/{id}', 'PortkeyController@openUpdate')->name('portkey.openUpdate');
Route::get('portkey/sceneMap/{id}', 'PortkeyController@sceneMap')->name('portkey.sceneMap');
Route::get('portkey/sceneMap/getPortkeyScene/{id}', 'PortkeyController@getPortkeyScene')->name('portkey.getPortkeyScene');
Route::post('portkey/sceneMap/updatePortkeyScene/{id}', 'PortkeyController@updatePortkeyScene')->name('portkey.updatePortkeyScene');
Route::get('portkey/sceneMap/deletePortkeyScene/{id}', 'PortkeyController@deletePortkeyScene')->name('portkey.deletePortkeyScene');
Route::get('portkey/portkeyFromHotspot/{id}', 'PortkeyController@getPortkeyFromHotspot')->name('portkey.portkeyFromHotspot');

/////////////// RESTfull Home/Login/Logout ////////////////
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

/////////////// RESTfull Resources Gallery ////////////////
Route::resource('gallery', 'GalleryController');
Route::get('gallery/{id}/edit', 'GalleryController@edit')->name('gallery.edit');
Route::patch('gallery/{id}', 'GalleryController@update')->name('gallery.update');
Route::get('gallery/delete/{id}', 'GalleryController@destroy')->name('gallery.delete');
Route::get('gallery/contenido/{id}', 'GalleryController@contenido')->name('gallery.contenido');
Route::get('gallery/save_resource/{id}/{id2}', 'GalleryController@save_resource')->name('gallery.save_resource');
Route::get('gallery/delete_resource/{id}/{id2}', 'GalleryController@delete_resource')->name('gallery.delete_resource');
Route::get('gallery/{id}/edit_resources/{resultado?}', 'GalleryController@edit_resources')->name('gallery.edit_resources');
Route::post('gallery/{id}/update_resources', 'GalleryController@update_resources')->name('gallery.update_resources');
Route::post('gallery/{id}/resources', 'GalleryController@getImagesFromGallery')->name('gallery.resources');
Route::post('gallery/all', 'GalleryController@getAllGalleries')->name('gallery.all');
Route::post('/gallery/buscador', 'GalleryController@buscador')->name('gallery.buscar');


/////////////// RESTfull Secondary Scenes ////////////////
Route::post('secondaryscenes/store', 'SecondarySceneController@store')->name('sscenes.store');
Route::post('secondaryscenes/update', 'SecondarySceneController@update')->name('sscenes.update');
Route::get('secondaryscenes/delete/{id}', 'SecondarySceneController@destroy')->name('sscenes.delete');
Route::get('secondaryscenes/{id}', 'SecondarySceneController@show')->name("secondaryscenes.show");
Route::get('secondaryscenes/showScene/{id}', 'SecondarySceneController@showScene')->name("secondaryscenes.showScene");
Route::resource('secondaryscenes', 'SecondarySceneController');
Route::post('secondaryscenes/setViewDefault/{id}', 'SecondarySceneController@setViewDefault')->name("secondaryscenes.setViewDefault");


/////////////// RUTAS HOTSPOT TYPES ////////////////////////////
Route::post('hotspottype/{hotspot}/getIdJump', 'HotspotTypeController@getIdJump')->name("htypes.getIdJump");
Route::post('hotspottype/{hotspot}/getIdGallery', 'HotspotTypeController@getIdGallery')->name("htypes.getIdGallery");
Route::post('hotspottype/{id}/getIdType', 'HotspotTypeController@getIdType')->name("htypes.getIdType");
Route::post('hotspottype/updateIdType', 'HotspotTypeController@updateIdType')->name("htypes.updateIdType");


/////////////// RUTA INSTALADOR ////////////////////////////
Route::post('install/check', 'Install@checkData')->name('install.check');
Route::post('install/crear', 'Install@instalation')->name('install.instalation');
Route::get('install', 'Install@index')->name('install.install');