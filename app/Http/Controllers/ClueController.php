<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clue;
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

    //Función para guardar nueva pista: 
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
        ]);

        $addClue = new Clue();
        $addClue->text = $request->text;
        $addClue->show = 0;
        $addClue->id_question = $request->id_question;
        $addClue->save();
        
        return response()->json($addClue);
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
        $updateClue->aid_question = $request->id_question;
        $updateClue->show = 0;
        
        $updateClue->save();
        
        return response()->json($updateClue);
    }

    //Función para eliminar
    public function destroy($id)
    {
        $clue = clue::destroy($id);
        return response()->json($clue);
    }
}
