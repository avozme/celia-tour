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

        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.index', ['data'=>$data, 'name'=>$name, 'font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
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
        $secondaryScene = SecondaryScene::all();

        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.freeVisit', ['data'=>$data, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'allZones'=>$allZones, 'secondScenes'=>$secondaryScene, 'font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
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

        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.highlights', ['scenes'=>$scenes, 'highlights'=>$highlights, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
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

        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.guidedvisit', ['scenes'=>$scenes, 'visits'=>$visits, 'visitsScenes'=>$visitsScenes, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
    }

    //---------------------------------------------------------------------------------


    /**
     * METODO PARA MOSTRAR LA VISTA DE CREDITOS
     */
    public function credits(){
        $collaborators = Option::where('id', 16)->get();
        $collaborators = $collaborators[0]->value;

        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.credits', ['collaborators'=>explode(',', $collaborators), 'font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
    }

     /**
     * Muestra la vista de privacidad
     */
    public function privacy(){
        $privacidad = Option::where("key", "Propietario legal de la web")->get();
        
        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.privacy', ['privacidad'=>$privacidad, 'font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
    }

     /**
     * Muestra la vista de cookies
     */
    public function cookies(){
        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);

        return view('frontend.cookie', ['font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor]);
    }

    public function reverColor($color){
        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x"); //convertir a rgb
        //Invertir color
        $rR= 255-$r;
        $rG= 255-$g;
        $rB= 255-$b;
        return sprintf("#%02x%02x%02x", $rR, $rG, $rB);
    }
}