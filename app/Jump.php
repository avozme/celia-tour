<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jump extends Model{

    protected $fillable = ['id_scene_destination', 'destination_pitch', 'destination_yaw', 'hotspot_id'];

}