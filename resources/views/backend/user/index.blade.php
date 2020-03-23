@extends('layouts/backend')

@section('headExtension')
<!--SCRIPT PARA CERRAR LAS MODALES-->
<script src="{{url('js/closeModals/close.js')}}"></script>    
<script src="{{url('js/user/user.js')}}"></script> 
@endsection

@section('title', 'Listado de usuarios Celia-Tour')

@section('modal')
    <!-- MODAL DE ELIMINAR USUARIO -->  
    <div id="modalDelete" class="window" align='center'>
        <span class="titleModal col100">ELIMINAR USUARIO</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div>
            <br><br>
        </div>
        <div>
            <form id="formadd" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100"> 
                    ¿Desea eliminar este usuario del sistema?
                </div>
            </form>
            <!-- Botones de control -->
            <div class="col50 mPaddingRight xlMarginTop">
                <button id="btnModal" type="button" value="Eliminar" class="col100">Aceptar</button>
            </div>
            <div class="col50 mPaddingLeft xlMarginTop">
                <button id="btnNo" type="button" class="col100">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- MODAL DE AÑADIR NUEVO USUARIO -->
    <div class="window sizeWindow40" id="newUserModal" style="display: none;">
        <span id="modalTitle" class="titleModal col100">AÑADIR NUEVO USUARIO</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div class="col100 MMarginTop">
            <div id="title" class="col20"></div>
            <div id="contentbutton"></div>
            <div id="content" class="col100">
                <form id="addNewUserForm" action="{{ route('user.store')}}" method='post' class="col90"  style="margin-left: 4%">
                    @csrf
                    <label class="col100 sMarginTop">Nombre</label>
                    <div class="col100"><input type='text' name='name' class="sMarginTop col100" required></div>
                    <label class="col100 sMarginTop">Contraseña</label>
                    <div class="col100"><input type='password' class="sMarginTop col100" id="password" name='password' autocomplete="on" required></div>
                    <label class="col100 sMarginTop">Repetir contraseña </label>
                    <div class="col100"><input type='password' class="sMarginTop col100" id="password2" name='password2' autocomplete="on" required><span id="msmError"></span></div>
                    <label class="col100 sMarginTop">E-mail</label>
                    <div  class="col100"><input id="email" type='email' name='email' class="sMarginTop col100" required></div>
                    <label class="col100 sMarginTop">Tipo</label>
                    <div class="col100 mMarginBottom">
                        <select class="col100" name="type">
                            <option value="1" selected>Admin</option>
                            <option value="0">Pendiente de Asignación</option>
                        </select>
                    </div>
                    <div class="col100"><span id="errorMesagge"></span></div>
                </form>
                <div id="submitAddNewUserForm" class="col100 xlMarginTop">
                    <button type='submit' class="col100" value='Aceptar' form="addNewUserForm">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div></div>
<span></span>

    <div id="title" class="col80"><span>USUARIOS</span></div>

    <div id="addNewUser" class="col20 xlMarginBottom">
        <button type="button" class="right round col45">
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                </svg>
        </button>
    </div>

    <div id="content" class="col100 centerH">
        <div class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col20 sPadding"><strong>Nombre</strong></div>
                <div class="col25 sPadding"><strong>E-mail</strong></div>
                <div class="col25 sPadding"><strong>Rol</strong></div>
            </div>

            @foreach($userList as $user) 
                @if ($user->type == 0)
                    @php 
                        $valor = "Pendiente de Asignación" 
                    @endphp
                @elseif($user->type == 1) 
                    @php 
                        $valor = "Admin" 
                    @endphp
                @endif
                <div class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                    <div class="col20 sPadding">{{$user->name}}</div>
                    <div class="col25 sPadding">{{$user->email}}</div>
                    <div class="col15 sPadding">{{$valor}}</div>
                    <div class="col15 sPadding">
                        <button type="button" value="Modificar" class="col100" onclick="window.location.href='{{ route('user.edit', $user->id) }}'">Modificar</button>
                    </div>
                    <div class="col15 sPadding">
                        <button id="btnEliminar" class="delete col100" type="button" value="Eliminar" onclick="borrarUsuario('{{route('user.destroy',$user->id)}}')">Eliminar</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function borrarUsuario(ruta){
            $("#modalWindow").css("display", "block");
            $("#ventanaModal").css("display", "block");
            $("#btnModal").attr("onclick", "window.location.href='"+ ruta +"'");
        }
    </script>
    <style>
        #btnModal{
            background-color: rgb(255, 87, 87);
        }
        #error{
            color: red;
            font-size: 97%;
        }
    </style>
@endsection