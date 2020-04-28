@extends('layouts/backendScene')

@section('title', 'Agregar escena')

@section('content')
<link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/audio.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/portkey.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/imageGallery.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/hide.css')}}'>
    <link rel="stylesheet" href="{{url('css/backendScene.css')}}" />

    <!-- MENSAJE DE VISTA ESTABLECIDA CON ÉXITO -->
    <div id="viewEstablecida" class="col100" >
        <span>VISTA ESTABLECIDA CON ÉXITO</span>
    </div>

    <!-- CONTROLES INDIVIDUALES -->
    <input id="titleScene" type="text" value="{{$scene->name}}" class="col0 l2">
    <input type="hidden" name="actualScene" id="actualScene" value="{{ $scene->id }}">
    
    <!-- IMAGEN 360 -->
    <div class="col75 l1 row100 absolute">
        <div id="pano" class="l1 col100"></div>
    </div>
    
    <!-- HOTSPOTS -->
    <div id="contentHotSpot"></div>

    <!-- CAPA PARA DIBUJAR LOS HOTSPOTS HIDE -->
    <div id="drawHide" class="col75 l1 row100 absolute" style="display: none">
        <!-- HIDE PREVIO ESPERANDO ACCIONES -->
        <div id="preHide" style="position: absolute"></div>
        <input type="hidden" id="hideType">
    </div>

    <!-- MENU DE GESTION LATERAL-->
    <div id="menuScenes" class="l2 width25 row100 right">
        <!-- AGREGAR -->
        <div id="addHotspot" class="col100">
            <div id="addClue" class="col100 row30 addHide">
                <div class="col100 pointer" style="margin-top: 60%" >
                    <div class="col100 centerH">
                        <button type="button" class="right round col45">
                                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                                </svg>
                        </button>
                    </div>
                    <div class="col100 centerH mMarginTop">
                        <strong>NUEVA PISTA</strong>
                    </div>
                </div>
            </div>
            <div id="addQuestion" class="col100 row50 addHide">
                <div class="col100 pointer" style="padding-top: 33%" >
                    <div class="col100 centerH">
                        <button type="button" class="right round col45 addHide">
                                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                                </svg>
                        </button>
                    </div>
                    <div class="col100 centerH mMarginTop">
                        <strong>NUEVA PREGUNTA</strong>
                    </div>
                </div>
            </div>
            <div id="returnZone" class="col100 absolute" style="padding: 0 45px 15px 0">
                <a id="urlReturnZone" href="">
                    <button class="col100 second">Volver al menú</button>
                </a>
            </div>
        </div>
        
        <!-- INSTRUCCIONES AGREGAR -->
        <div id="helpHotspotAdd" class="hidden">
            <div class="col100 centerVH lPadding">
                <div class="col100">
                    <strong class="col100 centerT">Haz doble click sobre la posicion donde se desea colocar el hotspot.</strong>
                    <button  class="col100 lMarginTop" id="CancelNewHotspot">Cancelar</button>
                </div>
            </div>
        </div>
        <!-- EDITAR -->
        <div id="editHotspot" class="hidden col100 row100">
            <span class="title col100">EDITAR HOTSPOT</span>
            {{-- TEXTO --}}
            <div id="textHotspot" class="containerEditHotspot">    
                <label class="col100">Título</label>
                <input type="text" class="col100 mMarginBottom"/>
                <label class="col100">Descripción</label>
                <textarea type="text" class="col100 mMarginBottom">Lo que sea</textarea>
            </div>

            <div class="ActionEditButtons col100">
                <button class="buttonMove bBlack width100 right sMarginBottom">Mover</button>
                <button class="buttonDelete delete width100 lMarginBottom">Eliminar</button>    
                <button class="buttonClose width100 lMarginBottom">Cerrar</button>    
            </div>
        </div>

        <!-- MOVER -->
        <div id="helpHotspotMove" class="hidden col100">
            <div class="col100 centerVH lPadding">
                <div class="col100">
                    <strong class="col100 centerT">Haz doble click sobre la posicion donde se desea mover el hotspot.</strong>
                    <button  class="col100 lMarginTop" id="CancelMoveHotspot">Cancelar</button>
                </div>
            </div>
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
    <script src="{{url('/js/hotspot/imageGallery.js')}}"></script>
    <script src="{{url('/js/hotspot/portkey.js')}}"></script>
    <script src="{{url('/js/hotspot/hide.js')}}"></script>
    <script src="{{url('js/zone/zonemap.js')}}"></script>

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
        //Url para volver a la edicion de zonas
        var returnUrl = "{{ route('escaperoom.index') }}";

        //Variable con todos los hotspot
        var hotspotCreated = new Array();
        //VARIABLES DISPONIBLES PARA SCRIPTS EXTERNOS DE HOTSPOTS
        var token = "{{ csrf_token() }}";
        var routeGetVideos = "{{ route('resource.getvideos') }}";
        var indexUrl = "{{ url('img/resources/') }}";
        var routeGetAudios = "{{ route('resource.getaudios') }}";
        var routeUpdateIdType = "{{ route('hotspot.updateIdType', 'req_id') }}";
        /* RUTA PARA SACAR ESCENA DE DESTINO ACTUAL DE UN JUMP */
        var sceneDestinationRoute = "{{ route('jump.destid', 'req_id') }}";
        /* RUTA PARA SACAR LAS IMÁGENES DE UNA GALERÍA */
        var getImagesGalleryRoute = "{{ route('gallery.resources', 'id') }}";
        /* RUTA PARA SACAR EL ID DEL JUMP A TRAVÉS DEL ID DEL HOTSPOT */
        var getIdJumpRoute = "{{ route('htypes.getIdJump', 'hotspotid') }}";
        /* RUTA PARA SACAR EL ID DE LA GALERÍA A TRAVÉS DEL ID DEL HOTSPOT */
        var getIdGalleryRoute = "{{ route('htypes.getIdGallery', 'hotspotid') }}";
        /* RUTA PARA SACAR EL ID DEL TIPO DE HOTSPOT */
        var getIdTypeRoute = "{{ route('htypes.getIdType', 'id') }}";
        /* URL PARA LAS IMÁGENES DE LA GALERÍA */
        var urlImagesGallery = "{{ url('img/resources/image') }}";
        /* URL DE LA IMAGEN DEL HOTSPOT GALERIA */
        var galleryImageHotspot = "{{ url('img/icons/gallery.png') }}";
        /* URL DE LA CARPETA DE ICONOS */
        var iconsRoute = "{{ url('img/icons/') }}";
        /* URL PARA OBTENER LAS ESCENAS ASOCIADAS A UN PORTKEY */
        var getScenesPortkey = "{{ route('portkey.getScenes', 'id') }}";
        //URL PARA LA IMAGEN DEL PUNTO ACTUAL
        var actualScenePointUrl = "{{ url('img/zones/icon-zone-hover.png') }}";
        //URL PARA LA IMAGEN DE UN PUNTO
        var ScenePointUrl = "{{ url('img/zones/icon-zone.png') }}";
        // URL PARA LAS IMAGENES DE PORTKEYS
        var urlImagesPortkey = "{{ url('img/portkeys') }}";
        // URL PARA OBTENER LOS DATOS DE UN PORTKEY A TRAVES DEL ID DE SU HOTSPOT
        var getPortkeyFromHotspot = "{{ route('portkey.portkeyFromHotspot', 'insertIdHere') }}";

        //Detectar si es una escena primaria o secundaria
        var typeScene = "{{ strpos(url()->current(), '/scene')!==false ? 'p' : 's' }}";

        /*
        * METODO QUE SE EJECUTA AL CARGARSE LA PÁGINA
        */
        $( document ).ready(function() {
            //Asignar url boton volver
            $("#urlReturnZone").attr("href", returnUrl);
            //Asignar metodos a botones
            $("#addClue").on("click", function(){
                $('#hideType').val(0);
                newHotspot(6)
            });
            $("#addQuestion").on("click", function(){
                $('#hideType').val(1);
                newHotspot(6)
            });
            $("#CancelNewHotspot").on("click", function(){showMain()});
            $("#setViewDefaultDestinationScene").on("click", function(){ setViewDefaultForJump($('#selectDestinationSceneButton').attr('value')) });
            
            
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
            for(var i=0; i<hotspots.length; i++){
                loadHotspot(hotspots[i].id, hotspots[i].title, hotspots[i].description,
                            hotspots[i].pitch, hotspots[i].yaw, hotspots[i].type);
            }
        });

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
            
            // Booleano que permite saber si es portkey, ya que si es portkey si añade de forma distinta
            var notPortkey = true;
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
                case 4:
                    imageGallery(id);
                    break;
                case 5:
                    // Se pone a falso para no añadir el hotspot al final de la funcion
                    notPortkey = false;
                    var address = getPortkeyFromHotspot.replace('insertIdHere', id);
                    // Añade los portkey de Ascensor o de tipo Mapa segun este configurado en opciones
                    $.get(address, function(data){
                        
                        if(data.id == "-1") { // Si es -1 se añade el hotspot ya que aun no se asigno el contenido
                            portkey(id);
                            var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch })
                            hotspotCreated["hots"+id]=hotspot;
                        } else {
                            // Se comprueba si se esta utilizando trasladores de tipo mapa o ascensor
                            if(typePortkey == "Mapa"){ 
                                // Si tiene imagen significa que es de tipo mapa
                                if(data.image != null){  
                                    portkey(id);
                                    var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch })
                                    hotspotCreated["hots"+id]=hotspot;
                                }
                            } else {
                                // Si no tiene imagen significa que es de tipo ascensor
                                if(data.image == null){
                                    portkey(id);
                                    var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch })
                                    hotspotCreated["hots"+id]=hotspot;
                                }
                            }
                        }
                    });
                    break;
                case 6:
                    loadHide(id);
                    //Crear el hotspot
                    var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch },
                    { perspective: { radius: 1640, extraTransforms: "rotateX(5deg)" }})
                    //Almacenar en el array de hotspots
                    hotspotCreated["hots"+id]=hotspot;
                    break;
            }
            // Si no es portkey se crea el hotspot
            if(notPortkey && type != 6){
                //Crear el hotspot
                var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+id), { "yaw": yaw, "pitch": pitch })
                //Almacenar en el array de hotspots
                hotspotCreated["hots"+id]=hotspot;
            }
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
            $("#editHotspot").hide();
            $("#pano").off("dblclick");
            $("#pano").removeClass("cursorAddHotspot");
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA ALAMCENAR UN HOTSPOT EN LA BASE DE DATOS
        */
        function saveHotspot(title, description, pitch, yaw, type){
            //Solicitud para almacenar por ajax
            var route = "{{ route('hotspot.store') }}";
            //Actuar segun si es una edicion de escena primaria o secundaria
            var fields={
                    _token: "{{ csrf_token() }}",
                    title:title,
                    description:description,
                    pitch:pitch,
                    yaw:yaw,
                    highlight_point: 0,
                    type:type,
                    id_secondary_scene:null,
                    scene_id:"{{$scene->id}}",
                };

            if(typeScene=="p"){
                fields.scene_id="{{$scene->id}}";
            }else{
                fields.id_secondary_scene="{{$scene->id}}";
            }

            $.ajax({
                url: route,
                type: 'POST',
                data: fields,
                success:function(result){
                    //Obtener el resultado de la accion
                    if(result['status']){                        
                        //Mostrar el hotspot en la vista
                        newHide(result['id'], pitch, yaw);
                    }else{
                        alert("Error al crear el hotspot");
                    }
                },
                error:function() {
                    alert("Error AJAX al crear el hotspot");
                }
            });
        };

        //-----------------------------------------------------------------------------------------

        /*
        * METODO PARA AGREGAR EL HOTSPOT EN LA POSICION MARCADA CON UN DOBLE CLICK
        */
        function newHotspot(type){
            $("#pano").addClass("cursorAddHotspot"); //Cambiar el cursor a tipo cell
            $("#addHotspot").hide();
            $("#helpHotspotAdd").show();

            //Detectar doble clic para agregar el hotspot
            $("#pano").on( "dblclick", function(e) {
                var view = viewer.view();
                var yaw = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).yaw;
                var pitch = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).pitch;
                //Saco coordenadas de posicionamiento de la capa
                var mousex = e.clientX;
                var mousey = e.clientY;
                var mousexx = 0;
                var mouseyy = 0;
                $('#preHide').css('top', mousey + "px");
                $('#preHide').css('left', mousex + "px");
                $('#preHide').css('border', '1.5px solid #8500FF');
                $('#drawHide').css('display', 'block');
                $('#drawHide').mousemove(function(event){
                    mousexx = event.clientX;
                    mouseyy = event.clientY;
                    var alto = (mouseyy - mousey);
                    var ancho = (mousexx - mousex);
                    document.getElementById('preHide').style.width = ancho + "px";
                    document.getElementById('preHide').style.height = alto + "px";
                });
                $('#drawHide').click(function(ev){
                    $('#drawHide').css('display', 'none');
                    var pitch = view.screenToCoordinates({x: (((mousexx - mousex) / 2) + mousex), y: (((mouseyy - mousey) / 2) + mousey),}).pitch;
                    var yaw = view.screenToCoordinates({x: (((mousexx - mousex) / 2) + mousex), y: (((mouseyy - mousey) / 2) + mousey),}).yaw;
                    saveHotspot('Hide', 'Descripción', pitch, yaw, 6);
                    //Volver a desactivar las acciones de doble click
                    $("#pano").off( "dblclick");
                    //Quitar el cursor de tipo cell
                    $("#pano").removeClass("cursorAddHotspot");
                    //Mostrar el menu inicial
                    showMain();
                    $('#drawHide').off('click');
                });
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

        /*
        * FUNCIÓN PARA AÑADIR UN REGISTRO EN LA TABLA JUMPS CUANDO SE CREA UN HOTSPOT DE ESTE TIPO
        */
        function newHide(hotspotId, pitch, yaw){
            var width = document.getElementById('preHide').style.width;
            var height = document.getElementById('preHide').style.height;
            var type = $('#hideType').val();
            var route = "{{ route('hide.store') }}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "width": width.substr(0, width.length - 2),
                    "height": height.substr(0, height.length - 2),
                    "type": type,
                },
                success:function(result){                   
                    if(result['status']){
                        updateIdTable(hotspotId, result['hideId'], pitch, yaw);
                    }else {
                        alert('Algo falló al guardar el hide');
                    }
                },
                error:function(resul) {
                    alert("Error al crear el hide");
                }
            });
        }

        

        /* FUNCIÓN PARA AÑADIR HOTSPOT Y JUMP EN LA TABLA INTERMEDIA */
        function updateIdTable(hotspotId, jumpId, pitch, yaw){
            var route = "{{ route('hotspot.updateIdType' , 'id') }}".replace('id', hotspotId);
            $.ajax({
                url: route,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'newId': jumpId,
                },
                success:function(result){                   
                    if(result['status']){
                        loadHotspot(hotspotId, null, null, pitch, yaw, 6);
                    }else {
                        alert('Algo falló al guardar el jump');
                    }
                },
                error:function() {
                    alert("Error al crear el jump");
                }
            });
        }

        /*FUNCIONES PARA ELEGIR ESCENA DE DESTINO DEL SALTO Y PITCH Y YAW DE LA VISTA DE ESTA*/
        function getSceneDestination(sceneDestinationId){
            var route = "{{ route('scene.show', 'id') }}".replace('id', sceneDestinationId);
            return $.ajax({
                url: route,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        }
        var viewerDestinationScene = null;
        function loadSceneDestination(sceneDestination, pitch, yaw){
            viewerDestinationScene = null;
            'use strict';
            //1. VISOR DE IMAGENES
            var padre = document.getElementById('destinationSceneView');
            var panoElement = padre.firstElementChild;
            /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
            a mayor, para conseguir una carga mas fluida. */
            viewerDestinationScene =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

            //2. RECURSO
            var source = Marzipano.ImageUrlSource.fromString(
            "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}".replace('dn', sceneDestination.directory_name),
            
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: "{{url('/marzipano/tiles/dn/preview.jpg')}}".replace('dn', sceneDestination.directory_name), 
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
            var view = null;
            if(pitch == null && yaw == null){
                view = new Marzipano.RectilinearView({yaw: sceneDestination.yaw, pitch: sceneDestination.pitch, roll: 0, fov: Math.PI}, limiter);
            }else{
                view = new Marzipano.RectilinearView({yaw: yaw, pitch: pitch, roll: 0, fov: Math.PI}, limiter);
            }

            //5. ESCENA SOBRE EL VISOR
            var scene = viewerDestinationScene.createScene({
            source: source,
            geometry: geometry,
            view: view,
            pinFirstLevel: true
            });

            //6.MOSTAR
            scene.switchTo({ transitionDuration: 1000 });
        }

        //------------------------------------------------------------------------------------------

        /*
        * FUNCIÓN PARA AÑADIR LA ESCENA DE DESTINO DEL JUMP
        */
        function saveDestinationScene(idJump, idScene){
            var route = "{{ route('jump.editDestinationScene', 'id') }}".replace('id', idJump);
            $.ajax({
                url: route,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'sceneDestinationId': idScene,
                },
                success:function(result){                   
                    if(result['status']){
                        //alert('Escena de destino guardada con éxtio');
                        $('#msgJumpSceneAsigned').slideDown(700).delay(1400).slideUp(700);
                    }else {
                        alert('Algo falló al guardar la escena de destino');
                    }
                },
                error:function() {
                    alert("Error en la petición AJAX");
                }
            });
        }
        //------------------------------------------------------------------------------------------

/*********************************** GALERIAS/PORTKEY ******************************************/
        function updateIdType(hotspot, idType){
            var route = "{{ route('htypes.updateIdType') }}";
            return $.ajax({
                url: route,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "hotspot": hotspot,
                    "id_type": idType,
                },
                success:function(result){
                    if(result['status']){
                        //alert("Asignado correctamente");
                    }else{
                        alert('Ha fallado ed_type');
                    }
                },
                error:function(){
                    alert("Error ajax al actualizar id_type");
                }
            });
        }

        /* ACTUALIZAR HOTSPOT DE TIPO SALTO. CAMBIAR CAMPO HIGHLIGHT_POINT */
        function updateJumpHotspotHlPoint(hotspotId){
            var route = "{{ route('hotspot.updateHlPoint', 'req_id') }}".replace('req_id', hotspotId);
            var hlPoint = 0;
            if($('#principal').is(":checked"))
                hlPoint = 1;

            return $.ajax({
                url: route,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "hlPoint": hlPoint,
                },
                success:function(result){
                    if(result['status']){
                        //alert("hlpoint bien");
                    }else{
                        alert('Ha fallado hlpoint');
                    }
                },
                error:function(){
                    alert("Error ajax al actualizar hlpoint");
                }
            });
        }

        function getHotspotInfo(idHotspot){
            var route = "{{ route('hotspot.show', 'req_id') }}".replace('req_id', idHotspot);
            return $.ajax({
                url: route,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        }

        function getHideInfo(idHotspot){
            var route = "{{ route('hide.getHide', 'req_id')}}".replace('req_id', idHotspot);
            return $.ajax({
                url: route,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        }

    </script>
    <style>
        .addScene {
            margin: 4% 0 0 16%;
            width: 57%;
        }

        #setViewDefaultDestinationScene {
            display: none;
        }
        
        #destinationSceneView {
            display: none;
        }

        .reveal-content {
            position: relative;
        }

        .reveal-content > img {
            position: relative;
        }
    </style>
    
@endsection
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
        
        {{----------------------------------------------------------------------------}}

        <div class="window" style="display: none" id="deleteHotspotWindow">
            <span class="titleModal col100">Eliminar Hotspot</span>
            <button id="closeModalWindowButton" class="closeModal" >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                    <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                </svg>
            </button>
            <span class="deleteText col100 xlMarginTop">¿Esta seguro que desea eliminar este hotspot?</span>
            <div class="col100">
                <!-- Botones de control -->
                <div class="col50 mPaddingRight xlMarginTop">
                    <button id="btnModalOk" type="button" value="Eliminar" class="col100">Aceptar</button>
                </div>
                <div class="col50 mPaddingLeft xlMarginTop">
                    <button id="btnNo" type="button" class="col100 bBlack">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#closeModalWindowButton, #btnNo').click(function(){
            $('#modalWindow').css('display', 'none');
            $('#showAllImages').css('display', 'none');
            $('#deleteHotspotWindow').css('display', 'none');
            $('#galleryResources').empty();
        });
    </script>
@endsection
    
