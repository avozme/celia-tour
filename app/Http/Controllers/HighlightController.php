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

    public function index(){
        $highlights = Highlight::all();
        return view('backend/highlight.index', ['highlightList' => $highlights ]);
    }

    public function create(){
        $zone = Zone::find(1);
        $scenes = Scene::all();
        return view('backend/highlight.create', ['scenes' => $scenes, 'zone' => $zone]);
    }

    public function store(Request $h){

        Highlight::create([
            'row' => $h['row'],
            'column' => $h['column'],
            'title' => $h['title'],
            'id_scene' => $h['id_scene'],
            'scene_file' => $h['scene_file'],
        ]);
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
        $highlight = Highlight::find($id);
        return view('backend/highlight.create', array('highlight' => $highlight));
    }

    public function update(Request $h, $id){

        $highlights = Highlight::find($id);
        $highlights->fill($h->all());
        $highlights->save();
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
        $zones = Zone::all();

        return view('backend/zone/map/zonemap', ['zones' => $z ]);
        
        //return response()->json(['highlight' => $highlight, 'scenes' => $scenes]);
    }
}
