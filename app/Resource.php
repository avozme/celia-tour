<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['title', 'description', 'type', 'route'];

    public function galeria(){
        return $this->belongsToMany("App\Gallery", 'resources_gallery', 'resource_id', 'gallery_id');
    }
}
