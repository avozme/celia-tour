<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * Atributos que deben ocultarse para las matrices.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function checkLogin($name){
        
        $userList = User::all();

        $found = false;

        foreach ($userList as $u):
            if ($u->name == $name) //&& $u->password):
                $found = true;
            endif;
        endforeach;
        return $found;
    }
}