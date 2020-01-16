<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuidedVisit extends Model
{
    /*
    * Los campos nombrados se asignan masivamente.
    */
    protected $fillable = ['name', 'description'];

    public function sgv() {
        return $this->hasMany('App\SceneGuidedVisit', 'id_guided_visit');
    }
    
}
