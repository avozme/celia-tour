<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;

class JumpController extends Controller
{
    public function store($id_scene_dest, $dest_pitch, $dest_yaw, $hotspot_id){
        $jump = new Jump();
        $jump->id_scene_destination = $id_scene_dest;
        $jump->destination_pitch = $dest_pitch;
        $jump->destination_yaw = $dest_yaw;
        $jump->hotspot_id = $hotspot_id;
        return $jump->save();
    }

    public function edit($id_jump, $id_scene_dest, $dest_pitch, $dest_yaw, $hotspot_id){
        $jump = Jump::find($id_jump);
        if($id_scene_dest != null){
            $jump->id_scene_destination = $id_scene_dest;
        }
        if($dest_pitch != null){
            $jump->destination_pitch = $dest_pitch;
        }
        if($dest_yaw != null){
            $jump->destination_yaw = $dest_yaw;
        }
        if($hotspot_id != null){
            $jump->hotspot_id = $hotspot_id;
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
}
