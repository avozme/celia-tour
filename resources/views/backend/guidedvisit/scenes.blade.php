@extends('layouts.backend')
{{-- @extends('backend.zone.map.zonemap') --}}
@section('headExtension')

    <!-- MDN para usar sortable -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

    <script src="{{url('js/guidedVisit/scene.js')}}"></script>

    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>
    
@endsection
@section('content')
<!-- Titulo -->
<div style="clear: both;" id="title" class="col100"> Escenas de la visita guiada </div>

<!-- Genera la vista de zonas -->
{{-- <div class="col50">
    {!! $zone !!}
</div> --}}

<!-- Añade una escena -->
{{-- <form action="{{ route('guidedVisit.scenesStore', $guidedVisit->id) }}" method="post">
    @csrf
    
    <h5>Escena</h5>
    <select id="scene" name='scene' class="col20">
        @foreach ($scene as $value)
            <option value="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select>
    
    <br>

    <h5>Audiodescripción</h5>
    <select id="resource" name='resource' class="col20">
        @foreach ($audio as $value)
            <option value="{{ $value->id }}">{{ $value->title }}</option>
        @endforeach
    </select>

    <br>

    <div id="contentbutton" class="col100"><input type="submit" value="Añadir"></div>
</form> --}}

<button id="showModal">Mapa</button>

<!-- Tabla de escenas -->
<form style="clear: both;" action="{{ route('guidedVisit.scenesPosition', $guidedVisit->id) }}" method="post">
    @csrf
    <input id="position" type="text" name="position" hidden>
    <input id="btn-savePosition" type="submit" value="Guardar posición" disabled>
</form>

<div id="content" class="col100">
    <table class="col100" style="text-align: center;">
        <thead>
            <th>Escena</th>
            <th>Audiodescripción</th>
            <th>Eliminar</th>
        </thead>
        <tbody class="sortable">
            @foreach ($sgv as $value)
                <tr id="{{ $value->id }}">
                    <td>{{$value->id_scenes}}</td>
                    <td><audio src="{{$value->id_resources}}" controls="true">Tu navegador no soporta este audio</audio></td>
                    <td><button class="btn-delete" id="{{$value->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!------------------------------------------------ Ventanas modales ------------------------------------------------------>
@section('modal')
    <!-- Modal mapa de escenas -->
    <div id="modalZone">
        @include('backend.zone.map.zonemap')
    </div>

    <!-- Modal audiodescripciones -->
    <div id="modalResource" style="display: none;">

        <p>Inserte audiodescripción aqui</p>

        <form action="{{ route('guidedVisit.scenesStore', $guidedVisit->id) }}" method="post">
            @csrf
            <input id="sceneValue" type="text" name="scene" value="">
            <input id="resourceValue" type="text" name="resource" value="">
        </form>

        <div id="actionbutton">
            <div id="acept" class="col10"> <button class="btn-acept">Aceptar</button> </div>
            <div id="cancel" class="col10"> <button class="btn-cancel">Cancelar</button> </div>
        </div>

    </div> 
@endsection
@endsection