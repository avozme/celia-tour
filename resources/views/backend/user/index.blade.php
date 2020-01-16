@extends('layouts/backend')

@section('title', 'Listado de usuarios Celia-Tour')

@section('content')

<div id="title" class="col80"><h1>Tabla de usuarios</h1></div>

<div id="contentbutton" class="col20">
    <input type="button" value="Insertar Usuario" onclick="window.location.href='{{ route('user.create')}}'">
</div>

<div id="content" class="col100">

    <div nombre class="col20">Nombre</div>
    <div email class="col20">E-mail</div>
    <div tipo class="col20">Tipo</div>
    <div modificar class="col20">Modificar</div>
    <div borrar class="col20">Borrar</div>
    
    @foreach($userList as $user) 
        @if ($user->type == 0)
            @php 
                $valor = "Pendiente de Asignación" 
            @endphp
        @elseif($user->type == 1) 
            @php 
                $valor = "Admin" 
            @endphp
        @endif
        
        <div nombre class="col20">{{$user->name}}</div>
        <div email class="col20">{{$user->email}}</div>
        <div tipo class="col20">{{$valor}}</div>
        <div modificar class="col20">
            <input type="button" value="Modificar" onclick="window.location.href='{{ route('user.edit', $user->id) }}'">
        </div>
        <div borrar class="col20">
            <input type="button" value="Eliminar" onclick="window.location.href='{{ route('user.destroy', $user->id) }}'">
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