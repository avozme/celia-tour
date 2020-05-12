<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;
use App\Jump;
use App\HotspotType;

class JumpController extends Controller
{
    /**
     * METODO PARA ACTUALIZAR LOS VALORES DE UN SALTO EN LA BASE DE DATOS
     */
    public function store(Request $r){
        $jump = new Jump();
        $jump->id_scene_destination = 0;
        $jump->destination_pitch = 0;
        $jump->destination_yaw = 0;
        $result = $jump->save();
        //echo $result;
        return response()->json(['status' => $result, 'jumpId' => $jump->id]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UN SALTO EN LA BASE DE DATOS
     */
    public function edit(Request $r){
        $jump = Jump::find($r->id_jump);
        if($r->id_scene_dest != null){
            $jump->id_scene_destination = $r->id_scene_dest;
        }
        if($r->dest_pitch != null){
            $jump->destination_pitch = $r->dest_pitch;
        }
        if($r->dest_yaw != null){
            $jump->destination_yaw = $r->dest_yaw;
        }
        if($r->hotspot_id != null){
            $jump->hotspot_id = $r->hotspot_id;
        }
        return $jump->save();
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UN SALTO DE LA BASE DE DATOS
     */
    public function destroy($jump_id){
        $jump = Jump::find($jump_id);
        return $jump->delete();
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LAS POSICIONES DE LA VISTA EN LA ESCENA AL REALIZAR EL SALTO
     */
    public function editPitchYaw(Request $r){
        $jump = Jump::find($r->id);
        $jump->destination_pitch = $r->pitch;
        $jump->destination_yaw = $r->yaw;
        if($jump->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LA ESCENA A LA QUE SE SALTA
     */
    public function editDestinationScene(Request $r){
        $jump = Jump::find($r->id);
        $jump->id_scene_destination = $r->sceneDestinationId;
        if($jump->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LA ESCENA DE DESTINO A LA QUE SE SALTA A TRAVES DE UN ID INDICADO POR PARAMETRO
     */
    public function getSceneDestId($jumpId){
        $jump = Jump::find($jumpId);
        return response()->json(['destSceneId' => $jump->id_scene_destination, 'pitch' => $jump->destination_pitch, 'yaw' => $jump->destination_yaw]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LA ESCENA DE DESTINO A LA QUE SE SALTA A TRAVES DE UN SALTO INDICADO POR PARAMETRO
     */
    public function getDestination(Jump $jump){
        return response()->json(['destination' => $jump->id_scene_destination, 'pitch' => $jump->destination_pitch, 'yaw'=>$jump->destination_yaw]);
    }
}
