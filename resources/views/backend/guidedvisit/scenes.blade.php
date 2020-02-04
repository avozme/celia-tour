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
    <div id="contentbutton" class="col100"><input type="submit" value="Añadir"></div>
</form>

<!-- Tabla de escenas -->
<form action="{{ route('guidedVisit.scenesPosition', $guidedVisit->id) }}" method="post">
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
        $(".sortable").sortable({
            // Al cambiar la lista se guardan todos los id en un input hidden
            update: function(){ 
                var ordenElementos = $(this).sortable("toArray").toString();
                $('#position').val(ordenElementos).change();
                document.getElementById("btn-savePosition").disabled = false; 
            },
    
            // Deshabilita los controles del audio ya que se queda pillado al intentar ordenar
            start: function(event, ui){
                $("tr[id="+ui.item[0].id+"] audio").removeAttr("controls");
            },
            
            // Se habilitan los controles de audio
            stop: function(event, ui){
                $("tr[id="+ui.item[0].id+"] audio").attr("controls", "true");
            }
        });
    });
</script>
@endsection