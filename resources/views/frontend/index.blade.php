@extends('layouts.frontend')

@section('content')
    
    <!-- CONTENIDO -->
    <div class="l2 col100 row100 absolute">
        <div id="coverCenter" class="col100 centerVH">
            <div id="titleIndex" class="col100">{!!$name[0]->value!!}</div>
            <div id="buttonsIndex" class="col100">
                <center>
                    <a href="{{route('frontend.freevisit')}}"><button id="buttonFreeVisit"  class="width20 width-mv-80 width-tb-60">Visita Libre</button></a>
                    @if ($guidedQ)
                        <a href="{{route('frontend.guidedvisit')}}"><button id="buttonGuided" class="mMarginTop width20 width-mv-80 width-tb-60">Visita Guiada</button></a>
                    @endif
                    @if ($highQ)
                        <a href="{{route('frontend.highlights')}}"><button id="buttonHigh" class="mMarginTop width20 width-mv-80 width-tb-60">Puntos Destacados</button></a>
                    @endif
                </center>
            </div>
            {{-- TEXTO OPCIONES --}}
            <div id="txtOption" class="col100 centerH lMarginTop">
                <span class="col40 centerT">
                    
                </span>
            </div>
        </div>

        {{-- ESCAPE ROOM (si está activo en opciones) --}}
        @isset($escape)
            <div id="escapeRoomOption" class="absolute" style="display:none">
                <a href="{{route('frontend.escaperoom')}}">
                    <div class="col0 sMarginRight" style="margin-top: 22px"> 
                        <svg id="padClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path d="M416,200.9V160C416,71.78,344.22,0,256,0S96,71.78,96,160v40.9A63.77,63.77,0,0,0,64,256V448a64.06,64.06,0,0,0,64,64H384a64.06,64.06,0,0,0,64-64V256a63.77,63.77,0,0,0-32-55.1ZM256,64a96.1,96.1,0,0,1,96,96v32H160V160A96.1,96.1,0,0,1,256,64Zm32,307.54V416H224V371.54a48,48,0,1,1,64,0Z" transform="translate(-64 0)"/>
                        </svg>

                        <svg id="padOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path d="M160,192V160a96,96,0,0,1,186.4-32.32l63.13-12.78C390,48.56,328.56,0,256,0,167.78,0,96,71.78,96,160v40.9A63.77,63.77,0,0,0,64,256V448a64.06,64.06,0,0,0,64,64H384a64.06,64.06,0,0,0,64-64V256c0-23.59-9-45.79-29.09-54.85-17-7.66-19.78-7.92-56.29-8.94M288,371.54V416H224V371.54a48,48,0,1,1,64,0Z" transform="translate(-64 0)"/>
                        </svg>
                    </div>

                    <div class="centerT col0">
                        <span id="sTextEscape"></span><br><span id="bTextEscape">JUEGO DE <br/> ESCAPE</span>
                        <br/><span id="sTextEscape" style="margin-left: -35px">ESCAPE ROOM VIRTUAL</span>
                    </div>
                </a>
            </div>
        @endisset

        {{-- FOOTER --}}
        <div id="footerIndex" class="absolute col100">
            <a>CeliaTour ® </a><span class="opacityFooter">|</span>
            @isset($history)
                <a href="{{route('frontend.history')}}" target="blank"> Historia </a><span class="opacityFooter">|</span>
            @endisset
            <a href="{{route('frontend.credits') }}" target="blank"> Créditos </a><span class="opacityFooter">|</span>
            <a href="{{route('frontend.privacy')}}" target="blank"> Privacidad </a><span class="opacityFooter">|</span>
            <a href="{{route('frontend.cookies')}}" target="blank"> Cookies</a>
        </div>
    </div>

    <!-- IMAGEN 360 -->
    <div id="pano" class="l1 col100" style="filter: brightness(75%);"></div>

    <!-- AGREGAR SCRIPTS -->
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>

    <script>        
var escapeRooms = @json($escapeRooms);
        $(document).ready(function(){

            var txtFV= @json($txtFreeVisit);
            var txtG =  @json($txtGuided);
            var txtH = @json($txtHigh);

            $("#buttonFreeVisit").hover(function(){
                $("#txtOption span").html(txtFV);
            });
            $("#buttonGuided").hover(function(){
                $("#txtOption span").html(txtG);
            });
            $("#buttonHigh").hover(function(){
                $("#txtOption span").html(txtH);
            });

            $("#buttonsIndex button").hover(function(){
                $("#txtOption span").addClass("showTextOption");
            }, function(){
                $("#txtOption span").removeClass("showTextOption");
            });

            //Determinar si hay algun escape room activo para mostrar o no la opcion correspondiente
            for(var i = 0; i<escapeRooms.length;i++){
                if(escapeRooms[i].active == 0){
                    escapeRooms.splice(i, 1);
                    i--;
                }
            }
            if(escapeRooms.length>0){
                $("#escapeRoomOption").show();
            }

            //Tipo de portada estatica o imagen 360
            var tipoPortada = @json($tipoPortada);
            var portada = @json($portada);
            var url = "{{url('img/options/image')}}";
        
            @if($tipoPortada[0]->value=="Estatica")
                var imagen = url.replace('image', portada[0].value);
                $('#coverCenter').css('background-image', 'url(' + imagen + ')');
            @else
                ///////////////////////////////////////////////////////////////////////////
                ///////////////////////////   MARZIPANO   /////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////
                'use strict';
                //1. VISOR DE IMAGENES
                var panoElement = document.getElementById('pano');
                /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
                a mayor, para conseguir una carga mas fluida. */
                var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

                //2. RECURSO
                var source = Marzipano.ImageUrlSource.fromString(
                "{{url('/marzipano/tiles/'.$data[0]->directory_name.'/{z}/{f}/{y}/{x}.jpg')}}",
                
                //Establecer imagen de previsualizacion para optimizar su carga 
                //(bdflru para establecer el orden de la capas de la imagen de preview)
                {cubeMapPreviewUrl: "{{url('/marzipano/tiles/'.$data[0]->directory_name.'/preview.jpg')}}", 
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
                var view = new Marzipano.RectilinearView({yaw: "{{$data[0]->yaw}}", pitch: "{{$data[0]->pitch}}", roll: 0, fov: Math.PI}, limiter);

                //5. ESCENA SOBRE EL VISOR
                var scene = viewer.createScene({
                    source: source,
                    geometry: geometry,
                    view: view,
                    pinFirstLevel: true
                });

                //6.MOSTAR
                scene.switchTo({ transitionDuration: 1000 });

                //7. AUTOROTACION
                var autorotate = Marzipano.autorotate({
                    yawSpeed: 0.03,         // Yaw rotation speed
                    targetPitch: 0,        // Pitch value to converge to
                    targetFov: Math.PI/2   // Fov value to converge to
                });
                // Movimiento infinito
                viewer.setIdleMovement(Infinity);
                // Empezar rotacion
                viewer.startMovement(autorotate);
            @endif
        });
    </script>
@endsection