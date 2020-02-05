@extends('layouts.backend')
@section('content')
    <!-- Enlazar archivos dropzone -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dropzone.css')}}"> <!-- CSS -->
    <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script> <!-- JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="title" class="col80 xlMarginBottom">
        <span>RECURSOS</span>
    </div>
    <div id="contentbutton" class="col20 xlMarginBottom">
        <button class="right round">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 663.555">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,66.26,65.435,66.276,65.4H440.925V489.79H771.436Z" transform="translate(-125.79 1104.48) rotate(-90)"/>
            </svg>              
        </button>
        <!--<input type="button" value="Añadir Video">-->
    </div>
    
    <div id="content" class="col100 resourcesIndex">      
        <!--Ventana modal para añadir recursos-->
        <!-- Dropzone -->
        <div id="contentmodal">
            <div id="windowsmodarl">
                <form action="{{ url('/images-save') }}" method="post" enctype="multipart/form-data" class='dropzone' >
                </form>
                <!--<input type="button" value="Actualizar" onclick="window.location.href='/resources'">-->
            </div>
        </div>
        <!-- Script -->
        <script>
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(".dropzone",{ 
                maxFilesize: 3,  // 3 mb
                acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            });
            myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
            }); 
        </script>
    
        <div class="col100">
            {{--
                    <div class="col25">Titlo</div>
                    <div class="col25">Miniatura</div>
                    <div class="col25">Eliminar</div>
                    <div class="col25">Editar</div>
            --}}
                @foreach ($resources as $resources )

                <div id="{{$resources->id}}" class="elementResource">
                    <!-- MINIATURA -->
                    <div class="preview col100">
                        @if( $resources->type == "image")
                            <img src="https://www.dzoom.org.es/wp-content/uploads/2017/07/seebensee-2384369-1024x681.jpg"/>
                        @elseif($resources->type == "audio")  

                        @elseif($resources->type == "video")  

                        @elseif($resources->type == "document")  

                        @endif()
                    </div>
                    <div class="title">
                        {{$resources->title}}
                    </div>
                </div>

                {{--
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
                --}}
                @endforeach
        </div>
    </div>
    <!--Ventana modal para añadir videos-->
    <div id="contentmodal">
        <div id="windowsmodarl">
            <form action="/video-save" method="post" enctype="multipart/form-data">
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