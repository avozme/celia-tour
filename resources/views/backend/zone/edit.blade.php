@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
@endsection

@section('content')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <div id="title" class="col80"></div>
    <div id="contentbutton" col20></div>
    <div id="content" class="col100">
        <form action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col20"><label for="name">Name</label></div>
            <div class="col20"><label for="file_image">File Image</label></div>
            <div class="col20"><label for="file_miniature">File miniature</label></div>
            <div class="col20"><label for="position">Position</label></div>
            <div class="col20"><label for="initial_zone">Zona inicial</label></div>

            <div style="clear:both"></div>

            <div class="col20"><input type="text" name="name" value="{{ $zone->name }}"><br><br></div>
            <div class="col20"><img src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image' height="100" width="150" onclick="$('#inputFileImage').trigger('click')"></div>
            <div class="col20"><img src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature' height="100" width="150" onclick="$('#inputFileMiniature').trigger('click')"></div>
            <div class="col20"><input type="number" name="position" value="{{ $zone->position }}" disabled></div>
            @if ($zone->initial_zone)
                <input type="checkbox" name="initial_zone" checked>
            @else
                <input type="checkbox" name="initial_zone">
            @endif
            <div style="display: none">
                <input type="file" name="file_image" accept=".png, .jpg, .jpeg" id="inputFileImage">
                <input type="file" name="file_miniature" accept=".png, .jpg, .jpeg" id="inputFileMiniature">
            </div>

            <div style="clear:both"></div>
            <input type="submit" name="Save Changes">
        </form>
        <button id="newScene" onclick="$('#modalWindow').css('display', 'block')">Añadir escena</button>
        
    </div>
@endsection

@section('modal')
<div id="addScene" style="width: 900px; height: auto; border: 1px solid red;position: relative;">
    <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
    <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}" alt="">
    
</div>
<script>
    $().ready(function(){
        $('#addScene').click(function(e){
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            $('#addScene').prepend('<div id="zoneicon" class="icon"><img class="scenepoint" src="'+ $('#url').val() +'" alt="icon" width="100%" ></div>');
            $('#zoneicon').css('top' , (mousey - posicion.top -8));
            $('#zoneicon').css('left', (mousex - posicion.left -8));
        });
    });
</script>
@endsection