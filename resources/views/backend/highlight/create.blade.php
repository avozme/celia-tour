@extends('layouts/backend')

@section('title', 'insertar zonas destacadas Celia-Tour')

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
    @include('backend.zone.map.zonemap')
@endsection

@section('content')
    @isset($highlight)
        <form action="{{ route('highlight.update', ['highlight' => $highlight->id])}}" method="post">
        @method("put")
    @else
        <form action="{{ route('highlight.store')}}" method='post'>
    @endisset
        @csrf
        Nombre de la escena: 
        <div><input type='text' name='title' value="{{$highlight->title ?? ''}}" required><div>
        <!--Posicoion-->
        <input type='hidden' id='sceneValue' type='int' name='id_scene' value="{{$highlight->id_scene ?? ''}}">
        Archivo de escena:
        <div><input type='file' name='scene_file' value="{{$highlight->scene_file ?? ''}}" required></div><br>
        <!--Boton para ver mapa-->
        <div class="dropzoneContainer" id="dzone">
            <div class="width100">
                <input type="button" id="btnMap" value="Ver mapa"><span id="mensaje"></span>
            </div>
        </div><br>
       
        <button type='submit' value='Insertar' id='btnSubmit' onclick="idScene()">Insertar</button>

        </form>

    <script>   
        $(document).ready(function() {
            $("#btnMap").click(function(){
                $("#modalWindow").css("display", "block");
                $("#ventanaModal").css("display", "block");
            });
        });

        function idScene(){
            idValue = document.getElementById("sceneValue");
            if(idValue.value == ""){
                event.preventDefault();   // Detenemos el submit!!
                document.getElementById("mensaje").innerHTML = " Debes seleccionar una zona para este punto destacado";
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