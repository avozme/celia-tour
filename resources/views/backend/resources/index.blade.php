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
                <th>Editar</th>
                <th>Eliminar</th>
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
                <td> <a href='/resources/{{$resources->id}}/delete'>Eliminar</a> </td>
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
@endsection