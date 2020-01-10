@extends('layouts/backend')

@section('title', 'insertar usuarios Celia-Tour')

@section('content')
    @isset($user)
        <form action="{{ route('user.update', ['id' => $user->id])}}" method="post">
        @method("put")
    @else
        <form action="{{ route('user.store')}}" method='post'>
    @endisset
        @csrf
        Nombre:<br> <input type='text' name='name' value="{{$user->name ?? ''}}"><br>
        Contraseña:<br> <input type='password' name='password' value="{{$user->password ?? ''}}"><br>
        E-mail:<br> <input type='email' name='email' value="{{$user->email ?? ''}}"><br>
        Tipo:<br>
            <select name='type'>
                <option value="0">Pendiente de Asignacion</option>
                <option value="1">Admin</option>
            </select><br><br>
        <input type='submit' value='Aceptar'>
    </form>
@endsection