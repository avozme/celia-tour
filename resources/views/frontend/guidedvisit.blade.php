@extends('layouts.frontend')

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
    <link rel='stylesheet' href='{{url('css/hotspot/imageGallery.css')}}'>


    <div id="menuFront" class="l2 col100 row100" style="display: none">
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

    <!-- VENTANA EMERGENTE DE VISITA -->
    <div id="emergent" class="width100 row100 absolute l7 centerVH" style="display: none">
            <div id="startVisit" class="width50 width-mv-90 width-tb-70">
                <span id="startVisitTitle" class="col100">COMENZAR LA VISITA GUIADA</span><br>
                <div class="col100 list">
                    <div class="col100 listElement centerV">
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 384 384'>
                            <path d='M288,192c0-37.653-21.76-70.187-53.333-85.867v171.84C266.24,262.187,288,229.653,288,192z'/>
                                <polygon points='0,128 0,256 85.333,256 192,362.667 192,21.333 85.333,128'/>
                            <path d='M234.667,4.907V48.96C296.32,67.307,341.333,124.373,341.333,192S296.32,316.693,234.667,335.04v44.053C320.107,359.68,384,283.413,384,192S320.107,24.32,234.667,4.907z'/></g>
                        </svg>
                        <div class="textList">Revise y/o ponga en funcionamiento su sistema de audio.</div>
                    </div>
                    
                    <div class="col100 listElement centerV">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                            <path id="flecha" d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#000"/>
                        </svg>                                                                                
                        <div class="textList">Cuando termine la descripción de una estancia, pasaremos automáticamente a la siguiente.</div>
                    </div>
    
                    <div class="col100 listElement centerV">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.333 341.333">
                            <rect x="128" y="128" width="85.333" height="85.333"/>
                            <rect x="0" y="0" width="85.333" height="85.333"/>
                            <rect x="128" y="256" width="85.333" height="85.333"/>
                            <rect x="0" y="128" width="85.333" height="85.333"/>
                            <rect x="0" y="256" width="85.333" height="85.333"/>
                            <rect x="256" y="0" width="85.333" height="85.333"/>
                            <rect x="128" y="0" width="85.333" height="85.333"/>
                            <rect x="256" y="128" width="85.333" height="85.333"/>
                            <rect x="256" y="256" width="85.333" height="85.333"/>
                        </svg>
                        <div class="textList">En cualquier momento es posible trasladarse a la estancia deseada mediante los botones de siguiente y anterior. El boton de menu le permite seleccionar la estancia.</div>
                    </div>
    
                    <div class="col100 listElement centerV">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" >
                            <path d="M25.5,357h102V0h-102V357z M229.5,0v357h102V0H229.5z"/>
                        </svg>
                        <div class="textList">Si desea permanecer en una estancia indefinidamente, detenga el audio.</div>
                    </div>
                </div>
                <div class="col100 centerH xlMarginTop mMarginBottom">
                    <button id="bStartVisit">Comenzar</button>
                </div>
            </div>
        </div>

    <!-- PANEL SUPERIO CON TITULO DE LA ESCENA -->
    <div id="titlePanel" class="absolute l6" style="display: none">
        <span></span><br>
        <div class="lineSub"></div>
    </div>

    <!-- PANEL LATERAL DE OPCIONES -->
    <div id="leftPanel" class="col40 absolute l6" style="display: none">
        <div id="actionButton" class="col10">    
            {{-- BOTON VOLVER A INICIO --}}
            <div id="buttonReturn">
                <a href="{{url('')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510">
                        <title>Volver al inicio 🏠</title>
                        <polygon points="204,471.75 204,318.75 306,318.75 306,471.75 433.5,471.75 433.5,267.75 510,267.75 255,38.25 0,267.75 76.5,267.75 76.5,471.75"/>
                    </svg>
                </a>
            </div>
            <!-- BOTON PANTALLA COMPLETA -->
            <div id="buttonFullScreen">
                    {{--Abrir pantalla completa--}}
                    <svg id="openFull" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357">
                        <title>Pantalla completa</title>
                        <path d="M51,229.5H0V357h127.5v-51H51V229.5z M0,127.5h51V51h76.5V0H0V127.5z M306,306h-76.5v51H357V229.5h-51V306z M229.5,0v51
                            H306v76.5h51V0H229.5z"/>
                    </svg>
                    {{--Cerrar pantalla completa--}}
                    <svg id="exitFull" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display:none">
                        <title>Salir de pantalla completa</title>
                        <path d="M0,280.5h76.5V357h51V229.5H0V280.5z M76.5,76.5H0v51h127.5V0h-51V76.5z M229.5,357h51v-76.5H357v-51H229.5V357z
                            M280.5,76.5V0h-51v127.5H357v-51H280.5z"/>
                    </svg>
            </div>
        </div>
    </div>
    
    <!-- PANEL LATERAL LISTADO ESCENAS-->
    <div id="scenesPanel" class="col20 absolute l6 row100 scenesPanelHide" style="display: none">
        
        <span id="titleScenesPanel" class="relative col100">
            Visita guiada
        </span>
        <div id="contentScenesPanel" class="relative width100">
           
        </div>
    </div>

    <!-- AUDIO -->
    <div id="controlVisit" class="l6 absolute" style="display: none">
        {{-- PLAY / PAUSE --}}
        <div id="actionVisit" class="col10 centerVH">
            <svg id="play" class="col30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                <path d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)" fill="#000"/>
            </svg>
            <svg id="pause" class="col33" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display: none">
                <path d="M25.5,357h102V0h-102V357z M229.5,0v357h102V0H229.5z" fill="#000"/>
            </svg>
        </div>
        {{-- BARRA --}}
        <div class="col60 centerVH">
            <progress class="col100" min="0" value="0"></progress>
        </div>
        {{-- BOTONES --}}
        <div  class="col30 centerVH">
            <svg width="20px" id="previusScene" class="smMarginLeft sMarginRight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                <title>Escena anterior</title>
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#000"/>
            </svg>  

            <svg width="20px" id="nextScene" class=" sMarginRight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                <title>Escena siguiente</title>
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#000"/>
            </svg>  

            <svg id="subtitleButton" width="20px" style="display:none" class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 426.667 426.667">
                <title>Subtitulos</title>
                <path d="M384,0H42.667C19.093,0,0.213,19.093,0.213,42.667L0,426.667l85.333-85.333H384c23.573,0,42.667-19.093,42.667-42.667
                    v-256C426.667,19.093,407.573,0,384,0z M149.333,192h-42.667v-42.667h42.667V192z M234.667,192H192v-42.667h42.667V192z M320,192
                    h-42.667v-42.667H320V192z"/>
            </svg>

            <svg width="20px" id="bShowScenes" class="smMarginLeft smMarginRight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.333 341.333">
                <title>Menú de escenas</title>
                <rect x="128" y="128" width="85.333" height="85.333"/><rect x="0" y="0" width="85.333" height="85.333"/><rect x="128" y="256" width="85.333" height="85.333"/>
                <rect x="0" y="128" width="85.333" height="85.333"/><rect x="0" y="256" width="85.333" height="85.333"/><rect x="256" y="0" width="85.333" height="85.333"/>
                <rect x="128" y="0" width="85.333" height="85.333"/><rect x="256" y="128" width="85.333" height="85.333"/><rect x="256" y="256" width="85.333" height="85.333"/>
            </svg>

        
        </div>
        <audio id="audioElement" preload="metadata" class="col70"></audio>
    </div>

    <div id="listSubt" class="listSubt col10 l6 absolute" style="display:none">
        
    </div>

    <div id="subtText" class="subtText l6 absolute"> 

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
     <script src="{{url('/js/frontend/imageGallery.js')}}"></script>
     <script src="{{url('/js/frontend/model3d.js')}}"></script>

    <script>
        /* RUTA PARA SACAR EL ID DE LA GALERÍA A TRAVÉS DEL ID DEL HOTSPOT */
        var getIdGalleryRoute = "{{ route('htypes.getIdGallery', 'hotspotid') }}";
        /* RUTA PARA SACAR LAS IMÁGENES DE UNA GALERÍA */
        var getImagesGalleryRoute = "{{ route('gallery.resources', 'id') }}";
        /* RUTA MODELOS 3D */
        var routeGetNameModel3D = "{{ route('model3d.getname', 'req_id') }}";
        var routeModel3D = "{{ route('model3d.view', 'name') }}";
        /* URL PARA LAS IMÁGENES DE LA GALERÍA */
        var urlImagesGallery = "{{ url('img/resources/image') }}";
        /* URL PARA LOS RECURSOS */
        var urlResources = "{{ url('img/resources/') }}";
        var token = "{{ csrf_token() }}";

        var subt = @json($subtitle);
        var indexSubt = "{{url('img/resources/subtitles')}}";


        $( document ).ready(function() {            
            var indexUrl = "{{ url('img/resources/') }}";
            var url = "{{url('')}}";
            var scenesVisit = @json($visitsScenes);
            var scenesUse = new Array();
            var currentScene = 0;
            var firstCharge = true;
            var allVisits = @json($visits);

            //EVENTOS
            $("#pano").css("position", "inherit");
            if(allVisits.length<=1){
                //Abrir directamente
                $("#emergent").show();
                getScenesUse(allVisits[0].id);
            }else{
                $("#menuFront").show();
                //Funcionalidad al pulsar una de las visitas del sistema
                $(".visit").on("click", function(){
                    $("#emergent").show();
                    var idVisit = parseInt($(this).attr("id"));
                    getScenesUse(idVisit);
                });
            }

            $("#nextScene").on("click", function(){ nextScene(); });
            $("#previusScene").on("click", function(){ previusScene(); });
            
            //Funcionalidad boton mostrar escenas
            $("#bShowScenes").on("click", function(){
                if($("#scenesPanel").hasClass("scenesPanelHide")){
                    $("#scenesPanel").removeClass("scenesPanelHide");
                }else{
                    $("#scenesPanel").addClass("scenesPanelHide");
                }
            });

            //Funcionalidad del boton de comenzar la visita
            $("#bStartVisit").on("click", function(){
                $("#emergent").hide();
                //Mostrar elementos de control
                $("#leftPanel").show();
                $("#scenesPanel").show();
                $("#controlVisit").show();
                $("#titlePanel").show();
                //Reproducir el audio inicial
                firstCharge=false;
                document.querySelector("audio").play();
            });

            //Actuar al finalizar la reproduccion del audio
            $("audio").on("ended", function(){
                nextScene();
            });
            
            //--------------------------------------------------------------------------

            /*
            * METODO PARA OBTENER LAS ESCENAS RELACIONADAS CON UNA VISITA GUIADA
            * PASADA POR PARAMETRO
            */
            function getScenesUse(id){
                //Obtener las escenas necesarias para la visita
                for(var i=0; i<scenesVisit.length;i++){
                    if(scenesVisit[i].id_guided_visit == id){
                        scenesUse.push(scenesVisit[i]);
                        //Obtener el nombre y directorio de la escena relacionada
                        var name="";
                        var dir="";
                        for(var j=0; j<data.length;j++){
                            if(data[j].id == scenesVisit[i].id_scenes){
                                name=data[j].name;
                                dir=data[j].directory_name;
                            }
                        }
                        //Crear elementos por cada uno de las escenas de la visita
                        addElementScene(scenesUse.length-1, name, url+"/marzipano/tiles/"+dir+"/1/b/0/0.jpg");
                    }
                }
                //Cargar primera escena
                setScene(0);
                audioControl(); 
            }

            //--------------------------------------------------------------------------

            /*
            * METODO PARA CONTROLAR EL AUDIO CON LOS CONTROLES PERSONALIZADOS
            */
            function audioControl(){
                var player = document.querySelector("audio");
                var progressBar = document.querySelector("progress");

                //Cambiar tiempo audio con la barra
                progressBar.addEventListener("click", seek);
                function seek(e) {
                    var percent = e.offsetX / this.offsetWidth;
                    player.currentTime = percent * player.duration;
                    progressBar.value = percent * player.duration;
                }
                //Actualizar barra de audio
                player.addEventListener("timeupdate", updateBar);
                function updateBar() {
                    progressBar.value = player.currentTime;
                }
                //Pausar y reanudar audio
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
            }

            //-------------------------------------------------------------------

            /*
            * METODO PARA CARGAR LA SIGUIENTE ESCENA DE LA VISITA
            */
            function nextScene(){
                //Comprobar que no sea la ultima
                if(currentScene<scenesUse.length-1){
                    currentScene++;
                    setScene(currentScene);
                }
            }

            //-------------------------------------------------------------------

            /*
            * METODO PARA CARGAR LA SIGUIENTE ESCENA DE LA VISITA
            */
            function previusScene(){    
                //Comprobar que no sea la ultima
                if(currentScene>0){
                    currentScene--;
                    setScene(currentScene);
                }
            }

            //------------------------------------------------------------------

            /*
            * METODOS PARA ESTABLECER UNA ESCENA
            */
            function setScene(id){
                currentScene=id;
                changeScene(scenesUse[id].id_scenes);
                //Establecer audio de la escena
                setAudio(scenesUse[id].id_resources);
                //Seleccionar escena activa
                $(".sceneElement span").show();
                $(".sceneElement svg").hide();
                $(".sceneElement").removeClass("selected");
                $(".backElementScene").removeAttr("style");
                $("#sElem"+id+" svg").css("display", "block");
                $("#sElem"+id+" span").css("display", "none");
                $("#sElem"+id).addClass("selected");
                $("#sElem"+id+" .backElementScene").attr("style", "background-color: transparent");
                
            }

            //------------------------------------------------------------------

            /*
            * METODO PARA CAMBIAR LA PISTA DE AUDIO
            */
            function setAudio(id, autoplay){
                var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', id);
                //Recuperar ruta de audio con ajax
                $.ajax({
                    url: getRoute,
                    method: "get",
                    success: function(src) {
                        $("audio").attr("src", urlResources+"/"+src);
                        var audio =  document.querySelector("audio");
                        audio.currentTime = 0;

                        audio.onloadedmetadata = function() {
                            $("progress").attr("max", audio.duration);
                            if(!firstCharge){
                                document.querySelector("audio").play();
                            }
                            $("#pause").show();
                            $("#play").hide();
                        };

                        //Cargar subtitulos
                        loadSubt(id);
                    }
                });
            }

            //------------------------------------------------------------------

            /*
            * METODO PARA AGREGAR LOS ELEMENTOS CORRESPONDIENTES AL LISTADO DE ESCENAS
            */
            function addElementScene(num, title, img){
                var element =   "<div id='sElem"+num+"' class='sceneElement relative'>"+
                                    "<div class='sceneElementInside' style='background-image: url("+img+");'>"+
                                        "<div class='backElementScene'>"+
                                            "<span class='titScene'><span class='num'>"+(num+1)+"</span><br>"+title+"</span>"+
                                            "<svg id='activeScene' class='col20' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 15.429 18' style='display:none'>"+
                                                "<path d='M35.353,0,50.782,9,35.353,18Z' transform='translate(-35.353)' fill='#fff'/>"+
                                            "</svg>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                $("#contentScenesPanel").append(element);
                
                //Acciones al hacer click sobre el
                $("#sElem"+num).on("click", function(){
                    setScene(num);
                });
            }

            //--------------------------------------------------------------------

            //Boton opcion subtitulos
            $("#subtitleButton").on("click", function(){
                if($("#listSubt").is(":visible")){
                    $("#listSubt").hide();
                }else{
                    $("#listSubt").show();
                }
            });
            
            //--------------------------------------------------------------------

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
            .mouseup(function() {
                clickDown=false;
                if(drag){
                    //Desvanecer puntos al dejar de arrastrar
                    $(".hotspotElement").addClass("hotsLowOpacity");
                    drag=false;
                }
            });

            //Detectar eventos en pantallas tactiles
            $("#pano").on('touchmove vmousemove', function(event){
                $(".hotspotElement").removeClass("hotsLowOpacity");
			});
			
			$("#pano").on('touchend vmouseup', function(){
                $(".hotspotElement").addClass("hotsLowOpacity");
			});
        });


        //----------------------------------------------------------------------

        /**
         * METODO PARA CARGAR LOS SUBTITULOS DE UNA PISTA DE AUDIO
         */
         function loadSubt(idResource){
            $(document).ready(function() {
                //Vaciar la lista de subtitulos y los track
                $('#listSubt').html("");
                $("#audioElement").html("");

                if(subt.hasOwnProperty(idResource)){
                    
                    $("#subtitleButton").show();
                    $('#listSubt').append(`<div id="subtTitle" class="col100 sPaddingTop centerT"><strong>Subtitulos</strong></div>`);
                    //Recorrer el array para insertar los subtitulos
                    for(var i =0; i<subt[idResource].length; i++){
                        //Agregar track al elemento de audio
                        var track =`<track kind="subtitles" src="`+indexSubt+"/"+subt[idResource][i]+`" srclang="`+subt[idResource][i]+`" />`;
                        $("#audioElement").append(track);

                        //Agregar elemento al listado de subtitulos visual
                        var name = subt[idResource][i].split(".");
                        $('#listSubt').append(
                            `<div id="`+subt[idResource][i]+`" class="subtOption pointer col100">
                                <svg fill="white" width="10px" style="display:none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 342.357 342.357">
                                    <polygon points="290.04,33.286 118.861,204.427 52.32,137.907 0,190.226 118.862,309.071 342.357,85.606 "/>
                                </svg>
                                `+name[name.length-2]+`
                            </div>`
                        );
            
                    }
                    //Agregar opcion de desactivar
                    $("#listSubt").append(
                        `<div id="subtDis" class="col100 pointer">Desactivar</div>`
                    );


                    ////////////////

                    //Accion al pulsar sobre un subtitulo
                    $(".subtOption").on("click", function(){
                        var audioElement = document.getElementById('audioElement');
                        document.getElementById('subtText').innerText=""; //Limpiar contenido
                        //Marcar la opcion seleccionada
                        $(".subtOption").removeClass("activeSubtOption");
                        $(".subtOption svg").hide();
                        $(this).addClass("activeSubtOption");
                        $(this).children().show();
                        
                        //Recorrer todas las pistas de audio
                        for (var i = 0; i < audioElement.textTracks.length; i++) {
                            //Por defecto desactivar el subtitulo y su evento
                            audioElement.textTracks[i].mode = 'disabled';
                            audioElement.textTracks[i].removeEventListener('cuechange', this, false);

                            //Si coincide con el subtitulo pulsado se activará
                            if($(this).attr("id")==audioElement.textTracks[i].language){
                                //Activar el subtitulo
                                audioElement.textTracks[i].mode = 'showing';
                                //Mostrar contenido
                                audioElement.textTracks[i].addEventListener('cuechange', function() {
                                    if(this.activeCues[0]!=null){
                                        document.getElementById('subtText').innerText = this.activeCues[0].text;
                                    }else{
                                        document.getElementById('subtText').innerText="";
                                    }
                                });
                            }
                        }  
                        //Ocultar panel de subtitulos
                        setTimeout(function(){
                            $("#listSubt").hide();
                        }, 500); 
                    });

                    ////////////////

                    //Accion al pulsar sobre desactivar subtitulos
                    $("#subtDis").on("click", function(){
                        var audioElement = document.getElementById('audioElement');
                        $(".subtOption").removeClass("activeSubtOption");
                        $(".subtOption svg").hide();

                        for (var i = 0; i < audioElement.textTracks.length; i++) {
                            //Desactivar el subtitulo y su evento
                            audioElement.textTracks[i].mode = 'disabled';
                            audioElement.textTracks[i].removeEventListener('cuechange', this, false);
                        }  
                        document.getElementById('subtText').innerText="";

                        //Ocultar panel de subtitulos
                        setTimeout(function(){
                            $("#listSubt").hide();
                        }, 500); 
                    });
                }else{
                    $("#subtitleButton").hide();
                }
            });
        }

        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////   MARZIPANO   /////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
        var data = @json($scenes);
        var hotsRel = @json($hotspotsRel); //Relaciones entre los diferentes tipos y el hotspot
        'use strict';
        //1. VISOR DE IMAGENES
        var panoElement = document.getElementById('pano');
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 
        
        var scenes= new Array;
        //2. RECORRER TODAS LAS ESCENAS
        for(var i=0;i<data.length;i++){
            var source = Marzipano.ImageUrlSource.fromString(
                "{{url('/marzipano/tiles/dirName/{z}/{f}/{y}/{x}.jpg')}}".replace("dirName", data[i].directory_name),
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
                case 4:
                    imageGallery(hotspot.id);
                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    break;
                case 8:
                    model3D(hotspot.idType);
                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.idType), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    break;
            }
        };

        //----------------------------------------------------------------------------------
        
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
                    $("#menuFront").remove(); //Quitar menus

                    //Cambiar
                    scenes[i].scene.switchTo({
                        transitionDuration: 700,
                        transitionUpdate: fun(ease)
                    });

                    //AUTOROTACION
                    var autorotate = Marzipano.autorotate({
                        yawSpeed: 0.03,         // Yaw rotation speed
                        targetPitch: 0,        // Pitch value to converge to
                        targetFov: Math.PI/2   // Fov value to converge to
                    });
                    // Movimiento infinito
                    viewer.setIdleMovement(Infinity);
                    // Empezar rotacion
                    viewer.startMovement(autorotate); 

                    //Establecer el titulo de la escena
                    for(i =0; i<data.length;i++){
                        if(data[i].id==id){
                            $("#titlePanel span").text(data[i].name);
                        }
                    } 
                }
            }
        }
    </script>
    
@endsection