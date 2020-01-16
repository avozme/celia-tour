<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SceneGuidedVisit extends Model
{
    protected $table = 'scenes_guided_visit';

    public function guidedVisit() {
        return $this->belongsTo('App\GuidedVisit');
    }
}
