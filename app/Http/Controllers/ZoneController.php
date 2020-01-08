<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zone;

class ZoneController extends Controller
{
    public function index(){
        //index
    }

    public function show(){
        $zones = Zone::all();
        $data["zones"] = $zones;
        return view('zone/tryshow', $data);
    }

    public function create(Request $r){
        return view('zone/trycreate');
    }

    public function store(Request $r){
        $zone = new Zone($r->all());
        $zone->save();
        return redirect()->route('zone.create');
    }

    public function edit($id){
        $zone = Zone::find($id);
        //dd($zone);
        $data['zone'] = $zone;
        return view('zone/tryedit', $data);
    }

    public function update(Request $r, $id){
        $zone = Zone::find($id);
        $zone->name = $r->name;
        $zone->file_image = $r->file_image;
        $zone->file_miniature = $r->file_miniature;
        $zone->save();
        return redirect()->route('zone.show');
    }

    public function destroy(Request $r){
        //destroy
    }

}
