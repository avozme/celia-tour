<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use DB;
use App\Zone;
use App\SecondaryScene;

class ZoneController extends Controller
{

    public function __construct(){

        $this->middleware('admin');
    }

    public function index(){
        $zones = DB::table('zones')->orderBy('position')->get();
        $data["zones"] = $zones;
        $data['rows'] = DB::table('zones')->count();
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
        $zone->file_image = "";
        $zone->file_miniature = "";
        $zone->position = 0;
        $zone->initial_zone = 0;
        $zone->save();

        $maxPosition = DB::select('SELECT MAX(position) as ultima FROM zones');
        $zone->position = $maxPosition[0]->ultima + 1;
        
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
        $data['scenes'] = $zone->scenes()->get();
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
        $position = $zone->position;
        $allZones = Zone::all();
        for($i = 0; $i < count($allZones); $i++){
            if($allZones[$i]->position > $position){
                $allZones[$i]->position -= 1;
                $allZones[$i]->save();
            }
        }
        Storage::disk('zoneimage')->delete($zone->file_image);
        Storage::disk('zoneminiature')->delete($zone->file_miniature);
        $zone->delete();
        return redirect()->route('zone.index');
    }

    public function updatePosition($opc){
        $movement = substr($opc, 0, 1);
        $id = substr($opc, 1);
        $movedZone = Zone::find($id);
        $newPosition = null;
        if($movement == 'u'){
            $displacedZone = DB::table('zones')->where('position', $movedZone->position - 1)->get(); //[0]
            $newPosition = $displacedZone[0]->id;
        }else {
            $displacedZone = DB::table('zones')->where('position', $movedZone->position + 1)->get(); //[0]
            $newPosition = $displacedZone[0]->id;
        }
        $displacedZone = Zone::find($newPosition);
        $savePosition = $movedZone->position;
        $movedZone->position = $displacedZone->position;
        $displacedZone->position = $savePosition;
        $movedZone->save();
        $displacedZone->save();
        return redirect()->route('zone.index');
        //dd($displacedZone);
    }

    public function map($id){
        $zone = Zone::find($id);
        $scenes = $zone->scenes()->get();
        return response()->json(['zone' => $zone, 'scenes' => $scenes]);
    }

    public function getZoneAndScenes($id){
        $zone = Zone::find($id);
        $scenes = $zone->scenes()->get();
    }

    public function getSecondaryScenes($id){
        $s_scenes = SecondaryScene::fins($id);
        return response()->json(['s_scenes' => $s_scenes]);
    }

    public function pruebas(){
        $maxPosition = DB::select('SELECT MAX(position) as ultima FROM zones');
        //$zone->position = $maxPosition + 1;
        dd($maxPosition);
    }

}
