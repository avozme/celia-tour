<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portkey extends Model
{
    protected $fillable=['name'];

    public function scene(){
        return $this->belongsToMany("App\Scene", 'portkeys_scene', 'portkey_id', 'scene_id');
    }
}

