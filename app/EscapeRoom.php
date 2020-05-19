<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscapeRoom extends Model
{
    protected $table = 'escape_rooms';
    protected $fillable = [
        'name', 'description', 'difficulty'
    ];
}
