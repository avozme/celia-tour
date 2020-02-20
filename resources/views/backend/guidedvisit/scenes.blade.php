@extends('layouts.backend')
@section('headExtension')

    <!-- Script base del documento -->
    <script src="{{url('js/guidedVisit/scene.js')}}"></script>

    <!-- Recursos de zonas -->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>

    <!-- MDN para usar sortable -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

    <style>
    .resourceSelected {
        animation-name: resourceSelected;
        animation-duration: 500ms;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        animation-direction: alternate;
    }

    @keyframes resourceSelected {
        from {transform: scale(1)}
        to {transform: scale(0.8)}
    }

    </style>
    
@endsection
@section('content')
<!-- Titulo -->
<div style="clear: both;" id="title" class="col100"> Escenas de la visita guiada </div>

<button id="showModal">Añadir escena</button>

<!-- Formulario para guardar posición -->
<form id="addPosition" action="{{ route('guidedVisit.scenesPosition', $guidedVisit->id) }}" method="post">
    @csrf
    <!-- Por defecto null, para saber si mandar petición al servidor -->
    <input id="position" type="text" name="position" value="null" hidden> 
</form>
<button id="btn-savePosition">Guardar posición</button>


<!-- Tabla de escenas -->
<div id="content" class="col100">
    <table class="col100" style="text-align: center;">
        <thead>
            <th>Escena</th>
            <th>Audiodescripción</th>
            <th>Eliminar</th>
        </thead>
        <tbody id="tableContent" class="sortable">
            @foreach ($sgv as $value)
            {{-- Modificar este tr y su contenido afectara a la insercion dinamica mediante ajax --}}
                <tr id="{{ $value->id }}">
                    <td>{{$value->id_scenes}}</td>
                    <td><audio src="{{$value->id_resources}}" controls="true">Tu navegador no soporta este audio</audio></td>
                    <td><button class="btn-delete">Eliminar</button></td>
                </tr>
            {{----------------------------------------------------------------------------------------}}
            @endforeach
        </tbody>
    </table>
</div>

<!------------------------------------------------ Ventanas modales ------------------------------------------------------>
@section('modal')

    <!-- Modal mapa de escenas -->
    <div id="modalZone" class="window" style="display:none">
        <span class="titleModal col100">Escena</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div>
            @include('backend.zone.map.zonemap')        
        </div>
    </div>
    
    <!-- Modal audiodescripciones -->
    <div id="modalResource" class="window" style="display:none">
        <span class="titleModal col100">Audiodescripción</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <!-- Contenido modal -->
        <div> 
            <!-- Contenedor de audiodescripciones -->
            <div style="clear: both;">
            @foreach ($audio as $value)
                <div id="{{ $value->id }}" class="elementResource col25">
                    <div style="cursor: pointer;" class="insideElement">
                        <!-- MINIATURA -->
                        <div class="preview col100">
                                <img src="http://celia-tour.test/img/spectre.png">
                        </div>
                        <div class="titleResource col100">
                            <div class="nameResource col80">
                                {{ $value->title }}
                            </div>
                            <div class="col20">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.9 18.81">
                                        <path class="cls-1" d="M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76" transform="translate(-0.07 0)"></path>
                                    </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <!-- form para guardar la escena -->
            <form id="addsgv" style="clear:both;" action="{{ route('guidedVisit.scenesStore', $guidedVisit->id) }}" method="post">
                @csrf
                <input id="sceneValue" type="text" name="scene" value="" hidden>
                <input id="resourceValue" type="text" name="resource" value="" >
            </form>

            <!-- Botones de control -->
            <div id="actionbutton">
                <div id="acept" class="col20"> <button class="btn-acept">Guardar</button> </div>
            </div>
        </div>
    </div>

@endsection
@endsection