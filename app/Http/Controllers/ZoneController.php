<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Zone;

class ZoneController extends Controller
{
    public function index(){
        $zones = Zone::all();
        $data["zones"] = $zones;
        return view('backend/zone/index', $data);
    }

    public function show($id){
        $zone = Zone::find($id);
        $data['zone'] = $zone;
        return view('backend/zone/show', $data);
    }

    public function create(){
        return view('backend/zone/create');
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

        $zone->position = $r->position;
        if($r->initial_zone){
            $zone->initial_zone = true;
        }else {
            $zone->initial_zone = false;
        }
        $zone->save();
        return redirect()->route('zone.index');
    }

    public function edit($id){
        $zone = Zone::find($id);
        $data['zone'] = $zone;
        return view('backend/zone/edit', $data);
    }

    public function update(Request $r, $id){
        $zone = Zone::find($id);
        $zone->name = $r->name;
        //Modifico la imagen de la zona
        $image = $r->file('file_image');
        if($image != null){
            Storage::disk('zoneimage')->delete($zone->file_image);
            $imagename = $image->getClientOriginalName();
            Storage::disk('zoneimage')->put($imagename, File::get($image));
            $zone->file_image = $imagename;
        }

        //Modifico la miniatura de la zona
        $miniature = $r->file('file_miniature');
        if($miniature != null){
            Storage::disk('zoneminiature')->delete($zone->file_miniature);
            $miniaturename = $miniature->getClientOriginalName();
            Storage::disk('zoneminiature')->put($miniaturename, File::get($miniature));
            $zone->file_miniature = $miniaturename;
        }
        if($r->initial_zone){
            $zone->initial_zone = true;
        }else {
            $zone->initial_zone = false;
        }
        $zone->save();
        return redirect()->route('zone.index');
    }

    public function destroy($id){
        $zone = Zone::find($id);
        Storage::disk('zoneimage')->delete($zone->file_image);
        Storage::disk('zoneminiature')->delete($zone->file_miniature);
        $zone->delete();
        return redirect()->route('zone.index');
    }

}
