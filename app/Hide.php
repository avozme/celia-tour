<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hide extends Model
{
    //Campos que pueden agragarse al objeto por asignacion masiva
    protected $fillable = [
        "width", "height", "type"
    ];

    //RELACIONES
    public function isType(){
        return $this->hasOne('App\HotspotType', 'id_hotspot');
    }
}
