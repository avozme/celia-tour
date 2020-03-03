<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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

    public static function checkEmail($email){

        $userList = User::all();
        $found = false;
        
        foreach ($userList as $u):
            if ($u->email == $email):
                $found = true;
            endif;
        endforeach;
        return $found;
    }

}
