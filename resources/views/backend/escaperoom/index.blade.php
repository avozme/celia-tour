@extends('layouts.backend')

@section('headExtension')
    <script src="{{url('js/escaperoom/index.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/escaperoom/index.css')}}" />
@endsection

@section('content')
    <div id="title" class="col80 mMarginBottom">
        <span>ESCAPE ROOM</span>
    </div>

    <input type="hidden" id="state"> <!-- 0 => nuevo | 1 => editando -->

    <!-- BOTON AGREGAR -->   
    <div class="col20 xlMarginBottom">   
        <button class="right round col45" id="addEscapeRoom">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                        8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
            </svg>
        </button>
    </div>

    <div id="content" class="col100 centerH">
        <div class="col100">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col20 sPadding mMarginRight"><strong>Nombre</strong></div>
                <div class="col30 sPadding mMarginRight"><strong>Descripción</strong></div>
                <div class="col10 sPadding mMarginRight"><strong>Dificultad</strong></div>
            </div>
            <div id="escapeRoomsList" class="col100 mPaddingLeft">
                @foreach ($escaperooms as $escaperoom)
                    <div id="escapeRoom{{ $escaperoom->id }}" class="oneEscapeRoom col100 lMarginBottom">
                        <div class="name col20 sPadding mMarginRight">{{ $escaperoom->name }}</div>
                        <div class="description col30 sPadding mMarginRight expand">{{ $escaperoom->description }}</div>
                        <div class="difficulty col10 mMarginRight sPaddingTop"><img class="col100" src="{{ url('img/icons/nivel'.$escaperoom->difficulty.'.svg') }}" alt="{{ $escaperoom->difficulty }}"></div>
                        <div class="col10 sMarginRight mMarginLeft"><button id="{{ $escaperoom->id }}" class="editEscapeRoom col100">Editar</button></div>
                        <div class="col10 sMarginRight"><button id="{{ $escaperoom->id }}" class="configureEscapeRoom col100 bBlack">Configurar</button></div>
                        <div class="col10"><button id="{{ $escaperoom->id }}" class="deleteEscapeRoom col100 delete">Eliminar</button></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('modal')
<!------------------------------- MODAL DE AÑADIR NUEVO ESCAPE ROOM -------------------------------->
<div id="modalNewEscapeRoom" class="window" style="display:none">
    <span class="titleModal col100">NUEVO ESCAPE ROOM</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
        <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
    </svg>
    </button>
    <div class="col100">
        <p class="col100">Nombre</p>
        <input type="text" id="newEscapeRoomName" class="col100">
        <p class="col100">Descripción</p>
        <textarea id="newEscapeRoomDescription" cols="98" rows="5"></textarea>
        <p class="col20 lMarginTop">Dificultad</p>
        <div id="difficultyPointsNewEscapeRoom" class="difficultyPointsEscapeRoom">
            <div id="1" class="col15 difficultyLevel" style="background-color: #8500FF"></div>
            <div id="2" class="col15 difficultyLevel"></div>
            <div id="3" class="col15 difficultyLevel"></div>
            <div id="4" class="col15 difficultyLevel"></div>
            <div id="5" class="col15 difficultyLevel"></div>
        </div>
        <input type="hidden" id="newEscapeRoomLevelSelected" value="1">
    </div>
    <!-- Botones de control -->
    <div class="col100 lMarginTop" style="clear: both;">
        <div class="col100 centerH"><button id="saveNewEscapeRoom" class="col80">Guardar</button> </div>
    </div>
</div>

<!---------------------------- MODAL DE EDITAR ESCAPE ROOM --------------------------------->
<div id="modalUpdateEscapeRoom" class="window" style="display:none">
    <span class="titleModal col100">EDITAR ESCAPE ROOM</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
        <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
    </svg>
    </button>
    <div class="col100">
        <p class="col100">Nombre</p>
        <input type="text" id="updateEscapeRoomName" class="col100">
        <p class="col100">Descripción</p>
        <textarea id="updateEscapeRoomDescription" cols="98" rows="5"></textarea>
        <p class="col20 lMarginTop">Dificultad</p>
        <div id="difficultyPointsUpdateEscapeRoom" class="difficultyPointsEscapeRoom">
            <div id="1" class="col15 difficultyLevel" style="background-color: #8500FF"></div>
            <div id="2" class="col15 difficultyLevel"></div>
            <div id="3" class="col15 difficultyLevel"></div>
            <div id="4" class="col15 difficultyLevel"></div>
            <div id="5" class="col15 difficultyLevel"></div>
        </div>
        <input type="hidden" id="updateEscapeRoomLevelSelected">
        <input type="hidden" id="idUpdateEscapeRoom">
    </div>
    <!-- Botones de control -->
    <div class="col100 lMarginTop" style="clear: both;">
        <div class="col100 centerH"><button id="saveUpdateEscapeRoom" class="col80">Guardar</button> </div>
    </div>
</div>

<!------------------------------ MODAL DE CONFIRMACIÓN DE ELIMINACIÓN ------------------------------->
<div id="modalConfirmDelete" class="window" style="display:none">
    <span class="titleModal col100">¿ELIMINAR ESCAPE ROOM?</span>
    <button id="closeModalWindowButton" class="closeModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
        <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
    </svg>
    </button>
    <div class="col100 centerH xlMarginTop">
        <input type="hidden" id="idEscapeRoomToDelete" >
        <button id="confirmDelete" class="col40 delete lMarginRight">Aceptar</button>
        <button id="cancelDelete" class="col40">Cancelar</button>
    </div>
</div>

<script>
    //RUTAS PARA USAR EN JS EXTERNO
    var token = "{{ csrf_token() }}";
    var newEscapeRoomRoute = "{{ route('escaperoom.store') }}";
    var getOneRoute = "{{ route('escaperoom.getOne', 'req_id') }}";
    var updateEscapeRoomRoute = "{{ route('escaperoom.update', 'req_id') }}";
    var deleteEscapeRoomRoute = "{{ route('escaperoom.destroy', 'req_id') }}";
    var difficultyLevelsUrl = "{{ url('img/icons/lvl') }}";
    var configureEscapeRoomRoute = "{{ route('escaperoom.configure', ['id' => 'escapeRoomId', 'id2' => 'scene']) }}".replace('scene', 0);
    
</script>
@endsection