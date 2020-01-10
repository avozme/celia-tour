<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        if($users == "" or $users == null){
            return view('backend.user.create');
        }else{
            return view('backend.user.index', ['userList'=>$users]);
        }
    }

    public function store(Request $u){
        $users = new User($u->all());
        $users->save();
        return redirect()->route('backend.user.index');
    }

    public function create(){
        return view('backend.user.create');
    }

    public function show($id){
        $user = User::find($id);
        if ($user != null) {
            $users[0] = $user;
        } else {
            $users = null;
        }
        return view('backend.user.index', ['userList' => $users]);       
    }

    public function update(Request $u){
        $users = User::find($u->id);
        $u->fill($u->all());
        $users->save();
        return redirect()->route('backend.user.index');     
    }

    public function destroy($id){
        $users = User::find($id);
        $users->delete();
        return redirect()->route('backend.user.index');
    }

    public function edit($id){
        $user = User::find($id);
        return view('backend.user.create', array('user' => $user));
    }
}