<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ranking;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Ordenado por tiempo de menor a mayor
        $all = Ranking::orderBy('time')->get(); 
        return $all;
    }

    /**
     * METODO PARA ALMACEANR ENTRADA EN LA TABLA DE RENKING
     */
    public function store(Request $request) {
        $id = $request->id_escaperoom;
        echo($id);
        //Ordenado por tiempo de mayor a menor
        $all = Ranking::where('id_escaperoom', $id)
                            ->orderBy('time', 'desc')
                            ->get(); 

        
        /*
        //Eliminar el mayor si el ranking esta completo
        if(count($all)>=10){
            Ranking::find($all[0]->id)->delete();
        }
        //Almacenar el nuevo
        $ranking  = new Ranking($request->all());
        if($ranking->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }*/
    }


}
