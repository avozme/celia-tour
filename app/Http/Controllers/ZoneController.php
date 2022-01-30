<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic;
use DB;
use App\Scene;
use App\Zone;
use App\SecondaryScene;

class ZoneController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE ZONAS
     */
    public function index(){
        $zones = DB::table('zones')->orderBy('position')->get();
        $data["zones"] = $zones;
        $data['rows'] = DB::table('zones')->count();
        //echo("Número de zonas ▶ ". DB::table('zones')->count());
        //echo("Número de escenas ▶ ". DB::table('scenes')->count());
        return view('backend/zone/index', $data, ['numberOfZones'=>DB::table('zones')->count()] );
        // Con lo que hay después de $data, estamos enviando a la vista index de zonas el número total de zonas que hay en la BD
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LOS DATOS DE UNA ZONA
     */
    public function show($id){
        $zone = Zone::find($id);
        $data['zone'] = $zone;
        return view('backend/zone/show', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE CREACION DE UNA ZONA
     */
    public function create(){
        return view('backend/zone/create');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR UNA UNA NUEVA ZONA EN LA BASE DE DATOS
     */
    public function store(Request $r){
        $zone = new Zone();
        $zone->name = $r->name;
        $zone->file_image = "";
        $zone->file_miniature = "";
        $zone->position = 0;
        $zone->save();

        $maxPosition = DB::select('SELECT MAX(position) as ultima FROM zones');
        $zone->position = $maxPosition[0]->ultima + 1;
        
        //Guardo la miniatura de la zona
        $miniatura = $r->file('file_image');
        $name = $miniatura->getClientOriginalName();
        $ruta = public_path('img/zones/miniatures/'.$name);
        ImageManagerStatic::make($miniatura->getRealPath())->resize(110, 78.46, function($const){
            $const->aspectRatio();
        })->save($ruta);
        $zone->file_miniature = $name;
        
        //Guardo la imagen de la zona
        $name = $r->file('file_image')->getClientOriginalName();
        $r->file('file_image')->move(public_path('img/zones/images/'), $name);
        $zone->file_image = $name;
        $zone->save();
        return redirect()->route('zone.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE EDICION DE UNA ZONA
     */
    public function edit($id){
        $zone = Zone::find($id);
        $data['zone'] = $zone;
        $data['scenes'] = $zone->scenes()->get();
        return view('backend/zone/edit', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UNA ZONA EN LA BASE DE DATOS
     */
    public function update(Request $r, $id){
        $zone = Zone::find($id);
        $zone->name = $r->name;

        //Modifico la miniatura de la zona
        if($r->hasFile('file_image')){
            $miniatura = $r->file('file_image');
            if(file_exists(public_path('img/zones/miniatures/').$zone->file_miniature)){
                unlink(public_path('img/zones/miniatures/').$zone->file_miniature);
            }
            $name = $miniatura->getClientOriginalName();
            $ruta = public_path('img/zones/miniatures/'.$name);
            ImageManagerStatic::make($miniatura->getRealPath())->resize(110, 78.46, function($const){
                $const->aspectRatio();
            })->save($ruta);
            $zone->file_miniature = $name;
    
            //Modifico la imagen de la zona
            $image = $r->file('file_image');
            if($image != null){
                if(file_exists(public_path('img/zones/images/').$zone->file_image)){
                    unlink(public_path('img/zones/images/').$zone->file_image);
                }
                $name = $r->file('file_image')->getClientOriginalName();
                $r->file('file_image')->move(public_path('img/zones/images/'), $name);
                $zone->file_image = $name;
            }
        }
            
        $zone->save();
        return redirect()->route('zone.index');
    }

    

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UNA ZONA DE LA BASE DE DATOS
     */
    public function destroy($id){
        $zone = Zone::find($id);
        $position = $zone->position;
        $allZones = Zone::all();
        for($i = 0; $i < count($allZones); $i++){
            if($allZones[$i]->position > $position){
                $allZones[$i]->position -= 1;
                $allZones[$i]->save();
            }
        }
        Storage::disk('zoneimage')->delete($zone->file_image);
        Storage::disk('zoneminiature')->delete($zone->file_miniature);
        if($zone->delete()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LA POSICION DE UNA ZONA
     * 
     * @param $opc => Opción ('u' = subir) / ('d' = bajar)
     */
    public function updatePosition($opc){
        $movement = substr($opc, 0, 1);
        $id = substr($opc, 1);
        $movedZone = Zone::find($id);
        $newPosition = null;
        if($movement == 'u'){
            $displacedZone = DB::table('zones')->where('position', $movedZone->position - 1)->get(); //[0]
            $newPosition = $displacedZone[0]->id;
        }else {
            $displacedZone = DB::table('zones')->where('position', $movedZone->position + 1)->get(); //[0]
            $newPosition = $displacedZone[0]->id;
        }
        $displacedZone = Zone::find($newPosition);
        $savePosition = $movedZone->position;
        $movedZone->position = $displacedZone->position;
        $displacedZone->position = $savePosition;
        $movedZone->save();
        $displacedZone->save();
        return redirect()->route('zone.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LOS DATOS DE UNA ZONA Y SUS ESCENAS PARA CONFECCIONAR EL MAPA
     */
    public function map($id){
        $zone = Zone::find($id);
        $scenes = $zone->scenes()->get();
        return response()->json(['zone' => $zone, 'scenes' => $scenes]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA
     */
    public function getZoneAndScenes($id){
        $zone = Zone::find($id);
        $scenes = $zone->scenes()->get();
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER UNA ESCENA SECUNDARIA
     */
    public function getSecondaryScenes($id){
        $s_scenes = SecondaryScene::find($id);
        return response()->json(['s_scenes' => $s_scenes]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA RECUPERAR EL NUMERO DE ESCENAS QUE TIENE UNA ZONA
     */
    public function checkScenes($zoneId){
        $scenes = Zone::find($zoneId)->scenes()->get();
        return response()->json(['num' => count($scenes)]);
    }

}
