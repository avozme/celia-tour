<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function __construct(){

        $this->middleware('admin');
    }
    
    public function index(){
        $users = User::all();
        if($users == "" or $users == null){
            return view('backend/user.create');
        }else{
            return view('backend/user.index', ['userList'=>$users]);
        }
    }

    public function store(Request $u){
    
        $validarEmail = User::checkEmail($u->email); 
        
        if($validarEmail == false){
            User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make($u['password']),
                'type' => $u['type'],
                ]);
                return redirect()->route('user.index');
            }else {
                return view('backend/user.create');
        }
           
    }

    public function create(){
        return view('backend/user.create');
    }

    public function show($id){
        $user = User::find($id);
        if ($user != null) {
            $users[0] = $user;
        } else {
            $users = null;
        }
        return view('backend/user.index', ['userList' => $users]);       
    }

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

    public function destroy($id){
        $users = User::find($id);
        $users->delete();
        return redirect()->route('user.index');
    }

    public function edit($id){
        $user = User::find($id);
        return view('backend/user.create', array('user' => $user));
    }
}