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
            <div><input type='text' name='name' value="{{$user->name ?? ''}}" required><div>
            Contraseña: 
            <div><input type='password' id="password" name='password' autocomplete="on" value="" required><div>
            Confirmar contraseña: 
            <div><input type='password' id="password2" name='password2' autocomplete="on" value="" required><span id="mensaje"></span><div>
            E-mail: 
            <div><input type='email' name='email' value="{{$user->email ?? ''}}" required><div>
            Tipo:
            <div>
                <select name='type' >
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
                </select>
            </div><br>
            <button type='submit' value='Aceptar' onclick="comfirmarPassword()">Aceptar</button>
        </form>

    <script>
        
        function comfirmarPassword(){

            check = true;
            pw1 = document.getElementById("password");
            pw2 = document.getElementById("password2");
            
            if (pw2.value != pw1.value){
                event.preventDefault();
                document.getElementById("mensaje").innerHTML = " Las contraseñas no coinciden";
                check = false;
            }else {
                check = true;
            }
            return check;
        }
    </script>
@endsection