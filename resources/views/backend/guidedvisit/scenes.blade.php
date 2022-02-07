@extends('layouts.backend')
@section('headExtension')



    <!-- URL GENERADAS PARA SCRIPT -->
    <script>
        // Para las urls con identificador se asignara "insertIdHere" por defecto para posteriormente modificar ese valor.
        const urlResource = "{{ url('/img/resources') }}/";
        const urlDelete = "{{ route('guidedVisit.deleteScenes', 'insertIdHere') }}";
        const urlAdd = "{{ route('guidedVisit.scenesStore', $guidedVisit->id) }}";
        const urlUpdate = "{{ route('guidedVisit.scenesUpdate', 'insertIdHere') }}";

    //FUNCIONES NECESARIAS PARA PREVISUALIZAR ESCENAS
    function loadScene(sceneDestination){
        'use strict';
        console.log(sceneDestination['id']);
        //1. VISOR DE IMAGENES
        var  panoElement = document.getElementById('pano');
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

    function loadSceneIfExist(idScene){
        sceneInfo(idScene).done(function(result){
            loadScene(result);
        });
    }
</script>

    <!-- MARZIPANO -->
    <script src="{{url('js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('js/marzipano/marzipano.js')}}"></script>


    <!-- Script base del documento -->
    <script src="{{url('js/guidedVisit/scene.js')}}"></script>

    <!-- Css base del documento -->
    <link rel="stylesheet" href="{{url('css/guidedVisit/scene.css')}}" />

    <!-- Recursos de zonas -->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>

    <!-- MDN para usar sortable -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

    <style>
    
    </style>
    
@endsection
@section('content')
 <!-- TITULO -->
<div class="col0 sMarginRight">
    <svg class="btnBack" onclick="window.location.href='{{ route('guidedVisit.index') }}'" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 405.333 405.333" style="enable-background:new 0 0 405.333 405.333;" xml:space="preserve">
        <polygon points="405.333,96 362.667,96 362.667,181.333 81.707,181.333 158.187,104.853 128,74.667 0,202.667 128,330.667 
            158.187,300.48 81.707,224 405.333,224"/>        
    </svg>
</div>
<div id="title" class="col65 xlMarginBottom">
    <span>Escenas de {{ $guidedVisit->name }}</span>
</div>


<!-- BOTON AGREGAR -->   
<div id="contentbutton" class="col30 xlMarginBottom">    
    <button class="right round col45 mMarginLeft" id="showModal">
        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
            <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                    8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
        </svg>                                        
    </button>
    <!--
    <button id="btn-savePosition" class="right" style="margin-top: 12px;">GUARDAR POSICIONES</button>
    -->
</div>

<!-- Formulario para guardar posición -->
<!--
    Para depurar la ordenación haz lo siguiente:
        - Quítale al formulario style="display: none;" para que sea visible
        - Quítale al input hidden para que sea visible
-->
<form id="addPosition" action="{{ route('guidedVisit.scenesPosition', $guidedVisit->id) }}" method="post" style="display: none;">
    @csrf
    <!-- Por defecto null, para saber si mandar petición al servidor -->
    <input id="position" type="text" name="position" value="null" hidden> 
</form>




<!-- Tabla de escenas -->
<div id="content" class="col100 centerH">
    <table class="col90" style="text-align: left;">
        <thead class="col100">
            <tr class="col100">
                <th class="mPaddingBottom sPadding col20">Escena</th>
                <th class="mPaddingBottom sPadding col60">Audiodescripción</th>
            </tr>
        </thead>
        <tbody id="tableContent" class="sortable col100"> <!-- Bloque ordenable (clase sortable)  -->
            @php
                $i = 0;
            @endphp
            @foreach ($sgv as $value)
            {{-- Modificar este tr y su contenido afectara a la insercion dinamica mediante ajax --}}
                <tr id="{{ $value->id }}" class="col100">
                    <td class="sPadding col20">{{$value->id_scenes}}</td>
                    <td class="sPadding col30"><audio src="{{$value->id_resources}}" controls="true" class="col100">Tu navegador no soporta este audio</audio></td>
                    <td class="sPadding col20" style="text-align: right;"><button id="{{ $scenesIds[$i] }}" class="scenePreview">Ver Escena</button></td>
                    <td class="sPadding col10"><button class="btn-update col100">Editar</button></td>
                    <td class="sPadding col10" style="text-align: right;"><button class="btn-delete delete">Eliminar</button></td>
                </tr>
            {{----------------------------------------------------------------------------------------}}
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<!------------------------------------------------ Ventanas modales ------------------------------------------------------>
@section('modal')

    <div id="modalZone" class="window sizeWindow70" style="display: none;">
        <span class="titleModal col100">SELECCIONAR ESCENA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="content col90 mMarginTop" style="overflow: auto; max-height: 523px">
            <div id="map2" class="oneMap col100">
                @include('backend.zone.map.zonemap')
            </div>
        </div>
        <div class="col80 centerH mMarginTop" style="margin-left: 9%">
            <button id="addSceneToKey" class="col100">Aceptar</button>
        </div>
    </div>
    
    <!-- Modal audiodescripciones -->
    <div id="modalResource" class="window" style="display:none">
        <span class="titleModal col100">Audiodescripción</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <!-- Contenido modal -->
        <div class="mMarginTop"> 
            <!-- Contenedor de audiodescripciones -->
            <div id="audioDescrip" class="xlMarginTop col100" style="max-height: 500px;">
            @foreach ($audio as $value)
                <div id="{{ $value->id }}" class="elementResource col25 tooltip">
                    {{-- Descripcion si la tiene --}}
                    @if($value->description!=null)
                        <span class="tooltiptext">{{$value->description}}</span>
                    @endif

                    <div style="cursor: pointer;" class="insideElement">
                        <!-- MINIATURA -->
                        <div class="preview col100">
                                <img src="{{ url('/img/spectre.png') }}">
                        </div>
                        <div class="titleResource col100">
                            <div class="nameResource col80">
                                {{ $value->title }}
                            </div>
                            <div class="col20">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.9 18.81">
                                        <path class="cls-1" d="M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76" transform="translate(-0.07 0)"></path>
                                    </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <!-- form para guardar la escena -->
            <form id="addsgv" style="display:none;">
                @csrf
                <input id="sgvId" type="text" name="sgv" value="" >
                <input id="sceneValue" type="text" name="scene" value="" >
                <input id="resourceValue" type="text" name="resource" value="" >
            </form>

            <!-- Botones de control -->
            <div id="actionbutton" style="clear:both;" class="lMarginTop col100">
                <div id="acept" class="col20"> <button class="btn-acept col100">Guardar</button> </div>
            </div>
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
            <button id="aceptDelete" class="delete">Aceptar</button>
            <button id="cancelDelete">Cancelar</button>
        </div>
    </div>

<!-- MODAL PREVISUALIZACIÓN DE ESCENA -->
<div id="previewModal" class="window" style="display: none;">
    <span class="titleModal col100">ESCENA ACTUAL</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="col100 xlMarginTop lMarginBottom">
        <div id="pano" style="height: 400px; border-radius: 17px;"></div>
    </div>
</div>

<style>
    #changeZone{
        left: 78%;
        top: 72%;
        width: 7%;
    }
</style>

@endsection


    
