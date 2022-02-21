<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;
use App\HotspotType;

class HotspotController extends Controller{

    public function show($idHotspot){
        $hotspot = Hotspot::find($idHotspot);
        return response()->json(['hotspot' => $hotspot]);
    }
    
    /* METODO PARA ALMACENAR UN HOTSPOT EN LA BASE DE DATOS */
    public function store(Request $request){
        $hotspot = new Hotspot($request->all());

        //Indicamos si se ha almacenado correctamente
        if($hotspot->save()){
            //Agregar fila a la tabla intermedia de tipos
            $hotspotType = new HotspotType();
            $hotspotType->id_hotspot = $hotspot->id;
            $hotspotType->id_type = -1; //Por defecto creacion sin recurso asociado
            $hotspotType->type = $request->type;
            //Guardar
            if($hotspotType->save()){
                return response()->json(['status'=> true, 'id'=>$hotspot->id]);
            }
        }
        
        return response()->json(['status'=> false]);
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA ACTUALIZAR EL HOTSPOT EN LA BASE DE DATOS */
    public function update(Request $request, Hotspot $hotspot){
        //Rellenar los nuevos datos
        $hotspot->fill($request->all());
        //Actualizar base datos
        if($hotspot->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA ACTUALIZAR LA POSICION DEL HOTSPOT */
    public function updatePosition(Request $request, Hotspot $hotspot){
        //Rellenar los nuevos datos de posicion
        $hotspot->pitch = $request->pitch;
        $hotspot->yaw = $request->yaw;

        //Actualizar base datos
        if($hotspot->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA ACTUALIZAR EL ID DEL RECURSO ASOCIADO EN LA TABLA INTERMEDIA DEL HOTSPOT */
    public function updateIdType(Request $request, Hotspot $hotspot){
        //Buscar el registro de la tabla intermedia que asocia el hotspot con un recurso
        $idTableType = $hotspot->isType->id;
        $HotspotType = HotspotType::find($idTableType);
        //Establecer el nuevo tipo
        $HotspotType->id_type = $request->newId;

        //Actualizar base datos
        if($HotspotType->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA ELIMINAR UN HOTSPOT */
    public function destroy(Hotspot $hotspot){

        $element = HotspotType::where('id_hotspot',$hotspot->id)->get();
        $HotspotType = HotspotType::find($element[0]->id);
        
        //Comprobar que se ha eliminado
        if($hotspot->delete()&&$HotspotType->delete()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /* FUNCIÓN PARA ACTUALIZAR HIGHlIGHT_POINT */
    public function updateHlPoint(Request $r, $hotspotId){
        $hotspot = Hotspot::find($hotspotId);
        $hotspot->highlight_point = $r->hlPoint;
        if($hotspot->save())
            return response()->json(['status' => true]);
        else
        return response()->json(['status' => false]);
    }
}
