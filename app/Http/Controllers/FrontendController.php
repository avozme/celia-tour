<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Scene;
use App\Hotspot;
use App\HotspotType;
use App\Zone;
use App\Highlight;

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
     * METODO PARA FORMAR LA VISITA LIBRE
     */
    public function freeVisit(){
        $data = Scene::all();
        $hotsRel = HotspotType::all();
        $allHots = Hotspot::all();
        $allZones = Zone::all();
        return view('frontend.freeVisit', ['data'=>$data, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'allZones'=>$allZones]);
    }

    //---------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LOS PUNTOS DESTACADOS
     */
    public function highlights(){
        $scenes = Scene::all();
        $highlights = Highlight::all();
        $hotsRel = HotspotType::all();
        $allHots = Hotspot::all();
        return view('frontend.highlights', ['scenes'=>$scenes, 'highlights'=>$highlights, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots]);
    }

    //
}
