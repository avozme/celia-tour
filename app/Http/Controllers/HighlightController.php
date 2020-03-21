<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Highlight;
use App\Resource;
use App\Scene;
use App\Zone;
use DB;

class HighlightController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE PUNTOS DESTACADOS
     */
    public function index(){
        $highlights = DB::table('highlights')->orderBy('position')->get();
        $data['rows'] = DB::table('highlights')->count();
        $data['firstZoneId'] = 1;
        $data['zones'] = Zone::orderBy('position')->get();
        
        return view('backend/highlight.index', ['highlightList' => $highlights ], $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE CREACION DE UN PUNTO DESTACADO
     */
    public function create(){
        $data['firstZoneId'] = 1;
        $data['zones'] = Zone::orderBy('position')->get();
        return view('backend/highlight.create', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR UN PUNTO DESTACADO NUEVO EN LA BASE DE DATOS
     */
    public function store(Request $r){
        $highlight = new Highlight();
        $highlight->title = $r->title;
        $highlight->id_scene = $r->id_scene;

        $last_highlight = Highlight::orderBy('position', 'desc')->take(1)->get();
        if(empty($last_highlight) == false){
            $highlight->position = $last_highlight[0]->position + 1;
        }else{
            $highlight->position = 1;
        }
        
        $name = $r->file('scene_file')->getClientOriginalName();
        $r->file('scene_file')->move(public_path('/img/resources/'), $name);
        $highlight->scene_file = $name;

        //miniatura
        $miniatura = $r->file('scene_file');
        $ruta = public_path('img/resources/miniatures/'.$name);
        ImageManagerStatic::make($miniatura->getRealPath())->resize(200, 200, function($const){
            $const->aspectRatio();
        })->save($ruta);

        $highlight->save();
        return redirect()->route('highlight.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTAR LA INFORMACION DE UN PUNTO DESTACADO
     */
    public function show($id){
        $highlight = Highlight::find($id);
        return response()->json(['highlight' => $highlight]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE EDICION DE UN PUNTO DESTACADO
     */
    public function edit($id){
        $zone = DB::table('zones')->orderBy('position')->get();
        $data['highlight'] = Highlight::find($id);
        $fz = Scene::find($data['highlight']->id_scene)->id_zone;
        $cambioI = 0;
        for($i=0; $i< $zone->count(); $i++){
            if($zone[$i]->id == $fz){
                $cambioI = $i+1;
            }
        }
        $data['firstZoneId'] = $cambioI;
        $data['zones'] = Zone::all();
   
        return view('backend/highlight.create', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UN PUNTO DESTACADO
     */
    public function update(Request $h, $id){
        $highlights = Highlight::find($id);
        $highlights->title = $h->title;
        $highlights->id_scene = $h->id_scene;

        if ($h->position != "") {
            $highlights->position = $h->position;
        }
        if ($h->scene_file != "") {
            $file = $h->file('scene_file');
            $name = $file->getClientOriginalName();
            $file->move(public_path('img/resources/'), $name);
            $highlights->scene_file = $name;
        }
        $highlights->save();
        
        return redirect()->route('highlight.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UN PUNTO DESTACADO DE LA BASE DE DATOS
     */
    public function destroy($id){
        $highlights = Highlight::find($id);
        $file = $highlights->scene_file;
        unlink(public_path().'/img/resources/'.$file);
        $allHg = Highlight::all();
        $position = $highlights->position;
        for($i = 0; $i < count($allHg); $i++){
            if($allHg[$i]->position > $position){
                $allHg[$i]->position -= 1;
                $allHg[$i]->save();
            }
        }
        $highlights->delete();
        return redirect()->route('highlight.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA CONFECCIONAR UN MAPA DE LA VISITA PARA USARLO EN VENTANA MODAL
     */
    public function map($id){
        $highlight = Highlight::find($id);
        $scenes = $highlight->scenes();

        return view('backend/zone/map/zonemap', $scenes);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LA POSICION DE LOS PUNTOS DESTACADOS
     */
    public function updatePosition($opc){
        $movement = substr($opc, 0, 1);
        $id = substr($opc, 1);
        $movedHL = Highlight::find($id);
        $newPosition = null;
        if($movement == 'u'){ //Subis punto destacado
            $displacedHL = DB::table('highlights')->where('position', $movedHL->position - 1)->get(); //[0]
            $newPosition = $displacedHL[0]->id;
        }else {
            $displacedHL = DB::table('highlights')->where('position', $movedHL->position + 1)->get(); //[0]
            $newPosition = $displacedHL[0]->id;
        }
        $displacedHL = Highlight::find($newPosition);
        $savePosition = $movedHL->position;
        $movedHL->position = $displacedHL->position;
        $displacedHL->position = $savePosition;
        $movedHL->save();
        $displacedHL->save();
        return redirect()->route('highlight.index');
    }
}