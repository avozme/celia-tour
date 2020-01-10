<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    /**
     * Atributos que deben ocultarse para las matrices.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
