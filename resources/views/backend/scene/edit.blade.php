@extends('layouts/backendScene')

@section('title', 'Agregar escena')

@section('content')
    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/audio.css')}}'>

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
            <span class="col100 lMargin">Selecciona el tipo de hotspot</span>
            <button id="addTextButton" class="col100 sMarginBottom" value="0">Texto</button>
            <button id="addJumpButton" class="col100 sMarginBottom" value="1">Salto</button>
            <button id="addVideoButton" class="col100 sMarginBottom" value="2">Video</button>
            <button id="addAudioButton" class="col100 sMarginBottom" value="3">Audio</button>
        </div>
        <!-- INSTRUCCIONES AGREGAR -->
        <div id="helpHotspotAdd" class="hidden">
            <span>Haz doble click para agregar el hotspot en la posicion deseada, más adelante podrá ser movido.</span>
        </div>
        <!-- EDITAR -->
        <div id="editHotspot" class="hidden col100 row100">
            <span class="title col100">EDITAR HOTSPOT</span>

            <div id="textHotspot" class="containerEditHotspot">    
                <label class="col100">Título</label>
                <input type="text" class="col100 mMarginBottom"/>
                <label class="col100">Descripción</label>
                <textarea type="text" class="col100 mMarginBottom"></textarea>
            </div>

            <div id="jumpHotspot" class="containerEditHotspot">
                <input id="jumpTitle" name="title" type="text"/>
                <textarea name="description" type="text"></textarea>
                <button id="selectDestinationSceneButton">Escena de destino</button>
                <input type="hidden" name="urljump" id="urljump" value="{{ url('img/icons/jump.png') }}">
            </div>
            
            <div id="videoHotSpot" class="containerEditHotspot">
                <div class="load col100">
                        <svg version="1.1" id="loadIcon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 214.367 214.367" style="enable-background:new 0 0 214.367 214.367;" xml:space="preserve">
                        <path d="M202.403,95.22c0,46.312-33.237,85.002-77.109,93.484v25.663l-69.76-40l69.76-40v23.494
                       c27.176-7.87,47.109-32.964,47.109-62.642c0-35.962-29.258-65.22-65.22-65.22s-65.22,29.258-65.22,65.22
                       c0,9.686,2.068,19.001,6.148,27.688l-27.154,12.754c-5.968-12.707-8.994-26.313-8.994-40.441C11.964,42.716,54.68,0,107.184,0
                       S202.403,42.716,202.403,95.22z"/>
                   </svg>                   
                </div>
                <div class="content" style="display:none">

                </div>
            </div>

            <div id="videoHotSpot" class="containerEditHotspot">
                <div class="load col100">
                        <svg version="1.1" id="loadIcon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 214.367 214.367" style="enable-background:new 0 0 214.367 214.367;" xml:space="preserve">
                        <path d="M202.403,95.22c0,46.312-33.237,85.002-77.109,93.484v25.663l-69.76-40l69.76-40v23.494
                        c27.176-7.87,47.109-32.964,47.109-62.642c0-35.962-29.258-65.22-65.22-65.22s-65.22,29.258-65.22,65.22
                        c0,9.686,2.068,19.001,6.148,27.688l-27.154,12.754c-5.968-12.707-8.994-26.313-8.994-40.441C11.964,42.716,54.68,0,107.184,0
                        S202.403,42.716,202.403,95.22z"/>
                    </svg>                   
                </div>
                <div class="content" style="display:none">

                </div>
            </div>

            <div class="ActionEditButtons col100">
                <button class="buttonMove width100 right sMarginBottom">Mover</button>
                <button class="buttonDelete second width100 lMarginBottom">Eliminar</button>    
            </div>
        </div>

        <!-- MOVER -->
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
    <script src="{{url('/js/hotspot/audio.js')}}"></script>

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
        {cubeMapPreviewUrl: "{{url('/marzipano/tiles/'.$scene->directory_name.'/preview.jpg')}}", 
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
        //VARIABLES DISPONIBLES PARA SCRIPTS EXTERNOS DE HOTSPOTS
        var token = "{{ csrf_token() }}";
        var routeGetVideos = "{{ route('resource.getvideos') }}";
        var routeUpdateIdType = "{{ route('hotspot.updateIdType', 'req_id') }}"

        /*
        * METODO QUE SE EJECUTA AL CARGARSE LA PÁGINA
        */
        $( document ).ready(function() {
            //Asignar metodos a botones
            $("#addTextButton").on("click", function(){ newHotspot($('#addTextButton').val()) });
            $("#addJumpButton").on("click", function(){ newHotspot($('#addJumpButton').val()) });
            $("#addVideoButton").on("click", function(){ newHotspot($('#addVideoButton').val()) });
            $("#addAudioButton").on("click", function(){ newHotspot($('#addAudioButton').val()) });
            $("#addHotspot").on("click", function(){ showTypes() });
            $("#setViewDefault").on("click", function(){ setViewDefault() });

            //Obtener todos los hotspot relacionados con esta escena
            var data = "{{$scene->relatedHotspot}}";
            var hotspots =  JSON.parse(data.replace(/&quot;/g,'"')); //Convertir a objeto de javascript

            //Acceder a la tabla intermedia entre los diferentes recursos para obtener el tipo de hotspot
            @foreach($scene->relatedHotspot as $hots)
                var type = parseInt("{{$hots->isType->type}}"); //Acceso a tabla intermedia
                //Buscar el objeto a traves del ID
                for(var i=0; i<hotspots.length; i++){
                    if(hotspots[i].id=="{{$hots->id}}"){
                        hotspots[i].type = type;
                    }
                }                
            @endforeach

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
            var route = "{{ route('scene.setViewDefault', 'req_id') }}".replace('req_id', "{{$scene->id}}");
            $.ajax({
                url: route,
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

            //Obtener el id del recurso con el que esta relacionado el hotspot
            var idType= -1;
            @foreach($scene->relatedHotspot as $hots)
                if("{{$hots->id}}"==id){
                    idType = "{{$hots->isType->id_type}}";
                }
            @endforeach

            //Insertar el código en funcion del tipo de hotspot
            switch(type){
                case 0:
                    textInfo(id, title, description, pitch, yaw)
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
            var route = "{{ route('hotspot.store') }}";
            $.ajax({
                url: route,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "title":title,
                    "description":description,
                    "pitch":pitch,
                    "yaw":yaw,
                    "highlight_point":0,
                    "type":type,
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
            var route = "{{ route('hotspot.update', 'req_id') }}".replace('req_id', id);
            return $.ajax({
                url: route,
                type: 'patch',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "title":title,
                    "description":description,
                    "pitch":pitch,
                    "yaw":yaw,
                    "highlight_point":0,
                }
            });
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA ELIMINAR UN HOTSPOT EN LA BASE DE DATOS
        */
        function deleteHotspot(id){
            var route = "{{ route('hotspot.destroy', 'req_id') }}".replace('req_id', id);
            return $.ajax({
                url: route,
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
            var route = "{{ route('hotspot.updatePosition', 'req_id') }}".replace('req_id', id);
            //Guardar el hotspot en la base de datos
            return $.ajax({
                url: route,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "yaw":yaw,
                    "pitch":pitch,
                }
            });   
        };

    </script>
    {{--
        /*
        * FUNCIÓN PARA ELEGIR ESCENA DE DESTINO
        */
        function allScenes(){
            var rute = "{{ route('scene.get') }}";
            return $.ajax({
                url: rute,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });   
        };
    --}}
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