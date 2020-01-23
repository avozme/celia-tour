@extends('layouts.backend')
@section('headExtension')
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>
@endsection
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
    <h5>Audiodescripción</h5>
    <select id="resource" name='resource' class="col20">
        @foreach ($audio as $value)
            <option value="{{ $value->id }}">{{ $value->title }}</option>
        @endforeach
    </select><br>
    <div id="contentbutton" class="col20"><input type="submit" value="Añadir"></div>
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
    <div  style="clear: both;">
        <div class="col10">{{$value->id_scenes}}</div>
        <div class="col10">{{$value->id_guided_visit}}</div>
        <div class="col10">{{$value->id_resources}}</div>
        <div class="col10">{{$value->position}}</div>
        <div class="col10">mover</div>
        <div class="col10"><button class="btn-delete" id="{{$value->id}}">Eliminar</button></div>
    </div>
    @endforeach
</div>
<script>
    $(function() {
        $(".btn-delete").click(function(){
        var isDelte = confirm("¿Desea eliminar la escena de la visita guiada?");
        if(isDelte){
            var domElement = $(this);
            var id = $(this).attr("id");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){ 
                    if (xhttp.responseText == 1) {
                        $(domElement.parent().parent()).fadeOut(500, function(){
                            $(domElement).parent().parent().remove();
                        });
                    } else {
                        alert("Algo fallo!");
                    }
                }
            }
            var direccion = "http://celia-tour.test/guidedVisit/deleteScenes/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
        });
    });
</script>
@endsection