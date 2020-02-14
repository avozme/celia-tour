@extends('layouts/backend')

@section('title', 'insertar zonas destacadas Celia-Tour')

@section('headExtension')
    <!-- Documento js de highlight-->
    <script src="{{url('js/highlight/highlight.js')}}"></script>

    <!-- Recursos de zonas para ventana modal-->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>
@endsection

@section('modal')
    <!-- Modal -->  
    <div id="ventanaModal" class="window" style="display: none;">
        <span class="titleModal col100">Añadir Destacados</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div>
            @include('backend.zone.map.zonemap')        
        </div>
    </div>
@endsection

@section('content')
    @isset($highlight)
        <form action="{{ route('highlight.update', ['highlight' => $highlight->id])}}" method="post">
        @method("put")
    @else
        <form action="{{ route('highlight.store')}}" method='post'>
    @endisset
        @csrf
        Fila: 
        <div><input type='int' name='row' value="{{$highlight->row ?? ''}}"><div>
        Columna: 
        <div><input type='int' name='column' value="{{$highlight->column ?? ''}}"><div>
        Nombre de la escena: 
        <div><input type='text' name='title' value="{{$highlight->title ?? ''}}"><div>
        ID escena:
        <div><input id='sceneValue' type='int' name='id_scene' value="{{$highlight->id_scene ?? ''}}"></div>
        Archivo de escena:
        <div><input type='file' name='scene_file' value="{{$highlight->scene_file ?? ''}}"></div><br>
        
        <div class="dropzoneContainer" id="dzone">
            <div class="width100">
                <input type="button" id="btnMap" value="Ver mapa">
            </div>
        </div><br>
       
        <button type='submit' value='Insertar'>Insertar</button>

        </form>

    <script>   
        $(document).ready(function() {
            $("#btnMap").click(function(){
                $("#modalWindow").css("display", "block");
                $("#ventanaModal").css("display", "block");
            });
            $(".closeModal").click(function() {
                $("#modalWindow").css("display", "none");
                $("#ventanaModal").css("display", "none");                
            })
        });
    </script>
@endsection