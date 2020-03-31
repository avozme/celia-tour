@extends('layouts.access')

@section('headExtension')
    <script type="text/javascript" src="{{ url('js/install/install.js') }}"></script>
@endsection

@section('content')
<div id="content" class="col100 centerV row100">

    <div class="col100" style="margin-top:-2%">
        <div class="col100 centerH">
            <img class="col25" src="{{ url('/img/logo.png')}}"/>
        </div>

        <form id="installForm" class="col80 xxlMarginTop" action="{{ route('install.instalation') }}" method="get" style="margin-left: 18%">
            <div class="col40" style="margin-right: 13%">
                <div class="col100"><span class="semiTitle">Para la instalación será necesario introducir el nombre de una base de datos previamente creada</span></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="">Nombre de la base de datos</label></div>
                <div class="co100 sMarginTop"><input class="col80" type="text" name="BDName" ></div>
                <div class="col100 mMarginTop sMarginBottom"><label >Nombre del servidor (localhost por defecto)</label></div>
                <div class="col100 sMarginTop"><input class="col80" type="text" name="SName" value="localhost" ></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="">Nombre del usuario de la base de datos (root por defecto)</label></div>
                <div class="col100 sMarginTop"><input class="col80" type="text" name="UName" value="root" ></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="">Contraseña (sin contraseña por defecto)</label></div>
                <div class="col100 sMarginTop"><input class="col80" type="password" name="PName" value=""></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="">Sitema operativo actual</label></div>
                <div class="col100">
                    <input type="radio" name="Sys" value="windows"> 
                    <label for="windows">windows</label><br>
                </div>
                <div class="col100">
                    <input type="radio" name="Sys" value="linux">
                    <label for="linux">linux</label>
                </div>
            </div>
            <div class="col30">
                <div class="col100"><span class="semiTitle">Creación de usuario administrador:</span></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="name">Nombre</label></div>
                <div class="col100 sMarginTop"><input class="col100" type="text" id="userName" name="Name" value="" ></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="password">Contraseña  </label></div>
                <div class="col100 sMarginTop"><input class="col100" type="password" id="userPass1" name="Pass" value="" ></div>
                <div class="col100 mMarginTop sMarginBottom"><label  for="password">Confirma la contraseña  </label></div>
                <div class="col100 sMarginTop"><input class="col100" type="password" id="userPass2" name="PassC" value="" ></div>
                <div id="errorMsgUser" class="col100">
                    <span></span>
                </div>
            </div>
            
            <div class="col100 lMarginTop" style="margin-left: 25%">
                <input class="col30" type="submit" value="Crear">
            </div>
        </form>
    </div>
</div>

<style>
    .semiTitle {
        padding: 4px 0px;
        font-size: 20px;
        font-weight: 500;
        color: rgb(104, 104, 104);
    }
</style>
@endsection