@extends('layouts.backend')
<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
<link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
{{-- <script src="{{url('js/zone/zonemap.js')}}"></script> --}}
<style>
    button{
        margin: 5px;
    }
    #modalMap{
        width: 60%;
    }
    .addScene{
        width: 85%;
    }
    #changeZone{
        top: 69.3%;
        left: 85%;
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
        <button id="addSceneToHl" class="col100">Aceptar</button>
    </div>
<div>
@endsection

@section('content')
    <h2>Opciones generales</h2>
        @foreach($options as $op)
            @if($op->key=="Imagen de portada")
                {{$idportada = $op->id}}
            @endif
            @if($op->type!='textarea')
            <button class="col30 btnopciones" id="{{$op->id}}">{{$op->key}}</button>
            @endif
        @endforeach
        <div class="col100" id="contenido" aling="center"></div>
        <div class="col100" id="img-portada" aling="center" style="display: none;">
            <h3>Imagen de portada:</h3>
            <p>La imagen principal de la portada puede ser panorámica (Imagen 360 en movimiento) o estática, es decir, una imágen normal, pulse sobre el botón deseado para configurarlo </p>
            <button class='panoramica' id="p{{$idportada}}">Imagen panorámica</button>
            <button class='estatica' id="x{{$idportada}}">Imagen estática</button>
            <div id="img-port"aling="center"></div>
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
                    elemento+="<form name='updateOption' action='"+route+"'  method='POST' enctype='multipart/form-data' aling='center'>"; 
                    //Añadimos el CSRF
                    elemento+="<input type='hidden' name='_token' id='token' value='{{ csrf_token() }}'>";  
                    //Aqui hacemos un if para que añada según el tipo de opción que sea:
                    if(data[i].type=="file"){
                        elemento+="<p>"+data[i].key+"</p>";
                        elemento+="<input type='file' name='option' value='"+data[i].value+"'> <br/><br/><img src'{{url('img/options/"+data[i].value+"')}} alt='options' height='250px' wigth='250px'> <br/><br/><input type='submit' value='Editar' form='updateOption'>";
                    }else if(data[i].type=="list"){
                         elemento+=data[i].key+": <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar' form='updateOption'>";
                    }else if(data[i].type=="boton"){
                         elemento+=data[i].key+": <select name='option'><option value='Si'>Si</option><option value='No'>No</option></select><br/><br/><input type='submit' value='Editar' form='updateOption'>"; 
                    }else if(data[i].type=="selector"){
                         elemento+=data[i].key+":<select name='option'><option value='Mapa'>Mapa</option><option value='Ascensor'>Ascensor</option></select><br/><br/><input type='submit' value='Editar' form='updateOption'>";
                    }else if(data[i].type=="color"){
                         elemento+=data[i].key+":<input type=color name='option' value='{{"+data[i].value+"?? '' }}'><br/><br/><input type='submit' value='Editar' form='updateOption'>"; 
                    }else{
                         elemento+=data[i].key+": <FONT FACE='roman'> <input type='text' name='option' value='"+data[i].value+"'></FONT><br/><br/><input type='submit' value='Editar' form='updateOption'>";
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
        var idop=$(this).attr("id");
        $("#opciones option[value='" + idop + "']").attr("selected","selected");

        $(".panoramica").click(function(){
            console.log("haciendo click en la imagen panoramica");
            $("#img-port").empty();
            $("#modalMap").css("display", "block"); //Contenido del form
            $("#mapSlide").css("display", "block"); //Contenido del form
        });

        $(".estatica").click(function(){
            $("#img-port").empty();
            console.log("haciendo click en la imagen estatica");
            $("#img-port").append("<form action='{{ route('options.update', ['id' => "+idop+"])}}'  method='POST' enctype='multipart/form-data' aling='center'>"); //Cabecera del form
            $("#img-port").append("<input type='hidden' name='_token' value='LWraQPJuNDpRsfmJdYIOq6gdBKMCO9SJtCwosb4o'>"); //Añadimos la protección de laravel  
            $("#img-port").append("contenido necesario para la imagen"); //Contenido del form
            $("#img-port").append("</form>"); //Cierre del form
        });
    </script>
@endsection
