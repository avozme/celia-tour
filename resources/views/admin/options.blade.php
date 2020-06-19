@extends('layouts.backend')
@section("headExtension")
    <script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <link rel="stylesheet" href="{{url('css/options/option.css')}}" />
    <script src="{{url('js/closeModals/close.js')}}"></script> 
    <script src="{{url('js/zone/zonemap.js')}}"></script>
    <script src="{{url('js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('js/marzipano/marzipano.js')}}"></script>
    <script src="{{url('js/options/option.js')}}"></script>
    <link href="https://fonts.googleapis.com/css?family=Spartan:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Acme:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Domine:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Gloria:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Mono:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poiret+One:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=MuseoModerno:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sriracha:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+HK
    :400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Staatliches:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bellota:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower
    :400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rajdhani:400, 500, 700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400, 500, 700&display=swap" rel="stylesheet">
@endsection
@section("modal")
<!-- MODAL MAPA -->
<div  id="modalMap" class="window sizeWindow70" style="display: none; max-height: 96%">
        <span class="titleModal col100">SELECCIONAR ESCENA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="content col90 mMarginTop" style="overflow: scroll; max-height: 523px">
            <div id="map1" class="oneMap col100">
                @include('backend.zone.map.zonemap')
            </div>
        </div>
        <div class="col80 centerH mMarginTop" style="margin-left: 9%">
            <button id="addPanoramica" class="col100">Aceptar</button>
        </div>
</div>

    <!-- MODAL PREVISUALIZACIÓN DE ESCENA -->
    <div id="previewModal" class="window" style="display: none;">
        <span class="titleModal col100">ESCENA ACTUAL</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
            <div id="pano" class="col100 xlMarginTop lMarginBottom" style="height: 370px; border-radius: 30px"></div>
        
    </div>
@endsection

@section('content')
    <h2>Opciones generales</h2>
        @foreach($options as $op)
            @if($op->key=="Imagen de portada")
                @php
                    $idportada = $op->id;
                    $imagen = $op->value;
                @endphp
            @endif
            @if($op->key=="EscapeRoom")
                @php
                    $audio = $op->value;
                @endphp
            @endif
            @if($op->key=="Título de la web")
                @php
                    $tituloW = $op->value;
                @endphp
            @endif
            @if($op->type=='audio' && $audio == "Si" || $op->type=='infoER' && $audio == "Si"  )
            <button class="col30 btnopciones" id="{{$op->id}}">{{$op->key}}</button>
            @endif
            @if($op->type!='textarea' && $op->type!='info' && $op->type!='audio' && $op->type!='infoER' )
                <button class="col30 btnopciones" id="{{$op->id}}">{{$op->key}}</button>
            @endif
        @endforeach
        <div class="col100" id="contenido" style="aling: right;"></div>
        <div class="col100" id="img-portada"  style="aling: center; display: none;">
            <h3>Imagen de portada:</h3>
            @foreach ($options as $op)
            @if ($op->key == "Imagen de portada")
                <input type="hidden" id="optionIdScene" value="{{ $op->value}}">
            @endif
            @endforeach

            @foreach ($options as $op)
            @if($op->key == "Tipo de portada")
            @php
                $type = $op->value;
                $idTipoPortada = $op->id;
            @endphp
            <form action="{{ route('options.update_cover', ['id' => $idportada, 'id1' => $idTipoPortada]) }}" method="POST" enctype="multipart/form-data" align="center"> 
            @csrf
            <input type="hidden" name="idScene" id="idScene" value="">
            @if($op->value=="Panoramica")
                <select name="option" onchange="cambiarTipo()" id="tipo_img">
                    <option value="Panoramica" selected>Panorámica</option>
                    <option value="Estatica">Estática</option>
                </select>
                <div id="PanoramicaContent" class="col100" style="aling: center; display: block;">
                    <button type="button" class='panoramica bBlack' id='{{$idportada}}' style='aling: center;'>Seleccionar Escena</button><br>
                    @if ($type == "Panoramica")
                        <button id="scenePreview" type="button">Ver Escena</button>
                    @endif
                </div>
                <div id="EstaticaContent"  style="aling: center; display: none;">
                    <input type='file' name='optionf' value='{{$op->value ?? '' }}'><br/>
                    @if($type!="Panoramica")
                    <img src='{{ url('/img/options/'.$imagen) }}' alt='options' height='250px' width='250px'>
                    @else
                        
                    @endif
                </div>
            @else
                <select name="option" onchange="cambiarTipo()" id="tipo_img">
                    <option value="Panoramica">Panorámica</option>
                    <option value="Estatica" selected>Estática</option>
                </select>
                <div id="PanoramicaContent" style="aling: center; display: none;">
                    <button type="button" class='panoramica bBlack' id='{{$idportada}}' style='aling: center;'>Seleccionar Escena</button>
                </div>
                <div id="EstaticaContent" style="aling: center; display: block;">
                    <input type='file' name='optionf' value='{{$op->value ?? '' }}'><br/>
                    @if($type!="Panoramica")
                    <img src='{{ url('/img/options/'.$imagen) }}' alt='options' height='250px' width='250px'>
                    @endif
                </div>
            @endif
        @endif
            @endforeach
            <br/><input type="submit" class='btnportada' id="{{$idportada}}" style="aling: center;" value="Guardar">
            </form>
            <div id="img-port" style="aling: center;"></div>
                
        </div>
        @foreach($options as $op)
        @if($op->id == "13")
            @php
                $resultado = $op->value;
            @endphp
        @endif
        @if($op->id == "20")
            @php
                $resultadoScape = $op->value;
            @endphp
        @endif
        @endforeach
        @foreach($options as $op)
        @if($op->type=='textarea')
            @if($op->key == "Texto panel historia" && $resultado=="No")
            @elseif($op->key == "Texto EspaceRoom" && $resultadoScape=="No")
            @else
            <form action="{{ route('options.update', ['id' => $op->id]) }}" method="POST" enctype="multipart/form-data" align="center"> 
                @csrf
                    <div class="col100" id="s{{$op->id}}">
                    <input type="hidden" name="option"  value="{{$op->value ?? '' }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3>{{$op->key}}</h3></div>
                                    <div class="panel-body">
                                        <form>
                                            <textarea class="ckeditor" name="option"  id="editor1" rows="10" cols="80">
                                                {{$op->value}}
                                            </textarea><br/>
                                            <input type="submit" value="Guardar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
           @endif
           @endif
        @endforeach
        
    <script>
        //RUTAS NECESARIAS PARA ARCHIVO JS EXTERNO
        var urlPointScene = "{{ url('img/zones/icon-zone.png') }}";
        var urlPointSceneHover = "{{ url('img/zones/icon-zone-hover.png') }}";


        var data = @JSON($options);
        $(".btnopciones").click(function(){
            $("#contenido").empty();
            $("#img-portada").css("display", "none");
            var idop=$(this).attr("id");
            var elemento = "";
            for(var i=0; i<data.length; i++){
                if(data[i].id == idop && data[i].key!="Imagen de portada"){
                    var route = "{{ route('options.update', 'req_id') }}".replace('req_id', idop);
                    //Incluimos la cabecera del form
                    elemento+="<form name='updateOption' action='"+route+"'  method='POST' enctype='multipart/form-data' align='center'>"; 
                    //Añadimos el CSRF
                    elemento+="<input type='hidden' name='_token' id='token' value='{{ csrf_token() }}'>";  
                    //Aqui hacemos un if para que añada según el tipo de opción que sea:
                    if(data[i].type=="file"){
                        url = "{{url('/img/options/image')}}";
                        imagen = url.replace('image', data[i].value);
                        elemento+="<h3>"+data[i].key+"</h3>";
                        elemento+="<input type='file' name='option' value='"+data[i].value+"'> <br/><br/><img src="+imagen+" alt='options' height='250px' wigth='250px'> <br/><br/><input type='submit' value='Guardar'>";
                    } else if(data[i].type=="audio"){
                        url = "{{url('/img/options/image')}}";
                        audio = url.replace('image', data[i].value);
                        elemento+="<h3>"+data[i].key+"</h3>";
                        elemento+=`<input type='file' name='option' value='${data[i].value}' accept='audio/*'> <br/><br/> <audio src="${audio}" controls>El navegador no soporta este audio</audio> <br/><br/><input type='submit' value='Guardar'>`;
                    }else if(data[i].type=="list"){
                        elemento+="<h3>"+data[i].key+"</h3>";
                        elemento+="<div id='tipoTexto' style='font-size: x-large !important; font-family:"+data[i].value+" !important'>{{$tituloW}}</div><br/>";
                        if(data[i].value=="Spartan"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan' selected>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Acme"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'selected>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Domine"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine' selected>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Gloria Hallelujah"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah' selected>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="PT Mono"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono' selected>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Poiret One"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One' selected>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Indie Flower"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower' selected>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Rubik"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik' selected>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="MuseoModerno"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno' selected>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Sriracha"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha' selected>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Montserrat"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat' selected>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Noto Sans HK"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK' selected>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Roboto Slab"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab' selected>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Open Sans "){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans ' selected>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Staatliches"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches' selected>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Bellota"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota' selected>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Dancing Script"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script' selected >Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Indie Flower"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower' selected>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Pacifico"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico' selected>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Amatic SC"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC' selected >Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Permanent Marker"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker' selected>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else if(data[i].value=="Rajdhani"){
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani' selected>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }else{
                            elemento+="<select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway' selected>Raleway</option><option value='MuseoModerno'>Museo Moderno</option><option value='Sriracha'>Sriracha</option><option value='Montserrat'>Monstserrat</option><option value='Noto Sans HK'>Noto Sans HK</option><option value='Roboto Slab'>Roboto Slab</option><option value='Open Sans '>Open Sans </option><option value='Staatliches'>Staatliches</option><option value='Bellota'>Bellota</option><option value='Dancing Script'>Dancing Script</option><option value='Indie Flower'>Indie Flower</option><option value='Pacifico'>Pacifico</option><option value='Amatic SC'>Amatic SC</option><option value='Permanent Marker'>Permanent Marker</option><option value='Rajdhani'>Rajdhani</option></select><br/><br/><input type='submit' value='Guardar'>";
                        }
                    }else if(data[i].type=="boton"){
                        if(data[i].value=="Si"){
                            elemento+="<h3>"+data[i].key+"</h3>  <select name='option'><option value='Si' selected>Si</option><option value='No'>No</option></select><br/><br/><input type='submit' value='Guardar' >"; 
                        }else{
                            elemento+="<h3>"+data[i].key+"</h3>  <select name='option'><option value='Si'>Si</option><option value='No' selected>No</option></select><br/><br/><input type='submit' value='Guardar' >"; 
                        }
                    }else if(data[i].type=="selector"){
                        if(data[i].value=="Ascensor"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option'><option value='Mapa'>Mapa</option><option value='Ascensor' selected>Ascensor</option></select><br/><br/><input type='submit' value='Guardar' >";
                        }else{
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option'><option value='Mapa' selected>Mapa</option><option value='Ascensor'>Ascensor</option></select><br/><br/><input type='submit' value='Guardar' >";
                        }
                    }else if(data[i].type=="color"){
                         elemento+="<h3>"+data[i].key+"</h3> <input type=color name='option' value='"+data[i].value+"'><br/><br/><input type='submit' value='Guardar'>"; 
                    }else if(data[i].type=="infoER"){
                        elemento+='<h3>'+data[i].key+'</h3> <button type="button" class="panoramica bBlack" id='+data[i].id+' style="aling: center;">Seleccionar Escena</button><br/><button id="PreviewER" class="'+data[i].value+'" type="button">Ver Escena</button><br/><input type="submit" value="Guardar">'
                        elemento+="<input type='hidden' name='option'  id='IdSceneER' value='"+data[i].value+"'>"
                    }else{
                         elemento+="<h3>"+data[i].key+"</h3>  <FONT FACE='roman'> <input type='text' name='option' value='"+data[i].value+"'></FONT><br/><br/><input type='submit' value='Guardar'>";
                    }
                        elemento+="</form>"; 
                        $("#contenido").append(elemento);
                        $("#opciones").change(function(){
                            var letra =$( "#opciones option:selected" ).val()
                            $("#tipoTexto").css('font-family', letra);
                        });
                         //Función para abrir la modal para escoger la escena
                        $(".panoramica").click(function(){
                            //Marcar escena actual si la tuviese
                            var escena = $('#optionIdScene').val();
                            if(escena != "" && escena != null){
                                $('#scene' + escena).addClass('selected');
                                $('#scene' + escena).attr('src', urlPointSceneHover);
                            }
                            $("#img-port").empty();
                            $("#modalWindow").css("display", "block"); //Contenido del form
                            $("#modalMap").css('display', 'block') //Contenido del form
                            $("#mapSlide").css("display", "block"); //Contenido del form
                        });
                }
                    $(".scenepoint").click(function(){
                        //Le quito la clase selected a todos los puntos para que la url de la imagen sea la de la imagen blanca
                        $('.scenepoint').removeClass('selected');
                        $('.scenepoint').attr('src', urlPointScene);
                        //Se la añado al punto seleccionado para que se marque como tal
                        $(this).addClass('selected');
                        $(this).attr('src', urlPointSceneHover);
                        var idScene = ($(this).attr('id')).substr(5);
                        $("#idScene").val(idScene);
                        $('#optionIdScene').val(idScene);
                        $('#IdSceneER').val(idScene);
                    });
                    if(data[i].id == idop && data[i].key=="Imagen de portada" ){
                       $("#img-portada").css("display", "block");
                       $('#pano').parent().show();
                    }
            }
        });

        var id = "{{$options[10]->value}}";
        $("#opciones option[value='" + id + "']").attr("selected","selected");

        /*FUNCIÓN PARA CARGAR VISTA PREVIA DE LA ESCENA*/
        function loadScene(sceneDestination){
            'use strict';
            console.log(sceneDestination);
            //1. VISOR DE IMAGENES
            var  panoElement = document.getElementById('pano');
            /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
            a mayor, para conseguir una carga mas fluida. */
            var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

            //2. RECURSO
            var source = Marzipano.ImageUrlSource.fromString(
            "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}".replace('dn', sceneDestination.directory_name),
            
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: "{{url('/marzipano/tiles/dn/preview.jpg')}}".replace('dn', sceneDestination.directory_name), 
            cubeMapPreviewFaceOrder: 'lfrbud'});

            //3. GEOMETRIA 
            var geometry = new Marzipano.CubeGeometry([
            { tileSize: 256, size: 256, fallbackOnly: true  },
            { tileSize: 512, size: 512 },
            { tileSize: 512, size: 1024 },
            { tileSize: 512, size: 2048},
            ]);

            //4. VISTA
            //Limitadores de zoom min y max para vista vertical y horizontal
            var limiter = Marzipano.util.compose(
                Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
                Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
            );
            //Establecer estado inicial de la vista con el primer parametro
            var view = new Marzipano.RectilinearView({yaw: sceneDestination.yaw, pitch: sceneDestination.pitch, roll: 0, fov: Math.PI}, limiter);

            //5. ESCENA SOBRE EL VISOR
            var scene = viewer.createScene({
            source: source,
            geometry: geometry,
            view: view,
            pinFirstLevel: true
            });

            //6.MOSTAR
            scene.switchTo({ transitionDuration: 1000 });
        }

        function sceneInfo($id){
            var route = "{{ route('scene.show', 'id') }}".replace('id', $id);
            return $.ajax({
                url: route,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        }

        function loadSceneIfExist(idScene){
            sceneInfo(idScene).done(function(result){
                loadScene(result);
            });
        }


        //Función para abrir la modal para escoger la escena
        $(".panoramica").click(function(){
            //Marcar escena actual si la tuviese
            var escena = $('#optionIdScene').val();
            if(escena != "" && escena != null){
                $('#scene' + escena).addClass('selected');
                $('#scene' + escena).attr('src', urlPointSceneHover);
            }
            $("#img-port").empty();
            $("#modalWindow").css("display", "block"); //Contenido del form
            $("#modalMap").css('display', 'block') //Contenido del form
            $("#mapSlide").css("display", "block"); //Contenido del form
        });

        //Función para cambiar tipo
        function cambiarTipo(){
            var data = @JSON($options);
            elemento=document.getElementById("tipo_img");
            indice=elemento.selectedIndex;
            tipo_seleccionado = elemento.options[indice].value;
            if(tipo_seleccionado=="Panoramica"){
                $("#EstaticaContent").css("display", "none"); 
                $("#PanoramicaContent").css("display", "block");
                $('#prevPano').show();
            }else{
                $('#prevPano').hide();
                $("#PanoramicaContent").css("display", "none"); 
                $("#EstaticaContent").css("display", "block"); 
            }
            
        }

        

    </script>
@endsection


