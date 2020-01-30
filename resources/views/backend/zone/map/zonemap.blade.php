<!--
Vista a la que se llega a través de la función 'map' del ZoneController.
zone/{id}/zonemap
Muestra el mapa de la zona con las escenas que esta tenga.
El id de la escena se encuenta en el id de cada punto del mapa el cual
está formado de la siguiente forma: scene{id_scene}.
-->

@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>
@endsection

@section('content')
<div id="addScene" style="width: 900px; height: auto; border: 1px solid red;position: relative;">
    <div id="zoneicon" class="icon" style="display: none">
        <img class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
    </div>
    @foreach ($scenes as $scene)
        <div class="icon" style="top: {{ $scene->top }}; left: {{ $scene->left }};">
            <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
        </div>
    @endforeach
    <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
    <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
    <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}" alt="">
</div>
@endsection