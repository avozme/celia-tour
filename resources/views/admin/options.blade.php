@extends('layouts.backend')
<style>
    button{
        margin: 5px;
    }
    h3{
        text-align: center;
    }
    p{
        text-align: center;
    }
    .btnportada{
        text-align: center;
    }
    #modalMap{
        width: 60%;
    }
    #img-port{
        text-align: center;
    }
    #img-portada{
        text-align: center;
    }
    .addScene{
        width: 85%;
    }
    #changeZone{
        top: 69%!important;
        left: 79%!important;
    }
    #floorUp, #floorDown{
        width: 150%;
    }    
    .closeModalButton{
        position: absolute;
        float: left;
        width: 40px;
        margin-left: 45%;
        margin-top: -20%;
    }
}
</style>
@section("headExtension")
    <script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/closeModals/close.js')}}"></script> 
    <script src="{{url('js/zone/zonemap.js')}}"></script>
@endsection
@section("modal")
<!-- MODAL MAPA -->
<div  id="modalMap" class="window sizeWindow70" style="display: none;">
    <div id="mapSlide"  style="display:none">
        <span class="titleModal col100">SELECCIONAR ESCENA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="content col90 mMarginTop">
                @include('backend.zone.map.zonemap')
        </div>
    </div>
    <div class="col80 centerH mMarginTop" style="margin-left: 9%">
        <button id="addPanoramica" class="col100">Aceptar</button>
    </div>
<div>
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
            @if($op->type!='textarea' && $op->type!='info' )
            <button class="col30 btnopciones" id="{{$op->id}}">{{$op->key}}</button>
            @endif
        @endforeach
        <div class="col100" id="contenido" style="aling: center;"></div>
        <div class="col100" id="img-portada"  style="aling: center; display: none;">
            <h3>Imagen de portada:</h3>
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
                        <div id="PanoramicaContent" style="aling: center; display: block;">
                            <button type="button" class='panoramica bBlack' id='{{$idportada}}' style='aling: center;'>Seleccionar Escena</button>
                        </div>
                        <div id="EstaticaContent" style="aling: center; display: none;">
                            <input type='file' name='option' value='{{$op->value ?? '' }}'><br/>
                            @if($type!="Panoramica")
                            <img src='{{ url('/img/options/'.$imagen) }}' alt='options' height='250px' width='250px'>
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
            @endforeach()
            <br/><input type="submit" class='btnportada' id="{{$idportada}}" style="aling: center;" value="Editar">
            </form>
            <div id="img-port" style="aling: center;"></div>
        </div>
        @foreach($options as $op)
           @if($op->type=='textarea')
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
                                        <input type="submit" value="Editar">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>
           @endif
        @endforeach
        
    <script>
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
                        elemento+="<h3>"+data[i].key+"</h3>";
                        elemento+="<input type='file' name='option' value='"+data[i].value+"'> <br/><br/><img src'{{url('img/options/"+data[i].value+"')}} alt='options' height='250px' wigth='250px'> <br/><br/><input type='submit' value='Editar'>";
                    }else if(data[i].type=="list"){
                        if(data[i].value=="Spartan"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan' selected>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="Acme"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'selected>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="Domine"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine' selected>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="Gloria Hallelujah"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah' selected>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="PT Mono"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono' selected>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="Poiret One"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One' selected>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="Indie Flower"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower' selected>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else if(data[i].value=="Rubik"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik' selected>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }else{
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway' selected>Raleway</option></select><br/><br/><input type='submit' value='Editar'>";
                        }
                    }else if(data[i].type=="boton"){
                        if(data[i].value=="Si"){
                            elemento+="<h3>"+data[i].key+"</h3>  <select name='option'><option value='Si' selected>Si</option><option value='No'>No</option></select><br/><br/><input type='submit' value='Editar' >"; 
                        }else{
                            elemento+="<h3>"+data[i].key+"</h3>  <select name='option'><option value='Si'>Si</option><option value='No' selected>No</option></select><br/><br/><input type='submit' value='Editar' >"; 
                        }
                    }else if(data[i].type=="selector"){
                        if(data[i].value=="Ascensor"){
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option'><option value='Mapa'>Mapa</option><option value='Ascensor' selected>Ascensor</option></select><br/><br/><input type='submit' value='Editar' >";
                        }else{
                            elemento+="<h3>"+data[i].key+"</h3> <select name='option'><option value='Mapa' selected>Mapa</option><option value='Ascensor'>Ascensor</option></select><br/><br/><input type='submit' value='Editar' >";
                        }
                    }else if(data[i].type=="color"){
                         elemento+="<h3>"+data[i].key+"</h3> <input type=color name='option' value='"+data[i].value+"'><br/><br/><input type='submit' value='Editar'>"; 
                    }else{
                         elemento+="<h3>"+data[i].key+"</h3>  <FONT FACE='roman'> <input type='text' name='option' value='"+data[i].value+"'></FONT><br/><br/><input type='submit' value='Editar'>";
                    }
                        elemento+="</form>"; 
                        $("#contenido").append(elemento);
                    }
                    if(data[i].id == idop && data[i].key=="Imagen de portada" ){
                       $("#img-portada").css("display", "block");
                    }
            }
        })

        var id = "{{$options[10]->value}}";
        $("#opciones option[value='" + id + "']").attr("selected","selected");

        //Función para abrir la modal para escoger la escena
        $(".panoramica").click(function(){
            console.log("haciendo click en la imagen panoramica");
            $("#img-port").empty();
            $("#modalWindow").css("display", "block"); //Contenido del form
            $("#modalMap").css("display", "block"); //Contenido del form
            $("#mapSlide").css("display", "block"); //Contenido del form
        });


    $( document ).ready(function() {
        //Función para el botón cerrar de la modal
        $(".closeModal").click(function(){
            console.log("hago click en el cerrar ventana");
            $("#img-port").empty();
            $("#modalWindow").css("display", "none");
            $("#modalMap").css("display", "none");
            $("#mapSlide").css("display", "none"); 
        });

        $(".scenepoint").click(function(){
            var idScene = ($(this).attr('id')).substr(5);
            $("#idScene").val(idScene);
        });
        //Funcionalidad del botón aceptar de la modal
        $("#addPanoramica").click(function(){
            $("#img-port").empty();
            $("#modalWindow").css("display", "none");
            $("#modalMap").css("display", "none");
            $("#mapSlide").css("display", "none"); 
        });
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
            }else{
                $("#PanoramicaContent").css("display", "none"); 
                $("#EstaticaContent").css("display", "block"); 
            }
            
        }
    </script>
@endsection


