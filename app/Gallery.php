<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'description', 'hotspot_id'];

    public function recursos(){
        return $this->belongsToMany("App\Resource", 'resources_gallery', 'gallery_id', 'resource_id');
    }

}
