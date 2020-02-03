@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
    <script src="{{url('js/zone/zone.js')}}"></script>
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
    <div id="zoneicon" class="icon" style="display: none">
        <img class="newscenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
    </div>
    @foreach ($scenes as $scene)
        <div class="icon" style="top: {{ $scene->top }}; left: {{ $scene->left }};">
            <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
        </div>
    @endforeach
    <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
    <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
    <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}" alt="">
</div>
<div id="menuModalAddScene">
    <form id="formAddScene" method="post" enctype="multipart/form-data" action="{{ route('scene.store') }}">
        @csrf
        <label for="name">Nombre</label>
        <input type="text" name="name" id="sceneName"><br><br>
        <label for="sceneImg">Imagen</label>
        <input type="file" name="image360" id="sceneImg">
        <input id="top" type="hidden" name="top">
        <input id="left" type="hidden" name="left">
        <input type="hidden" name="idZone" value="{{ $zone->id }}"><br><br>
        <input type="submit" value="Guardar" id="saveScene">
        <input type="button" value="Cerrar" id="closeMenuAddScene">
    </form>
</div>
<div id="menuModalUpdateScene" style="display: none">
    <form id="formUpdateScene" method="GET" enctype="multipart/form-data" action="{{ route('scene.updatee') }}">
        @csrf
        <label for="name">Nombre</label>
        <input type="text" name="name" id="updateSceneName"><br><br>
        <label for="updateSceneImg">Imagen</label>
        <input type="file" name="image360" id="updateSceneImg">
        <input type="hidden" name="sceneId" id="sceneId">
        <input type="submit" value="Guardar" id="updateScene">
        <input type="button" value="Borrar escena" id="deleteScene">
        <input type="button" value="Cerrar" id="closeMenuUpdateScene">
    </form>
</div>

<script type="text/javascript">
/*********FUNCIÓN PARA SACAR LA INFORMACIÓN DEL PUNTO DE LA ESCENA**********/
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

    function deleteScenePoint($id) {
        var route = "{{ route('scene.destroy', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'DELETE',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }
</script>
@endsection