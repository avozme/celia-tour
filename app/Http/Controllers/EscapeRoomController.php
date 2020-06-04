<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Zone;
use App\Scene;
use App\Option;
use App\Question;
use App\Resource;
use App\Key;
use App\Clue;
use App\EscapeRoom;
use DB;

class EscapeRoomController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $data['escaperooms'] = EscapeRoom::all();
        return view('backend.escaperoom.index', $data);
    }

    public function store(Request $r){
        $er = new EscapeRoom();
        $er->name = $r->name;
        $er->description = $r->description;
        $er->difficulty = $r->difficulty;
        $escenaInicial = Scene::where('principal', 1)->get();
        $er->start_scene = $escenaInicial[0]->id;
        if($er->save()){
            return response()->json(['status' => true, 'er' => $er]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function update($id, Request $r){
        $er = EscapeRoom::find($id);
        $er->name = $r->name;
        $er->description = $r->description;
        $er->difficulty = $r->difficulty;
        if($er->save()){
            return response()->json(['status' => true, 'escaperoom' => $er]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function destroy($id){
        $er = EscapeRoom::find($id);
        if($er->delete()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function edit($id){
        //Proteccion para evitar mostrar las opciones si esta desactivado el escape room
        if(Option::where('id', 20)->get()[0]->value=="Si"){
            $data['zones'] = Zone::orderBy('position')->get();
            $data['firstZoneId'] = 1;
            $data['question'] = Question::where('id_escaperoom', $id)->get();
            $data['keys'] = Key::where('id_escaperoom', $id)->get();
            $data['clue'] = Clue::where('id_escaperoom', $id)->get();
            $data['audio'] = Resource::fillType("audio");
            $data['video'] = Resource::fillType("video");
            //Obtener las miniaturas de vimeo para los videos
            foreach($data['video'] as $value){
                $imgid = $value->route;
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                $value->preview = $hash[0]['thumbnail_medium'];
            }
            $data['idEscapeRoom'] = $id;
            $er = EscapeRoom::find($id);
            $data['escapeRoomName'] = $er->name;
            $data['datosEscape'] = $er;
            $data['images'] = Resource::where('Type', 'image')->get();
            return view('backend/escaperoom/editescaperoom', $data);
        }else{
            return redirect()->route('zone.index');
        }
    }

    public function editScene($sceneId, $escapeRoomId){
        //Proteccion para evitar mostrar las opciones si esta desactivado el escape room
        if(Option::where('id', 20)->get()[0]->value=="Si"){
            $scene = Scene::find($sceneId);
            //Juego activo (S/N)
            $game = Option::find(20)->value;
            $questions = Question::where('id_escaperoom', $escapeRoomId)->get();
            $clues = Clue::where('id_escaperoom', $escapeRoomId)->get();
            return view('backend/escaperoom/editscene', ['scene' => $scene, 'game' => $game, 'questions' => $questions, 'clues' => $clues, 'escapeRoomId' => $escapeRoomId]);
        }else{
            return redirect()->route('zone.index');
        }
    }

    public function getOne($id){
        $er = EscapeRoom::find($id);
        return response()->json($er);
    }

    public function saveOption($id,  Request $r){
        $escape = EscapeRoom::find($id);
        $escape->start_scene = $r->start_scene;
        $escape->history = $r->history;
        $escape->id_audio = $r->id_audio;
        $escape->environment_audio = $r->environment_audio; //Audio de fondo
        if($escape->save()){
            return response()->json(['status' => true, 'datos' => $escape]);
        }else{
            return response()->json(['status' => false]);
        }
    }
}
