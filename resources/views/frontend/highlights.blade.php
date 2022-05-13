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


@section('content')
    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/audio.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/imageGallery.css')}}'>

    <div id="menuFront" class="l2 col100 row100">
        {{-- TITULO --}}
        <div id="titleFront" class="col100">
        <div class="col100">
            <span>PUNTOS DESTACADOS</span><br>
            <div class="lineSub"></div>
        </div>
        </div>
        {{-- ELEMENTOS --}}
        <div id="tableHigh" class="col100">
            <div id="row1"></div>
            <div id="row2"></div>
            <div id="row3"></div>
        </div>
    </div>

    <!-- PANEL SUPERIO CON TITULO DE LA ESCENA -->
    <div id="titlePanel" class="absolute l6" style="display: none">
        <span></span><br>
        <div class="lineSub"></div>
    </div>

    <!-- PANEL LATERAL DE OPCIONES DEL MAPA-->
    <div id="leftPanel" class="col40 absolute l6" style="display: none">
        <div id="actionButton" class="col10">    
             <!-- BOTON DESTACADOS -->
             <div id="buttonHighIcon">
                <svg id="Bold" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <title>Menú puntos destacados ⭐</title>
                    <path d="m5.574 15.362-1.267 7.767c-.101.617.558 1.08 1.103.777l6.59-3.642 6.59 3.643c.54.3 1.205-.154 1.103-.777l-1.267-7.767 5.36-5.494c.425-.435.181-1.173-.423-1.265l-7.378-1.127-3.307-7.044c-.247-.526-1.11-.526-1.357 0l-3.306 7.043-7.378 1.127c-.606.093-.848.83-.423 1.265z" fill="white"/>
                </svg>            
            </div>

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
    <script src="{{url('/js/frontend/portkey.js')}}"></script>
    <script src="{{url('/js/frontend/fullScreen.js')}}"></script>
    <script src="{{url('/js/frontend/imageGallery.js')}}"></script>
    <script src="{{url('/js/frontend/model3d.js')}}"></script>

    <script>
        var indexUrl = "{{ url('img/resources/') }}";
        var token = "{{ csrf_token() }}";

        var subt = @json($subtitle);
        var indexSubt = "{{url('img/resources/subtitles')}}";
        
        /* RUTA PARA SACAR EL ID DE LA GALERÍA A TRAVÉS DEL ID DEL HOTSPOT */
        var getIdGalleryRoute = "{{ route('htypes.getIdGallery', 'hotspotid') }}";
        /* RUTA MODELOS 3D */
        var routeGetNameModel3D = "{{ route('model3d.getname', 'req_id') }}";
        var routeModel3D = "{{ route('model3d.view', 'name') }}";
        /* RUTA PARA SACAR LAS IMÁGENES DE UNA GALERÍA */
        var getImagesGalleryRoute = "{{ route('gallery.resources', 'id') }}";
        /* URL PARA LAS IMÁGENES DE LA GALERÍA */
        var urlImagesGallery = "{{ url('img/resources/image') }}";
        
        /************* MENU DE PUNTOS DESTACADOS *************/
        //Creacion de filas y columnas en funcion del numero de elementos

        var ruta ="{{url('img/resources')}}"
        var element="<div id='idHigh' class='highlight col'>"+
                    "<div class='elementInside col100 row100'>"+
                        "<span class='l4'>Sala profesorado</span>"+
                        "<img class='l3' src=''>"+
                    "</div>"+
                "</div>";
        var high= @JSON($highlights);
        var highCounts= high.length;

        var increment=1;
        var rowCount = parseInt(highCounts/3); //Media de elementos por fila
        var rest = highCounts - rowCount; //Elementos restantes tras la media

        if(rest==0){
            count = rowCount; //TODAS LAS FILAS CON EL MISMO NUMERO DE ELEMENTOS
        }else{
            count = parseInt(rest/2); //NUMERO ELEMENTOS FILA 1
        }
        
        //Añadir los diferentes funtos
        for(var i =0 ; i<3; i++){
            //Añadir elementos por fila
            for(var j=0; j<count; j++){
                $("#row"+(i+1)).append(element.replace("idHigh", increment));
                $("#"+increment).css("width", 100/count+"%");
                $("#"+increment+" span").text(high[increment-1].title);
                $("#"+increment+" img").attr("src", ruta+"/"+high[increment-1].scene_file);
                
                $("#"+increment+" .elementInside").on("click", function(){
                    var id = parseInt($(this).parent().attr("id")-1);
                    changeScene(high[id].id_scene, high[id].pitch, high[id].yaw, false);
                });
                //Comprobar si solo hay 1 o 2 puntos
                if(highCounts==1){
                    $("#"+increment).css("height", "100%");
                }else if(highCounts==2){
                    $("#"+increment).css("height", "50%");
                }
                increment++;
            }
            //Cambiar num elemetos de la fila
            if(i==0 && rest!=0){
                //FILA 2
                count=rowCount; 
            }else if(i==1 && rest!=0){
                //FILA 3
                if(rest%2==0){
                    count = parseInt(rest/2);
                }else{
                    count = (parseInt(rest/2)+1);
                }
            }
        }

        //----------------------------------------------------------------------------------

        $( document ).ready(function() {
            //Estado inicial
            $("#pano").css("position", "inherit");

            /*
            * METODO PARA MOSTRAR EL MENU DE PUNTOS DESTACADOS AL PULSAR SOBRE EL ICONO
            */
            $("#buttonHighIcon").on("click", function(){
                $("#pano").css("position", "inherit");
                $("#pano").addClass("l1");
                $("#pano").removeClass("l5");
                $("#leftPanel").hide();
                $("#titlePanel").hide();
            });

            //----------------------------------------------------------------------

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
        * METODO PARA INSTANCIAR EN PANTALLA UN HOTSPOT PASADO POR PARAMETRO
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
                    if(hotspot.highlight_point==0){
                        //Obtener los datos del salto como id de destino y posicion de vista
                        var getRoute = "{{ route('jump.getdestination', 'req_id') }}".replace('req_id', hotspot.idType);
                        
                        $.get(getRoute, function(dest){
                            jump(hotspot.id, dest.destination, dest.pitch, dest.yaw);
                            //Crear el hotspot al obtener la informacion
                            scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                        });
                    }
                    
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
        function changeScene(id, pitch, yaw, tunnel){
            //Efectos de transicion
            var fun = transitionFunctions["opacity"];
            var ease = easing["easeFrom"];
            //Buscar el mapa correspondiente con el id en el array
            for(var i=0; i<scenes.length;i++){
                if(scenes[i].id == id){
                    
                    //Cambiar
                    scenes[i].scene.switchTo({
                        transitionDuration: 000,
                        transitionUpdate: fun(ease)
                    });

                    scenes[i].scene.view().setYaw(yaw);
                    scenes[i].scene.view().setPitch(pitch);
  
                    //Establecer el titulo de la escena
                    for(i =0; i<data.length;i++){
                        if(data[i].id==id){
                            $("#titlePanel span").text(data[i].name);
                        }
                    } 

                    //Cambiar las clases para mostrar la escena 360
                    $("#pano").removeClass("l1");
                    $("#pano").addClass("l5");
                    $("#pano").css("position", "absolute");
                    $("#leftPanel").show();
                    $("#titlePanel").show();

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