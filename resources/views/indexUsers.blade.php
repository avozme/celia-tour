@extends('layouts/master')

@section('title', 'Listado de usuarios')

@section('content')

<form action = "{{route('user.create')}}" method="GET">
    @csrf
    @method("INSERT")
    <input type="submit" value="Insertar usuario">
</form>

<table border=1>
    <tr>
        <td>Nombre</td>
        <td>E-mail</td>
        <td>Tipo</td>
        <td>Modificar</td>
        <td>Borrar</td>
    </tr>
    @foreach($userList as $user) 
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->tipo}}</td>
            <td>
                    <form action = "{{route('user.edit', $user->id)}}" method="GET">
                        @csrf
                        <input type="submit" value="Modificar">
                    </form>
            </td>
            <td>
                <form action = "{{route('user.destroy', $user->id)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td>E-mail</td>
            <td>Tipo</td>
            <td>Modificar</td>
            <td>Borrar</td>
        </tr>
    @endforeach
</table>
@endsection