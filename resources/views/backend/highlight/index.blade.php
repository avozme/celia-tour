@extends('layouts.backend')

@section('headExtension')
<!--SCRIPT PARA CERRAR LAS MODALES-->
<script src="{{url('js/closeModals/close.js')}}"></script>    
@endsection

@section('title', 'Zonas Destacadas Celia-Tour')

@section('modal')
    <!-- Modal -->  
    <div id="modalDelete" class="window">
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
                    ¿Desea eliminar esta zona destacada del sistema?
                </div>
            </form>
            <!-- Botones de control -->
            <div class="col50 mPaddingRight xlMarginTop">
                <button id="btnNo" type="button" class="col100 bBlack">Cancelar</button>
            </div>
            <div class="col50 mPaddingLeft xlMarginTop">
                <button id="btnModal" type="button" value="Eliminar" class="col100">Aceptar</button>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>PUNTOS DESTACADOS</span>
    </div>

    <div id="contentbutton" class="col20 xlMarginBottom">
        <button type="button" class="right round col45" onclick="window.location.href='{{ route('highlight.create')}}'">
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                    <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
                </svg>
        </button>
    </div>

    <div id="content" class="col100 centerH">
        <div class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col20"><strong>Titulo</strong></div>
                <div class="col25"><strong>Imagen</strong></div>
                <div class="col15"><strong>Posicion</strong></div>
            </div>

            @php
                $cont = 1;   
            @endphp
                
            @foreach($highlightList as $highlight)
                <div class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                    <div class="col20 sPadding">{{$highlight->title}}</div>
                    <div class="col25 sPadding">
                        <img class="col50" src='{{url('img/resources/'.$highlight->scene_file)}}'>
                    </div>
                    <div class="col15 sPadding">{{$highlight->position}}</div>
                    <div class="col15 sPadding">
                        <button type="button" class="col80" value="Modificar" onclick="window.location.href='{{ route('highlight.edit', $highlight->id) }}'">Modificar</button>
                    </div>
                    <div class="col15 sPadding">
                        <button class="delete col80" type="button" value="Eliminar" onclick="borrarHL('/highlight/delete/{{$highlight->id}}')">Eliminar</button>
                    </div>
                    
                    @if($cont == 1)
                        <div class="col5"> <img id="d{{ $highlight->position }}" src="{{ url('img/icons/down.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'd'.$highlight->id]) }}'"> </div>
                    @else
                        @if($cont == $rows)
                            <div class="col5"> <img id="u{{ $highlight->position }}" src="{{ url('img/icons/up.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'u'.$highlight->id]) }}'"> </div>
                        @else
                            <div class="col5"> <img id="u{{ $highlight->position }}" src="{{ url('img/icons/up.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'u'.$highlight->id]) }}'"> </div>
                            <div class="col5"> <img id="d{{ $highlight->position }}" src="{{ url('img/icons/down.png') }}" width="15px" onclick="window.location.href='{{ route('highlight.updatePosition', ['opc' => 'd'.$highlight->id]) }}'"> </div>
                        @endif
                    @endif
                    @php
                        $cont++;
                    @endphp
                </div>
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