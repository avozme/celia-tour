<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zones extends Model
{
    protected $table = 'zones';
    protected $primaryKey = 'id';

    // Relacion uno a muchos con Scenes
    public function scenes(){
        return $this->hasMany('App\Scenes');
    }
}
