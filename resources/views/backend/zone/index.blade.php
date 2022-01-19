@extends('layouts.backend')

@section('title', 'Admin Zones')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
    <script src="{{url('js/zone/zone.js')}}"></script> 
@endsection

@section('modal')
    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ZONAS -->
<div class="window" id="confirmDelete">
    <span class="titleModal col100">¿Eliminar Zona?</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="confirmDeleteScene col100 xlMarginTop">
        <div class="col50 centerH"><button id="aceptDelete" class="deleteButton col90">Aceptar</button></div>
        <div class="col50 centerH"><button id="cancelDelete" class="col90" >Cancelar</button></div>
    </div>
</div>

<!-- MODAL DE INFORMACIÓN PARA ANTES DE ELIMINAR UNA ZONA CUANDO ESTA CONTIENE ESCENAS -->
<div class="window" id="cancelDeleteForScenes" style="display: none;">
    <span class="titleModal col100">No se puede eliminar la zona seleccionada</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
        <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
    </svg>
    </button>
    <div class="col100 xlMarginTop" style="margin-left: 3.8%">
        <p>Esta zona no puede eliminarse porque contiene escenas.</p>
        <p>Por favor, elimine las escenas antes de eliminar la zona.</p>
        <p>Gracias.</p>
    </div>
    <div class="col100 centerH mMarginTop">
        <button id="aceptCondition" class="col50">Aceptar</button>
    </div>
</div>

<!-- MODAL PARA AÑADIR NUEVA ZONA -->
<div class="window" id="newZoneModal" style="display: none; width: 37%">
    <span class="titleModal col100">Nueva Zona</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
        <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
    </svg>
    </button>
    <div class="col100 xlMarginTop" style="margin-left: 3.8%">
        <div id="title" class="col20"></div>
        <div id="contentbutton"></div>
        <div id="content" class="col100">
            <form id="formAddNewZone" action="{{ route('zone.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required><br><br>
                <label for="file_image">File Image</label>
                <input id="file_image" type="file" name="file_image" required><br><br>
            </form>
        </div>
    </div>
    <div id="errorMessagge" class="col100 mPaddingLeft">
        <span style="font-size: 95%; color: red"></span>
    </div>
    <div class="col100 centerH mMarginTop">
        <input class="col100" type="submit" value="Añadir" form="formAddNewZone">
    </div>
</div>
@endsection

@section('content')
    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>ZONAS ({{ $numberOfZones }})</span>
        <!-- Obtiene el número de zonas que se envía desde ZoneController desde el método index -->
    </div>

    <!-- BOTON AGREGAR -->   
    <div id="contentbutton" class="col20 xlMarginBottom">   
        <button id="addNewZone" class="right round col45">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                        8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
            </svg>                                        
        </button>
    </div>

    <div id="content" class="col100 centerH">
        <div id="table" class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col30"><strong>Nombre</strong></div>
                <div class="col15"><strong>Imagen</strong></div>
                <div class="col15"><strong>Posición</strong></div>
            </div>

            @php
                $count = 1;
            @endphp
            @foreach ($zones as $zone)
                <div id="zone{{ $zone->id }}" class="col100 mPadding">
                    <div class="col30 row15">{{ $zone->name }}</div>
                    <div class="col15 row15"> <img src="{{ url('img/zones/miniatures/'.$zone->file_miniature) }}" alt='file_miniature'> </div>
                    <div class="col15 row15">{{ $zone->position }}</div>
                    <div class="col15 row15"> <input type="button" value="Editar" class="col80" onclick="window.location.href='{{ route('zone.edit', $zone->id) }}'"> </div>
                    <div class="col15 row15"> <input id="{{ $zone->id }}" type="button" value="Eliminar" class="col80 delete"> </div>
                    <!-- Comprueba si hay solo una zona, y si es así no muestra la flecha de ordenar -->
                    @if($numberOfZones > 1) 
                        @if($count == 1)
                            <div class="pointer col5 row15"> <img id="d{{ $zone->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'd'.$zone->id]) }}'"> </div>
                        @else
                            @if($count == $rows)
                                <div class="pointer col5 row15"> <img id="u{{ $zone->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'u'.$zone->id]) }}'"> </div>
                            @else
                                <div class="pointer col5 row15"> <img id="u{{ $zone->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'u'.$zone->id]) }}'"> </div>
                                <div class="pointer col5 row15"> <img id="d{{ $zone->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'd'.$zone->id]) }}'"> </div>
                            @endif
                        @endif
                        @php
                            $count++;
                        @endphp
                    @endif

                </div>
            @endforeach
        </div>
        
    </div>



<script>

    //RUTAS NECESARIAS PARA ARCHIVO EXTERNO .js
    var checkScenesRoute = "{{ route('zone.checkScenes', 'req_id') }}";
    var deleteZoneRoute = "{{ route('zone.delete', 'req_id') }}";
    var indexRoute = "{{ route('zone.index') }}";
    var token = "{{ csrf_token() }}";
    
</script>
@endsection

