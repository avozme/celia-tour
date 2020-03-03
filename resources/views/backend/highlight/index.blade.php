@extends('layouts.backend')

@section('headExtension')
<!--SCRIPT PARA CERRAR LAS MODALES-->
<script src="{{url('js/closeModals/close.js')}}"></script>    
@endsection

@section('title', 'Zonas Destacadas Celia-Tour')

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
            <form id="formadd" action="{{ route('highlight.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100"> 
                    {{ "Desea eliminar esta zona destacada"}}
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

    <div id="title" class="col80"><h1>Zonas Destacadas</h1></div>

    <div id="contentbutton" class="col20">
        <button type="button" value="Insertar Zona Destacada" onclick="window.location.href='{{ route('highlight.create')}}'">Insertar Zona Destacada</button>
    </div>

    <div id="content" class="col100">
        <div id="table" class="col80">
            <div class="col10" align='center'>Posicion</div>
            <div class="col10" align='center'>Id</div>
            <div class="col20" align='center'>Titulo</div>
            <div class="col25" align='center'>Imagen</div>
            <div class="col15" align='center'>Modificar</div>
            <div class="col15" align='center'>Eliminar</div>

            @php
                $cont = 1;   
            @endphp
                
            @foreach($highlightList as $highlight)
                <div class="col10" align='center'>{{$highlight->position}}</div>
                <div class="col10" align='center'>{{$highlight->id}}</div>
                <div class="col20" align='center'>{{$highlight->title}}</div>
                <div class="col25" align='center'>
                    <img style="width: 30; height: 30px" src='{{ url('img/highlights/miniaturas/'.$highlight->scene_file)}}'>
                </div>
                <div class="col15" align='center'>
                    <button type="button" value="Modificar" onclick="window.location.href='{{ route('highlight.edit', $highlight->id) }}'">Modificar</button>
                </div>
                <div class="col15" align='center'>
                    <button class="delete" type="button" value="Eliminar" onclick="borrarHL('/highlight/delete/{{$highlight->id}}')">Eliminar</button>
                </div>
                
                @if($cont == 1)
                    <div class="col5"> <img id="d{{ $highlight->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'd'.$highlight->id]) }}'"> </div>
                @else
                    @if($cont == $rows)
                        <div class="col5"> <img id="u{{ $highlight->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'u'.$highlight->id]) }}'"> </div>
                    @else
                        <div class="col5"> <img id="u{{ $highlight->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'u'.$highlight->id]) }}'"> </div>
                        <div class="col5"> <img id="d{{ $highlight->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'd'.$highlight->id]) }}'"> </div>
                    @endif
                @endif
                @php
                    $cont++;
                @endphp
            @endforeach
        </div>
    </div>

    <script>
        function borrarHL(ruta){
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