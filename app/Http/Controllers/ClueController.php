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
}
