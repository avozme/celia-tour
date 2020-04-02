@extends('layouts.access')

@section('headExtension')
    <script type="text/javascript" src="{{ url('js/install/install.js') }}"></script>
@endsection

@section('modal')
    <!-- VENTANA MODAL FIN DE LA INSTALACIÓN -->
    <div id="video"  class="window">
        <span class="titleModal col100">INSTALACIÓN COMPLETADA</span>
        <button id="closew" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="col100 xlMarginTop centerV">
            <div class="col15 mPaddingRight">
                <svg class="col100" viewBox="0 0 512 512">
                    <g id="_x3C_Group_x3E__28_">
                        <path d="m376 60v60h-240v-60h-75v452h390v-452zm-225 397.21-40.61-40.6 21.22-21.22 19.39 19.4 49.39-49.4 21.22 21.22zm0-90-40.61-40.6 21.22-21.22 19.39 19.4 49.39-49.4 21.22 21.22zm0-90-40.61-40.6 21.22-21.22 19.39 19.4 49.39-49.4 21.22 21.22zm240 143.79h-150v-30h150zm0-90h-150v-30h150zm0-90h-150v-30h150z"/>
                        <path d="m286 30c0-16.569-13.43-30-30-30-16.569 0-30 13.43-30 30-7.259 0-52.693 0-60 0v60h180c0-7.259 0-52.693 0-60-7.259 0-52.693 0-60 0z"/>
                    </g>
                </svg>
            </div>
            <span class="col85">La instalación ha sido completado correctamente.<br>Puede administrar la aplicación accediendo a <i>dominio.com/login</i> con el usuario administrador creado.</span>
        </div>
        {{-- <div class="col100 lMarginTop centerH">
            <button id="buttonAcept" class="col50">Aceptar</button>
        </div> --}}
    </div>
@endsection

@section('content')
<div id="content" class="col100">
    <center>
        <div class="lPaddingTop col100 centerH">
            <img class="col25" src="{{ url('/img/logo.png')}}"/>
        </div>
        <div display="none" id="errorMsg">
            <span>{{$mensaje ?? ''}}</span>
        </div>
        @isset($mensaje)
                <div class="col100">
                    <span>{{$mensaje}}</span>
                </div>
            @endisset

        <div id="controllerError" class="col100 xlMarginTop" style="margin-bottom: -4%; display: none">
            <span id="controllerErrorSpan">
                Debe completar todos los campos de forma correcta
            </span>
        </div>

        <form id="installForm" class="col100 xxlMarginTop" action="{{ route('install.instalation') }}" method="post">
            @csrf
            <div class="col100 centerH">
                <div class="col70">
                    <div class="groupInstall col48 mPaddingTop mPaddingBottom lPaddingLeft lPaddingRight" style="margin-right: 1%">
                        <span class="col100 subtitleInstall">Base de datos</span>
                        <div class="col100"><span class="col100 descriptionInstall">Para la instalación será necesario introducir los datos de una base de datos previamente creada.</span></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="">Nombre de la base de datos</label></div>
                        <div class="col100"><input class="col100" type="text" name="BDName" id="bName" ></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" >Nombre del servidor (localhost por defecto)</label></div>
                        <div class="col100"><input class="col100" type="text" name="SName" value="localhost" ></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="">Nombre del usuario de la base de datos (root por defecto)</label></div>
                        <div class="col100"><input class="col100" type="text" name="UName" value="root" ></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100"  for="">Contraseña (sin contraseña por defecto)</label></div>
                        <div class="col100"><input class="col100" type="password" name="PName" value=""></div>
                        
                    </div>

                    <div class="groupInstall col48 mPaddingTop mPaddingBottom lPaddingLeft lPaddingRight" style="margin-left: 1%" id="radio">
                        <span class="col100 subtitleInstall">Servidor</span>
                        <div class="col100"><span class="col100 descriptionInstall">Seleccione el tipo de sistema operativo del servidor donde se desea realizar la instalación.</span></div>
                        <div class="radioGroup col100 sMarginTop">
                                <input type="radio" name="Sys" id="radioWindows" value="windows"> 
                                <label for="windows">Windows</label><br>
                        </div>
                        <div class="radioGroup col100">
                            <input type="radio" name="Sys" id="radioLinux" value="linux">
                            <label for="linux">Linux</label>
                        </div>
                    </div>
                    
                    <div class="groupInstall col48 mMarginTop mPaddingTop mPaddingBottom lPaddingLeft lPaddingRight" style="margin-left: 1%">
                        <span class="col100 subtitleInstall">Usuario Administrador</span>
                        <div class="col100"><span class="col100 descriptionInstall">Indique la información de accceso del usuario administrador inicial que podrá acceder al sistema.</span></div>
                        <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="name">Nombre</label></div>
                        <div class="col100"><input class="col100" type="text" id="userName" name="Name" value="" ></div>
                        <div class="col50 sPaddingRight">
                            <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="password">Contraseña  </label></div>
                            <div class="col100"><input class="col100" type="password" id="userPass1" name="Pass" value="" ></div>
                        </div>
                        
                        <div class="col50 sPaddingLeft">
                            <div class="col100 mMarginTop sMarginBottom"><label class="col100" for="password">Confirmar contraseña  </label></div>
                            <div class="col100"><input class="col100" type="password" id="userPass2" name="PassC" value="" ></div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div id="errorMsgUser" class="col100 sPaddingBottom mMarginTop" style="display: none">
                <span></span>
            </div>
            <div class="col100 xlMarginTop xxlMarginBottom">
                <div class="col100 centerH">
                    <input id="sendForm" class="col30" type="button" value="Crear">
                    <input id="submitButton" type="submit" style="display: none">
                </div>
            </div>
        </form>
    </center>
</div>
<script>
    var formRoute = "{{ route('install.check') }}";
    var instalationRoute = "{{ route('install.instalation') }}"
    var token = "{{ csrf_token() }}";
    
    $( document ).ready(function() {

        // //Codigo para mostrar la ventana
        // $("#modalWindow").hide();

        // //Codigo para ocultar la ventana
        // $("#buttonAcept, #closew").on("click", function(){
        //     $("#modalWindow").hide();
        // });

        // $("#sendForm").on("click", function(){
        //     $("#modalWindow").show();
        // });
    });
</script>
@endsection