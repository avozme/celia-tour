@extends('layouts.backend')

@section('headExtension')

@endsection

@section('content')
<form action="{{ route('install.instalation') }}" method="get">
Para la instalación será necesario introducir el nombre de una base de datos previamente creada </br> </br>
Nombre de la base de datos <input type="text" name="BDName" required> </br> </br>
Nombre del servidor (localhost por defecto) <input type="text" name="SName" value="localhost" required> </br> </br>
Nombre del usuario de la base de datos (root por defecto)<input type="text" name="UName" value="root" required> </br> </br>
Contraseña (sin contraseña por defecto) <input type="password" name="PName" value=""> </br> </br>
Sitema operativo del servidor </br> 
    <input type="radio" name="Sys" value="windows">
    <label for="windows">windows</label><br>
    <input type="radio" name="Sys" value="linux">
    <label for="linux">linux</label><br> </br> </br>
Creación de usuario administrador: </br> </br>
Nombre  <input type="text" name="Name" value="" required> </br> </br>
Contraseña  <input type="password" name="Pass" value="" required> </br> </br>
Confirme la contraseña  <input type="password" name="PassC" value="" required> </br> </br>
<input type="submit" value="crear"></form>
@endsection