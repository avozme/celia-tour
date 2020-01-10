<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name', 'file_image', 'file_miniature', 'position', 'initial_zone'];
}
