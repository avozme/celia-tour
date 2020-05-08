<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Zone;
use App\Scene;
use App\Option;
use App\Question;
use App\Clue;
use App\Resource;
use App\Key;
use App\Clue;
use DB;

class EscapeRoomController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        //Proteccion para evitar mostrar las opciones si esta desactivado el escape room
        if(Option::where('id', 20)->get()[0]->value=="Si"){
            $data['zones'] = Zone::orderBy('position')->get();
            $data['firstZoneId'] = 1;
            $data['question'] = Question::all();
            $data['keys'] = Key::all();
            $data['clue'] = Clue::all();
            $data['audio'] = Resource::fillType("audio");
            return view('backend/escaperoom/index', $data);
        }else{
            return redirect()->route('zone.index');
        }
    }

    public function editScene($sceneId){
        //Proteccion para evitar mostrar las opciones si esta desactivado el escape room
        if(Option::where('id', 20)->get()[0]->value=="Si"){
            $scene = Scene::find($sceneId);
            //Juego activo (S/N)
            $game = Option::find(20)->value;
            $questions = Question::all();
            $clues = Clue::all();
            return view('backend/escaperoom/editscene', ['scene' => $scene, 'game' => $game, 'questions' => $questions, 'clues' => $clues]);
        }else{
            return redirect()->route('zone.index');
        }
    }

}
