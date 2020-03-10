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

    public function index(){
        $highlights = DB::table('highlights')->orderBy('position')->get();
        $data['rows'] = DB::table('highlights')->count();
        
        return view('backend/highlight.index', ['highlightList' => $highlights ], $data);
    }

    public function create(){
        $zone = Zone::find(1);
        $scenes = Scene::all();
        $data['firstZoneId'] = 1;
        $data['zones'] = Zone::orderBy('position')->get();
        return view('backend/highlight.create', $data);
    }

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
        
        //$file = $r->file('scene_file');
        $name = $r->file('scene_file')->getClientOriginalName();
        $r->file('scene_file')->move(public_path('/img/resources/'), $name);
        $highlight->scene_file = $name;
        $highlight->save();
        return redirect()->route('highlight.index');
    }

    public function show($id){

        $highlight = Highlight::find($id);
        if ($highlight != null) {
            $highlights[0] = $highlight;
        } else {
            $highlights = null;
        }
        return view('backend/highlight.index', ['highlightList' => $highlights]);      
    }

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
            $file->move(public_path().'/img/resources/', $name);
            $highlights->scene_file = $name;
        }
        $highlights->save();
        
        return redirect()->route('highlight.index');
    }

    public function destroy($id){

        $highlights = Highlight::find($id);
        $file = $highlights->scene_file;
        unlink(public_path().'/img/resources/'.$file);
        $highlights->delete();
        return redirect()->route('highlight.index');
    }

    public function map($id){
        $highlight = Highlight::find($id);
        $scenes = $highlight->scenes();

        return view('backend/zone/map/zonemap', $scenes);
    }

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
