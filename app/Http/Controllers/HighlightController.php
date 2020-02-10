<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Highlight;

class HighlightController extends Controller{

    public function index(){

        $highlights = Highlight::all();
        return view('backend/highlight.index', ['highlightList' => $highlights ]);
    }

    public function create(){

        return view('backend/highlight.create');
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
        return view('backend/highlight.index', ['highlightList' => $highlights]);      
    }

    public function edit($id){

        $highlight = Highlight::find($id);
        return view('backend/highlight.create', array('highlight' => $highlight));
    }

    public function update(Request $request, $id){
        //
    }

    public function destroy($id){

        $highlights = Highlight::find($id);
        $highlights->delete();
        return redirect()->route('highlight.index');
    }
}
