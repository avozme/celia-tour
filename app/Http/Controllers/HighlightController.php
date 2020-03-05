<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Highlight;
use App\Scene;
use App\Zone;
use DB;

class HighlightController extends Controller{

    /*public function __construct(){

        $this->middleware('admin');
    }*/

    public function index(){
        $highlights = DB::table('highlights')->orderBy('position')->get();
        $data['rows'] = DB::table('highlights')->count();
        
        return view('backend/highlight.index', ['highlightList' => $highlights ], $data);
    }

    public function create(){
        $zone = Zone::find(1);
        $scenes = Scene::all();
        $data['firstZoneId'] = 1;
        $data['zones'] = Zone::all();

        return view('backend/highlight.create', $data);
    }

    public function store(Request $h){
        $last_highlight = Highlight::orderBy('position', 'desc')->take(1)->get()[0];
        $new_position = $last_highlight->position + 1;
        $highlight = new Highlight();
        $highlight->title = $h->title;

        Highlight::create([
            'title' => $h['title'],
            'id_scene' => $h['id_scene'],
            'position' => $new_position,
            'scene_file' => $h['scene_file'],
        ]);

        /*$highlight->position = $h->position;
        if($h->initial_zone){
            $highlight->initial_zone = true;
        }else {
            $highlight->initial_zone = false;
        }*/
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
        $data['highlight'] = Highlight::find($id);
        $data['firstZoneId'] = Scene::find($data['highlight']->id_scene)->id_zone;
        $data['zones'] = Zone::all();
        
        return view('backend/highlight.create', $data);
    }

    public function update(Request $h, $id){
        $highlight = new Highlight();
        $highlight->title = $h->title;

        $highlights = Highlight::find($id);
        $highlights->fill($h->all());
        $highlights->save();
        return redirect()->route('highlight.index');

        if($h->initial_zone){
            $highlight->initial_zone = true;
        }else {
            $highlight->initial_zone = false;
        }
        $zone->save();
        
        return redirect()->route('highlight.index');
    }

    public function destroy($id){

        $highlights = Highlight::find($id);
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
        if($movement == 'u'){
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
