@extends('layouts.frontend')

@section('content')
    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/audio.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>

    <div id="menuFront" class="l2 col100 row100">
        {{-- TITULO --}}
        <div id="titleFront" class="col100">
        <div class="col100">
            <span>VISITAS GUIADAS</span><br>
            <div class="lineSub"></div>
        </div>
        </div>
        {{-- ELEMENTOS --}}
        <div id="contentVisits" class="col100">
            @foreach ($visits as $visit)
                <div id="{{$visit->id}}" class="visit">
                    <div class='elementInside visitInside col100 row100'>
                        <span class='l4 row100 width100 absolute titGuided'>{{$visit->name}}</span>
                        <span class="l4 desGuided row100 width100 absolute">{{$visit->description}}</span>
                    <img class='l3' src='{{url('img/resources/'.$visit->file_preview)}}'>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>

    <!-- PANEL LATERAL DE OPCIONES DEL MAPA-->
    <div id="leftPanel" class="col40 absolute l6" style="display: none">
        <div id="actionButton" class="col10">    
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
    </div>
    <!-- AUDIO -->
    <div id="controlVisit" class="l6 absolute" style="display: none">
        <div id="actionVisit" class="col10 centerVH">
            <svg id="play" class="col30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                <path d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)" fill="#000"/>
            </svg>
            <svg id="pause" class="col33" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display: none">
                <path d="M25.5,357h102V0h-102V357z M229.5,0v357h102V0H229.5z" fill="#000"/>
            </svg>
        </div>
        <div class="col65 centerVH">
            <progress class="col100" min="0" value="0"></progress>
        </div>
        <div  class="col25 centerVH">
            <svg id="previusScene" class="col20 sMarginRight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#000"/>
            </svg>  

            <svg id="nextScene" class="col20 mMarginRight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#000"/>
            </svg>  

            <svg class="col18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.333 341.333">
                <rect x="128" y="128" width="85.333" height="85.333"/><rect x="0" y="0" width="85.333" height="85.333"/><rect x="128" y="256" width="85.333" height="85.333"/>
                <rect x="0" y="128" width="85.333" height="85.333"/><rect x="0" y="256" width="85.333" height="85.333"/><rect x="256" y="0" width="85.333" height="85.333"/>
                <rect x="128" y="0" width="85.333" height="85.333"/><rect x="256" y="128" width="85.333" height="85.333"/><rect x="256" y="256" width="85.333" height="85.333"/>
            </svg>

        
        </div>
        <audio id="audioElement" src='{{url('uploads/test.mp3')}}' class="col70"></audio>
    </div>

    <!-- IMAGEN 360 -->
    <div id="pano" class="col100 l1"></div>
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
     <script src="{{url('/js/frontend/fullScreen.js')}}"></script>

    <script>
        
        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////   MARZIPANO   /////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
        var data = @json($scenes);
        var hotsRel = @json($hotspotsRel); //Relaciones entre los diferentes tipos y el hotspot
        'use strict';
        //1. VISOR DE IMAGENES
        var panoElement = document.getElementById('pano');
        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

        var scenes= new Array;
        //2. RECORRER TODAS LAS ESCENAS
        for(var i=0;i<data.length;i++){
            var source = Marzipano.ImageUrlSource.fromString(
                "{{url('/marzipano/tiles/dirName/{z}/{f}/{y}/{x}.jpg')}}".replace("dirName", data[i].directory_name),
            
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: "{{url('/marzipano/tiles/dirName/preview.jpg')}}".replace("dirName", data[i].directory_name), 
            cubeMapPreviewFaceOrder: 'lfrbud'});

            //3. GEOMETRIA 
            var geometry = new Marzipano.CubeGeometry([
            { tileSize: 256, size: 256, fallbackOnly: true  },
            { tileSize: 512, size: 512 },
            { tileSize: 512, size: 1024 },
            { tileSize: 512, size: 2048},
            ]);

            //4. CREAR VISOR (Con parametros de posicion, zoom, etc)
            //Limitadores de zoom min y max para vista vertical y horizontal
            var limiter = Marzipano.util.compose(
                Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
                Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
            );
            //Crear el objeto vista
            var dataView = {pitch: data[i].pitch, yaw: data[i].yaw, roll: 0, fov: Math.PI}
            var view = new Marzipano.RectilinearView(dataView, limiter);
            //5. CREAR LA ESCENA Y ALMACENARLA EN EL ARRAY 
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
         * METODO PARA CAMBIAR DE ESCENA
         */
        function changeScene(id){
            //Efectos de transicion
            var fun = transitionFunctions["opacity"];
            var ease = easing["easeFrom"];
            //Buscar el mapa correspondiente con el id en el array
            for(var i=0; i<scenes.length;i++){
                if(scenes[i].id == id){
                    //Cambiar las clases para mostrar la escena 360
                    $("#pano").removeClass("l1");
                    $("#pano").addClass("l5");
                    $("#pano").css("position", "absolute");
                    $("#leftPanel").show();
                    $("#controlVisit").show();
                    $("#menuFront").remove(); //Quitar menus
                    
                    
                    
                    //Cambiar
                    scenes[i].scene.switchTo({
                        transitionDuration: 000,
                        transitionUpdate: fun(ease)
                    });
                    

                    //Mostrar el mapa correspondiente
                    $(".map").removeClass("showMap");
                    $("#map"+scenes[i].zone).addClass("showMap");
                    //Marcar el punto activo
                    $(".pointMap").removeClass("activePoint");
                    $("#point"+id).addClass("activePoint");
                }
            }           
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
                    hotspots.push(allHots[i]); //Eliminar el hotspot si no esta asociado a la escena
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
                loadHotspot(h, hotspots[i]);
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
                    scenes[h].scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    break;     
            }
        };

        //----------------------------------------------------------------------------------

        $( document ).ready(function() {
            var scenesVisit = @json($visitsScenes);
            var scenesUse = new Array();

            $("#pano").css("position", "inherit");

            $(".visit").on("click", function(){
                var idVisit = parseInt($(this).attr("id"));
                getScenesUse(idVisit);
            });
            
             


            /*
            * METODO PARA OBTENER LAS ESCENAS RELACIONADAS CON UNA VISITA GUIADA
            * PASADA POR PARAMETRO
            */
            function getScenesUse(id){
                //Obtener las escenas necesarias para la visita
                for(var i=0; i<scenesVisit.length;i++){
                    if(scenesVisit[i].id_guided_visit == id){
                        scenesUse.push(scenesVisit[i]);
                    }
                }
                //Cargar primera escena
                changeScene(scenesUse[0].id_scenes);

                //AUDIO
                var player = document.querySelector("audio");
                var progressBar = document.querySelector("progress");
                progressBar.setAttribute("max", player.duration);
                player.play();
                $("#pause").show();
                $("#play").hide();
                
                //Cambiar tiempo audio
                progressBar.addEventListener("click", seek);
                function seek(e) {
                    var percent = e.offsetX / this.offsetWidth;
                    player.currentTime = percent * player.duration;
                    progressBar.value = percent * player.duration;
                }
                //Actualizar barra con el audio
                player.addEventListener("timeupdate", updateBar);
                function updateBar() {
                    progressBar.value = player.currentTime;
                }
            }
            //onended

            /*
            * METODO PARA PARAR Y REANUDAR LA REPRODUCCION DE AUDIO
            */
            $("#actionVisit").on("click", function(){
                if( $("#pause").css('display') == 'none' ){
                    $("#pause").show();
                    $("#play").hide();
                    document.querySelector("audio").play();
                }else{
                    $("#pause").hide();
                    $("#play").show();
                    document.querySelector("audio").pause();
                }
            });
        });
    </script>
    
@endsection