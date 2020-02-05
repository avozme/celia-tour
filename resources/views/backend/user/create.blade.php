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
        Nombre: 
        <div>
            <input type='text' name='name' value="{{$user->name ?? ''}}">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div>
        Contraseña: 
        <div>
            <input type='password' name='password' value="{{$user->password ?? ''}}">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div>
        E-mail: 
        <div>
            <input type='email' name='email' value="{{$user->email ?? ''}}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div>
        Tipo:
            <div>
                <select name='type'>
                    @if(isset($user))
                        @if ($user->type == 0)
                            <option value="0" selected>Pendiente de Asignación</option>
                            <option value="1">Admin</option>
                        @elseif ($user->type == 1)
                            <option value="0">Pendiente de Asignación</option>
                            <option value="1" selected>Admin</option>
                        @endif
                    @else
                        <option value="0">Pendiente de Asignación</option>
                        <option value="1">Admin</option>
                    @endif
                </select><br><br>
            </div>
        <input type='submit' value='Aceptar'>
    </form>
@endsection