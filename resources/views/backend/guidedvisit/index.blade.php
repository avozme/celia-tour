@extends('layouts.backend')
@section('content')
    <h2>Administración de visitas guiadas</h2>
    <a href="{{route('guidedVisit.create')}}">Añadir</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Archivo</th>
                <th colspan="2">Herramientas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guidedVisit as $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->description}}</td>
                <td>{{$value->file_preview}}</td>
                <td><a href="{{ route('guidedVisit.edit', $value->id) }}">Modificar</a></td>
                <td><span class="delete" id="{{$value->id}}">Eliminar<span></td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    <script>
        $(function() {
            $("#delete").click(function(){
            var isDelte = confirm("¿Esta seguro que desea eliminar la visita guiada?");
            if(isDelte){
                var domElement = $(this);
                var id = $(this).attr("id");
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){ 
                        if (xhttp.responseText == 1) {
                            $(domElement.parent()).fadeOut(500, function(){
                                $(domElement).parent().remove();
                            });
                        } else {
                            alert("Algo fallo!");
                        }
                    }
                }
                var direccion = "http://localhost:3000/guidedVisit/delete/"+id;
                xhttp.open("GET", direccion, true);
                xhttp.send();
            }
            });
        });
    </script>    
@endsection