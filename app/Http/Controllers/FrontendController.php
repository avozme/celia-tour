<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Scene;

class FrontendController extends Controller
{
    /**
     * METODO PARA OBTENER LA ESCENA POR DEFECTO Y MOSTRARLA EN PANTALLA PRINCIPAL
     */
    public function index(){
        $data = Scene::where('cover', true)->limit(1)->get();
        return view('frontend.index', ['data'=>$data]);
    }

    //---------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LA ESCENA POR DEFECTO Y MOSTRARLA EN PANTALLA PRINCIPAL
     */
    public function freeVisit(){
        $data = Scene::all();
        return view('frontend.freeVisit', ['data'=>$data]);
    }

    //
}
