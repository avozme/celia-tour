@extends('layouts/backendScene')

@section('title', 'Agregar escena')

@section('content')
    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>

    <!-- CONTROLES INDIVIDUALES -->
    <input id="titleScene" type="text" value="{{$scene->name}}" class="col0 l2">
    <button id="setViewDefault" class="l2">Establecer vista</button>
    
    <!-- IMAGEN 360 -->
    <div id="pano" class="l1 col80"></div>
    
    <!-- HOTSPOTS -->
    <div id="contentHotSpot"></div>

    <!-- MENU DE GESTION LATERAL-->
    <div id="menuScenes" class="l2 width20 row100 right">
        <!-- AGREGAR -->
        <div >
            <button id="addHotspot">Nuevo Hotspot</button>
        </div>
        <!-- TIPO PARA AGREGAR -->
        <div id="typesHotspot" class="hidden">
            <br><span>Selecciona el tipo de hotspot<span><br>
            <button id="addTextButton" value="0">Texto</button>
            <button id="addJumpButton" value="1">Salto</button>
            <button id="addVideoButton" value="2">Video</button>
        </div>
        <!-- INSTRUCCIONES AGREGAR -->
        <div id="helpHotspotAdd" class="hidden">
            <br><span>Haz doble click para agregar el hotspot en la posicion deseada, más adelante podrá ser movido.<span>
        </div>
        <!-- EDITAR -->
        <div id="editHotspot" class="hidden">
            <label>EDITAR HOTSPOT</label>

            <div id="textHotspot" class="containerEditHotspot">    
                <input type="text"/>
                <textarea type="text"></textarea>
            </div>

            <div id="jumpHotspot" class="containerEditHotspot">
                <input id="jumpTitle" name="title" type="text"/>
                <textarea name="description" type="text"></textarea>
                <button id="selectDestinationSceneButton">Escena de destino</button>
                <input type="hidden" name="urljump" id="urljump" value="{{ url('img/icons/jump.png') }}">
            </div>
            
            <button class="buttonDelete">Eliminar</button>
            <button class="buttonMove">Mover</button>
        </div>
        <div id="helpHotspotMove" class="hidden">
            <br><span>Haz doble click en la posicion donde deseas mover el hotspot.<span>
            <button id="CancelMoveHotspot">Cancelar</button>
        </div>
    </div>

    </div>

    <!-- AGREGAR SCRIPTS -->
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>
    <script src="{{url('/js/hotspot/textInfo.js')}}"></script>
    <script src="{{url('/js/hotspot/jump.js')}}"></script>
    <script src="{{url('/js/hotspot/video.js')}}"></script>

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

        //Variable con todos los hotspot
        var hotspotCreated = new Array();
        
        /*
        * METODO QUE SE EJECUTA AL CARGARSE LA PÁGINA
        */
        $( document ).ready(function() {
            //Asignar metodos a botones
            $("#addTextButton").on("click", function(){ newHotspot($('#addTextButton').val()) });
            $("#addJumpButton").on("click", function(){ newHotspot($('#addJumpButton').val()) });
            $("#addVideoButton").on("click", function(){ newHotspot($('#addVideoButton').val()) });
            $("#addHotspot").on("click", function(){ showTypes() });
            $("#setViewDefault").on("click", function(){ setViewDefault() });

            //Obtener todos los hotspot relacionados con esta escena
            var data = "{{$scene->relatedHotspot}}";
            var hotspots =  JSON.parse(data.replace(/&quot;/g,'"'));

            //Recorrer todos los datos de los hotspot existentes y mostrarlos
            for(var i=0; i<hotspots.length;i++){
                loadHotspot(hotspots[i].id, hotspots[i].title, hotspots[i].description,
                            hotspots[i].pitch, hotspots[i].yaw, hotspots[i].type);
            }
        });

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA CAMBIAR LA POSICION DE VISTA QUE APARECE POR DEFECTO (Pitch/Yaw)
        */
        function setViewDefault(){
            //Obtener posiciones actuales
            var yaw = viewer.view().yaw();
            var pitch = viewer.view().pitch();

            //Solicitud para almacenar por ajax
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

        //-----------------------------------------------------------------------------------------

        /*
        * METODO INSTANCIAR EN PANTALLA UN HOTSPOT PASADO POR PARAMETRO
        */
        function loadHotspot(id, title, description, pitch, yaw, type){
            //Insertar el código en funcion del tipo de hotspot
            switch(type){
                case 0:
                    textInfo(id, title, description, pitch, yaw)
                    break;
                case 1:
                    jump(id, title, description, pitch, yaw);
                    break;
                case 2:
                    video(id, title, description, pitch, yaw);
                    break;
            }
            //Crear el hotspot
            var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch })
            //Almacenar en el array de hotspots
            hotspotCreated["hots"+id]=hotspot;
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA MOSTRAR LOS DIFERENTES TIPOS DE HOTSPOT QUE SE PUEDEN AGREGAR
        */
        function showTypes(){
            $("#addHotspot").hide();
            $("#typesHotspot").show();
            $("#helpHotspotAdd").hide();
            $("#helpHotspotMove").hide();
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA MOSTRAR EL MENU PRINCIPAL
        */
        function showMain(){
            $("#addHotspot").show();
            $("#typesHotspot").hide();
            $("#helpHotspotAdd").hide();
            $("#helpHotspotMove").hide();
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA AGREGAR EL HOTSPOT EN LA POSICION MARCADA CON UN DOBLE CLICK
        */
        function newHotspot(type){
            $("#pano").addClass("cursorAddHotspot"); //Cambiar el cursor a tipo cell
            $("#typesHotspot").hide();
            $("#helpHotspotAdd").show();

            //Detectar doble clic para agregar el hotspot
            $("#pano").on( "dblclick", function(e) {
                var view = viewer.view();
                var yaw = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).yaw;
                var pitch = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).pitch;

                //Guardar el hotspot en la base de datos
                saveHotspot("Nuevo punto","Sin descripción",pitch,yaw, parseInt(type));

                //Volver a desactivar las acciones de doble click
                $("#pano").off( "dblclick");
                //Quitar el cursor de tipo cell
                $("#pano").removeClass("cursorAddHotspot");
                //Mostrar el menu inicial
                showMain();
            });
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA ALAMCENAR UN HOTSPOT EN LA BASE DE DATOS
        */
        function saveHotspot(title, description, pitch, yaw, type){
            //Solicitud para almacenar por ajax
            var rute = "{{ route('hotspot.store') }}";
            $.ajax({
                url: rute,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "title":title,
                    "description":description,
                    "pitch":pitch,
                    "yaw":yaw,
                    "type":type,
                    "highlight_point":0,
                    "scene_id":"{{$scene->id}}",
                },
                success:function(result){                   
                    //Obtener el resultado de la accion
                    if(result['status']){                        
                        //Mostrar el hotspot en la vista
                        loadHotspot(result['id'], title, description,pitch, yaw, type);
                    }else{
                        alert("Error al crear el hotspot");
                    }
                },
                error:function() {
                    alert("Error al crear el hotspot");
                }
            });
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA ACTUALIZAR UN HOTSPOT EN LA BASE DE DATOS
        */
        function updateHotspot(id, title, description, pitch, yaw, type){
            //Solicitud para actualizar por ajax
            var rute = "{{ route('hotspot.update', 'req_id') }}".replace('req_id', id);
            return $.ajax({
                url: rute,
                type: 'patch',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "title":title,
                    "description":description,
                    "pitch":pitch,
                    "yaw":yaw,
                    "type":type,
                    "highlight_point":0,
                }
            });
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA ELIMINAR UN HOTSPOT EN LA BASE DE DATOS
        */
        function deleteHotspot(id){
            var rute = "{{ route('hotspot.destroy', 'req_id') }}".replace('req_id', id);
            return $.ajax({
                url: rute,
                type: 'delete',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA EDITAR POSICION DE UN HOTSPOT EN LA BASE DE DATOS
        */
        function moveHotspot(id, yaw, pitch){
            var rute = "{{ route('hotspot.updatePosition', 'req_id') }}".replace('req_id', id);
            //Guardar el hotspot en la base de datos
            return $.ajax({
                url: rute,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "yaw":yaw,
                    "pitch":pitch,
                }
            });   
        };

    </script>
@endsection

<!-- VENTANA MODAL PARA LA SELECCIÓN DE ESCENA DE DESTINO EN HOTSPOT DE TIPO SALTO -->
@section('modal')
<style>


#selectNextScene {
    border: 1px solid black;
    margin: 5% 0 0 11%;
    width: 60%;
    height: 80%;
}
</style>
    <div id="selectNextScene">
        
    </div>
@endsection