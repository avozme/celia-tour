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

        //Indicar a la vista si hay visitas guiadas o puntos destacados
        $highQ=false;
        $guidedQ=false;
        if(GuidedVisit::all()->count()>0){
            $guidedQ =true;
        }
        if(Highlight::all()->count()>0){
            $highQ =true;
        }
        $info = array('data'=>$data, 'name'=>$name, 'guidedQ'=>$guidedQ, 'highQ'=>$highQ);

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.index', $info);
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
        $info = array('data'=>$data, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'allZones'=>$allZones, 'secondScenes'=>$secondaryScene);

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.freeVisit', $info);
    }


    //---------------------------------------------------------------------------------


    /**
     * METODO PARA MOSTRAR LOS PUNTOS DESTACADOS
     */
    public function highlights(){
        $scenes = Scene::all();
        $highlights = Highlight::orderBy('position')->get();
        $hotsRel = HotspotType::all();
        $allHots = Hotspot::all();
        $info = array('scenes'=>$scenes, 'highlights'=>$highlights, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots);

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.highlights', $info);
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
        $info = array('scenes'=>$scenes, 'visits'=>$visits, 'visitsScenes'=>$visitsScenes, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots);

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.guidedvisit', $info);
    }


    //---------------------------------------------------------------------------------


    /**
     * METODO PARA MOSTRAR LA VISTA DE CREDITOS
     */
    public function credits(){
        $collaborators = Option::where('id', 16)->get();
        $collaborators = $collaborators[0]->value;
        $info = array('collaborators'=>explode(',', $collaborators));

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.credits', $info);
    }


    //---------------------------------------------------------------------------------


    /**
     * METODO PARA MOSTRAR LA VISTA DE PRIVACIDAD
     */
    public function privacy(){
        $privacidad = Option::where("key", "Propietario legal de la web")->get();
        $info = array('privacidad'=>$privacidad);

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.privacy', $info);
    }

    
    //---------------------------------------------------------------------------------


    /**
     * METODO PARA MOSTRAR LA VISTA DE COOKIES
     */
    public function cookies(){
        $info = $this->getOptions();
        return view('frontend.cookie',$info);
    }


    //---------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LAS OPCIONES DE LA BASE DE DATOS Y ENVIARLAS A LA VISTA PRINCIPAL
     */
    public function getOptions(){
        ///// COLOR + FUENTE
        $font = Option::where('id', 11)->get()[0]->value;
        $fontLink = str_replace(' ', '+', $font);
        $color = Option::where('id', 12)->get()[0]->value;
        $reverseColor= $this->reverColor($color);
        ///// FAVICON
        $favicon = Option::where('id', 4)->get()[0]->value;
        ///// META
        $metatitle = Option::where('id', 1)->get()[0]->value;
        $metadescription = Option::where('id', 2)->get()[0]->value;

        return array('font'=>$font, 'fontLink'=>$fontLink, 'color'=>$color, 'reverseColor'=>$reverseColor,
                     'favicon'=>$favicon, 'metadescription'=>$metadescription, 'metatitle'=>$metatitle);
    }

    //---------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER EL COLOR INVERSO DEL PASADO POR PARAMETRO
     */
    public function reverColor($color){
        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x"); //convertir a rgb
        //Invertir color
        $rR= 255-$r;
        $rG= 255-$g;
        $rB= 255-$b;
        return sprintf("#%02x%02x%02x", $rR, $rG, $rB);
    }
}