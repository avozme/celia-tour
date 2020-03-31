@extends('layouts.access')

@section('headExtension')
    <script type="text/javascript" src="{{ url('js/install/install.js') }}"></script>
@endsection

@section('content')
<div id="content" class="col100">
    <center>
        <div class="lPaddingTop col100 centerH">
            <img class="col25" src="{{ url('/img/logo.png')}}"/>
        </div>

        <form id="installForm" class="col100 xxlMarginTop" action="{{ route('install.instalation') }}" method="get">
            <div class="col100 centerH">
                <div class="col70">
                    <div class="groupInstall col48 mPaddingTop mPaddingBottom lPaddingLeft lPaddingRight" style="margin-right: 1%">
                        <span class="col100 subtitleInstall">Base de datos</span>
                        <div class="col100"><span class="col100 descriptionInstall">Para la instalación será necesario introducir los datos de una base de datos previamente creada.</span></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="">Nombre de la base de datos</label></div>
                        <div class="col100"><input class="col100" type="text" name="BDName" required></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" >Nombre del servidor (localhost por defecto)</label></div>
                        <div class="col100"><input class="col100" type="text" name="SName" value="localhost" required></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="">Nombre del usuario de la base de datos (root por defecto)</label></div>
                        <div class="col100"><input class="col100" type="text" name="UName" value="root" required></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100"  for="">Contraseña (sin contraseña por defecto)</label></div>
                        <div class="col100"><input class="col100" type="password" name="PName" value=""></div>
                        
                    </div>

                    <div class="groupInstall col48 mPaddingTop mPaddingBottom lPaddingLeft lPaddingRight" style="margin-left: 1%">
                        <span class="col100 subtitleInstall">Servidor</span>
                        <div class="col100"><span class="col100 descriptionInstall">Seleccione el tipo de sistema operativo del servidor donde se desea realizar la instalación.</span></div>
                        <div class="radioGroup col100 sMarginTop">
                                <input type="radio" name="Sys" value="windows"> 
                                <label for="windows">Windows</label><br>
                        </div>
                        <div class="radioGroup col100">
                            <input type="radio" name="Sys" value="linux">
                            <label for="linux">Linux</label>
                        </div>
                    </div>
                    
                    <div class="groupInstall col48 mMarginTop mPaddingTop mPaddingBottom lPaddingLeft lPaddingRight" style="margin-left: 1%">
                        <span class="col100 subtitleInstall">Usuario Administrador</span>
                        <div class="col100"><span class="col100 descriptionInstall">Indique la información de accceso del usuario administrador inicial que podrá acceder al sistema.</span></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="name">Nombre</label></div>
                        <div class="col100"><input class="col100" type="text" id="userName" name="Name" value="" required></div>
                        <div class="col50 sPaddingRight">
                            <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="password">Contraseña  </label></div>
                            <div class="col100"><input class="col100" type="password" id="userPass1" name="Pass" value="" required></div>
                        </div>
                        
                        <div class="col50 sPaddingLeft">
                            <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="password">Confirmar contraseña  </label></div>
                            <div class="col100"><input class="col100" type="password" id="userPass2" name="PassC" value="" required></div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col100 xlMarginTop xxlMarginBottom">
                <div class="col100 centerH">
                    <input class="col30" type="submit" value="Crear">
                </div>
            </div>
        </form>
    </center>
</div>
@endsection