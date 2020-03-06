@extends('layouts/backend')

@section('title', 'Nueva zona destacada | Celia-Tour')

@section('headExtension')
    <!-- Documento js de highlight-->
    <script src="{{url('js/highlight/highlight.js')}}"></script>

    <!-- Recursos de zonas para ventana modal-->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <link rel="stylesheet" href="{{url('css/backend.css')}}"/>
    <script src="{{url('js/zone/zonemap.js')}}"></script>
@endsection

@section('modal')
    <!-- Modal --> 
    <!-- Form añadir visita guiada -->
    <div class="window sizeWindow70" style="display:none">
        <span class="titleModal col100">SELECCIONAR ESCENA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        @include('backend.zone.map.zonemap')
    <div>
@endsection

@section('content')
    {{------ TITULO ------}}
    @isset($highlight)
<<<<<<< HEAD
        <form action="{{ route('highlight.update', ['highlight' => $highlight->id])}}" method="post" enctype="multipart/form-data">
        @method("put")
    @else
        <form action="{{ route('highlight.store')}}" method='post' enctype="multipart/form-data">
    @endisset
        @csrf
        Nombre de la escena: 
        <div><input type='text' name='title' value="{{$highlight->title ?? ''}}" required><div>
        <!--Posicoion-->
        <input type='hidden' id='sceneValue' type='int' name='id_scene' value="{{$highlight->id_scene ?? ''}}">
        Archivo de escena:
        <div><input type='file' name='scene_file' value="{{$highlight->scene_file ?? ''}}"></div><br>
        <!--Boton para ver mapa-->
        <div class="dropzoneContainer" id="dzone">
            <div class="width100">
                <input type="button" id="btnMap" value="Ver mapa"><span id="mensaje"></span>
=======
        <div id="title" class="col80"><span>EDITAR PUNTO DESTACADO</span></div>
    @else
        <div id="title" class="col80"><span>NUEVO PUNTO DESTACADO</span></div>
    @endisset

    {{----- CONTENIDO -----}}
    <div id="content" class="col100 centerH">
        @isset($highlight)
            <form action="{{ route('highlight.update', ['highlight' => $highlight->id])}}" method="post" class="col45">
            @method("put")
        @else
            <form action="{{ route('highlight.store')}}" method='post' class="col45">
        @endisset
            @csrf
            <label class="col100 xlMarginTop">Nombre del punto<span class="req">*<span></label>
            <div>
                <input type='text' name='title' value="{{$highlight->title ?? ''}}" class="col100 sMarginTop" required>
>>>>>>> d6ecc7e15603f882081c130fb27104d73b203e2f
            </div>

            <label class="col100 sMarginTop">Imagen de escena<span class="req">*<span></label>
            <div>
                <input type='file' name='scene_file' class="sMarginTop" value="{{$highlight->scene_file ?? ''}}" required>
            </div>
            <!--Posicoion-->
            <input type='hidden' id='sceneValue' type='int' name='id_scene' value="{{$highlight->id_scene ?? ''}}">
            <!--Boton para ver mapa-->
            <div class="col100" id="dzone">
                <input type="button" class="col100 mMarginTop bBlack" id="btnMap" value="Seleccionar escena"><span id="msmError" class="sMarginTop col100"></span>
            </div>
        
            <button type='submit' class="col100 xlMarginTop" value='Insertar' id='btnSubmit' onclick="idScene()">Guardar</button>

            </form>
        <div>
    <script>   
        $(document).ready(function() {
            $("#btnMap").click(function(){
                $("#modalWindow").css("display", "block");
                $("#ventanaModal").css("display", "block");
                $(".window").css("display", "block");
            });

            $(".closeModal").click(function(){
                $("#modalWindow, #ventanaModal, .window").hide();
            });
        });

        function idScene(){
            idValue = document.getElementById("sceneValue");
            if(idValue.value == ""){
                event.preventDefault();   // Detenemos el submit!!
                document.getElementById("msmError").innerHTML = " Debes seleccionar una zona para este punto destacado";
            }
        }
    </script>

    <style> 
        .addScene{
            width: 60%;
        }
        
        .closeModalButton{
            position: absolute;
            float: left;
            width: 40px;
            margin-left: 45%;
            margin-top: -20%;
        }
    </style>
@endsection