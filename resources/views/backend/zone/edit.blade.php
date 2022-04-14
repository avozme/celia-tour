@extends('layouts.backend')

@section('headExtension')
<link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
<script src="{{url('js/closeModals/close.js')}}"></script>
<script src="{{url('js/zone/zoneEdit.js')}}"></script>
@endsection

{{--------------------------------- VENTANA MODAL ----------------------------------}}
@section('modal')
<!--Vista modal para añadir nuevas escenas secundarias-->
<div class="window" id="Sscene">
    <span class="titleModal col100">Añadir escena secundaria</span>
    <button class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="addVideoContent col100 xlMarginTop">
        <form id="añadirSceneS" class="col100" method="post" enctype="multipart/form-data" action="{{ route('sscenes.store') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <label for="name" class="col100 sMarginTop">Nombre</label>
            <input type="text" name="name" id="newSecondarySceneName" class="col100" required><br><br>
            <label for="name" class="col100 sMarginTop">Fecha</label>
            <input type="date" name="date" id="newSecondarySceneDate" class="col100" required><br><br>
            <label for="updateSceneImg" class="col100 sMarginTop">Imagen</label>
            <input type="file" name="image360" id="newSecondarySceneImg" class="col100" required><br><br>
            <div id="errorMessageNewSecondaryScene" class="col100 errormsg">
                <span></span>
            </div>
            <input type="hidden" name="idScene" id="idScene">
            <input type="hidden" name="idZone" id="idZone" value="{{$zone->id ?? ''}}">
            <input type="submit" value="Guardar" class="col100 lMarginTop" id="addSScene">
        </form>
    </div>
</div>

<!--Vista modal para EDITAR escenas secundarias-->
<div class="window" id="upSscene">
    <span class="titleModal col100">Modificar escena secundaria</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="addVideoContent col100 xlMarginTop">
        <form id="updateSceneS" class="col100" method="post" enctype="multipart/form-data" action="{{ route('sscenes.update') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <label for="name" class="col100">Nombre</label>
            <input type="text" name="name" id="upSceneName" class="col100" required><br><br>
            <label for="name" class="col100 sMarginTop">Fecha</label>
            <input type="date" name="date" id="upSceneDate" class="col100" required><br><br>
            <label for="updateSceneImg" class="col100 sMarginTop">Imagen</label>
            <input type="file" name="image360" id="updateSecondarySceneImg" class="col100" required><br><br>
            <div id="errorMessageUpdateSecondaryScene" class="col100 errormsg">
                <span></span>
            </div>
            <input type="hidden" name="id" id="ids">
            <input type="hidden" name="idZone" id="idZone" value="{{$zone->id ?? ''}}">
            <input type="submit" value="Guardar" class="col100 lMarginTop" id="addSScene">
        </form>
    </div>
</div>

<!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
<div class="window" id="confirmDelete">
    <span class="titleModal col100">¿Eliminar escena?</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="confirmDeleteScene col100 xlMarginTop">
        <button id="aceptDelete" class="deleteButton">Aceptar</button>
        <button id="cancelDelete">Cancelar</button>
    </div>
</div>

<!-- MODAL DE INFORMACIÓN AL INTENTAR BORRAR UNA ESCENA QUE TIENE HOTSPOTS -->
<div class="window" id="cancelDeleteHotspots">
    <span class="titleModal col100">No se puede eliminar la escena seleccionada</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="contentCancelDeleteScene col100 xlMarginTop">
        <p>Esta escena no puede eliminarse porque contiene hotspots.</p>
        <p>Por favor, elimine los hotspots antes de eliminar la escena.</p>
        <p>Gracias.</p>
    </div>
    <div class="col100 centerH mMarginTop">
        <button id="aceptCondition" class="col50">Aceptar</button>
    </div>
</div>

<!-- MODAL DE INFORMACIÓN AL INTENTAR BORRAR UNA ESCENA QUE TIENE ESCENAS SECUNDARIAS -->
<div class="window" id="cancelDeleteSs">
    <span class="titleModal col100">No se puede eliminar la escena seleccionada</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="contentCancelDeleteScene col100 xlMarginTop">
        <p>Esta escena no puede eliminarse porque contiene escenas secundarias.</p>
        <p>Por favor, elimine las escenas secundarias antes de eliminar la escena.</p>
        <p>Gracias.</p>
    </div>
    <div class="col100 centerH mMarginTop">
        <button id="aceptCondition" class="col50">Aceptar</button>
    </div>
</div>


<!-- MODAL DE INFORMACIÓN AL INTENTAR BORRAR UNA ESCENA QUE ESTÁ ASOCIADA A UNA VISITA GUIADA -->
<div class="window" id="cancelDeleteScenes_guided_visit">
    <span class="titleModal col100">No se puede eliminar la escena seleccionada</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="contentCancelDeleteScene col100 xlMarginTop">
        <p>Esta escena no puede eliminarse porque está asociada a una visita guiada</p>
        <p>Por favor, elimine la escena de la visita guiada antes de eliminar la escena.</p>
        <p>Gracias.</p>
    </div>
    <div class="col100 centerH mMarginTop">
        <button id="aceptCondition" class="col50">Aceptar</button>
    </div>
</div>

<!-- MODAL DE INFORMACIÓN AL INTENTAR BORRAR UNA ESCENA QUE ESTÁ ASOCIADA A PUNTO DESTACADO -->
<div class="window" id="cancelDeleteScenes_Highlight">
    <span class="titleModal col100">No se puede eliminar la escena seleccionada</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28" />
        </svg>
    </button>
    <div class="contentCancelDeleteScene col100 xlMarginTop">
        <p>Esta escena no puede eliminarse porque está asociada a un punto destacado</p>
        <p>Por favor, elimine la escena del punto destacado antes de eliminar la escena.</p>
        <p>Gracias.</p>
    </div>
    <div class="col100 centerH mMarginTop">
        <button id="aceptCondition" class="col50">Aceptar</button>
    </div>
</div>

@endsection


{{----------------------------------- CONTENIDO -------------------------------}}
@section('content')
<script src="{{url('js/marzipano/es5-shim.js')}}"></script>
<script src="{{url('js/marzipano/eventShim.js')}}"></script>
<script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
<script src="{{url('js/marzipano/marzipano.js')}}"></script>

<!-- TITULO -->
<div class="col0 sMarginRight">
    <svg class="btnBack" onclick="window.location.href='{{ route('zone.index') }}'" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 405.333 405.333" style="enable-background:new 0 0 405.333 405.333;" xml:space="preserve">
        <polygon points="405.333,96 362.667,96 362.667,181.333 81.707,181.333 158.187,104.853 128,74.667 0,202.667 128,330.667 
                158.187,300.48 81.707,224 405.333,224" />
    </svg>
</div>
<div id="title" class="col80 xlMarginBottom">
    <span>{{ $zone->name }} | Número de escenas en esta zona ({{ $scenes->count() }}) </span>
</div>

<div id="content" class="col100">
    <input type="hidden" name="actualScene" id="actualScene">
    <div class="col90">
        {{----- EDITAR DATOS DE LA ZONA -----}}
        <form id="editZoneForm" class="col100" action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col100">
                <div class="col20 lPaddingRight sPaddingLeft"><label for="name">Nombre de zona</label></div>
                <div class="col30 sPaddingLeft"><label for="file_image">Imagen</label></div>
            </div>
            <div class="col100">
                <div class="col20 lPaddingRight"><input id="zoneName" type="text" name="name" value="{{ $zone->name }}" class="col100 sMarginTop"></div>
                <div class="col30 sPaddingLeft"><input id="zoneImage" class="col100" type="file" name="file_image" accept=".png, .jpg, .jpeg" id="inputFileImage"></div>
                <input id="submitEditZoneForm" type="submit" name="Save Changes" class="col10 sPaddingLeft" value="Guardar">
                <div class="col10 lPaddingLeft">
                    <img class="btnRotateImage" src="{{ url('img/icons/girar.png') }}" alt="" width="35px">
                </div>
                <div id="errorMessagge" class="col20 mPaddingLeft errormsg">
                    <span></span>
                </div>
            </div>

        </form>
        <!-- Formulario para girar la imagen -->
        <form id="editZoneForm" class="col100" action="{{ route('zone.rotateImageStore', ['filename' => $zone->file_image],  ['id' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            
            <div class="col100">
                <div class="col10 lPaddingLeft">
                    <input id="image_src" type="text" style="width: 550px; display:none">
                    <input id="submitRotateImageForm" style="display:none" type="submit" name="Save Changes" class="col10 sPaddingLeft" value="">
                   
                </div>
            </div>

        </form>
    </div>

    <div class="col60 lMarginTop">
        {{----- MAPA -----}}
        <div id="addScene" class="col100 relative">
            <div id="zoneicon" class="icon" style="display: none">
                <img class="newscenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%">
            </div>
            @foreach ($scenes as $scene)
            <div class="icon iconHover" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%">
                <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%">
            </div>
            @endforeach
            <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
            <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
            <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}" alt="">
        </div>
    </div>

    {{----- NUEVA ESCENA -----}}
    <div id="menuModalAddScene" class="menuLateral col40 lPaddingLeft xlMarginTop">
        <div id="formAddSceneContainer">
            <form id="formAddScene" method="post" enctype="multipart/form-data" action="{{ route('scene.store') }}">
                @csrf
                <input id="newSceneName" type="text" name="name" required placeholder="Nombre*" class="col100">
                @isset($mensaje)
                <p class="col100">{{ $mensaje }}</p>
                @endisset
                <label for="sceneImg" class="col100  mMarginTop">Imagen 360</label>
                <input type="file" name="image360" id="newSceneImg" required class="col100 sMarginTop">
                <div class="col100 mMarginTop ajustarTamaño">
                    <label class="checkbox" for="principal">
                        <div class="centrarLabel">Escena principal</div>
                        <input type="checkbox" name="principal" id="principal"><br><br>
                        <span class="check"></span>
                    </label>
                </div>
                <div id="errorMessaggeNewScene" class="col100 SMarginTop errormsg">
                    <span></span>
                </div>
                <input id="top" type="hidden" name="top">
                <input id="left" type="hidden" name="left">


                <input type="hidden" name="idZone" value="{{ $zone->id }}">
            </form>

            <input type="submit" form="formAddScene" value="Guardar" id="saveScene" class="col100 xlMarginTop">
        </div>
        <div id="loadUploadScene" class="loadUpload col100 xxlMarginTop">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <rect x="19" y="19" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0s" calcMode="discrete"></animate>
                </rect>
                <rect x="40" y="19" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.125s" calcMode="discrete"></animate>
                </rect>
                <rect x="61" y="19" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.25s" calcMode="discrete"></animate>
                </rect>
                <rect x="19" y="40" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.875s" calcMode="discrete"></animate>
                </rect>
                <rect x="61" y="40" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.375s" calcMode="discrete"></animate>
                </rect>
                <rect x="19" y="61" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.75s" calcMode="discrete"></animate>
                </rect>
                <rect x="40" y="61" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.625s" calcMode="discrete"></animate>
                </rect>
                <rect x="61" y="61" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.5s" calcMode="discrete"></animate>
                </rect>
            </svg>
        </div>
    </div>
    {{----- ACTUALIZAR ESCENA ------}}
    <div id="menuModalUpdateScene" class="menuLateral menuModalUpdateScene col40 lPaddingLeft xlMarginTop">
        <div id="formUpdateSceneContainer">
            <form id="formUpdateScene" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="name" id="updateSceneName" class="col100" placeholder="Nombre"><br><br>
                <div id="pano" class="l1 col100 relative sMarginTop"></div>
                <label for="updateSceneImg" class="col100 mMarginTop">Cambiar imagen 360</label>
                <input type="file" name="image360" id="updateSceneImg" class="col100 sMarginTop">
                <div class="col100 mMarginTop ajustarTamaño">
                    <label class="checkbox" for="principal2">
                        <div class="centrarLabel">Escena principal</div>
                        <input type="checkbox" name="principal2" id="principal2"><br><br>
                        <span id="checkPrincipal" class="check"></span>
                    </label>
                </div>
                <div id="errorMessaggeUpdateScene" class="col100 errormsg">
                    <span></span>
                </div>
                <input id="topUpdate" type="hidden" name="top">
                <input id="leftUpdate" type="hidden" name="left">
                <input type="hidden" name="sceneId" id="sceneId">
                <input type="hidden" name="idZone" id="idZone" value="{{$zone->id}}">
            </form>

            <div class="col100 sMarginRigth" style="margin-top: 10%">
                <div class="col30 buttonEditScene">
                    <button id="moveActualScene" class="col100">Mover punto</button>
                </div>
                <div class="col30 buttonEditScene sMarginLeft">
                    <button id="deleteScene" class="col100">Borrar escena</button>
                </div>
                <div class="col30 buttonEditScene sMarginLeft">
                    <button id="editActualScene" class="col100 bBlack">Editar Hotspots</button>
                </div>
                <input type="submit" form="formUpdateScene" value="Guardar Cambios" id="updateScene" class="col100  sMarginTop">
            </div>
        </div>
        <div id="loadUploadSceneUpdate" class="loadUpload col100 xxlMarginTop">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <rect x="19" y="19" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0s" calcMode="discrete"></animate>
                </rect>
                <rect x="40" y="19" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.125s" calcMode="discrete"></animate>
                </rect>
                <rect x="61" y="19" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.25s" calcMode="discrete"></animate>
                </rect>
                <rect x="19" y="40" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.875s" calcMode="discrete"></animate>
                </rect>
                <rect x="61" y="40" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.375s" calcMode="discrete"></animate>
                </rect>
                <rect x="19" y="61" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.75s" calcMode="discrete"></animate>
                </rect>
                <rect x="40" y="61" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.625s" calcMode="discrete"></animate>
                </rect>
                <rect x="61" y="61" width="20" height="20" fill="#6e00ff">
                    <animate attributeName="fill" values="#4f179b;#6e00ff;#6e00ff" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.5s" calcMode="discrete"></animate>
                </rect>
            </svg>
        </div>
    </div>
    <div id="menuMovePoint" class="col40 xlPaddingS xlMarginTop" style="display:none">
        <div class="col100" style="margin-top: 45%">
            <p class="col100" style="margin-left: 20%; font-weight: bold">Reubique la escena en el mapa</p>
            <div>
                <button id="aceptNewPointSite" class="col100 sMarginTop">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="secondaryScenesList" class="menuModalUpdateScene col100" style="display:none">
    <!--Lista de las escenas secundarias ya creadas para esa escena-->
    <div id="separatorLine" class="col100 xlMarginTop lMarginBottom"></div>
    <div class="col100 mPaddingLeft mPaddingRight lMarginBottom">
        <span id="subTitleZone" class="col85">Escenas Secundarias</span>
        <button id="addSScene" class="col15">Nueva</button>
    </div>
    <div id="infosscene"></div>
</div>




<script type="text/javascript">
    /**
     * Giro de imagen de zona
     */
    var routeRotateImage = "{{ route('zone.rotateImageStore', '') }}";

    //alert("HOLA");
    console.log(routeRotateImage);

    var token = "{{ csrf_token() }}";
    var routeUpdate = "{{ route('scene.update', 'req_id') }}";
    var routeEdit = "{{ route('scene.edit', 'id') }}";
    var routeEditSecondart = "{{ route('secondaryscenes.edit', 'id') }}"; //Ruta de edicion de escena secundaria para usar en zone.js
    //Rutas de tiles para usar en zone.js
    var marzipanoTiles = "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}";
    var marzipanoPreview = "{{url('/marzipano/tiles/dn/preview.jpg')}}";
    /*********FUNCIÓN PARA SACAR LA INFORMACIÓN DEL PUNTO DE LA ESCENA**********/
    function sceneInfo($id) {
        var route = "{{ route('scene.show', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    function deleteScenePoint($id) {
        var route = "{{ route('scene.destroy', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'DELETE',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    /*FUNCIÓN PARA CARGAR VISTA PREVIA DE LA ESCENA*/
    var view = null;

    function loadScene(sceneDestination, elemento) {
        view = null;
        'use strict';
        console.log(sceneDestination['id']);
        //1. VISOR DE IMAGENES
        var panoElement = document.getElementById('pano');
        if (elemento == 0) {
            var padre = document.getElementById('sSceneView');
            panoElement = padre.firstElementChild;
        }
        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer = new Marzipano.Viewer(panoElement, {
            stage: {
                progressive: true
            }
        });

        //2. RECURSO
        var source = Marzipano.ImageUrlSource.fromString(
            "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}".replace('dn', sceneDestination.directory_name),

            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {
                cubeMapPreviewUrl: "{{url('/marzipano/tiles/dn/preview.jpg')}}".replace('dn', sceneDestination.directory_name),
                cubeMapPreviewFaceOrder: 'lfrbud'
            });

        //3. GEOMETRIA 
        var geometry = new Marzipano.CubeGeometry([{
                tileSize: 256,
                size: 256,
                fallbackOnly: true
            },
            {
                tileSize: 512,
                size: 512
            },
            {
                tileSize: 512,
                size: 1024
            },
            {
                tileSize: 512,
                size: 2048
            },
        ]);

        //4. VISTA
        //Limitadores de zoom min y max para vista vertical y horizontal
        var limiter = Marzipano.util.compose(
            Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
            Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
        );
        //Establecer estado inicial de la vista con el primer parametro
        var view = new Marzipano.RectilinearView({
            yaw: sceneDestination.yaw,
            pitch: sceneDestination.pitch,
            roll: 0,
            fov: Math.PI
        }, limiter);

        //5. ESCENA SOBRE EL VISOR
        var scene = viewer.createScene({
            source: source,
            geometry: geometry,
            view: view,
            pinFirstLevel: true
        });

        //6.MOSTAR
        scene.switchTo({
            transitionDuration: 1000
        });
    }


    $().ready(function() {
        ///// NUEVA ESCENA
        $("#addSScene").click(function() {
            var scenId = $('#idScene').attr('value');
            $("#modalWindow").css("display", "block");
            $("#Sscene").css("display", "block");
        });

        ///// EDITAR ESCENA
        $('.scenepoint').click(function() {
            //cambio la imagen del punto
            ruta = $('#url').val();
            $('.scenepoint').attr('src', ruta);
            rutahover = $('#urlhover').val();
            $(this).attr('src', rutahover);

            var idScene = ($(this).attr('id')).substr(5);
            $('#idScene').attr('value', idScene);
            sceneInfo(idScene).done(function(result) {
                loadScene(result, 1);
                $('#showScene').show();
            });
            checkStatus(idScene).done(function(result) {
                if (result['principal']) {
                    if (!$('#principal2').is(':checked')) {
                        $('#checkPrincipal').click();
                    }
                } else {
                    if ($('#principal2').is(':checked'))
                        $('#checkPrincipal').click();
                }
                if (result['cover']) {
                    if (!$('#cover2').is(':checked'))
                        $('#checkCover').click();
                } else {
                    if ($('#cover2').is(':checked'))
                        $('#checkCover').click();
                }
            });
        });


    });
    //FUNCIÓN PARA SACAR LAS ESCENAS SECUNDARIAS
    function s_sceneInfo($id) {
        var route = "{{ route('secondaryscenes.show', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    //FUNCIÓN PARA SACAR LAS ESCENA SECUNDARIA A MODIFICAR
    function seconInfo($id) {
        var route = "{{ route('secondaryscenes.showScene', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    /******************FUNCIÓN PARA COMPROBAR LAS RELACIONES DE LAS ESCENAS ANTES DE BORRARLAS**********************/
    function checkSecondaryScenes(idScene) {
        var route = "{{ route('scene.checkSs', 'req_id') }}".replace('req_id', idScene);
        return $.ajax({
            url: route,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    function checkHotspot(idScene) {
        var route = "{{ route('scene.checkHotspots', 'req_id') }}".replace('req_id', idScene);
        return $.ajax({
            url: route,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    function checkScenes_guided_visit(idScene) {
        var route = "{{ route('scene.checkScenes_guided_visits', 'req_id') }}".replace('req_id', idScene);
        return $.ajax({
            url: route,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    function checkHighlight(idScene) {
        var route = "{{ route('scene.checkHighlights', 'req_id') }}".replace('req_id', idScene);
        return $.ajax({
            url: route,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

    function checkStatus(sceneId) {
        var route = "{{ route('scene.checkStatus', 'req_id') }}".replace('req_id', sceneId);
        return $.ajax({
            url: route,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }







    /* FUNCIÓN PARA MOVER EL PUNTO UNA VEZ COLOCADO EN EL MAPA */
    $('#moveActualScene').click(function() {
        modify = true;
        var sceneId = $('#actualScene').val();
        console.log(sceneId);
        // $('#addScene').unbind();
        // $('.scenepoint').unbind();
        $('#scene' + sceneId).addClass('onMovement');
        $('.scenepoint').css('cursor', 'cell');
        $('.scenepoint').hover(function() {
            $(this).parent().css('width', '2.2%');
        });
        $('#topUpdate').attr('value', '');
        $('#leftUpdate').attr('value', '');
        $('#menuModalUpdateScene').hide();
        $('#menuMovePoint').show();
        $('#addScene').bind("click", function(e) {
            if ($('#scene' + sceneId).hasClass('onMovement')) {
                $('#menuModalAddScene').css('display', 'none');
                $('#menuModalUpdateScene').hide();
                $('#secondaryScenesList').show();
                $('#zoneicon').css('display', 'none');
                var capa = document.getElementById("addScene");
                var posicion = capa.getBoundingClientRect();
                var mousex = e.clientX;
                var mousey = e.clientY;
                var alto = (mousey - posicion.top); //posición en píxeles
                var ancho = (mousex - posicion.left); //posición en píxeles
                var top = ((alto * 100) / ($('#zoneimg').innerHeight()) - 1.55);
                var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) - 1.1);
                $('#scene' + sceneId).parent().css('top', top + "%");
                $('#scene' + sceneId).parent().css('left', left + "%");
                $('#topUpdate').attr('value', top);
                $('#leftUpdate').attr('value', left);
            }
        });
    });

    $('#aceptNewPointSite').click(function() {
        var sceneId = $('#actualScene').val();
        var route = "{{ route('scene.updateTopLeft') }}";
        $.ajax({
            url: route,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                'id': sceneId,
                'top': $('#topUpdate').val(),
                'left': $('#leftUpdate').val(),
            },
            success: function(result) {
                if (result['status']) {
                    modify = false;
                    $('#scene' + sceneId).removeClass('onMovement');
                    $('#menuMovePoint').hide();
                    $('.scenepoint').css('cursor', 'pointer');
                    $('#menuModalUpdateScene').show();
                    $('#secondaryScenesList').show();
                } else {
                    alert('Error Controlador');
                }
            },
            error: function() {
                alert('Error AJAX');
            }
        });
    });

    $('#aceptCondition').click(function() {
        $('#confirmDelete').hide();
        $('#modalWindow').hide();
    });

    //Variable necesaria para el delete
    var direccion = "{{url('')}}";
</script>
@endsection