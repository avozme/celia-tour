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
                <td>Modificar</td>
                <td>Eliminar</td>
            </tr>
            @endforeach
            
        </tbody>
    </table>

@endsection