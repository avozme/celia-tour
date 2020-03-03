@extends('layouts/backend')

@section('headExtension')
<!--SCRIPT PARA CERRAR LAS MODALES-->
<script src="{{url('js/closeModals/close.js')}}"></script>    
@endsection

@section('title', 'Listado de usuarios Celia-Tour')

@section('modal')
    <!-- Modal -->  
    <div id="modalDelete" class="window" align='center'>
        <span class="titleModal col100">Confirmar eliminación</span>
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
                    {{ "Desea eliminar este usuario"}}
                </div>
            </form>
            <!-- Botones de control -->
            <div>
                <br><br><br>
            </div>
            <div class="col50" align='center'>
                <button id="btnNo" type="button">No</button>
            </div>
            <div class="col50" align='center'>
                <button id="btnModal" type="button" value="Eliminar">Si</button>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div id="title" class="col80"><h1>Tabla de usuarios</h1></div>

    <div id="contentbutton" class="col20">
        <button type="button" value="Insertar Usuario" onclick="window.location.href='{{ route('user.create')}}'">Insertar Usuario</button>
    </div>

    <div id="content" class="col100">

        <div class="col20" align='center'>Nombre</div>
        <div class="col20" align='center'>E-mail</div>
        <div class="col20" align='center'>Tipo</div>
        <div class="col20" align='center'>Modificar</div>
        <div class="col20" align='center'>Borrar</div>
        
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
            
            <div class="col20" align='center'>{{$user->name}}</div>
            <div class="col20" align='center'>{{$user->email}}</div>
            <div class="col20" align='center'>{{$valor}}</div>
            <div class="col20" align='center'>
                <button type="button" value="Modificar" onclick="window.location.href='{{ route('user.edit', $user->id) }}'">Modificar</button>
            </div>
            <div class="col20" align='center'>
                <button id="btnEliminar" class="delete" type="button" value="Eliminar" onclick="borrarUsuario( '/user/destroy/{{$user->id}}' )">Eliminar</button>
            </div>
        @endforeach
    </div>

    <script>
        function borrarUsuario(ruta){
            $("#modalWindow").css("display", "block");
            $("#ventanaModal").css("display", "block");
            $("#btnModal").attr("onclick", "window.location.href='"+ ruta +"'");
        }
      
        $(document).ready(function() {
            $("#btnNo").click(function(){
                $("#modalWindow").css("display", "none");
                $("#ventanaModal").css("display", "none");
            });
        });
    </script>
@endsection