<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Zone;
use App\Scene;
use App\Option;
use DB;

class EscapeRoomController extends Controller
{
    
    public function index(){
        $data['zones'] = Zone::orderBy('position')->get();
        $data['firstZoneId'] = 1;
        return view('backend/escaperoom/index', $data);
    }

    public function editScene($sceneId){
        $scene = Scene::find($sceneId);
        //Juego activo (S/N)
        $game = Option::find(20)->value;
        return view('backend/escaperoom/editscene', ['scene' => $scene, 'game' => $game]);
    }

}
