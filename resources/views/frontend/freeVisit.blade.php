@extends('layouts.frontend')

@section('content')

    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>

        <button id="test" class="absolute col100 l2"> hola </button>
    
    
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

    <script>        
        var data = @json($data);
        var hotsRel = @json($hotspotsRel); //Relaciones entre los diferentes tipos y el hotspot

        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////   MARZIPANO   /////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
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
            scenes.push(scene);
        }
        
        //6.MOSTAR
        scenes[0].switchTo({transitionDuration: 0});

        //CAMBIAR ESCENA CON TRANSICION
        function changeScene(scene){
            var fun = transitionFunctions["fromWhite"];
            var ease = easing["easeFrom"];

            scenes[scene].switchTo({
                transitionDuration: 300,
                transitionUpdate: fun(ease)
            });
        }
        var count=0;
        $("#test").on("click", function(){
            $("#pano").addClass("panoTunnel");
                     
            $("#pano").on('animationend', function(e) {
                $("#pano").removeClass("panoTunnel");
                changeScene(++count);
            });
        });

        //FALTA RECUPERAR TODAS LAS ESCENAS CON UN FOR Y ASIGNAR LOS HOTSPOT AUTOMATICAMENTE A CADA UNA
        //Obtener todos los hotspot relacionados con esta escena
        var jsonHots = "{{$data[0]->relatedHotspot}}".replace("0", count);
        var hotspots = JSON.parse(jsonHots.replace(/&quot;/g,'"')); //Convertir a objeto de javascript
        
        console.log(hotsRel);
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
            loadHotspot(hotspots[i].id, hotspots[i].title, hotspots[i].description,
                        hotspots[i].pitch, hotspots[i].yaw, hotspots[i].type);
        }
    

        //-----------------------------------------------------------------------------------------

        /*
        * METODO INSTANCIAR EN PANTALLA UN HOTSPOT PASADO POR PARAMETRO
        */
        function loadHotspot(id, title, description, pitch, yaw, type, idType){

            //Insertar el código en funcion del tipo de hotspot
            switch(type){
                case 0:
                    textInfo(id, title, description)
                    break;
                case 1:
                    jump(id, title, description, pitch, yaw);
                    break;
                case 2:
                    video(id, idType);
                    break;
                case 3:
                    audio(id, idType);
                    break;
            }
            //Crear el hotspot
            scenes[count].hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch })
        };
      
    </script>
@endsection