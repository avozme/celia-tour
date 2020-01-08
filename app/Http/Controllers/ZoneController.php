<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
        $zone = new Zone();
        $zone->name = $r->name;
        //Guardo la imagen de la zona
        $image = $r->file('file_image');
        $imagename = $image->getClientOriginalName();
        Storage::disk('zoneimage')->put($imagename, File::get($image));
        $zone->file_image = $imagename;

        //Guardo la miniatura de la zona
        $miniature = $r->file('file_miniature');
        $miniaturename = $miniature->getClientOriginalName();
        Storage::disk('zoneminiature')->put($miniaturename, File::get($miniature));
        $zone->file_miniature = $miniaturename;

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
