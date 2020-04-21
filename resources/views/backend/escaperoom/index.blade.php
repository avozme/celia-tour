@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <link rel="stylesheet" href="{{url('css/escaperoom/index.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>
    <script src="{{url('js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('js/marzipano/marzipano.js')}}"></script>
@endsection

@section('content')
    <div id="title" class="col100 mMarginBottom">
        <span>ESCAPE ROOM</span>
    </div>

    {{-- <nav id="menuHorizontal" class="col100"> --}}
        <div id="menuEscapeRoom" class="col100 mMarginBototom">
            <ul>
                <div id="menuList">
                    <li>Escenas</li>
                    <li>Preguntas</li>
                    <li id="liBorder">Llaves</li>
                </div>
            </ul>
        </div>
        <div id="borderDiv" class="col100"></div>
    {{-- </nav> --}}

    {{------------ MAPA -------------}}
    <div id="map" class="col60">
        @include('backend.zone.map.zonemap')
    </div>

    {{------------ MENÚ ------------}}
    <div id="menu" class="col30 lMarginTop hidden">
        <span id="sceneName"></span>
        <div id="pano" class="col100 relative" style="height: 255px"></div>
        <input type="hidden" id="actualScene">
        <button id="editScene" class="col100 bBlack lMarginTop">Modificar Escena</button>
    </div>

    <script>
        /* RUTAS PARA ARCHIVOS EXTERNOS JS */
        var pointImgRoute = "{{ url('img/zones/icon-zone.png') }}";
        var pointImgHoverRoute = "{{ url('img/zones/icon-zone-hover.png') }}";
        var marzipanoTiles = "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}";
        var marzipanoPreview = "{{url('/marzipano/tiles/dn/preview.jpg')}}";

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

        function loadScenePreview(sceneDestination){     
            'use strict';
            //1. VISOR DE IMAGENES
            var panoElement = document.getElementById('pano');

            /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
            a mayor, para conseguir una carga mas fluida. */
            var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

            //2. RECURSO
            var source = Marzipano.ImageUrlSource.fromString(
                marzipanoTiles.replace('dn', sceneDestination.directory_name),
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: marzipanoPreview.replace('dn', sceneDestination.directory_name), 
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

        $().ready(function(){
            $(".scenepoint").hover(function(){
                $(this).attr('src', pointImgHoverRoute);
            }, function(){
                if(!($(this).hasClass('selected'))){
                    $(this).attr('src', pointImgRoute);
                }
            });

            $('.scenepoint').click(function(){
                $('#menu').show();
                $('.scenepoint').attr('src', pointImgRoute);
                $('.scenepoint').removeClass('selected');
                $(this).attr('src', pointImgHoverRoute);
                $(this).addClass('selected');
                var pointId = $(this).attr('id');
                var sceneId = parseInt(pointId.substr(5));
                $('#actualScene').val(sceneId);
                sceneInfo(sceneId).done(function(result){
                    $('#sceneName').text(result.name);
                    loadScenePreview(result);
                })
            });

            $('#editScene').click(function(){
                var pointId = $(this).attr('id');
                var sceneId = $('#actualScene').val();
                window.location.href = "{{ route('escaperoom.editScene', 'req_id') }}".replace('req_id', parseInt(sceneId));
            });

        });
    </script>
@endsection