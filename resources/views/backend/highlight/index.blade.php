@extends('layouts.backend')

@section('headExtension')
<!-- Documento js de highlight-->
<script src="{{url('js/highlight/highlight.js')}}"></script>

<!-- Recursos de zonas para ventana modal-->
<link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
<link rel="stylesheet" href="{{url('css/backend.css')}}"/>
<script src="{{url('js/zone/zonemap.js')}}"></script>

<!-- MDN para usar sortable -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
@endsection

@section('title', 'Zonas Destacadas Celia-Tour')

@section('modal')
    <!-- Modal -->  
    <div id="modalDelete" class="window">
        <span class="titleModal col100">Confirmar eliminación</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div>
            <br><br>
        </div>
        <div>
            <form id="formadd" action="{{ route('highlight.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100"> 
                    ¿Desea eliminar esta zona destacada del sistema?
                </div>
            </form>
            <!-- Botones de control -->
            <div class="col50 mPaddingRight xlMarginTop">
                <button id="btnModal" type="button" value="Eliminar" class="col100">Aceptar</button>
            </div>
            <div class="col50 mPaddingLeft xlMarginTop">
                <button id="btnNo" type="button" class="col100">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- MODAL PARA AÑADIR NUEVO PUNTO DESTACADO -->
<div class="window" id="newHlModal" style="display: none;">
    <div id="newSlide" class="slide" style="display: none;">
        <span id="modalTitle" class="titleModal col100"></span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div class="col100 xlMarginTop" style="margin-left: 3.8%">
            <div id="title" class="col20"></div>
            <div id="contentbutton"></div>
            <div id="content" class="col100">
                <div id="title" class="col80"><span>NUEVO PUNTO DESTACADO</span></div>
                <form id="newHlForm" action="{{ route('highlight.store')}}" method='post' class="col90" enctype="multipart/form-data" style="margin-left: 1.5%">
                    @csrf
                    <label class="col100 xlMarginTop">Nombre del punto<span class="req">*<span></label>
                    <div>
                        <input type='text' name='title' class="col100 sMarginTop" required>
                    </div>

                    <label class="col100 sMarginTop">Imagen de escena<span class="req">*<span></label>
                    <div>
                        <input type='file' name='scene_file' class="sMarginTop" required>
                    </div>
                    <input type='hidden' id='idSelectedScene' name='id_scene'>
                    <!--Boton para ver mapa-->
                    <div class="col100 sMarginTop" id="dzone">
                        <input type="button" class="col100 mMarginTop bBlack" id="btnMap" value="Seleccionar escena"><span id="msmError" class="sMarginTop col100"></span>
                    </div>
                    <div class="col100 sMarginTop" >
                        <span id="textConfirmSelectedScene"></span>
                    </div>

                    <button type='submit' class="col100 xlMarginTop" value='Insertar' id='btnSubmit'>Guardar</button>

                </form>
            </div>
        </div>
    </div>
    
</div>

<!-- MODAL PARA MODIFICAR PUNTO DESTACADO -->
<div class="window" id="modifyHlModal" style="display: none;">
    <div id="newSlideUpdate" class="slide" style="display: none;">
        <span id="modalTitle" class="titleModal col100"></span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div class="col100 xlMarginTop" style="margin-left: 3.8%">
            <div id="title" class="col20"></div>
            <div id="contentbutton"></div>
            <div id="content" class="col100">
                <div id="title" class="col80"><span>MODIFICAR PUNTO DESTACADO</span></div>
                <form id="formUpdateHl" action="{{ route('highlight.update', 'id')}}" method="post" class="col90" enctype="multipart/form-data">
                    @method("put")
                    @csrf
                    <label class="col100 xlMarginTop">Nombre del punto</label>
                    <div>
                        <input id="hlTitle" type='text' name='title' class="col100 sMarginTop">
                    </div>

                    <label class="col100 sMarginTop">Imagen de escena</label>
                    <div>
                        <img id="hlSceneImg" src="" alt="imagen" style="width: 60%">
                    </div>
                    <div>
                        <input type='file' name='scene_file' class="sMarginTop">
                    </div>
                    <input type='hidden' id='idSelectedSceneUpdate' name='id_scene'>
                    <!--Boton para ver mapa-->
                    <div class="col100 sMarginTop" id="updateHlMap">
                        <input type="button" class="col100 mMarginTop bBlack" id="btnMap" value="Seleccionar escena"><span id="msmError" class="sMarginTop col100"></span>
                    </div>
                    <div class="col100 sMarginTop" >
                        <span id="textConfirmSelectedScene"></span>
                    </div>

                    <button type='submit' class="col100 xlMarginTop" value='Insertar' id='btnSubmitUpdate' onclick="idScene()">Guardar</button>

                </form>
            </div>
        </div>
    </div>
    
</div>

<!-- MODAL MAPA -->
<div  id="modalMap" class="window sizeWindow70" style="display: none;">
    <div id="mapSlide" class="slide" style="display:none">
        <span class="titleModal col100">SELECCIONAR ESCENA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="content col90 mMarginTop" style="overflow: auto; max-height: 523px">
            <div id="map1" class="oneMap col100">
                @include('backend.zone.map.zonemap')
            </div>
        </div>
    </div>
    <div class="col80 centerH mMarginTop" style="margin-left: 9%">
        <button id="addSceneToHl" class="col100">Aceptar</button>
    </div>
<div>
@endsection

@section('content')

    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>PUNTOS DESTACADOS</span>
    </div>

    <div id="contentbutton" class="col20 xlMarginBottom">
        <button id="newHighlight" type="button" class="right round col45" >
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                </svg>
        </button>
    </div>





    <div id="content" class="col100 centerH">
        <div class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col20"><strong>Titulo</strong></div>
                <div class="col25"><strong>Imagen</strong></div>
                <div class="col15"><strong>Nombre escena</strong></div>
                <div class="col15"><strong>Nombre zona</strong></div>
            </div>
            
            <div class="sortable"> <!-- Bloque ordenable (clase sortable)  -->
            @php
                $cont = 1;   
            @endphp
            
            @foreach($highlightList as $highlight)
                <div id="{{ $highlight->id }}" class="col100 row10 mPaddingLeft mPaddingRight sPaddingTop">
                    <div class="col20 sPadding">{{$highlight->title}}</div>
                    <div class="col25 sPadding">
                        <img src='{{url('img/resources/'.$highlight->scene_file)}}' style='width: 130px; height: 100px'>
                    </div>
                    <div class="col15 sPadding">
                        {{isset($scene_name[$cont - 1]->scene_name)?$scene_name[$cont - 1]->scene_name:'No hay ninguna escena asociada'}}
                    </div>
                    <div class="col15 sPadding">
                        {{isset($zone_name[$cont - 1]->zone_name)?$zone_name[$cont - 1]->zone_name:'No hay ninguna zona asociada'}}
                    </div>
                    <div class="col12 sPadding">
                        <div id="{{ $highlight->id }}">
                            <button id="{{ $highlight->id }}" class="modifyHl col80" type="button" value="Modificar">Modificar</button>
                        </div>
                    </div>
                    <div class="col12 sPadding">
                        <button class="delete col80" type="button" value="Eliminar" onclick="borrarHL('{{route('highlight.borrar',$highlight->id)}}')">Eliminar</button>
                    </div>
                    
                    <!-- 
                         COMENTADO EL CÓDIGO DE ORDENACIÓN POR FLECHAS
                    
                    @if($cont == 1)
                        @if($highlightList->count() > 1)
                            <div class="col5"> <img id="d{{ $highlight->position }}" src="{{ url('img/icons/down.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'd'.$highlight->id]) }}'"> </div>
                        @endif
                    @else
                        @if($cont == $rows)
                            <div class="col5"> <img id="u{{ $highlight->position }}" src="{{ url('img/icons/up.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'u'.$highlight->id]) }}'"> </div>
                        @else
                            <div class="col5"> <img id="u{{ $highlight->position }}" src="{{ url('img/icons/up.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'u'.$highlight->id]) }}'"> </div>
                            <div class="col5"> <img id="d{{ $highlight->position }}" src="{{ url('img/icons/down.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'd'.$highlight->id]) }}'"> </div>
                        @endif
                    @endif
                 -->
                    @php
                        $cont++;
                    @endphp
                </div>
            @endforeach
            </div>
        </div>
    </div>

    <!-- Formulario para guardar posición -->
    <!--
        Para depurar la ordenación haz lo siguiente:
            - Quítale al formulario style="display: none;" para que sea visible
            - Quítale al input hidden para que sea visible
    -->
    <form id="addPosition" action="{{ route('highlight.highlightPosition', isset($highlight->id)?$highlight->id:'') }}" method="post">
        @csrf
        <!-- Por defecto null, para saber si mandar petición al servidor -->
        <input id="position" type="text" name="position" value="null" hidden> 
    </form>

    <script>
        //RUTAS PARA EL JS EXTERNO
        var rutaIconoEscena = "{{ url('img/zones/icon-zone.png') }}";
        var rutaIconoEscenaHover = "{{ url('img/zones/icon-zone-hover.png') }}";
        var rutaShow = "{{ route('highlight.showw', 'req_id') }}";
        var rutaImg = "{{ url('img/resources/image') }}";
        var rutaSceneZone = "{{ route('scene.getZone', 'req_id') }}";
        var token = "{{ csrf_token() }}";

        function borrarHL(ruta){
            $("#modalWindow").css("display", "block");
            $("#ventanaModal").css("display", "block");
            $("#btnModal").attr("onclick", "window.location.href='"+ ruta +"'");
        }
    </script>
    <style> 
        #modalMap{
            width: 60%;
        }
        .addScene{
            width: 85%;
        }
        #changeZone{
            top: 70%;
            left: 78%;
            width: 7%;
        }
        #floorUp, #floorDown{
            width: 150%;
        }
        
        .closeModalButton{
            position: absolute;
            float: left;
            width: 40px;
            margin-left: 45%;
            margin-top: -20%;
        }

        #btnModal{
            background-color: rgb(255, 87, 87);
        }
    </style>
@endsection
