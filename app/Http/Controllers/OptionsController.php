<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Option;

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
        $data['firstZoneId'] = 1;
        return view('admin.options', array('options' => $options, 'data' => $data));
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
       	$op->save();
        
        return redirect()->route('options.edit');
    }
}