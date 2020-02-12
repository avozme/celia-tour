<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    //Campos que pueden agragarse al objeto por asignacion masiva
    protected $fillable = [
        
    ];

    /**
     * METODO PARA OBTENER LOS HOTSPOT RELACIONADOS CON UNA ESCENA
     */
    public function relatedHotspot(){
        return $this->hasMany('App\Hotspot');
    }
    
    public function highlight(){
        return $this->belongsTo('App\Highlight');
    }
    
    public function portkey(){
        return $this->belongsToMany("App\Scene", 'portkeys_scene', 'scene_id', 'portkey_id');
    }
}
