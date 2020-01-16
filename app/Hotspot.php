<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model{
    //Campos que pueden agragarse al objeto por asignacion masiva
    protected $fillable = [
        "title", "description", "pitch", "yaw", "type", "highlight_point", "scene_id"
    ];

    //RELACIONES
    public function jumps(){
        return $this->hasMany('App\Jump', 'hotspot_id');
    }
}
