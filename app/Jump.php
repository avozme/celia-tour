<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jump extends Model
{
    protected $fillable = ['destination_pitch', 'destination_yaw'];

    //RELACIONES
    public function JumpIsHotspot(){
        return $this->belongsTo('App\Hotspot');
    }
}
