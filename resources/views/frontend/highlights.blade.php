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
             <div id="buttonHigh">
                <svg id="Bold" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5.574 15.362-1.267 7.767c-.101.617.558 1.08 1.103.777l6.59-3.642 6.59 3.643c.54.3 1.205-.154 1.103-.777l-1.267-7.767 5.36-5.494c.425-.435.181-1.173-.423-1.265l-7.378-1.127-3.307-7.044c-.247-.526-1.11-.526-1.357 0l-3.306 7.043-7.378 1.127c-.606.093-.848.83-.423 1.265z" fill="white"/>
                </svg>            
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
                console.log(count);
                $("#"+increment).css("width", 100/count+"%");
                $("#"+increment+" span").text(high[increment-1].title);
                $("#"+increment+" img").attr("src", ruta+"/"+high[increment-1].scene_file);
                
                $("#"+increment+" .elementInside").on("click", function(){
                    var id = parseInt($(this).parent().attr("id")-1);
                    changeScene(high[id].id_scene);
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
            $("#buttonHigh").on("click", function(){
                $("#pano").css("position", "inherit");
                $("#pano").addClass("l1");
                $("#pano").removeClass("l5");
                $("#leftPanel").hide();
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
                loadHotspot(h, hotspots[i]);
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
                    scenes[h].scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    break;     
                case 1:/*
                    //Obtener los datos del salto como id de destino y posicion de vista
                    var getRoute = "{{ route('jump.getdestination', 'req_id') }}".replace('req_id', hotspot.idType);
                    var scene = scenes[h].scene;
                    $.get(getRoute, function(dest){
                        jump(hotspot.id, dest.destination, dest.pitch, dest.yaw);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });*/
                    break;
                case 2:
                    //Obtener la URL del recurso asociado a traves de ajax
                    var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', hotspot.idType);
                    var scene = scenes[h].scene;
                    $.get(getRoute, function(src){
                        video(hotspot.id, src);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });
                    break;
                case 3:
                    //Obtener la URL del recurso asociado a traves de ajax
                    var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', hotspot.idType);
                    var scene = scenes[h].scene;
                    $.get(getRoute, function(src){
                        audio(hotspot.id, src);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });
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
                    $("#leftPanel").show();
                    $("#titlePanel").show();
                    
                    //Cambiar
                    scenes[i].scene.switchTo({
                        transitionDuration: 000,
                        transitionUpdate: fun(ease)
                    });

                    
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