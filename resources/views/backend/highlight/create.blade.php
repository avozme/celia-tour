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
        <div><input type='text' name='title' value="{{$highlight->title ?? ''}}"><div>
        ID escena:
        <div><input id='sceneValue' type='int' name='id_scene' value="{{$highlight->id_scene ?? ''}}"></div>
        Posicion:
        <div><input type='int' name='position' value="{{$highlight->position ?? ''}}"></div>
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
        });
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