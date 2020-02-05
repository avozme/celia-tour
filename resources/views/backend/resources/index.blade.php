@extends('layouts.backend')
@section('content')
    <div id="title" class="col80">
        Administración de recursos
    </div>
    <div id="contentbutton" class="col20">
        <input type="button" value="Añadir Recursos">
        <input type="button" value="Añadir Video">
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="content" class="col100">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dropzone.css')}}">
    <!-- JS -->
    <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script>
    <!--Ventana modal para añadir recursos-->
    <!-- Dropzone -->
    <div id="contentmodal">
        <div id="windowsmodarl">
    <form action="{{ url('/images-save') }}" method="post" enctype="multipart/form-data" class='dropzone' >
      </form>
      <input type="button" value="Actualizar" onclick="window.location.href='/resources'">
    </div>
</div>
    <!-- Script -->
    <script>
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone",{ 
            maxFilesize: 3,  // 3 mb
            acceptedFiles: ".jpeg,.jpg,.png, .pdf, .docx, .mp3, .wav",
        });
        myDropzone.on("sending", function(file, xhr, formData) {
           formData.append("_token", CSRF_TOKEN);
        }); 
        </script>
    </div>
    <div id="content" class="col100">
                <div class="col25">Titlo</div>
                <div class="col25">Miniatura</div>
                <div class="col25">Eliminar</div>
                <div class="col25">Editar</div>
            @foreach ($resources as $resources )
                <div id="{{$resources->id}}" style="clear:both;">
                    <div class="col25">{{$resources->title}}</div>
                    <div class="col25">
                        @if( $resources->type == "image")
                            <img src={{$resources->route}} weigth="100px" height="100px"></i>
                        @elseif($resources->type == "audio")  
                            <audio src={{$resources->route}}  controls="controls" type="audio/mpeg" preload="preload"></audio>
                        @elseif($resources->type == "video")  
                            <video src={{$resources->route}}  controls="controls" preload="preload" ></video>
                        @elseif($resources->type == "document")  
                            <img src="/img/resources/documentos.png" weigth="100px" height="100px"></i>
                        @endif()
                    </div>
                    <div class="col25"><span id="{{$resources->id}}" class="delete">Eliminar</span></div>
                    <div class="col25"><a href='/resources/{{$resources->id}}/edit'>Modificar</a> </div> 
                </div>
            @endforeach
    </div>
    <!--Ventana modal para añadir videos-->
    <div id="contentmodal">
        <div id="windowsmodarl">
            <form action="/resources" method="post" enctype="multipart/form-data">
            @csrf
                <br /> Titlo:<br /> <input type='text' name='title'><br />
                <br /> Ruta:<br /> <input type='text' name='route'><br />
                <br /> <input type="submit" value="Añadir Video">
            </form>
        </div>
    </div>

<script>
            $(function(){
                //.delete es el nombre de la clase
                //peticion_http es el objeto que creamos de Ajax
                $(".delete").click(function(){
                    id = $(this).attr("id");
                    elementoD = $(this);
                    var confirmacion = confirm("¿Esta seguro de que desea eliminarlo?")
                    if(confirmacion){
                    $.get('http://celia-tour.test/resources/delete/'+id, function(respuesta){
                        $(elementoD).parent().parent().remove();
                    });
                    }
                })
            })
        </script>
@endsection