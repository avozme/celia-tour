<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;
use App\Jump;
use App\HotspotType;

class HotspotTypeController extends Controller
{

    /**
     * METODO PARA OBTENER EL ID DE UN SALTO DE UN HOTSPOT
     */
    public function getIdJump($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['jump' => $hotspottype[0]['id_type']]);
        //echo $hotspottype[0]['id_type'];
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER EL ID DE UNA GALERIA DE UN HOTSPOT
     */
    public function getIdGallery($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['gallery' => $hotspottype[0]['id_type']]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER EL ID DE UN TRASLADOR DE UN HOTSPOT
     */
    public function getIdPortkey($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['portkey' => $hotspottype[0]['id_type']]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER EL ID TIPO DE UNA RELACION DE LA TABLA INTERMEDIA DEL HOTSPOT
     */
    public function getIdType($id){
        $hotspottype = HotspotType::where('id_hotspot', $id)->get();
        return response()->json(['id_type' => $hotspottype[0]['id_type']]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR EL ID TIPO DE LA TABLA INTERMEDIA DE UN HOTSPOT
     */
    public function updateIdType(Request $r){
        $hotspottype = HotspotType::where('id_hotspot', $r->hotspot)->get();
        $ht = HotspotType::find($hotspottype[0]->id);
        $ht->id_type = $r->id_type;
        if($ht->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }
    
    
}