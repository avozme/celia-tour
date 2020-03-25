<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portkey;
use App\Scene;
use App\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        $mode = DB::table('options')
                ->where('id', '=', 15)
                ->select('value')
                ->get();

        $mode = $mode[0]->value;
        if($mode == "Ascensor"){
            $data['portkeyList'] = DB::table('portkeys')
                    ->where('image', '=', null)
                    ->select('*')
                    ->get();
            return view('backend.portkey.index', $data);
        } else {
            $data['portkeyList'] = DB::table('portkeys')
                    ->where('image', '!=', null)
                    ->select('*')
                    ->get();
            return view('backend.portkey.map', $data);
        } 
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMECENAR UN PORTKEY EN LA BASE DE DATOS
     */
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'image' => 'file | image'
        ]);

        $portkey = new Portkey($request->all());
        if(isset($request->image)){
            $path = $request->file('image')->store('', 'portkeyMap');
            $portkey->image = $path;
        }
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
        
        if(isset($r->image)){
            Storage::disk('portkeyMap')->delete($prk->image);
            $path = $r->file('image')->store('', 'portkeyMap');
            $prk->image = $path;
        }
        $prk->save();
        return redirect()->route('portkey.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UN PORTKEY DE LA BASE DE DATOS
     */
    public function destroy($id)
    {
        
        $count = DB::table('portkey_scene')
                ->where('portkey_id', $id)
                ->count();
        
        // Se comprueba que no haya escenas asignadas a este traslador
        if($count > 0){
            $data['error'] = true;
        } else {
            $data['error'] = false;
            $portkey = Portkey::find($id);
            Storage::disk('portkeyMap')->delete($portkey->image);
            $portkey->delete();
        }
        return response()->json($data);
    }

    //esto es mio
    public function mostrarRelacion($id)
    {
        $data['zones'] = Zone::orderBy('position')->get();
        $data['firstZoneId'] = 1;

        $data['portkey'] = Portkey::find($id);
        $data['portkeyZoneList'] = Zone::find($id);
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
     * METODO PARA OBTENER LOS DATOS PARA EDITAR UN PORTKEY EN VENTANA MODAL
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