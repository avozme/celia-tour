@extends('layouts.backend')
@section('content')
    <h2>Administración de recursos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titlo</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Ruta</th>
                <th>Eliminar</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resources )
                <tr>
                <td>{{$resources->id}}</td>
                <td>{{$resources->title}}</td>
                <td>{{$resources->description}}</td>
                <td>{{$resources->type}}</td>
                <td>{{$resources->route}}</td>
                <td><span><a id="{{$resources->id}}" class="delete">Eliminar</a></span> </td>
                <td> <a href='/resources/{{$resources->id}}/edit'>Modificar</a> </td>
                </tr>        
            @endforeach
        </tbody>
    </table>
    <form action="/resources" method="post" enctype="multipart/form-data">
    @csrf
        <br /> Titlo:<br /> <input type='text' name='title'><br />
        <br /> Descripción:<br /> <input type='text' name='description'><br />
        <br /> Tipo:<br /> <input type='text' name='type'><br />
        <br /> Ruta:<br /> <input type='text' name='route'><br />
        <br /> <input type="submit" value="Añadir Recurso">
    </form>
    <script>
    $(function(){
        //.delete es el nombre de la clase
        //peticion_http es el objeto que creamos de Ajax
        $(".delete").click(function(){
            id = $(this).attr("id");
            elementoD = $(this);
            var confirmacion = confirm("¿Esta seguro de que desea eliminarlo?")
            if(confirmacion){
            $.get('http://celia-tour.test/resources/delete/'+id, function(respuesta){
                 $(elementoD).parent().parent().parent().remove();
            });
            }
        })
    })
</script>
@endsection