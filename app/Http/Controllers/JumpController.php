<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;
use App\Jump;

class JumpController extends Controller
{
    public function store(Request $r){
        $jump = new Jump();
        $jump->id_scene_destination = 0;
        $jump->destination_pitch = 149.399999999;
        $jump->destination_yaw = 54.3999999999;
        $result = $jump->save();
        //echo $result;
        return response()->json(['status' => $result, 'jumpId' => $jump->id]);
    }

    public function edit(Request $r){
        $jump = Jump::find($r->id_jump);
        if($r->id_scene_dest != null){
            $jump->id_scene_destination = $r->id_scene_dest;
        }
        if($r->dest_pitch != null){
            $jump->destination_pitch = $r->dest_pitch;
        }
        if($r->dest_yaw != null){
            $jump->destination_yaw = $r->dest_yaw;
        }
        if($r->hotspot_id != null){
            $jump->hotspot_id = $r->hotspot_id;
        }
        return $jump->save();
    }

    public function destroy($jump_id){
        $jump = Jump::find($jump_id);
        return $people->delete();
    }

    public function editPitchYaw($id_jump, $pitch, $yaw){
        $jump = Jump::find($id_jump);
        $jump->destination_pitch = $pitch;
        $jump->destination_yaw = $yaw;
        return $jump->save();
    }

    public function getDestination(Jump $jump){
        return response()->json(['destination' => $jump->id_scene_destination, 'pitch' => $jump->destination_pitch, 'yaw'=>$jump->destination_yaw]);
    }
}
