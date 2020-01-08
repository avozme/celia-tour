<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        if($users == "" or $users == null){
            return view('user.create');
        }else{
            return view('user.index', ['userList'=>$users]);
        }
    }

    public function store(Request $u){
        $users = new User();
        $users->id = $u->id;
        $users->nick = $u->nick;
        $users->email = $u->email;
        $users->password = $u->password;
        $users->type = $u->type;
        $users->save();
        return redirect()->route('user.index');
    }

    public function create(){
        return view('user.create');
    }

    public function show($id){
        $user = User::find($id);
        if ($user != null) {
            $users[0] = $user;
        } else {
            $users = null;
        }
        return view('user.index', ['userList' => $users]);       
    }

    public function update(Request $u){
        $users = User::find($u->id);
        $users->nick = $u->nick;
        $users->email = $u->email;
        $users->password = $u->password;
        $users->type = $u->type
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
        return view('user.create', array('user' => $user));
    }
}