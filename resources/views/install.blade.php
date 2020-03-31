@extends('layouts.access')

@section('headExtension')

@endsection

@section('content')
<div id="content" class="col100 centerV row100">

    <div class="col100" style="margin-top:-5%">
        <div class="col100 centerH">
            <img class="col25" src="{{ url('/img/logo.png')}}"/>
        </div>

        <form class="col100" action="{{ route('install.instalation') }}" method="get">
            <div class="col100"><span>Para la instalación será necesario introducir el nombre de una base de datos previamente creada</span></div>
            <div class="col100">Nombre de la base de datos</div>
            <div class="co100"><input type="text" name="BDName" required></div>
            Complete los campos para generear el archivo .env </br> </br>
            Nombre del servidor (localhost por defecto) <input type="text" name="SName" value="localhost" required> </br> </br>
            Nombre del usuario de la base de datos (root por defecto)<input type="text" name="UName" value="root" required> </br> </br>
            Contraseña (sin contraseña por defecto) <input type="text" name="PName" value=""> </br> </br>
            Sitema operativo actual </br> 
                <input type="radio" name="Sys" value="windows">
                <label for="windows">windows</label><br>
                <input type="radio" name="Sys" value="linux">
                <label for="linux">linux</label><br> </br> </br>
            Creación de usuario administrador: </br> </br>
            Nombre  <input type="text" name="Name" value="" required> </br> </br>
            Contraseña  <input type="text" name="Pass" value="" required> </br> </br>
            <input type="submit" value="crear"></form>
    </div>
</div>
@endsection

