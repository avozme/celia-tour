@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
    <script src="{{url('js/zone/zone.js')}}"></script>
    <script src="{{url('js/closeModals/close.js')}}"></script>    
@endsection

@section('content')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <div id="title" class="col80"></div>
    <div id="contentbutton" col20></div>
    <div id="content" class="col100">
        <form action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col30"><label for="name">Name</label></div>
            <div class="col20"><label for="initial_zone">Zona inicial</label></div>

            <div style="clear:both"></div>

            <div class="col30"><input type="text" name="name" value="{{ $zone->name }}"><br><br></div>
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
        
    </div>

<div id="addScene">
    <div id="zoneicon" class="icon" style="display: none; position: absolute;">
        <img class="newscenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
    </div>
    @foreach ($scenes as $scene)
        <div class="icon" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%">
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
<div id="menuModalUpdateScene">
    <form id="formUpdateScene" method="post" enctype="multipart/form-data" action="{{ route('scene.update', 'req_id') }}">
        @csrf
        <input type="hidden" name="_method" value="PATCH">

        <label for="name">Nombre</label>
        <input type="text" name="name" id="updateSceneName"><br><br>
        <label for="updateSceneImg">Imagen</label>
        <input type="file" name="image360" id="updateSceneImg"><br><br>
        <input type="hidden" name="sceneId" id="sceneId">
        <input type="hidden" name="idZone" id="idZone" value="{{$zone->id}}">
        <input type="submit" value="Guardar" id="updateScene">
        <input type="button" value="Borrar escena" id="deleteScene">
        <input type="button" value="Cerrar" id="closeMenuUpdateScene">
    </form>
    <!--Lista de las escenas secundarias ya creadas para esa escena-->
        <div id="infosscene"></div>
    <!--Botón para añadir escenas nuevas-->
    <button id="addSScene">Añadir Escena Secundaria</button>
</div>
@section('modal')
<!--Vista modal para añadir nuevas escenas secundarias-->
<div class="window" id="Sscene" style="display: none;">
    <span class="titleModal col100">Añadir escena secundaria</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="addVideoContent col100 xlMarginTop">
        <form id="añadirSceneS" method="post" enctype="multipart/form-data" action="{{ route('secondaryscenes.store', 'req_id') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="updateSceneName"><br><br>
            <label for="name">Fecha</label>
            <input type="date" name="date" id="updateSceneDate"><br><br>
            <label for="updateSceneImg">Imagen</label>
            <input type="file" name="image360" id="updateSceneImg"><br><br>
            <input type="hidden" name="sceneId" id="sceneId">
            <input type="hidden" name="idScene" id="idScene" value="{{$scene->id}}">
            <input type="hidden" name="idZone" id="idZone" value="{{$zone->id}}">
            <input type="submit" value="Guardar" id="addSScene">
        </form>
    </div>
</div>    
@endsection

<script type="text/javascript">
var routeEdit = "{{ route('scene.update', 'req_id') }}";

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

    //ACCIÓN PARA ABRIR LA VENTANA MODAL DE AÑADIR ESCENA SECUNDARIA
    $("#addSScene").click(function(){
        $("#modalWindow").css("display", "block");
        $("#Sscene").css("display", "block")
    });

    //FUNCIÓN PARA SACAR LAS ESCENAS SECUNDARIARS
     function s_sceneInfo($id){
        var route = "{{ route('secondaryscenes.show', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }
</script>
@endsection