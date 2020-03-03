<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceGallery extends Model
{
    protected $table = 'resources_gallery';
    protected $fillable = ['resource_is', 'gallery_id'];
}
