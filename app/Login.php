<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * Atributos que deben ocultarse para las matrices.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}