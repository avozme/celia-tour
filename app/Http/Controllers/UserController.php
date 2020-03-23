<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE USUARIOS
     */
    public function index(){
        $users = User::all();
        if($users == "" or $users == null){
            return view('backend/user.create');
        }else{
            return view('backend/user.index', ['userList'=>$users]);
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR UN USUARIO NUEVO EN LA BASE DE DATOS
     */
    public function store(Request $r){
        $user = new User();
        $user->fill($r->all());
        $user->save();
        return redirect()->route('user.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE CREACION DE UN NUEVO USUARIO
     */
    public function create(){
        return view('backend/user.create');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LOS DATOS DE UN USUARIO
     */
    public function show($id){
        $user = User::find($id);
        if ($user != null) {
            $users[0] = $user;
        } else {
            $users = null;
        }
        return view('backend/user.index', ['userList' => $users]);       
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UN USUARIO EN LA BASE DE DATOS
     */
    public function update(Request $u, $id){
        $users = User::find($id);
        $users->name = $u->name;
        $users->email = $u->email;
        if ($u->password != "") {
            $users->password = Hash::make($u->password);
        }
        $users->type = $u->type;
        /*if ($u->type == 0) $users->role = "user";
        else $users->role = "admin";*/
        $users->save();
        return redirect()->route('user.index');     
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UN USUARIO DE LA BASE DE DATOS
     */
    public function destroy($id){
        $users = User::find($id);
        $users->delete();
        return redirect()->route('user.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE EDICION DE UN USUARIO
     */
    public function edit($id){
        $user = User::find($id);
        return view('backend/user.create', array('user' => $user));
    }
}