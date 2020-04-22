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
    
    {{-- PANEL LATERAL DERECHO PARA MOSTRAR LAS LLAVES --}}
    <div id="keyPanel" class="absolute l3">
        
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
            * Aplicar funcionalidad a los puntos del mapa para cambiar de escena al presionarlos
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
            

            //Provisional
            timerStart();
            lockPoints();
        });

        //--------------------------------------------------------------------------------------------
        // ESCAPE ROOM
        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA INICIAR EL MARCADOR DE TIEMPO
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

        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA APLICAR ANIMACION A LAS ETIQUETAS DE LAS LLAVES
        */
        function animateLabelKey(){
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
        }

        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA BLOQUEAR LAS ESCENAS CON LLAVE
        */
        function lockPoints(){
            //Cada una de las llaves
            for(var i=0; i<keys.length; i++){
                var scenesToLock = keys[i].scenes_id.split(",");

                //Cada una de las escenas de una llave
                for(var j=0; j<scenesToLock.length; j++){
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

                //Agregar icono de llave
                $("#keyPanel").append(`
                    <div id="key`+keys[i].id+`" class="keyContainer centerV">
                        <div class="labelKey col82">
                            <div>`+keys[i].name+`</div> 
                        </div>
                        <svg class="col18 keyClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256.08 469.51">
                            <path d="M170.66,248.53a128,128,0,1,0-85.33,0V371.8A18.45,18.45,0,0,1,88.39,374a18.72,18.72,0,0,1,4.14,5.31,17.06,17.06,0,0,1,5.88,27,16.94,16.94,0,0,1-1.34,1.34v15.8H85.33v45.86h85.33V426.67H256V341.33H170.66ZM128,170.67h0A42.67,42.67,0,1,1,170.66,128h0A42.66,42.66,0,0,1,128,170.67Z" transform="translate(0.04 0.18)"/>
                            <path fill="#fff" d="M138.93,334.9V318.75a63.27,63.27,0,0,0-53.6-62.44,64.26,64.26,0,0,0-9.57-.72h-.41A63.21,63.21,0,0,0,12.6,318.75V334.9A25.18,25.18,0,0,0,0,356.66v75.78a25.29,25.29,0,0,0,25.27,25.27H126.28a25.29,25.29,0,0,0,25.28-25.27V356.66A25.23,25.23,0,0,0,138.93,334.9Zm-75.8,84.91V402.26a18.93,18.93,0,0,1,12.22-33.05,18.73,18.73,0,0,1,10,2.59A18.45,18.45,0,0,1,88.39,374a18.72,18.72,0,0,1,4.14,5.31,18.93,18.93,0,0,1-2.65,21.44,20.94,20.94,0,0,1-1.49,1.49v17.55Zm50.52-88.43H37.86V318.75a37.93,37.93,0,0,1,37.49-37.89h.41a37.9,37.9,0,0,1,37.89,37.89Z" transform="translate(0.04 0.18)"/>
                        </svg>

                        <svg class="col18 keyOpen" style="display:none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 469.33">
                            <path fill="#fff" d="M192,248.53a128,128,0,1,1,85.33,0v92.8h85.34v85.34H277.33v42.66H192ZM277.33,128a42.67,42.67,0,1,0-42.66,42.67A42.66,42.66,0,0,0,277.33,128Z" transform="translate(-106.67 0)"/>
                        </svg>
                    </div>
                `);
            }

            //Lamada al metodo para aplicar animacion a las etiquetas de las llaves
            animateLabelKey();
        }

        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA DESBLOQUEAR UNA ESCENA CON LLAVE
        */
        function unlockPoints(id){
            //Cada una de las llaves
            for(var i=0; i<keys.length; i++){
                //Buscar la llave pasada por parametro
                if(keys[i].id==id){
                    var scenesToUnlock = keys[i].scenes_id.split(",");

                    //Cada una de las escenas de la llave
                    for(var j=0; j<scenesToUnlock.length; j++){
                        //Comprobar si la escena esta bloqueada por si ya se ha ejecutao el metodo
                        if(lockScenes.includes(scenesToUnlock[j])){

                            //1. Eliminar las escenas bloqueadas del listado
                            for(var k=lockScenes.length-1; k>=0; k--){
                                if(scenesToUnlock[j]==lockScenes[k]){
                                    lockScenes.splice( k, 1 );
                                }
                            }

                            //2. Reestablecer puntos en el mapa
                            $("#point"+scenesToUnlock[j]+" .pointPadlock").remove();
                            $("#point"+scenesToUnlock[j]).append(` <div class="pointMapInside"></div> `);

                            //3. Reestablecer funcionalidad del punto
                            $("#point"+scenesToUnlock[j]).on("click", function(){
                                var idPulse = $(this).attr("id");
                                idPulse = idPulse.replace("point", "");
                                for(var j=0; j<data.length; j++){
                                    if(data[j].id==idPulse){
                                        changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                                    }
                                }
                            });

                            //4. Reestablecer saltos
                            for(var k=0; k<lockJumps.length; k++){
                                if(scenesToUnlock[j]==lockJumps[k].idScene){
                                    //4.1 Eliminamos el hotspot de tipo candado
                                    lockJumps[k].scene.hotspotContainer().destroyHotspot(lockJumps[k].oldHots);
                                    //4.2 Establecemos el nuevo punto de tipo salto
                                    loadHotspot(lockJumps[k].scene, lockJumps[k].hotspot);
                                }
                            }

                            //5. Eliminar los saltos bloqueados del listado
                            for(var k=lockJumps.length-1; k>=0; k--){
                                if(scenesToUnlock[j]==lockJumps[k].idScene){
                                    lockJumps.splice( k, 1 );
                                }
                            }
                        }
                        
                    }

                    //Cambiar icono de la llave
                    $("#key"+id+" .keyClose").hide();
                    $("#key"+id+" .keyOpen").show();
                    $("#key"+id+" .labelKey").addClass("unlockKey");

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
                            var padlockHots = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                            //Almacenar informacion para el posterior desbloqueo
                            var j={'idScene':dest.destination, 'scene':scene, 'hotspot':hotspot, 'oldHots':padlockHots};
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