<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Option;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function edit()
    {
        $options = Option::all();
        return view('admin.options', array('options' => $options));
    }

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

    public function getPrivacy(){
        $privacidad = Option::where("key", "Propietario legal de la web")->get();
        $data['privacidad'] = $privacidad;
        return view('frontend.privacy', $data);
    }

    public function getCookie(){
        return view('frontend.cookie');
    }

}
