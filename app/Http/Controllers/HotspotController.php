<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;
use App\HotspotType;

class HotspotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * METODO PARA ALMACENAR UN HOTSPOT EN LA BASE DE DATOS
     */
    public function store(Request $request){
        $hotspot = new Hotspot($request->all());

        //Indicamos si se ha almacenado correctamente
        if($hotspot->save()){
                //Agregar fila a la tabla intermedia de tipos
                $hotspotType = new HotspotType();
                $hotspotType->id_hotspot = $hotspot->id;
                $hotspotType->id_type = 0;
                $hotspotType->type = $request->type;
                //Guardar
                if($hotspotType->save()){
                    return response()->json(['status'=> true, 'id'=>$hotspot->id]);
                }
        }
        
        return response()->json(['status'=> false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * METODO PARA ACTUALIZAR EL HOTSPOT EN LA BASE DE DATOS
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotspot $hotspot){
        //Eliminar hotspot
        $hotspot->delete();

        //Comprobar que se ha eliminado
        if(Hotspot::find($hotspot->id)==null){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }
}
