<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portkey;
use App\Scene;
use App\Zone;
use Illuminate\Support\Facades\DB;

class PortkeyController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE PORTKEY
     */
    public function index()
    {
        $data['portkeyList'] = Portkey::all();
        $data['portkeySceneList'] = Scene::all();
        return view('backend.portkey.index', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMECENAR UN PORTKEY EN LA BASE DE DATOS
     */
    public function store(Request $request){
        $portkey = new Portkey($request->all());
        $portkey->save();

        return redirect()->route('portkey.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE EDICION DE PORTKEY
     */
    public function edit($id){
        $portkey = Portkey::all();
        return view('backend.portkey.index', array('portkey' => $portkey));
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UN PORTKEY EN LA BASE DE DATOS
     */
    public function update(Request $r, $id){
        $prk = Portkey::find($id);
        $prk->name = $r->name;
        $prk->save();
        return redirect()->route('portkey.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UN PORTKEY DE LA BASE DE DATOS
     */
    public function destroy($id){
        $portkey = Portkey::find($id);
        $portkey->delete();
        echo "1";
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LAS ESCENAS DE UN PORTKEY ORDENADAS POR POSICION
     */
    public function mostrarRelacion($id){
        Zone::orderBy('position')->get();
        $data['firstZoneId'] = 1;

        $data['portkey'] = Portkey::find($id);
        $data['portkeySceneList'] = DB::table('portkeys')
            ->join('portkey_scene', 'portkeys.id', '=', 'portkey_scene.portkey_id')
            ->join('scenes', 'portkey_scene.scene_id', '=', 'scenes.id')
            ->join('zones', 'zones.id', '=', 'scenes.id_zone')
            ->where('portkeys.id', '=', $id)
            ->orderBy('zones.position', 'ASC')
            ->select('scenes.*')
            ->get();
        $data['zoneSceneList'] = $data['portkey']->scene()->get();
        return view('backend.portkey.portkeyScene', $data);
    }

    //---------------------------------------------------------------------------------------
    
    /**
     * METODO PARA ALMACENAR EN LA BASE DE DATOS UNA ESCENA ASOCIADA A UN PORTKEY 
     * EN LA TABLA INTERMEDIA
     */
    public function storeScene(request $r, $id){

        $portkey = Portkey::find($id);
        $scene = Scene::find($r->scene);
        $portkey->scene()->attach($r->scene);
        
        $data['portkey'] = $portkey;
        $data['scene'] = $scene;

        return response()->json($data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UNA ESCENA DE LA TABLA INTERMEDIA ENTRE PORTKEY Y ESCENAS
     */
    public function deleteScene($id, $id2){
        $portkey = Portkey::find($id);
        $portkey->scene()->detach($id2);
        echo "1";
        // $portkey = Portkey::find($id);
        // $scene = Scene::find($r->scene);
        // $scene->delete();
        // echo "1";
        //return redirect()->route('portkey.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODOPARA OBTENER LOS DATOS PARA EDITAR UN PORTKEY EN VENTANA MODAL
     */
    public function openUpdate($id){
        $portkey = Portkey::find($id);
        return response()->json($portkey);
    }
    
    //---------------------------------------------------------------------------------------

    /*
    * METODO PARA CONFECCIONAR EL HOTSPOT DE TIPO ASCENSOR PASANDOLE 
    * LOS NOMBRES DE CADA ESCENA Y SU POSICION
    */
    public function getScenes($id){
        $portkey = Portkey::find($id);
        $scenesRelated = $portkey->scene;

        for($i=0; $i<$scenesRelated->count(); $i++){
            $zone = Zone::find($scenesRelated[$i]->id_zone);
            $scenesRelated[$i]->zone = $zone->name;
            $scenesRelated[$i]->pos =  $zone->position; //La posicion del ascensor se realiza en funcion de la de la zona
        }
       
        return response()->json($scenesRelated);
    }
}