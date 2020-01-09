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
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resources )
                <tr>
                <td>{{$resources->id}}</td>
                <td>{{$resources->title}}</td>
                <td>{{$resources->desceiption}}</td>
                <td>{{$resources->type}}</td>
                <td>{{$resources->ruute}}</td>
                </tr>        
            @endforeach
        </tbody>
    </table>

@endsection