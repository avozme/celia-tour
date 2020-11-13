@extends('layouts.backend')

@section('headExtension')
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>
    <script src="{{url('js/portkey/index.js')}}"></script>
    <!-- Recursos de zonas -->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    

    <!-- MDN para usar sortable -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>
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
		<div id="title" class="col75 xlMarginBottom">
            <span style="text-transform: uppercase">ESCENAS DE {{$portkey->name}}</span>
        </div>
    
        <!-- BOTON AGREGAR -->   
        <div id="contentbutton" class="col20 xlMarginBottom">   
            <button class="right round col45" id="newportkey">
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                            8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                </svg>                                        
            </button>
        </div>
	
        <div id="content" class="col100 centerH">
            <table id="tableContent" class="col60">   
                @foreach($portkeySceneList as $prk)
                    @php
                        $idScepeP = $prk->id;
                    @endphp
                    <tr id={{$prk->id}} class="tabla">
                        <td class="col25">{{ $prk->name }}</td>
                        @foreach ($scenes as $sc)
                             @if($idScepeP==$sc->id)
                                @php
                                    $idZone=$sc->id_zone
                                @endphp
                             @endif
                         @endforeach
                        @foreach ( $portkeyZoneList as $z )
                            @if($idZone == $z->id)
                                <td class="col25">{{ $z->name }}</td>
                            @endif
                        @endforeach
                        <td class="col25 sPaddingRight"><button id="{{$prk->id}}" class="prueba col100 marcar"> Previsualizar </button></td>
                        <td class="col25 sPaddingLeft"><button id="{{$prk->id}}" class="deleteportkeyscene delete col100"> Eliminar </button></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="col100 centerH lMarginTop">
            <div id="pano" style="display:none;" class="previewPortkey col50"></div>
        </div>
    </div>
    <style>
        
    </style>

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
    function loadScene(sceneDestination){
        var view = null;
        'use strict';
        console.log("{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}".replace('dn', sceneDestination.directory_name));

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

    $('.prueba').click(function(){
        var id = $(this).attr("id");
        sceneInfo(id).done(function(result){
            previsualizacion = id;
            loadScene(result);
        });
        $(".tabla").css('color','black');
        $("#"+id).css("color", "blue");
        $("#pano").css("display","block");
        
    });
    
    </script>
@endsection
@section('modal')
<script src="{{url('js/zone/zonemap.js')}}"></script>
    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR PORTKEYS -->
    <div class="window" id="confirmDelete" style="display: none;">
        <span class="titleModal col100">¿Eliminar portkey?</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
            <button id="aceptDelete" class="delete">Aceptar</button>
            <button id="cancelDelete" >Cancelar</button>
        </div>
    </div>
    <!-- Form añadir portkey -->
    <div id="modalportkey" class="window" style="display:none" ;>
        <span class="titleModal col100">Nueva escena</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div id="map1" class="oneMap col100">
            @include('backend.zone.map.zonemap')
        </div>

        <!-- form para guardar la escena -->
        <form id="addsgv" style="clear:both;" action="{{ route('portkey.guardar', $portkey->id) }}" method="post">
            @csrf
            <input id="sceneValue" type="text" name="scene" value="" hidden>
        </form>

        <!-- Botones de control -->
        <div id="actionbutton">
            <div id="aceptscene" class="col20"> <button class="btn-acept">Guardar</button> </div>
        </div>
    </div>
    <style>
        #modalportkey{
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
@endsection
