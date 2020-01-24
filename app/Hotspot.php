<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model{
    //Campos que pueden agragarse al objeto por asignacion masiva
    protected $fillable = [
        "title", "description", "pitch", "yaw", "highlight_point", "scene_id"
    ];

    //RELACIONES
    public function isType(){
        return $this->hasOne('App\HotspotType', 'id_hotspot');
    }

}