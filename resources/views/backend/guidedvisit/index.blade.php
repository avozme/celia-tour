@extends('layouts.backend')
@section('content')
    <div id="title" class="col80">Visitas guiadas</div>
    <div id="contentbutton" class="col20">
        <button>
            <a href="{{route('guidedVisit.create')}}">Añadir</a>
        </button>
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
            <div class="col10"><button><a href="{{ route('guidedVisit.scenes', $value->id) }}">Escenas</a></button></div>
            <div class="col10"><button><a href="{{ route('guidedVisit.edit', $value->id) }}">Modificar</a></button></div>
            <div class="col10"><button class="btn-delete" id="{{$value->id}}">Eliminar</button></div>
        </div>
        @endforeach
    </div>
    <script>
        $(function() {
            $(".btn-delete").click(function(){
            var isDelte = confirm("¿Desea eliminar esta visita guiada?");
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
                var direccion = "http://celia-tour.test/guidedVisit/delete/"+id;
                xhttp.open("GET", direccion, true);
                xhttp.send();
            }
            });
        });
    </script>    
@endsection