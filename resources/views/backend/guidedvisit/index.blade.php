@extends('layouts.backend')
@section('headExtension')
    <script src="{{url('js/guidedVisit/index.js')}}"></script>
@endsection
@section('content')
    <div id="title" class="col80">Visitas guiadas</div>
    <div id="contentbutton" class="col20">
        <button onclick="window.location.href='{{ route('guidedVisit.create') }}'">Añadir</button>
    </div>
    <div id="content" class="col100">
        <div class="col5">ID</div>
        <div class="col15">Nombre</div>
        <div class="col30">Descripción</div>
        <div class="col20">Vista previa</div>
        <div class="col10">Escenas</div>
        <div class="col10">Modificar</div>
        <div class="col10">Eliminar</div>
        @foreach ($guidedVisit as $value)
        <div style="clear: both;">
            <div class="col5">{{$value->id}}</div>
            <div class="col15">{{$value->name}}</div>
            <div class="col30">{{$value->description}}</div>
            <div class="col20"><img src="/img/guidedVisit/miniatures/{{$value->file_preview}}"></div>
            <div class="col10"><button onclick="window.location.href='{{ route('guidedVisit.scenes', $value->id) }}'">Escenas</button></div>
            <div class="col10"><button onclick="window.location.href='{{ route('guidedVisit.edit', $value->id) }}'">Modificar</button></div>
            <div class="col10"><button class="btn-delete" id="{{$value->id}}">Eliminar</button></div>
        </div>
        @endforeach
    </div>
@endsection