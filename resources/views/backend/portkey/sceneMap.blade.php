@extends('layouts.backend')


@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
    <script src="{{url('js/portkey/sceneMap.js')}}"></script>
    <script src="{{url('js/errorMessage.js')}}"></script>

    {{-- RECURSOS PARA EL MAPA DE ZONAS --}}
    <script src="{{url('js/zone/zonemap.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />

    {{-- MARZIPANO --}}
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>

    <!-- URL GENERADAS PARA SCRIPT -->
    <script>
        // Para las urls con identificador se asignara 'insertIdHere' por defecto para posteriormente modificar ese valor.
        const urlResourceZones = "{{ url('img/zones') }}/";
        const urlgetPortkeyScene = "{{ route('portkey.getPortkeyScene', 'insertIdHere') }}";
        const urlupdatePortkeyScene = "{{ route('portkey.updatePortkeyScene', 'insertIdHere') }}";
        const urldeletePortkeyScene = "{{ route('portkey.deletePortkeyScene', 'insertIdHere') }}";
    </script>

    <style>
        .previewPortkeyMap {
            height: 250px;
            position: relative;
            border-radius: 5px;
        }

        #menuAddScene {
            border: none;
            margin: 20px 0 0 0;
        }

    </style>
@endsection


@section('content')

<div>
    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>Escenas de {{ $portkey->name }}</span>
    </div>
</div>

{{-- CONTENIDO --}}
<div id="zoneMap" class="col60 lMarginTop">
    {{----- MAPA -----}}
    <div id="addScene" class="col100 relative">
        <div id="zoneicon" class="icon" style="display: none; position: absolute;">
            <img class="newscenepoint" src="{{ url('img/zones/icon-zone-hover.png') }}" alt="icon" width="100%" >
        </div>
        @foreach ($scenes as $value)
            <div class="icon iconHover" style="top: {{ $value->top }}%; left: {{ $value->left }}%">
                <img id="scene{{ $value->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
            </div>
        @endforeach
        <img id="zoneimg" width="100%" src="{{ url('img/portkeys/' . $portkey->image) }}" alt="">
    </div>
</div>

{{----- FORMULARIO AÑADIR ESCENA -----}}
<div id="menuAddScene" class="col40 xlPaddingS lMarginTop" style="display:none">
    <button id="selectSceneInsert" class="col100">Seleccionar escena</button>
    <button id="saveSceneInsert" style="display:none"  class="col100 sMarginTop">Guardar</button>
    <div class="col100 centerH lMarginTop">
        <div id="panoInsert" style="display:none;" class="previewPortkeyMap col100"></div>
    </div>

    <form id="formAddScene" style="display:none" method="post" enctype="multipart/form-data" action="{{ route('portkey.guardar', $portkey->id) }}">
        @csrf
        <input type="text" name="scene"> 
        <input type="text" name="top">
        <input type="text" name="left">
    </form>

</div>

{{----- FORMULARIO MODIFICAR ESCENA -----}}
<div id="menuUpdateScene" class="col40 xlPaddingS lMarginTop" style="display:none">
    <button id="selectSceneUpdate" class="col100">Seleccionar escena</button>
    <button id="saveSceneUpdate" class="col50 sMarginTop">Guardar</button>
    <button id="deleteScene" class="col50 sMarginTop">Borrar</button>
    <div class="col100 mMarginTop ajustarTamaño">
        <label class="checkbox" for="changePosition"><div class="centrarLabel">Pemitir cambiar la posición</div>
            <input type="checkbox" name="changePosition" id="changePosition">
            <span id="checkPrincipal" class="check"></span>
        </label>
    </div>
    <div class="col100 centerH lMarginTop">
        <div id="panoUpdate" style="display:none;" class="previewPortkeyMap col100"></div>
    </div>
    <form id="formUpdateScene" style="display:none" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="scene">
        <input type="text" name="top">
        <input type="text" name="left">
    </form>
</div>



@section('modal')
    <!-- SELECIONA ESCENA -->
    <div id="modalZone" class="window" style="display:none" ;>
        <span class="titleModal col100">Seleccionar escena</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
            @include('backend.zone.map.zonemap')
        </div>
    </div>
    <style>
        #modalZone{
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
        .closeModalButton {
            display: none;
        }
    </style>


    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR -->
    <div class="window" id="confirmDelete" style="display: none;">
        <span class="titleModal col100">¿Eliminar escena?</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
            <button id="aceptDelete" class="delete">Aceptar</button>
            <button id="cancelDelete">Cancelar</button>
        </div>
    </div>
@endsection


{{-- VISOR DE IMAGENES 360 --}}
<script>
        
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

    //var view = null;
    function loadScene(sceneDestination, panoElement){
        var view = null;
        'use strict';

        //1. VISOR DE IMAGENES
        // var  panoElement = document.getElementById("pano");

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
</script>
@endsection



