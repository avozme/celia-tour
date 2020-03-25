@extends('layouts.backend')
@section('headExtension')

    <!-- URL GENERADAS PARA SCRIPT -->
    <script>
        // Para las urls con identificador se asignara 0 por defecto para posteriormente modificar ese valor.
        const urlResource = "{{ url('/img/resources') }}/";
        const urlDelete = "{{ route('guidedVisit.deleteScenes', 'insertIdHere') }}";
        const urlAdd = "{{ route('guidedVisit.scenesStore', $guidedVisit->id) }}";
    </script>


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
    /* ANIMACION PARA RECURSOS SELECCIONADOS */
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

    /* ZONAS DE LA VENTANA MODAL */
    #modalportkey{
        width: 60%;
    }
    .addScene{
        width: 85%;
    }
    #changeZone{
        top: 69.3%;
        left: 85%;
    }
    #floorUp, #floorDown{
        width: 150%;
    }
    .closeModalButton {
        display: none;
    }
    </style>
    
@endsection
@section('content')
 <!-- TITULO -->
 <div id="title" class="col70 xlMarginBottom">
    <span>Escenas de {{ $guidedVisit->name }}</span>
</div>

<!-- BOTON AGREGAR -->   
<div id="contentbutton" class="col30 xlMarginBottom">    
    <button class="right round col45 mMarginLeft" id="showModal">
        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
            <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                    8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
        </svg>                                        
    </button>
    <button id="btn-savePosition" class="right" style="margin-top: 12px;">GUARDAR POSICIONES</button>
</div>

<!-- Formulario para guardar posición -->
<form id="addPosition" action="{{ route('guidedVisit.scenesPosition', $guidedVisit->id) }}" method="post" style="display: none;">
    @csrf
    <!-- Por defecto null, para saber si mandar petición al servidor -->
    <input id="position" type="text" name="position" value="null" hidden> 
</form>




<!-- Tabla de escenas -->
<div id="content" class="col100 centerH">
    <table class="col90" style="text-align: left;">
        <thead class="col100">
            <tr class="col100">
                <th class="mPaddingBottom sPadding col20">Escena</th>
                <th class="mPaddingBottom sPadding col60">Audiodescripción</th>
            </tr>
        </thead>
        <tbody id="tableContent" class="sortable col100">
            @foreach ($sgv as $value)
            {{-- Modificar este tr y su contenido afectara a la insercion dinamica mediante ajax --}}
                <tr id="{{ $value->id }}" class="col100">
                    <td class="sPadding col20">{{$value->id_scenes}}</td>
                    <td class="sPadding col60"><audio src="{{$value->id_resources}}" controls="true" class="col100">Tu navegador no soporta este audio</audio></td>
                    <td class="sPadding col20" style="text-align: right;"><button class="btn-delete delete">Eliminar</button></td>
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
        <div class="mMarginTop"> 
            <!-- Contenedor de audiodescripciones -->
            <div id="audioDescrip" class="xlMarginTop col100">
            @foreach ($audio as $value)
                <div id="{{ $value->id }}" class="elementResource col25 tooltip">
                    {{-- Descripcion si la tiene --}}
                    @if($value->description!=null)
                        <span class="tooltiptext">{{$value->description}}</span>
                    @endif

                    <div style="cursor: pointer;" class="insideElement">
                        <!-- MINIATURA -->
                        <div class="preview col100">
                                <img src="{{ url('/img/spectre.png') }}">
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
            <form id="addsgv" style="display:none;">
                @csrf
                <input id="sceneValue" type="text" name="scene" value="" hidden>
                <input id="resourceValue" type="text" name="resource" value="" hidden>
            </form>

            <!-- Botones de control -->
            <div id="actionbutton" style="clear:both;" class="lMarginTop col100">
                <div id="acept" class="col20"> <button class="btn-acept col100">Guardar</button> </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
    <div class="window" id="confirmDelete" style="display: none;">
        <span class="titleModal col100">¿Eliminar escena?</span>
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


    
@endsection