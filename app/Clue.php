<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clue extends Model
{
    protected $fillable = ['text', 'show', 'id_question', 'id_hide'];
}
