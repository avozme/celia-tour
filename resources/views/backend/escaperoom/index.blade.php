@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <link rel="stylesheet" href="{{url('css/escaperoom/index.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>
    <script src="{{url('js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('js/marzipano/marzipano.js')}}"></script>
    <script src="{{url('js/question/index.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/question/question.css')}}" />

    <!-- URL GENERADAS PARA SCRIPT -->
    <script>
        // Para las urls con identificador se asignara 'insertIdHere' por defecto para posteriormente modificar ese valor.
        const questionDelete = "{{ route('question.destroy', 'insertIdHere') }}";
        const questionEdit = "{{ route('question.edit', 'insertIdHere') }}";
    </script>
@endsection

@section('content')
    <div id="title" class="col100 mMarginBottom">
        <span>ESCAPE ROOM</span>
    </div>

    {{-- <nav id="menuHorizontal" class="col100"> --}}
        <div id="menuEscapeRoom" class="col100 mMarginBototom">
            <ul>
                <div id="menuList">
                    <li class="escenas">Escenas</li>
                    <li class="preguntas">Preguntas</li>
                    <li id="liBorder" class="llaves">Llaves</li>
                </div>
            </ul>
        </div>
        <div id="borderDiv" class="col100"></div>
    {{-- </nav> --}}
    {{---------DIV DE ESCENAS--------}}
    <div id="escenas" style="display: block;">
        {{------------ MAPA -------------}}
        <div id="map" class="col60">
            @include('backend.zone.map.zonemap')
        </div>
        {{------------ MENÚ ------------}}
        <div id="menu" class="col30 lMarginTop hidden">
            <span id="sceneName"></span>
            <div id="pano" class="col100 relative" style="height: 255px"></div>
            <input type="hidden" id="actualScene">
            <button id="editScene" class="col100 bBlack lMarginTop">Modificar Escena</button>
        </div>
    </div>
    {{---------DIV DE PPREGUNTAS/RESPUESTAS--------}}
    <div id="preguntasRespuestas" style="display: none;">
        <!-- TITULO -->
        <div id="title" class="col80 xlMarginBottom">
            <span>Preguntas</span>
        </div>

        <!-- BOTON AGREGAR -->   
        <div class="col20 xlMarginBottom">   
            <button class="right round col45" id="btn-add">
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                            8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                </svg>
            </button>
        </div>

        <!-- TABLA DE CONTENIDO -->
        <div id="content" class="col100 centerH">
            <div class="col90">
                <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                    <div class="col15 sPadding"><strong>Pregunta</strong></div>
                    <div class="col15 sPadding"><strong>Respuesta</strong></div>
                    <div class="col15 sPadding"><strong>Llave</strong></div>
                    <div class="col15 sPadding"><strong>Pista</strong></div>
                    <div class="col15 sPadding"><strong>Audio</strong></div>
                </div>

                <div id="tableContent">
                    @foreach ($question as $value)
                    {{-- Modificar este div y su contenido afectara a la insercion dinamica mediante ajax --}}
                        <div id="{{$value->id}}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                            <div class="col15 sPadding">{{$value->text}}</div>
                            <div class="col15 sPadding">{{$value->answer}}</div>
                            @if($value->key==0)
                                <div class="col15 sPadding">No</div>
                                <div class="col15 sPadding">Si</div>
                            @else 
                                <div class="col15 sPadding">Si</div>
                                <div class="col15 sPadding">No</div>   
                            @endif
                            @if($value->id_audio==null)
                                <div class="col15 sPadding">Sin audio</div>
                            @else 
                            <div class="col15 sPadding">{{$value->id_audio}}</div>
                            @endif
                            <div class="col12 sPadding"><button class="btn-update col100">Editar</button></div>
                            <div class="col12 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
                        </div>
                    {{----------------------------------------------------------------------------------------}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{---------DIV DE PPREGUNTAS/RESPUESTAS--------}}
    <div id="keys" style="display: none;">
        <p>AQUI VA EL CONTENIDO DE LAS KEYS.</p>
    </div>

    @section('modal')

    <!-- FORM NUEVO QUESTION -->
    <div id="modalQuestionAdd" class="window" style="display:none">
        <span class="titleModal col100">NUEVA PREGUNTA</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="col100">
            <form id="formAdd" action="{{ route('question.store') }}" method="POST" class="col100">
                @csrf
                <p class="xlMarginTop">Pregunta<span class="req">*<span></p>
                <input type="text" id="textAdd" name="text" class="col100" required><br>
                <p class="xlMarginTop">Respuesta<span class="req">*<span></p>
                <input type="text" id="answerAdd" name="answer" class="col100" required><br>
                <div class="col50">
                    <p class="xlMarginTop">¿Desbloquea una llave?<span class="req">*<span></p>
                    <input type="radio" id="keyTrue" name="key" value="1">
                    <label for="keyTrue">Si</label>
                    <input type="radio" id="keyFalse" name="key" value="0" checked>
                    <label for="keyFalse">No</label>
                </div>
                <div class="col50">
                    <p class="xlMarginTop">¿Muestra una pista?<span class="req">*<span></p>
                    <input type="radio" id="clueTrue" name="show_clue" value="1">
                    <label for="clueTrue">Si</label>
                    <input type="radio" id="clueFalse" name="show_clue" value="0" checked>
                    <label for="clueFalse">No</label>
                </div>
                {{-- <input type="submit" value="Guardar" class="col100 mMarginTop"> --}}
                
            </form>
            <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop" style="clear: both;">
                <div id="acept" class="col100 centerH"><button id="btn-saveNew" class="col70">Guardar</button> </div>
            </div>
        </div>
    </div>

    <!-- FORM MODIFICAR QUESTION -->
    <div id="modalQuestionUpdate" class="window" style="display:none">
        <span class="titleModal col100">MODIFICAR PREGUNTA</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="col100">
            <form id="formUpdate" action="{{ route('question.update', 'insertIdHere') }}" method="POST" class="col100">
                @csrf
                @method("patch")
                <p class="xlMarginTop">Pregunta<span class="req">*<span></p>
                <input type="text" id="textUpdate" name="text" class="col100" required><br>
                <p class="xlMarginTop">Respuesta<span class="req">*<span></p>
                <input type="text" id="textUpdate" name="text" class="col100" required><br>
                <div class="col50">
                    <p class="xlMarginTop">¿Desbloquea una llave?<span class="req">*<span></p>
                    <input type="radio" id="keyTrue" name="key" value="1">
                    <label for="keyTrue">Si</label>
                    <input type="radio" id="keyFalse" name="key" value="0" checked>
                    <label for="keyFalse">No</label>
                </div>
                
                <div class="col50">
                    <p class="xlMarginTop">¿Muestra una pista?<span class="req">*<span></p>
                    <input type="radio" id="clueTrue" name="show_clue" value="1">
                    <label for="clueTrue">Si</label>
                    <input type="radio" id="clueFalse" name="show_clue" value="0" checked>
                    <label for="clueFalse">No</label>
                </div>
                {{-- <input type="submit" value="Guardar" class="col100 mMarginTop"> --}}
                
            </form>
            <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop" style="clear: both;">
                <div id="acept" class="col100 centerH"><button id="btn-update" class="col70">Guardar</button> </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
    <div class="window" id="confirmDelete" style="display: none;">
        <span class="titleModal col100">¿Eliminar pregunta?</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
            <button id="aceptDelete" class="delete">Aceptar</button>
            <button id="cancelDelete">Cancelar</button>
        </div>
    </div>
@endsection


    <script>
        /* RUTAS PARA ARCHIVOS EXTERNOS JS */
        var pointImgRoute = "{{ url('img/zones/icon-zone.png') }}";
        var pointImgHoverRoute = "{{ url('img/zones/icon-zone-hover.png') }}";
        var marzipanoTiles = "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}";
        var marzipanoPreview = "{{url('/marzipano/tiles/dn/preview.jpg')}}";

        function sceneInfo($id){
            var route = "{{ route('scene.show', 'id') }}".replace('id', $id);
            return $.ajax({
                url: route,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        }

        function loadScenePreview(sceneDestination){     
            'use strict';
            //1. VISOR DE IMAGENES
            var panoElement = document.getElementById('pano');

            /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
            a mayor, para conseguir una carga mas fluida. */
            var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

            //2. RECURSO
            var source = Marzipano.ImageUrlSource.fromString(
                marzipanoTiles.replace('dn', sceneDestination.directory_name),
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: marzipanoPreview.replace('dn', sceneDestination.directory_name), 
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
            var view = new Marzipano.RectilinearView({yaw: sceneDestination.yaw, pitch: sceneDestination.pitch, roll: 0, fov: Math.PI}, limiter);

            //5. ESCENA SOBRE EL VISOR
            var scene = viewer.createScene({
            source: source,
            geometry: geometry,
            view: view,
            pinFirstLevel: true
            });

            //6.MOSTAR
            scene.switchTo({ transitionDuration: 1000 });
        }

        $().ready(function(){
            $(".scenepoint").hover(function(){
                $(this).attr('src', pointImgHoverRoute);
            }, function(){
                if(!($(this).hasClass('selected'))){
                    $(this).attr('src', pointImgRoute);
                }
            });

            $('.scenepoint').click(function(){
                $('#menu').show();
                $('.scenepoint').attr('src', pointImgRoute);
                $('.scenepoint').removeClass('selected');
                $(this).attr('src', pointImgHoverRoute);
                $(this).addClass('selected');
                var pointId = $(this).attr('id');
                var sceneId = parseInt(pointId.substr(5));
                $('#actualScene').val(sceneId);
                sceneInfo(sceneId).done(function(result){
                    $('#sceneName').text(result.name);
                    loadScenePreview(result);
                })
            });

            $('#editScene').click(function(){
                var pointId = $(this).attr('id');
                var sceneId = $('#actualScene').val();
                window.location.href = "{{ route('escaperoom.editScene', 'req_id') }}".replace('req_id', parseInt(sceneId));
            });

        });

        /*Funciones para cambiar entre menús:*/
        $(".escenas").click(function(){
            $("#escenas").css("display", "block");
            $("#preguntasRespuestas").css("display", "none");
            $("#keys").css("display", "none");
        });

        $(".preguntas").click(function(){
            $("#preguntasRespuestas").css("display", "block");
            $("#escenas").css("display", "none");
            $("#keys").css("display", "none");
        });

        $(".llaves").click(function(){
            $("#keys").css("display", "block");
            $("#escenas").css("display", "none");
            $("#preguntasRespuestas").css("display", "none");
        });
    </script>
@endsection