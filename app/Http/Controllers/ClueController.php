<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clue;
use App\Resource;
use DB;

class ClueController extends Controller
{
    public function getAll(){
        $clues = Clue::all();
        return response()->json(['clues' => $clues]);
    }

    public function updateIdHide($idClue, Request $r){
        $c = Clue::find($idClue);
        $c->id_hide = $r->idHide;
        if($c->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function getClueFromHide($idHide){
        $clue = DB::table('clues')->where('id_hide', $idHide)->get();
        if(count($clue) > 0){
            return response()->json(['status' => true, 'clue' => $clue[0]]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    /*
    * DEVUELVE LOS DATOS DE UNA PISTA
    */
    public function show($id){
        $data['clue'] = Clue::find($id);
        return response()->json($data);
    }

    //Función para guardar nueva pista: 
    public function store(Request $request)
    {


        $addClue = new Clue();
        $addClue->text = $request->text;
        $addClue->show = $request->show;
        

        $data['audio'] = null;
        if(isset($request->id_audio)) {
            $data['audio'] = DB::table('resources')->where('id', $request->id_audio)->get()[0];
            $data['audio'] = url('img/resources/'.$data['audio']->route);
        }
        $data['question'] = null;
        if($request->id_question != "null") {
            $addClue->id_question = $request->id_question;
            $data['question'] = DB::table('questions')->where('id', $addClue->id_question)->get()[0];
        }


        $addClue->id_audio = $request->id_audio;
        $addClue->type = $request->type;
        $addClue->id_resource = $request->id_resource;
        $addClue->id_escaperoom = $request->id_escaperoom;
        $addClue->save();
        
        $data['clue'] = $addClue;
        
        return response()->json($data);
    }

    //Funcion para sacar la pista a editar
    public function edit($id)
    {
        $clue = Clue::find($id);
        return response()->json($clue);
    }

    //Función para actualizar
    public function update(Request $request, $id)
    {
        $updateClue = Clue::find($id);
        $updateClue->text = $request->text;
        $updateClue->show = $request->show;

        
        if(isset($request->id_audio)) {
            $data['audio'] = DB::table('resources')->where('id', $request->id_audio)->get()[0];
            $data['audio'] = url('img/resources/'.$data['audio']->route);
            $updateClue->id_audio = $request->id_audio;
        } else {
            $updateClue->id_audio = null;
            $data['audio'] = null;
        }
        

        if($request->id_question != "null") {
            $updateClue->id_question = $request->id_question;
            $data['question'] = DB::table('questions')->where('id', $updateClue->id_question)->get()[0];
        } else {
            $updateClue->id_question = null;
            $data['question'] = null;
        }

        $updateClue->type = $request->type;
        if($request->id_resource == "null"){
            $updateClue->id_resource = 0;
        } else {
            $updateClue->id_resource = $request->id_resource;
        }

        $updateClue->save();

        $data['clue'] = $updateClue;

        
        
        return response()->json($data);
    }

    //Función para eliminar
    public function destroy($id)
    {
        $clue = clue::destroy($id);
        return response()->json($clue);
    }

    /**
     * DEVUELVE LAS PISTAS SEGUN EL FILTRO ESPECIFICADO
     */
    public function filter($filter){
        switch ($filter) {
            case 'all':
                $clues = DB::table('clues')->select("id")->get();;
                break;
            case 'assigned':
                $clues = DB::table('clues')->where('id_hide', '!=', null)->select("id")->get();;
                break;
            case 'not-assigned':
                $clues = DB::table('clues')->where('id_hide', null)->select("id")->get();;
                break;
        }
        return response()->json($clues);
    }

    /**
     * DE UNA PISTA ESPECIFICADA SE DEVUELVE EL AUDIO Y EL RECURSO
     */
    function getMultimedia($id){
        $clue = Clue::find($id);
        $data["audio"] = 0;
        if($clue->id_audio != 0){
            $data["audio"] = Resource::find($clue->id_audio);
        }
        $data["resource"] = 0;
        if($clue->id_resource != 0){
            $data["resource"] = Resource::find($clue->id_resource);
        }
        return response()->json($data);
    }
}
