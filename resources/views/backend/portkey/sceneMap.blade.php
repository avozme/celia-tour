@extends('layouts.backend')


@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
    <link rel="stylesheet" href="{{url('css/map.css')}}" />
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
    <div class="col0 sMarginRight">
        <svg class="btnBack" onclick="window.location.href='{{ route('portkey.index') }}'" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	        viewBox="0 0 405.333 405.333" style="enable-background:new 0 0 405.333 405.333;" xml:space="preserve">
            <polygon points="405.333,96 362.667,96 362.667,181.333 81.707,181.333 158.187,104.853 128,74.667 0,202.667 128,330.667 
                158.187,300.48 81.707,224 405.333,224"/>
        </svg>
    </div>
    <div id="title" class="col80 xlMarginBottom">
        <span>Escenas de {{ $portkey->name }}</span>
    </div>
</div>

{{-- CONTENIDO --}}
<div id="zoneMap" class="col60 lMarginTop">
    {{----- MAPA -----}}
    <div id="addScene" class="col100 relative">
        <div id="zoneicon" class="icon pulse" style="display: none; position: absolute;">
            <img class="newscenepoint iconfilter" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
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
    <div class="col100 mMarginTop sMarginBottom">
        <label class="checkbox" for="changePosition"><div class="centrarLabel">Pemitir cambiar la posición</div>
            <input type="checkbox" name="changePosition" id="changePosition">
            <span id="checkPrincipal" class="check"></span>
        </label>
    </div>
    <div class="col100 centerH lMarginTop">
        <div id="panoUpdate" class="previewPortkeyMap col100"></div>
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
        <div id="map1" class="oneMap col100">
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
    //RUTAS PARA ARCHIVOS JS EXTERNOS
    var token = "{{ csrf_token() }}";
    var sceneShowRoute = "{{ route('scene.show', 'id') }}";
    var marzipanoRoute1 = "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}";
    var marzipanoRoute2 = "{{url('/marzipano/tiles/dn/preview.jpg')}}";
</script>
@endsection



