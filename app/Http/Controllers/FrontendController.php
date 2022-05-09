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
use App\Key;
use App\Clue;
use App\Question;
use App\Answer;
use App\AnswersOption;
use App\Resource;
use App\EscapeRoom;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    /**
     * METODO PARA OBTENER LA ESCENA POR DEFECTO Y MOSTRARLA EN PANTALLA PRINCIPAL
     */
    public function index(){
        $data = Scene::where('cover', true)->limit(1)->get();
        $name = Option::where('id', 7)->get();
        $tipoPortada = Option::where("id", 17)->get();
        $portada = Option::where("id", 18)->get();
        $escaperooms = EscapeRoom::orderBy('difficulty')->get(); 

        //Indicar a la vista si hay visitas guiadas o puntos destacados
        $highQ=false;
        $guidedQ=false;
        if(GuidedVisit::all()->count()>0){
            $guidedQ =true;
        }
        if(Highlight::all()->count()>0){
            $highQ =true;
        }

        //Obtener textos descriptivos de opciones
        $txtFreeVisit = Option::where('id', 8)->get()[0]->value;
        $txtGuided = Option::where('id', 9)->get()[0]->value;
        $txtHigh = Option::where('id', 10)->get()[0]->value;
        
        //Confeccionar datos para la vista
        $info = array('data'=>$data, 'name'=>$name, 'guidedQ'=>$guidedQ, 'highQ'=>$highQ,
                      'txtHigh'=>$txtHigh, 'txtGuided'=>$txtGuided, 'txtFreeVisit'=>$txtFreeVisit, 
                      'tipoPortada'=>$tipoPortada, 'portada'=>$portada, 'escapeRooms'=>$escaperooms);

        //Comprobar si esta activa la historia
        $enabledHis = Option::where('id', 13)->get()[0]->value;
        if($enabledHis=="Si"){
            $info= array_merge($info, ['history'=>true]);
        }

        //Comprobar si esta activa el escape room
        $enabledEscape = Option::where('id', 20)->get()[0]->value;
        if($enabledEscape=="Si"){
            $info= array_merge($info, ['escape'=>true]);
        }

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.index', $info);
    }


    //---------------------------------------------------------------------------------


    /**
     * METODO PARA FORMAR LA VISITA LIBRE
     */
    public function freeVisit(){
        $typePortkey = Option::where('id', 15)->get();
        $typePortkey = $typePortkey[0]->value;
        $data = Scene::all();
        $hotsRel = HotspotType::all();
        $allHots = Hotspot::all();
        $allZones = Zone::orderBy('position')->get();
        $secondaryScene = SecondaryScene::all();
        $subtitle =  $this->getSubtitle();
        $info = array('data'=>$data, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'allZones'=>$allZones, 'secondScenes'=>$secondaryScene, 'typePortkey'=>$typePortkey, 'subtitle'=> $subtitle);

        //Agregar opciones al recuperadas a la vista
        $info= array_merge($info, $this->getOptions());
        return view('frontend.freevisit', $info);
    }

    //---------------------------------------------------------------------------------


    /**
     * METODO PARA FORMAR EL ESCAPE ROOM
     */
    public function escapeRoom(){
        //Comprobar si esta activa la opcion, si no lo bloqueamos
        $enabledEscape = Option::where('id', 20)->get()[0]->value;
        if($enabledEscape=="Si"){
            //Funcionamiento general de las escenas
            $typePortkey = Option::where('id', 15)->get();
            $typePortkey = $typePortkey[0]->value;
            $data = Scene::all();
            $hotsRel = HotspotType::all();
            $allHots = Hotspot::all();
            $allZones = Zone::orderBy('position')->get();
            $subtitle =  $this->getSubtitle();
            $audios =  Resource::where('type', 'audio')->get();
            //Escape room
            $key = Key::all();
            $clue = Clue::All();
            $question = Question::All();
            $escaperooms = EscapeRoom::orderBy('difficulty')->get(); 
            $nameTour = Option::where('id', 7)->get();

            //Obtener rutas de los recursos que se utilizaran tanto en las pistas como en las preguntas
            $resources = array();
            foreach($clue as $c){
                if($c->id_resource != 0){
                    $value = Resource::select('route')->where('id', $c->id_resource)->get()[0];
                    $resources[$c->id_resource] = $value["route"];;
                }
            }
            foreach($question as $q){
                if($q->id_resource != 0){
                    $value = Resource::select('route')->where('id', $q->id_resource)->get()[0];
                    $resources[$q->id_resource] = $value["route"];;
                }
            }


            $info = array('data'=>$data, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'allZones'=>$allZones, 'typePortkey'=>$typePortkey,
                          'subtitle'=> $subtitle, 'keys'=>$key, 'clues'=>$clue, 'questions'=>$question, 'nameTour'=>$nameTour,
                          'audios'=>$audios, 'escapeRooms'=>$escaperooms, 'resourcesRoutes'=>$resources);

            //Agregar opciones al recuperadas a la vista
            $info= array_merge($info, $this->getOptions());
            return view('frontend.escaperoom', $info);
        }else{
            //Redireccionamos al index
            return redirect()->route('frontend.index');
        }
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
        $subtitle =  $this->getSubtitle();
        $info = array('scenes'=>$scenes, 'highlights'=>$highlights, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'subtitle'=> $subtitle);

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
        $subtitle =  $this->getSubtitle();
        $info = array('scenes'=>$scenes, 'visits'=>$visits, 'visitsScenes'=>$visitsScenes, 'hotspotsRel'=>$hotsRel, 'allHots'=>$allHots, 'subtitle'=> $subtitle);

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
     * METODO PARA MOSTRAR LA VISTA DE HISTORIA SI ESTÁ ACTIVADA EN LAS OPCIONES
     */
    public function history(){
        $enabled =   Option::where('id', 13)->get()[0]->value;
        //Comprobar que la opcion esta activa en la base de datos
        if($enabled=="Si"){
            $history =  Option::where('id', 14)->get();
            $info = array('history'=>$history);

            //Agregar opciones al recuperadas a la vista
            $info= array_merge($info, $this->getOptions());
            return view('frontend.history', $info);
        }else{
            return redirect('');
        }
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

    //---------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LOS SUBTITULOS DE LOS DIFERENTES RECURSOS DE AUDIOS
     */
    public function getSubtitle(){
        $subt = array();
        //Comprobar que el directorio existe
        if(file_exists(public_path("img/resources/subtitles"))){
            $allSubt = scandir(public_path('img/resources/subtitles'));
            
            //Crear array con los subtitulos agrupados por id
            for($i=0;$i<count($allSubt);$i++){
                $name = explode( '.', $allSubt[$i]);
                $idElement = $name[0];

                if($allSubt[$i]!="." && $allSubt[$i]!=".."){
                    //Comprobar si existe una clave en el array para el id
                    if (array_key_exists($idElement."", $subt)) {
                        array_push($subt[$idElement.""], $allSubt[$i]);
                    }else{
                        $subt[$idElement.""] = array();
                        array_push($subt[$idElement.""], $allSubt[$i]);
                    }
                }
            }
        }
        return $subt;
    }

    /**
     * Métodos para obtener el nombre de los Modelos 3D de la base de datos
     */
    public function visualizarModelos3D ($name) {
        $data['name'] = $name;
        return view('frontend.model3d', $data);
    }

    public function getName($id){
        echo Resource::find($id)->route;

    }
}