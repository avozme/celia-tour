<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model{

    protected $fillable = ['title', 'id_scene', 'position', 'scene_file'];

    public function scene(){
        return $this->hasOne('App\Scene');
    }
}
