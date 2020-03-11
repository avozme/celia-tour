@extends('layouts/backend')

@section('title', 'Nuevo usuario | Celia-Tour')

@section('content')
    @isset($user)
        <div id="title" class="col80"><span>EDITAR USUARIO</span></div>
    @else
        <div id="title" class="col80"><span>NUEVO USUARIO</span></div>
    @endisset

    <div id="content" class="col100 centerH">
        @isset($user)
            <form action="{{ route('user.update', ['id' => $user->id])}}" method="post" class="col45">
            @method("put")
        @else
            <form action="{{ route('user.store')}}" method='post' class="col45">
        @endisset
                @csrf
                <label class="col100 xlMarginTop">Nombre<span class="req">*<span></label>
                <div class="col100"><input type='text' name='name' class="sMarginTop col100" value="{{$user->name ?? ''}}" required></div>
                <label class="col100 sMarginTop">Contraseña<span class="req">*<span></label>
                <div class="col100"><input type='password' class="sMarginTop col100" id="password" name='password' autocomplete="on" value=""><span id="pwError"></span></div>
                <label class="col100 sMarginTop">Repetir contraseña<span class="req">*<span> </label>
                <div class="col100"><input type='password' class="sMarginTop col100" id="password2" name='password2' autocomplete="on" value=""><span id="msmError"></span></div>
                <label class="col100 sMarginTop">E-mail<span class="req">*<span></label>
                <div  class="col100"><input type='email' name='email' class="sMarginTop col100" value="{{$user->email ?? ''}}" required></div>
                <label class="col100 sMarginTop">Tipo<span class="req">*<span></label>
                <div>
                    <select name='type' class="col100" style="height:30px; border-radius">
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
                <button type='submit' class="col100 xlMarginTop" value='Aceptar' onclick="comfirmarPassword()">Aceptar</button>
            </form>
    </div>
    <script>
        
        function comfirmarPassword(){

            check = true;
            pw1 = document.getElementById("password").value;
            pw2 = document.getElementById("password2").value;
            var expresion = "^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$".test(pw1);
            
            //Minimo 8 caracteres, Al menos una letra mayúscula, Al menos una letra minucula, Al menos un dígito, No espacios en blanco, Al menos 1 caracter especial
            if (expresion)
                if (pw2.value != pw1.value){
                    event.preventDefault();
                    document.getElementById("msmError").innerHTML = " Las contraseñas no coinciden";
                    check = false;
                }else {
                    check = true;
                }
                check = true;
            } else{
                event.preventDefault();
                document.getElementById("pwError").innerHTML = " La contraseña no es segura";
                check = false;
            }
            return check;
        }
    </script>
@endsection