<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Scene;
use App\Hotspot;
use App\HotspotType;
use App\Zone;
use App\Highlight;
use App\GuidedVisit;
use App\SceneGuidedVisit;
use App\Option;
use App\SecondaryScene;

class FrontendController extends Controller
{
    /**
     * METODO PARA OBTENER LA ESCENA POR DEFECTO Y MOSTRARLA EN PANTALLA PRINCIPAL
     */
    public function index(){
        $data = Scene::where('cover', true)->limit(1)->get();
        $name = Option::where('id', 7)->get();
        return view('frontend.index', ['data'=>$data, 'name'=>$name]);
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
        $secondaryScene = SecondaryScene::orderBy('date')->get();
        return view('frontend.freeVisit', ['data'=>$data, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'allZones'=>$allZones, 'secondScenes'=>$secondaryScene]);
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

    //---------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LOS PUNTOS DESTACADOS
     */
    public function guidedVisit(){
        $scenes = Scene::all();
        $visits = GuidedVisit::all();
        $visitsScenes = SceneGuidedVisit::orderBy('position')->get();
        $hotsRel = HotspotType::all();
        $allHots = Hotspot::all();
        return view('frontend.guidedvisit', ['scenes'=>$scenes, 'visits'=>$visits, 'visitsScenes'=>$visitsScenes, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots]);
    }

    //
}
