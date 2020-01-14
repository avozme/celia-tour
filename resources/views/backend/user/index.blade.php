@extends('layouts/backend')

@section('title', 'Listado de usuarios Celia-Tour')

@section('content')

<div id="title" class="col80"><h1>Tabla de usuarios</h1></div>

<div id="contentbutton" class="col20">
    <form action = "{{route('user.create')}}" method="GET">
        @csrf
        @method("INSERT")
        <input type="submit" value="Insertar usuario">
    </form>
</div>

<div id="content" class="col100">

    <div nombre class="col20">Nombre</div>
    <div email class="col20">E-mail</div>
    <div tipo class="col20">Tipo</div>
    <div modificar class="col20">Modificar</div>
    <div borrar class="col20">Borrar</div>
    
    @foreach($userList as $user) 
    
            <div nombre class="col20">{{$user->name}}</div>
            <div email class="col20">{{$user->email}}</div>
            <div tipo class="col20">{{$user->type}}</div>
            <div modificar class="col20">
                <form action = "{{route('user.edit', $user->id)}}" method="GET">
                    @csrf
                    <input type="submit" value="Modificar">
                </form>
            </div>
            <div borrar class="col20">
                <form action = "{{route('user.destroy', $user->id)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" value="Eliminar">
                </form>
            </div>
    @endforeach
</div>

<div id="contentmodal">
    <div id="windowsmodal">
        <div class="col100">
        </div>
        <div id="actionnutton">
            <div id="acept" class="col50">
            <div id="cancel" class="col50">
        </div>
    </div>
</div>
@endsection