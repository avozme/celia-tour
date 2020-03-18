<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryScene extends Model{
    protected $fillable = ['name', 'date', 'pitch', 'yaw', 'directory_name'];

    /*METODO PARA RECURPERAR EL ID DE LA SCENA */
    public function isID(){
        return $this->hasOne('App\Scene', 'id_scenes');
    }

    /**
     * METODO PARA OBTENER LOS HOTSPOT RELACIONADOS CON UNA ESCENA
     */
    public function relatedHotspot(){
        return $this->hasMany('App\Hotspot', 'id_secondary_scene');
    }
}