@extends('layouts/backend')

@section('title', 'Listado de usuarios Celia-Tour')

@section('content')

<div id="title" class="col80"><h1>Tabla de usuarios</h1></div>

<div id="contentbutton" class="col20">
    <button type="button" value="Insertar Usuario" onclick="window.location.href='{{ route('user.create')}}'">Insertar Usuario</button>
</div>

<div id="content" class="col100">

    <div class="col20">Nombre</div>
    <div class="col20">E-mail</div>
    <div class="col20">Tipo</div>
    <div class="col20">Modificar</div>
    <div class="col20">Borrar</div>
    
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
        
        <div class="col20">{{$user->name}}</div>
        <div class="col20">{{$user->email}}</div>
        <div class="col20">{{$valor}}</div>
        <div class="col20">
            <button type="button" value="Modificar" onclick="window.location.href='{{ route('user.edit', $user->id) }}'">Modificar</button>
        </div>
        <div class="col20">
            <button type="button" value="Eliminar" onclick="window.location.href='{{ route('user.destroy', $user->id) }}'">Eliminar</button>
        </div>
    @endforeach
</div>

<div id="contentmodal">
    <div id="windowsmodal">
        <div class="col100">
        </div>
        <div id="actionbutton">
            <div id="acept" class="col50">
            <div id="cancel" class="col50">
        </div>
    </div>
</div>
@endsection