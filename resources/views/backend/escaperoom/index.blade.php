@extends('layouts.backend')

@section('headExtension')
    <script src="{{url('js/escaperoom/index.js')}}"></script>
@endsection

@section('content')
    <div id="title" class="col80 mMarginBottom">
        <span>ESCAPE ROOM</span>
    </div>

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
            <div class="col100 mPaddingLeft">
                @foreach ($escaperooms as $escaperoom)
                    <div class="col20 sPadding mMarginRight">{{ $escaperoom->name }}</div>
                    <div class="col30 sPadding mMarginRight expand">{{ $escaperoom->description }}</div>
                    <div class="col10 sPadding mMarginRight">{{ $escaperoom->difficulty }}</div>
                    <div class="col15"><button id="{{ $escaperoom->id }}" class="editEscapeRoom col80">Editar</button></div>
                    <div class="col15"><button id="{{ $escaperoom->id }}" class="deleteEscapeRoom col80 delete">Eliminar</button></div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('modal')
<div id="modalNewEscapeRoom" class="window" style="display:none">
    <span class="titleModal col100">NUEVA PREGUNTA</span>
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
        <p class="col40">Dificultad</p>
        <select id="newEscapeRoomDifficulty" name="newEscapeRoomDifficulty" class="col60">
            <option value="0">Selecciona un nivel de dificultad</option>
            <option value="1" style="background-image:url('{{ url('img/icons/nivel1.svg') }}');"></option>

        </select>
    </div>
    <!-- Botones de control -->
    <div id="actionbutton" class="col100 lMarginTop" style="clear: both;">
        <div id="acept" class="col100 centerH"><button id="btn-saveNew" class="col70">Guardar</button> </div>
    </div>
</div>
@endsection