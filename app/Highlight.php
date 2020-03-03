<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model{

    protected $fillable = ['title', 'row', 'column', 'scene_file', 'id_scene'];


    public function scene(){
        return $this->hasOne('App\Scene');
    }
}
