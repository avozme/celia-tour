@extends('layouts.frontend')
{{--Añadiendo cambios--}}
{{-- VENTANA MODAL PARA LAS GALERIAS DE IMAGENES --}}
@section('modal')
    <div id="map" style="display: none">
        @include('backend.zone.map.zonemap') 
    </div>
    <!--MODAL PARA VER LAS IMAGENES DE LAS GALERÍAS-->
    <div id="containerModal">
        <div class="window" style="display: none" id="showAllImages">
            <div id="galleryResources" class="col100">
                <button id="closeModalWindowButton" class="closeModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                </button>
                
            </div>
            <div class="col100 centerV xlMarginTop">
                <div class="col5 leftArrow">
                    <img id="backResource" class="col100" src="{{ url('/img/icons/left.svg') }}" alt="leftArrow">
                </div>
                
                <div id="imageMiniature" class="col90"></div>

                <div class="col5 rightArrow">
                    <img id="nextResource" class="col100" src="{{ url('/img/icons/right.svg') }}" alt="rightArrow">
                </div>
            </div>
            <input type="hidden" name="numImages" id="numImages">
            <input type="hidden" name="actualResource" id="actualResource">
        </div>
        <script>
            $('#closeModalWindowButton').click(function(){
                $('#modalWindow').css('display', 'none');
                $('#showAllImages').css('display', 'none');
                $('#galleryResources').empty();
            });
        </script>
    </div>
@endsection

{{-- CONTENIDO --}}
@section('content')
    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/audio.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/portkey.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/imageGallery.css')}}'>
   
    <!-- PANEL SUPERIO CON TITULO DE LA ESCENA -->
    <div id="titlePanel" class="absolute l3">
        <span></span><br>
        <div class="lineSub"></div>
    </div>

    <!-- PANEL SUPERIO DERECHO CON HISTORIAL ESCENAS SECUNDARIAS -->
    <div id="timerCount" class="absolute l3">
        <span>00:00</span>
    </div>

    <div id="keyPanel" class="absolute l3">
            <div class="keyContainer centerV">
                <div class="labelKey col85">
                    <div>Secretaría</div> 
                </div>
                <svg class="col15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 469.33">
                    <path d="M192,248.53a128,128,0,1,1,85.33,0v92.8h85.34v85.34H277.33v42.66H192ZM277.33,128a42.67,42.67,0,1,0-42.66,42.67A42.66,42.66,0,0,0,277.33,128Z" transform="translate(-106.67 0)"/>
                </svg>
            </div>

            <div class="keyContainer centerV">
                <div class="labelKey col85">
                    <div>Departamente de geografia e historia</div>
                </div>
                <svg class="col15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 469.33">
                    <path d="M192,248.53a128,128,0,1,1,85.33,0v92.8h85.34v85.34H277.33v42.66H192ZM277.33,128a42.67,42.67,0,1,0-42.66,42.67A42.66,42.66,0,0,0,277.33,128Z" transform="translate(-106.67 0)"/>
                </svg>
            </div>
          
        {{--<svg id="eu5x8wouae31" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 700 580" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" height="80px">
            <g id="eu5x8wouae32_to" transform="translate(371.842188,241.444175)">
                <g id="eu5x8wouae32_tr" transform="rotate(-90)">
                    <path id="eu5x8wouae32" d="M-305.300000,234.240000L-4.620000,234.240000C3.491216,234.206890,11.261275,230.972361,17,225.240000L92.670000,149.560000C98.407732,143.828011,101.631639,136.050318,101.631639,127.940000C101.631639,119.829682,98.407732,112.051989,92.670000,106.320000L17,30.680000C11.264810,24.915336,3.451434,21.700607,-4.680000,21.760000L-305.460000,21.760000C-313.538804,21.759190,-321.287018,24.967828,-327,30.680000C-332.742509,36.411930,-335.978863,44.186371,-336,52.300000L-336,203.650000C-335.964724,211.760778,-332.730524,219.530046,-327,225.270000C-321.249807,231.030452,-313.439236,234.259061,-305.300000,234.240000ZM22.400000,111.760000C31.355026,102.806124,45.872963,102.806746,54.827223,111.761389C63.781482,120.716031,63.781482,135.233969,54.827223,144.188611C45.872963,153.143254,31.355026,153.143876,22.400000,144.190000C18.091786,139.893620,15.670460,134.059372,15.670460,127.975000C15.670460,121.890628,18.091786,116.056380,22.400000,111.760000Z" transform="translate(0,0)" opacity="0" fill="rgb(216,216,216)" stroke="none" stroke-width="1"/>
                </g>
            </g>
            <path id="eu5x8wouae33" d="M277.330000,248.530000C336.105927,227.750485,371.363324,167.648925,360.821765,106.205671C350.280206,44.762418,297.005981,-0.150147,234.665000,-0.150147C172.324019,-0.150147,119.049794,44.762418,108.508235,106.205671C97.966676,167.648925,133.224073,227.750485,192,248.530000L192,341.330000L106.670000,341.330000L106.670000,426.670000L192,426.670000L192,469.330000L277.330000,469.330000ZM192,128C192,104.434010,211.104010,85.330000,234.670000,85.330000C258.235990,85.330000,277.340000,104.434010,277.340000,128C277.340000,151.565990,258.235990,170.670000,234.670000,170.670000C223.352399,170.672653,212.497576,166.177929,204.494824,158.175176C196.492071,150.172424,191.997347,139.317601,192,128Z" transform="matrix(1 0 0 1 336 0)" fill="rgb(0,0,0)" stroke="none" stroke-width="1"/>
        </svg>
        --}}
    </div>


    <!-- PANEL LATERAL DE OPCIONES -->
    <div id="leftPanel" class="col40 absolute l2">
        <div id="actionButton" class="col10">
            <!-- BOTON DESPLAZAR PLANTAS  -->
            <div id="buttonsFloorCont" class="col100 xlMarginBottom" style="display:none">
                <div id="floorUp">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                        <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#fff"/>
                    </svg>                          
                </div>
                <div id="floorDown">
                    <svg class="col100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32" style="transform: rotate(180deg)">
                        <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#fff"/>
                    </svg>                          
                </div>
            </div>

            <!-- BOTON MAPA -->
            <div id="buttonMap">
                <svg id="mapIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.258 32.266">
                    <path  d="M.067,5.416V35.55l9.511-1.722V3.505Z" transform="translate(-0.067 -3.284)"/>
                    <path  d="M190.462,25.3V4.78L180.99,3.151V33.474L190.462,35V27.283C190.466,27.265,190.462,25.3,190.462,25.3Z" transform="translate(-169.588 -2.952)"/>
                    <path  d="M361.293,1.807V32.023l9.493-1.785V0Z" transform="translate(-338.529)"/>
                </svg>          
                
                <svg id="closeMapIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" style="display:none">
                    <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                </svg>    
            </div>
            
            {{-- BOTON VOLVER A INICIO --}}
            <div id="buttonReturn">
                <a href="{{url('')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510">
                        <polygon points="204,471.75 204,318.75 306,318.75 306,471.75 433.5,471.75 433.5,267.75 510,267.75 255,38.25 0,267.75 76.5,267.75 76.5,471.75"/>
                    </svg>
                </a>
            </div>

             <!-- BOTON PANTALLA COMPLETA -->
            <div id="buttonFullScreen">
                {{--Abrir pantalla completa--}}
                <svg id="openFull" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357">
                    <path d="M51,229.5H0V357h127.5v-51H51V229.5z M0,127.5h51V51h76.5V0H0V127.5z M306,306h-76.5v51H357V229.5h-51V306z M229.5,0v51
                        H306v76.5h51V0H229.5z"/>
                </svg>
                {{--Cerrar pantalla completa--}}
                <svg id="exitFull" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display:none">
                    <path d="M0,280.5h76.5V357h51V229.5H0V280.5z M76.5,76.5H0v51h127.5V0h-51V76.5z M229.5,357h51v-76.5H357v-51H229.5V357z
                        M280.5,76.5V0h-51v127.5H357v-51H280.5z"/>
                </svg>
            </div>
        </div>

        {{-- MAPAS PLANTAS --}}
        <div id="mapContent" class="col90">
            @foreach ($allZones as $key => $zone)
                <div id="map{{ $key }}" class="map" value="{{$zone->id}}">
                    {{-- Mapa --}}
                    <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}">
                    {{-- Dibujar puntos de zonas --}}
                    @foreach ($data as $scene)
                        @if($scene->id_zone == $zone->id)
                            <div id="point{{$scene->id}}" class="pointMap" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%;">
                                <div class="pointMapInside"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!-- IMAGEN 360 -->
    <div id="pano" class="l1 col100"></div>

    <!-- HOTSPOTS -->
    <div id="contentHotSpot"></div>

    <!-- AGREGAR SCRIPTS -->
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>

    <script src="{{url('/js/marzipano/easing.js')}}" ></script>
    <script src="{{url('/js/marzipano/transitionFunctions.js')}}" ></script>

    <script src="{{url('/js/frontend/textInfo.js')}}"></script>
    <script src="{{url('/js/frontend/audio.js')}}"></script>
    <script src="{{url('/js/frontend/video.js')}}"></script>
    <script src="{{url('/js/frontend/jump.js')}}"></script>
    <script src="{{url('/js/frontend/portkey.js')}}"></script>
    <script src="{{url('/js/frontend/fullScreen.js')}}"></script>
    <script src="{{url('/js/frontend/imageGallery.js')}}"></script>

    <script>      
        var token = "{{ csrf_token() }}";  
        var indexUrl = "{{ url('img/resources/') }}";
        var url = "{{url('')}}";
        var data = @json($data);
        var subt = @json($subtitle);
        var indexSubt = "{{url('img/resources/subtitles')}}";
        
        /////// Variables especificas para el escape room

        var keys = @json($keys);
        var lockScenes=[]; //Listado de escenas bloqueadas
        var lockJumps=[];//Listado con todos los saltos bloqueados

        var padlockIcon=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="hotspotPadlock">
                            <path d="M416,200.9V160C416,71.78,344.22,0,256,0S96,71.78,96,160v40.9A63.77,63.77,0,0,0,64,256V448a64.06,64.06,0,0,0,64,64H384a64.06,64.06,0,0,0,64-64V256a63.77,63.77,0,0,0-32-55.1ZM256,64a96.1,96.1,0,0,1,96,96v32H160V160A96.1,96.1,0,0,1,256,64Zm32,307.54V416H224V371.54a48,48,0,1,1,64,0Z" transform="translate(-64 0)"/>
                         </svg>`;
        
        /////////////////////////////////////////////////

        //Relaciones entre los diferentes tipos y el hotspot
        var hotsRel = @json($hotspotsRel); 
        var typePortkey = @json($typePortkey);
        //Rutas necesarias por scripts externos
        var getScenesPortkey = "{{ route('portkey.getScenes', 'id') }}";
        
        /* RUTA PARA SACAR EL ID DE LA GALERÍA A TRAVÉS DEL ID DEL HOTSPOT */
        var getIdGalleryRoute = "{{ route('htypes.getIdGallery', 'hotspotid') }}";
        /* RUTA PARA SACAR LAS IMÁGENES DE UNA GALERÍA */
        var getImagesGalleryRoute = "{{ route('gallery.resources', 'id') }}";
        /* URL PARA LAS IMÁGENES DE LA GALERÍA */
        var urlImagesGallery = "{{ url('img/resources/image') }}";
        //URL PARA LA IMAGEN DE UN PUNTO
        var ScenePointUrl = "{{ url('img/zones/icon-zone.png') }}";
        // URL PARA LAS IMAGENES DE PORTKEYS
        var urlImagesPortkey = "{{ url('img/portkeys') }}";
        // URL PARA OBTENER LOS DATOS DE UN PORTKEY
        var getPortkey = "{{ route('portkey.openUpdate', 'insertIdHere') }}";
        
        $( document ).ready(function() {
                       
            //Mostrar la escena inicial si existe alguna marcada como tal en la bbdd
            var escenaIni=false;
            for(var j=0; j<data.length; j++){
                if(data[j].principal==true){
                    changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                    escenaIni=true;
                }
            }
            //Si no se encuentra escena inicial, establecemos la primera
            if(!escenaIni){
                changeScene(data[0].id, data[0].pitch, data[0].yaw, false);
            }
            
            //EVENTOS

            /*
            * Funcionalidad a todos los puntos del mapa para poder cambiar de escena
            */
            $(".pointMap").on("click", function(){
                var idPulse = $(this).attr("id");
                idPulse = idPulse.replace("point", "");
                for(var j=0; j<data.length; j++){
                    if(data[j].id==idPulse){
                        changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                    }
                }
            });

            /*
            * Boton para subir de planta
            */
            $("#floorUp").on("click", function(){
                //Obtener el id del elemento visible
                if($('.map.showMap').length>=1){
                    var map = parseInt($('.map.showMap').attr("id").replace("map", ""));
                    //Comprobar que no queremos subir mas de las plantas existentes
                    if((map+1)<=$(".map").length-1){
                        $("#map"+map).removeClass('showMap'); //Ocultar actual
                        $("#map"+map).on('transitionend', function(e) {
                            $("#map"+map).off('transitionend');
                            $("#map"+(map+1)).addClass('showMap');//Mostrar siguiente
                        });
                        
                    }
                }
            });

            /*
            * Boton para bajar de planta
            */
            $("#floorDown").on("click", function(){
                //Obtener el id del elemento visible
                if($('.map.showMap').length>=1){
                    var map = parseInt($('.map.showMap').attr("id").replace("map", ""));
                    //Comprobar que no queremos subir mas de las plantas existentes
                    if((map-1)>=0){
                        $("#map"+map).removeClass('showMap'); //Ocultar actual
                        $("#map"+map).on('transitionend', function(e) {
                            $("#map"+map).off('transitionend');
                            $("#map"+(map-1)).addClass('showMap');//Mostrar siguiente
                        });
                        
                    }
                }
            });
            /*
            * Boton para mostrar y ocultar el mapa
            */
            $("#buttonMap").on("click", function(){
                $("#closeMapIcon, #mapIcon").hide();
                if($("#mapContent").hasClass("showContentMap")){
                    //Ocultar
                    $("#mapContent").removeClass("showContentMap");
                    $("#mapIcon").show();
                    $("#buttonsFloorCont").hide();
                }else{
                    //Mostrar
                    $("#mapContent").addClass("showContentMap");
                    $("#closeMapIcon").show();
                    $("#buttonsFloorCont").show();
                }
            });

            //------------------------------------------------------------------------

            /*
             * ACCION PARA ATENUAR LOS HOTSPOT MIENTRAS NO SE MUEVE EN LA VISTA
             */
            var clickDown = false;
            var drag = false;
            $(".hotspotElement").addClass("hotsLowOpacity");

            $("#pano")
            .mousedown(function() {
                clickDown = true;
            })
            .mousemove(function() {
                if(clickDown){
                    drag="true";
                    //Al arrastrar la vista que mostrar los hotspot
                    $(".hotspotElement").removeClass("hotsLowOpacity");
                }
            })
            /*
            .mouseup(function() {
                clickDown=false;
                if(drag){
                    //Desvanecer puntos al dejar de arrastrar
                    $(".hotspotElement").addClass("hotsLowOpacity");
                    drag=false;
                }
            });*/

            //------------------------------------------------------------------------
            // ESCAPE ROOM
            //------------------------------------------------------------------------
            //Animación para las etiquetas de las llaves
            $( ".keyContainer svg" ).hover(
                function() {
                    //Mostrar etiqueta
                    var hoverKey =  $(this).parent().find(".labelKey div").addClass("animateShowLabelKey");
                    hoverKey.removeClass("animateHideLabelKey");
                    hoverKey.addClass("animateShowLabelKey");
                }, function() {
                    //Ocultar etiqueta
                    var hoverKey =  $(this).parent().find(".labelKey div").addClass("animateShowLabelKey");
                    hoverKey.addClass("animateHideLabelKey");
                    hoverKey.removeClass("animateShowLabelKey");
                }
            );

            //Provisional
            timerStart();
            lockPoints();
        });
        
        /**
        * FUNCION PARA INICIAR EL MARCADOR DE TIEMPO
        */
        var time=0;
        function timerStart(){
            //Contador de tiempo
            window.setInterval(function(){
                var min = Math.trunc(time/60).toString();
                var sec = (time%60).toString();
                $("#timerCount span").text(min.padStart(2, 0)+":"+sec.padStart(2, 0));
                time++;
            },1000);
        }

        /**
        * METODO PARA BLOQUEAR LAS ESCENAS CON LLAVE
        */
        function lockPoints(){
            //Cada una de las llaves
            for(var i=0; i<keys.length; i++){
                var scenesToLock = keys[i].scenes_id.split(",");

                //Cada una de las escenas de una llave
                for(var j=0; j<=keys.length; j++){
                    //Editar punto
                    $("#point"+scenesToLock[j]+" .pointMapInside").remove();
                    $("#point"+scenesToLock[j]).append(`
                        <div class="pointPadlock">
                            `+padlockIcon+`
                        </div>
                    `);
                    $("#point"+scenesToLock[j]).off("click");
                    //Agregar al listado
                    lockScenes.push(scenesToLock[j]);
                }
            }
        }
        
        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////   MARZIPANO   /////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
        'use strict';
        //1. VISOR DE IMAGENES
        var panoElement = document.getElementById('pano');
        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 
        var currentScene=null;
        var currentPrincipalId;
        var scenes= new Array;
        //2. RECORRER TODAS LAS ESCENAS
        for(var i=0;i<data.length;i++){
            var source = Marzipano.ImageUrlSource.fromString(
                "{{url('/marzipano/tiles/dirName/{z}/{f}/{y}/{x}.jpg')}}".replace("dirName", data[i].directory_name),
            
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: "{{url('/marzipano/tiles/dirName/preview.jpg')}}".replace("dirName", data[i].directory_name), 
            cubeMapPreviewFaceOrder: 'lfrbud'});
            //GEOMETRIA 
            var geometry = new Marzipano.CubeGeometry([
            { tileSize: 256, size: 256, fallbackOnly: true  },
            { tileSize: 512, size: 512 },
            { tileSize: 512, size: 1024 },
            { tileSize: 512, size: 2048},
            ]);
            //CREAR VISOR (Con parametros de posicion, zoom, etc)
            //Limitadores de zoom min y max para vista vertical y horizontal
            var limiter = Marzipano.util.compose(
                Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
                Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
            );
            //Crear el objeto vista
            var dataView = {pitch: data[i].pitch, yaw: data[i].yaw, roll: 0, fov: Math.PI}
            var view = new Marzipano.RectilinearView(dataView, limiter);
            //CREAR LA ESCENA Y ALMACENARLA EN EL ARRAY 
            var scene = viewer.createScene({
                source: source,
                geometry: geometry,
                view: view,
                pinFirstLevel: true
            });
            //ALMACENAR OBJETO EN ARRAY
            scenes.push({scene:scene, id:data[i].id, zone:data[i].id_zone});
        }
        
               
        /*
        * Recorrer todas las escenas para asignar a cada una sus hotspot
        */
        for(var h=0; h<scenes.length;h++){
            var allHots = @json($allHots);
            var hotspots = new Array();
            //Obtener todos los hotspot relacionados con esta escena
            for(var i=0; i<allHots.length;i++){
                if(allHots[i].scene_id == scenes[h].id){
                    hotspots.push(allHots[i]); //Agregar el hotspot si esta asociado a la escena
                }
            }
            //Acceder a los datos de las relaciones entre hotspot y los diferentes recursos
            for(var i=0; i<hotspots.length;i++){
                for(var j = 0; j<hotsRel.length;j++){
                    if(hotspots[i].id == hotsRel[j].id_hotspot){
                        //Almacenar el tipo de hotspot para pasarlo al metodo de instanciacion de hotspot
                        hotspots[i].type = hotsRel[j].type;
                        //Almacenar el id del recurso referenciado
                        hotspots[i].idType = hotsRel[j].id_type;
                    }
                }
            }
            //Recorrer todos los datos de los hotspot existentes e instanciarlos en pantalla
            for(var i=0; i<hotspots.length;i++){
                loadHotspot(scenes[h].scene, hotspots[i]);
            }
        }

        //-----------------------------------------------------------------------------------------
        /*
        * METODO INSTANCIAR EN PANTALLA UN HOTSPOT PASADO POR PARAMETRO
        */
        function loadHotspot(scene, hotspot){
            //Insertar el código en funcion del tipo de hotspot
            switch(hotspot.type){
                case 0:
                    textInfo(hotspot.id, hotspot.title, hotspot.description);
                    //Crear el hotspot
                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    break;    

                case 1:
                    //Obtener los datos del salto como id de destino y posicion de vista
                    var getRoute = "{{ route('jump.getdestination', 'req_id') }}".replace('req_id', hotspot.idType);
                   
                    
                    $.get(getRoute, function(dest){
                        //Comprobar si la escena de destino del salto esta bloqueada
                        var lock=false;
                        for(var i=0; i<=lockScenes.length; i++){
                            if(dest.destination == lockScenes[i]){
                                lock=true
                            }
                        }

                        //Si no esta bloqueado lo agregamos
                        if(!lock){
                            jump(hotspot.id, dest.destination, dest.pitch, dest.yaw);
                            //Crear el hotspot al obtener la informacion
                            scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                        }else{
                            //Crear el hotspot al obtener la informacion
                            $("#contentHotSpot").append(
                                `<div id='hintspot' class='hotspotElement hotsLowOpacity hots`+hotspot.id+`'>
                                    `+padlockIcon+`
                                </div>`
                            );     
                            scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                            //Almacenar informacion para el posterior desbloqueo
                            var j={'idScene':dest.destination, 'scene':scene, 'hotspot':hotspot};
                            lockJumps.push(j);
                        }
                    });
                    break;

                case 2:
                    //Obtener la URL del recurso asociado a traves de ajax
                    var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', hotspot.idType);
                    
                    $.get(getRoute, function(src){
                        video(hotspot.id, src);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });
                    break;

                case 3:
                    //Obtener la URL del recurso asociado a traves de ajax
                    var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', hotspot.idType);
                    
                    $.get(getRoute, function(src){
                        audio(hotspot.id, src, hotspot.idType);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });
                    break;

                case 4:                 
                    imageGallery(hotspot.id);
                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    break;

                case 5:
                    var address = getPortkey.replace('insertIdHere', hotspot.idType);
                    $.get(address, function(data){
                        if(typeof data.id != "undefined") { // Controla que el portkey contiene datos
                            // Filtra los portkeys segun el tipo de portkey seleccionado en opciones.
                            if(typePortkey == "Mapa"){
                                if(data.image != null){ // Si tiene imagen significa que es de tipo mapas
                                    portkey(hotspot.id, hotspot.idType);
                                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                                }
                            } else {
                                if(data.image == null){ // Si no tiene imagen es de tipo ascensor
                                    portkey(hotspot.id, hotspot.idType);
                                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                                }
                            }
                        }
                    });
                    break;
            }
        };

        //-----------------------------------------------------------------------------
        /*
         * METODO PARA CAMBIAR DE ESCENA CON TRANSICION
         */
         function changeScene(id, pitch, yaw, tunnel){
            //Efectos de transicion
            if(tunnel){
                var fun = transitionFunctions["opacityRT"];
                var easeOpacity = easing["easeInOutCubic"]; //https://hsto.org/getpro/habr/post_images/f7b/65e/8e7/f7b65e8e7024fcdeecb308e97d4621fe.png
            }else{
                var fun = transitionFunctions["opacity"];
                var easeOpacity = easing["easeInOutCubic"];
            }
            //Buscar escena correspondiente con el id en el array
            for(var i=0; i<scenes.length;i++){
                if(scenes[i].id == id){
                    var s = scenes[i].scene;
                    
                    //Cambiar
                    s.switchTo({
                        transitionDuration: 800,
                        transitionUpdate: fun(easeOpacity, currentScene)
                    });
                    
                    s.view().setYaw(yaw);
                    s.view().setPitch(pitch);
                    
                    currentScene=s;
                    currentPrincipalId=id;
                    
                    //Mostrar el mapa correspondiente
                    $(".map").removeClass("showMap");
                    $(".map").each(function( index ) {
                        if($(this).attr("value")==scenes[i].zone){
                            $(this).addClass("showMap");
                        }
                    });

                    //Marcar el punto activo
                    $(".pointMap").removeClass("activePoint");
                    $("#point"+id).addClass("activePoint");
                    //Obtener infor de la escena
                    var dir="";
                    var pitchOriginal = 0;
                    var yawOriginal =0;
                    for(i =0; i<data.length;i++){
                        if(data[i].id==id){
                            $("#titlePanel span").text(data[i].name);
                            dir = data[i].directory_name;
                            pitchOriginal = data[i].pitch;
                            yawOriginal = data[i].yaw;
                        }
                    } 
                    
                    //Detener todos los audios de los hotspots
                    $('audio').each(function(){
                        this.pause(); // Stop playing
                        this.currentTime = 0; // Reset time
                    }); 
                    $(".contentAudio").hide();
                    
                    //Argucia para detener los videos de los hotspot
                    $('iframe').each(function(){
                        var url = $(this).attr('src');
                        $(this).attr('src','');
                        $(this).attr('src',url);
                    }); 
                }
            }
        }
    </script>
@endsection