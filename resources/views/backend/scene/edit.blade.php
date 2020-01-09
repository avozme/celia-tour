@extends('layouts/backendScene')

@section('title', 'Agregar escena')

@section('content')
    <!-- CONTROLES INDIVIDUALES -->
    <input id="titleScene" type="text" value="{{$scene->name}}" class="col0 l2">
    <button id="setViewDefault" onclick="setViewDefault()" class="l2">Establecer vista</button>
    
    <!-- IMAGEN 360 -->
    <div id="pano" class="l1 col80"></div>
    <div id="contentHotSpot"></div>

    <!-- MENU DE GESTION-->
    <div id="menuScenes" class="l2 width20 row100 right">
        <button id="addScene" onclick="showTypes()">Nuevo Hotspot</button>
        <div id="typesHotspot" class="hidden">
            <br><span>Selecciona el tipo de hotspot<span><br>
            <button onclick="addHotspot()">Texto</button>
        </div>
        <div id="helpHotspot" class="hidden">
            <br><span>Haz doble click para agregar el hotspot en la posicion deseada, más adelante podrá ser movido.<span>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>
    <script>
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
        console.log("{{$scene->directory_name}}");  
        var source = Marzipano.ImageUrlSource.fromString(
        "{{url('/marzipano/tiles/'.$scene->directory_name.'/{z}/{f}/{y}/{x}.jpg')}}",
        
        //Establecer imagen de previsualizacion para optimizar su carga 
        //(bdflru para establecer el orden de la capas de la imagen de preview)
        {cubeMapPreviewUrl: "{{url('/marzipano/tiles/'.$scene->directory_name.'/preview.jpg')}}"}, 
        {cubeMapPreviewFaceOrder: 'bdflru'},);

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
        var view = new Marzipano.RectilinearView({yaw: "{{$scene->yaw}}", pitch: "{{$scene->pitch}}", roll: 0, fov: Math.PI}, limiter);

        //5. ESCENA SOBRE EL VISOR
        var scene = viewer.createScene({
        source: source,
        geometry: geometry,
        view: view,
        pinFirstLevel: true
        });

        //6.MOSTAR
        scene.switchTo({ transitionDuration: 1000 });


        ///////////////////////////////////////////////////////////////////////////
        ////////////////////////////   JQUERY   ///////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////

        $( document ).ready(function() {
            loadHotspot(0,0,0,0,0,0);
            loadHotspot(1,0,0,1,2,0);
        });


        /*
        * METODO PARA CAMBIAR LA POSICION DE VISTA QUE APARECE POR DEFECTO (Pitch/Yaw)
        */
        function setViewDefault(){
            //Obtener posiciones actuales
            var yaw = viewer.view().yaw();
            var pitch = viewer.view().pitch();
            console.log("enviado");
            //Solicitud para almacenar por aja
            var rute = "{{ route('scene.setViewDefault', 'req_id') }}".replace('req_id', "{{$scene->id}}");
            $.ajax({
                url: rute,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "pitch":pitch,
                    "yaw":yaw,
                },
                success:function(result){                   
                    //Obtener el resultado de la accion
                    if(result['status']){                        
                        alert("La posicion inicial de la camara ha sido editada");
                    }else{
                        alert("Error al editar");
                    }
                }
            });
        };

        //----------------------------------------------------------------

        /*
        * METODO INSTANCIAR EN PANTALLA UN HOTSPOT PASADO POR PARAMETRO
        */
        function loadHotspot(id, name, description, pitch, yaw, type){
            //Insertar el código en funcion del tipo de hotspot
            switch(type){
                case 0:
                    //Codigo HTML del hotspot
                    $("#contentHotSpot").append(
                        "<div id='textInfo' class='hots"+id+"''>"+
                            "<div class='hotspot'>"+
                                "<div class='out'></div>"+
                                "<div class='in'></div>"+
                            "</div>"+
                            "<div class='tooltip-content'>"+
                                "<strong>"+name+"</strong></br>"+
                                "<span>"+description+"</span>"+
                            "</div>"+
                        "</div>"+

                        "<link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>"
                    );             
                    break;

                case 1:
                    break;
                case 2:
                    break;
            }

            //Crear el hotspot
            scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch });
        };

        //-------------------------------------------------------------

        /*
        * METODO PARA MOSTRAR LOS DIFERENTES TIPOS DE HOTSPOT QUE SE PUEDEN AGREGAR
        */
        function showTypes(){
            $("#addScene").hide();
            $("#typesHotspot").show();
        };

        //-------------------------------------------------------------

        /*
        * METODO PARA OCULTAR LOS DIFERENTES TIPOS DE HOTSPOT QUE SE PUEDEN AGREGAR
        */
        function hideTypes(){
            $("#addScene").show();
            $("#typesHotspot").hide();
            $("#helpHotspot").hide();
        };

        //-------------------------------------------------------------

        /*
        * METODO PARA AGREGAR EL HOTSPOT EN LA POSICION MARCADA CON UN DOBLE CLICK
        */
        function addHotspot(){
            $("#pano").addClass("cursorAddHotspot"); //Cambiar el cursor a tipo cell
            $("#typesHotspot").hide();
            $("#helpHotspot").show();

            //Detectar doble clic para agregar el hotspot
            $("#pano").on( "dblclick", function(e) {
                var view = viewer.view();
                var yaw = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).yaw;
                var pitch = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).pitch;

                loadHotspot(Math.floor((Math.random() * 100000) + 1),"Nuevo punto","Sin descripción",pitch,yaw,0);

                console.log(yaw+" | "+pitch);
                //Volver a desactivar las acciones de doble click
                $("#pano").off( "dblclick");
                //Quitar el cursor de tipo cell
                $("#pano").removeClass("cursorAddHotspot");
                //Mostrar el menu inicial
                hideTypes();
            });
        };

        //--------------------------------------------------------------------


        
        
    </script>
@endsection