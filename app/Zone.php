<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name', 'file_image', 'file_miniature', 'position', 'initial_zone'];

    /*FUNCIÓN PARA SACAR LAS ESCENAS A PARTIR DE LAS ZONAS*/
    public function scenes(){
        return $this->hasMany('App\Scene', 'id_zone');
    }
}
