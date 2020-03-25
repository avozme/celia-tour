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
    public function update(Request $r, $id){
        $user = User::find($id);
        $user->name = $r->name;
        $user->email = $r->email;
        if ($r->password != "") {
            $user->password = Hash::make($r->password);
        }
        $user->type = $r->type;
        $user->save();
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

    /* FUNCIÓN PARA OBTENER TODOS LOS DATOS DE UN USUARIO */
    public function getInfo($userId){
        $user = User::find($userId);
        return response()->json(['user' => $user]);
    }
}