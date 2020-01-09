@extends('layouts/master')

@section('title', 'Listado de usuarios')

@section('content')

<div id="contentbutton" class="col20">
    <form action = "{{route('user.create')}}" method="GET">
        @csrf
        @method("INSERT")
        <input type="submit" value="Insertar usuario">
    </form>
</div>

<div id="title" class="col100">s
    <table border=1>
        <tr>
            <div nombre class="col20">
                <td>Nombre</td>
            </div>
            <div email class="col20">
                <td>E-mail</td>
            </div>
            <div tipo class="col20">
                <td>Tipo</td>
            </div>
            <div modificar class="col20">
                <td>Modificar</td>
            </div>
            <div borrar class="col20">
                <td>Borrar</td>
            </div>
        </tr>
        @foreach($userList as $user) 
            <tr>
                <div nombre class="col20">
                    <td>{{$user->name}}</td>
                </div>
                <div email class="col20">
                    <td>{{$user->email}}</td>
                </div>
                <div tipo class="col20">
                    <td>{{$user->tipo}}</td>
                </div>
                <div modificar class="col20">
                    <td>
                        <form action = "{{route('user.edit', $user->id)}}" method="GET">
                            @csrf
                            <input type="submit" value="Modificar">
                        </form>
                    </td>
                </div>
                <div borrar class="col20">
                    <td>
                        <form action = "{{route('user.destroy', $user->id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </div>
            </tr>
        @endforeach
    </table>
</div>
@endsection