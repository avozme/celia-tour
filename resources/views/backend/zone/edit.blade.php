@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
    <script src="{{url('js/closeModals/close.js')}}"></script>
    <script src="{{url('js/zone/zone.js')}}"></script> 
@endsection

@section('content')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{url('js/marzipano/es5-shim.js')}}"></script>
<script src="{{url('js/marzipano/eventShim.js')}}"></script>
<script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
<script src="{{url('js/marzipano/marzipano.js')}}"></script>


    <div id="title" class="col80"></div>
    <div id="contentbutton" col20></div>
    <div id="content" class="col100">
        <form class="col60" action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col30"><label for="name">Name</label></div>

            <div style="clear:both"></div>

            <div class="col30"><input type="text" name="name" value="{{ $zone->name }}"><br><br></div>
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
<input type="hidden" name="actualScene" id="actualScene">
<div id="menuModalAddScene">
    <form id="formAddScene" method="post" enctype="multipart/form-data" action="{{ route('scene.store') }}">
        @csrf
        <label for="name">Nombre</label>
        <input type="text" name="name" id="sceneName"><br><br>
        <label for="sceneImg">Imagen</label>
        <input type="file" name="image360" id="sceneImg"><br><br>
        <label for="principal">Hacer escena principal</label>
        <input type="checkbox" name="principal" id="principal"><br><br>
        <label for="principal">Cover</label>
        <input type="checkbox" name="cover" id="cover"><br><br>
        <input id="top" type="hidden" name="top">
        <input id="left" type="hidden" name="left">
        <input type="hidden" name="idZone" value="{{ $zone->id }}"><br><br>
    </form>
    <div style="margin-top: -13%; margin-left: 3%">
        <input type="submit" form="formAddScene" value="Guardar" id="saveScene">
        <button id="closeMenuAddScene">Cerrar</button>
    </div>
</div>
<div id="menuModalUpdateScene">
    <form id="formUpdateScene" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Nombre</label>
        <input type="text" name="name" id="updateSceneName"><br><br>
        <label for="principal">Hacer escena principal</label>
        <input type="checkbox" name="principal" id="principal"><br><br>
        <label for="principal">Cover</label>
        <input type="checkbox" name="cover" id="cover"><br><br>
        <div id="pano" class="l1 col50"></div>
        <label for="updateSceneImg">Imagen</label>
        <input type="file" name="image360" id="updateSceneImg"><br><br>
        <input type="hidden" name="sceneId" id="sceneId">
        <input type="hidden" name="idZone" id="idZone" value="{{$zone->id}}">
    </form>
    <div style="margin-top: -5%; margin-bottom: 2%">
        <input type="submit" form="formUpdateScene" value="Guardar" id="updateScene">
        <button id="deleteScene" class="deleteButton">Borrar escena</button>
        <button id="editActualScene" >Editar escena</button>
        <button id="addSScene">Añadir Escena Secundaria</button>
        <button id="closeMenuUpdateScene">Cerrar</button>
    </div>
    <!--Lista de las escenas secundarias ya creadas para esa escena-->
        <div id="infosscene"></div>
    <!--Botón para añadir escenas nuevas-->
</div>
@section('modal')
<!--Vista modal para añadir nuevas escenas secundarias-->
<div class="window" id="Sscene" style="display: none;">
    <span class="titleModal col100">Añadir escena secundaria</span>
    <button class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="addVideoContent col100 xlMarginTop">
        <form id="añadirSceneS" method="post" enctype="multipart/form-data" action="{{ route('sscenes.store') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="updateSceneName"><br><br>
            <label for="name">Fecha</label>
            <input type="date" name="date" id="updateSceneDate"><br><br>
            <label for="updateSceneImg">Imagen</label>
            <input type="file" name="image360" id="updateSceneImg"><br><br>
            <input type="hidden" name="idScene" id="idScene">
            <input type="hidden" name="idZone" id="idZone" value="{{$zone->id ?? ''}}">
            <input type="submit" value="Guardar" id="addSScene">
        </form>
    </div>
</div>    
<!--Vista modal para añadir EDITAR escenas secundarias-->
<div class="window" id="upSscene" style="display: none;">
    <span class="titleModal col100">Modificar escena secundaria</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="addVideoContent col45 xlMarginTop">
        <form id="updateSceneS" method="post" enctype="multipart/form-data" action="{{ route('sscenes.update') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="upSceneName"><br><br>
            <label for="name">Fecha</label>
            <input type="date" name="date" id="upSceneDate"><br><br>
            <label for="updateSceneImg">Imagen</label>
            <input type="file" name="image360" id="updateSceneImg"><br><br>
            <input type="hidden" name="id" id="ids">
            <input type="hidden" name="idZone" id="idZone" value="{{$zone->id ?? ''}}">
            <input type="submit" value="Guardar" id="addSScene">
        </form>
    </div>
    <div class="col10 row50" ></div>
        <div id="sSceneView" class="col45">
            <div id="pano" class="l1 col100" style="width: 100%; heigth: 100%"></div>
        </div>
</div>

<!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
<div class="window" id="confirmDelete" style="display: none;">
    <span class="titleModal col100">¿Eliminar escena?</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
        <button id="aceptDelete" class="deleteButton">Aceptar</button>
        <button id="cancelDelete" >Cancelar</button>
    </div>
    
</div>
@endsection

<script type="text/javascript">
var routeUpdate = "{{ route('scene.update', 'req_id') }}";
var routeEdit = "{{ route('scene.edit', 'id') }}";

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

    /*FUNCIÓN PARA CARGAR VISTA PREVIA DE LA ESCENA*/
    var view = null;
    function loadScene(sceneDestination, elemento){
        view = null;
        'use strict';
        console.log(sceneDestination['id']);
        //1. VISOR DE IMAGENES
        var  panoElement = document.getElementById('pano');
        if(elemento == 0){
            var padre = document.getElementById('sSceneView');
            panoElement = padre.firstElementChild;
        }
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
    

    //ACCIÓN PARA ABRIR LA VENTANA MODAL DE AÑADIR ESCENA SECUNDARIA
    $().ready(function(){
        $("#addSScene").click(function(){
            var scenId = $('#idScene').attr('value');
            $("#modalWindow").css("display", "block");
            $("#Sscene").css("display", "block");
        });
        $('.scenepoint').click(function(){
            var idScene = ($(this).attr('id')).substr(5);
            $('#idScene').attr('value', idScene);
             console.log("llegue a la funcion para ver campos");
            sceneInfo(idScene).done(function(result){
                console.log(result);
                loadScene(result, 1);
                $('#showScene').show();
            });
        });
    });
    //FUNCIÓN PARA SACAR LAS ESCENAS SECUNDARIAS
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

        //FUNCIÓN PARA SACAR LAS ESCENA SECUNDARIA A MODIFICAR
        function seconInfo($id){
        var route = "{{ route('secondaryscenes.showScene', 'id') }}".replace('id', $id);
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