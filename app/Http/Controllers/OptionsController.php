<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Option;
use App\Zone;
use App\Scene;
use DB;

class OptionsController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA DE EDICION DE OPCIONES
     */
    public function edit(){
        $options = Option::all();
        $data['options'] = $options;
        $data['firstZoneId'] = 1;
        $data['zones'] = Zone::orderBy('position')->get();
        return view('admin.options', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS VALORES DE LAS OPCIONES EN LA BASE DE DATOS
     */
    public function update(Request $r, $id)
    {
    	$op = Option::find($id);
    	$image= $r->file('option');
    	if($r->file('option') != null):
    		Storage::disk('optionsimages')->delete($op->value);
            $file = $r->file('option');
            $name = $file->getClientOriginalName();
            Storage::disk('optionsimages')->put($name, File::get($file));
            $op->value = $name;
        else:
        	$op->value = $r->option;    
        endif;

        //Actualizar variable de sesion que indica si mostrar o no la opcion de escape room
        if($id==20 && $r->option=="Si"){
            Session::put('escape', true);
        }else if($id==20){
            Session::put('escape', false); 
        }

       	$op->save();
        
        return redirect()->route('options.edit');
    }

    /*FUNCIÓN PARA ACTUALIZAR LA IMAGEN DE PORTADA Y EL TIPO*/
    public function update_cover(Request $request, $idportada, $idTipoPortada){
        //Esto nos guarda el valor del tipo de la imagen
        $tipoPortada = Option::find($idTipoPortada);
        $tipoPortada->value = $request->option; 
        $tipoPortada->save();
        $op = Option::find($idportada);
        //Busco la escena cover actual en la base de datos
        $actualCoverId = DB::select('SELECT id FROM scenes WHERE cover=1');
        if(!empty($actualCoverId)){
            //La recojo como un objeto Scene
            $actualSceneCover = Scene::find($actualCoverId[0]->id);
            //Pongo cover en false
            $actualSceneCover->cover = 0;
            //Guardo la antigua escena cover
            $actualSceneCover->save();
        }
        //Aqui miramos el tipo y según el tipo guardamos como:
        if($tipoPortada->value=="Panoramica"){
            //Imagen panoramica:
            $idScene = $request->idScene;
            $escena = Scene::find($idScene);
            //Pongo la escena que se está actualizando como cover true
            $escena->cover = true;
            $escena->save();
            $op->value = $escena->id;
        }else{
            //Imagen estatica:
            $image= $request->file('optionf');
            if($request->file('optionf') != null):
                Storage::disk('optionsimages')->delete($op->value);
                $file = $request->file('optionf');
                $name = $file->getClientOriginalName();
                Storage::disk('optionsimages')->put($name, File::get($file));
                $op->value = $name;   
            endif;
        }
        $op->save();
        
        return redirect()->route('options.edit');
    }
}