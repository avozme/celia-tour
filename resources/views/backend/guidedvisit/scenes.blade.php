@extends('layouts.backend')
@section('content')
<!-- Titulo -->
<div style="clear: both;" id="title" class="col100"> Escenas de la visita guiada </div>

<!-- Añade una escena -->
<form action="{{ route('guidedVisit.scenesStore', $guidedVisit->id) }}" method="post">
    @csrf
    <h5>Escena</h5>
    <select id="scene" name='scene' class="col20">
        @foreach ($scene as $value)
            <option value="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select><br>
    <h5>Recurso</h5>
    <select id="resource" name='resource' class="col20">
        @foreach ($resource as $value)
            <option value="{{ $value->id }}">{{ $value->title }}</option>
        @endforeach
    </select><br>
    <div id="contentbutton" class="col20"><input type="submit" value="enviar"></div>
</form>

<!-- Tabla de escenas -->
<div id="content" class="col100">
    <div class="col10">ID escena</div>
    <div class="col10">ID visita guiada</div>
    <div class="col10">ID recurso</div>
    <div class="col10">Posicion</div>
    <div class="col10">Mover</div>
    <div class="col10">Eliminar</div>
    @foreach ($sgv as $value)
    <div style="clear: both;">
        <div class="col10">{{$value->id_scenes}}</div>
        <div class="col10">{{$value->id_guided_visit}}</div>
        <div class="col10">{{$value->id_resources}}</div>
        <div class="col10">{{$value->position}}</div>
        <div class="col10">mover</div>
        <div class="col10">eliminar</div>
    </div>
    @endforeach
</div>

@endsection