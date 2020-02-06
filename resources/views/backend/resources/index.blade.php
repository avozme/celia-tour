@extends('layouts.backend')

@section('modal')
    <!-- VENTANA MODAL SUBIR VIDEO -->
    <div class="window" style="display:none">
        <span class="titleModal col100">Insertar Video</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="addVideoContent col100 xlMarginTop">
            <form action="/video-save" method="post" class="col60" enctype="multipart/form-data">
                @csrf
                <label class="col100">Titulo<span class="req">*<span></label>
                <input type='text' name='title' class="col100">
                <label class="col100 sMarginTop">URL video en vimeo<span class="req">*<span></label>
                <input type='text' name='route' class="col100" placeholder="https://vimeo.com/000000">
                <input type="submit" value="Añadir Video" class="col100 xlMarginTop">
            </form>
        </div>
    </div>

    <!-- VENTANA MODAL RECURSO -->
    <div class="window sizeWindow70" >
            <!-- Subir video -->
                <span class="titleModal col100">Editar Recurso</span>
                <button class="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                       <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                   </svg>
                </button>
                <div class="resourceContent col100 xlMarginTop">
                    <div class="previewResource col70">
                        {{-- <div class="imageResource col90">
                            <img src="https://concepto.de/wp-content/uploads/2019/12/paisaje-rural-e1576119288479.jpg"/>
                        </div>
                        <div class="videoResource col90">
                                <iframe src="https://player.vimeo.com/video/156212670" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        </div> --}}
                        <div class="audioResource col90">
                                <audio src='{{url('/uploads/test.mp3')}}' controls></audio>
                        </div>
                    </div>

                    <form id="updateResource" method="POST" action="" enctype="multipart/form-data" class="col30">
                        @csrf
                        <label class="col100">Titulo<span class="req">*<span></label>
                        <input type='text' name='title' value='' class="col100">
                        <label class="col100 sMarginTop">Descripción</label>
                        <textarea name="description" class="col100"></textarea>
                    </form>

                    <div class="xlMarginTop col100">
                        <input type="submit" form="updateResource" name="edit" value="Guardar Cambios" class="right ">
                        <button class="delete ">Eliminar</button>
                    </div>
                    
                </div>
            </div>
@endsection

@section('content')
    <!-- Archivos necesarios para la libreria de dropzone -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dropzone.css')}}"> <!-- CSS -->
    <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script> <!-- JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TITULO -->
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
    
    <!-- CONTENIDO -->
    <div id="content" class="col100 resourcesIndex">      
        <!--Ventana modal para añadir recursos-->
        <!-- Dropzone -->
        <div class="dropzoneContainer col100">
            <form action="{{ url('/images-save') }}" method="post" enctype="multipart/form-data" class='dropzone sMarginBottom' >
            </form>
            <div class="width100">
                <button class="right">Insertar Video</button>
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
        <!-- Recursos -->
        <div class="col100">
                @foreach ($resources as $resources )
                    <div id="{{$resources->id}}" class="elementResource col166">
                        <div class="insideElement">
                            <!-- MINIATURA -->
                            <div class="preview col100">
                                @if( $resources->type == "image")
                                    <img src="{{$resources->route}}"/>
                                @elseif($resources->type == "audio")  
                                    <img src="{{url('img/spectre.png')}}"/>
                                @elseif($resources->type == "video")  
                                    <img src="{{$resources->preview}}"/>
                                @elseif($resources->type == "document")  

                                @endif()
                            </div>
                            <div class="titleResource col100">
                                <div class="nameResource col80">
                                    {{$resources->title}}
                                </div>
                                <div class="col20">
                                    @if( $resources->type == "image")
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.821 18">
                                            <g transform="translate(0 -33.331)">
                                            <path d="M22.459,33.331H.362A.362.362,0,0,0,0,33.693V50.969a.362.362,0,0,0,.362.362h22.1a.361.361,0,0,0,.362-.362V33.693A.361.361,0,0,0,22.459,33.331ZM20.651,48.448,15.678,43.3a.148.148,0,0,0-.2-.008l-3.449,3.036L7.617,40.9a.145.145,0,0,0-.118-.055.148.148,0,0,0-.115.059l-5.214,7V35.5H20.651Z"/>
                                            <path d="M187.3,90.039a1.774,1.774,0,1,0-1.774-1.774A1.774,1.774,0,0,0,187.3,90.039Z" transform="translate(-172.115 -49.316)"/>
                                            </g>
                                        </svg>
                                    
                                    @elseif($resources->type == "audio")  
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.9 18.81">
                                            <path class="cls-1" d="M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76" transform="translate(-0.07 0)"/>
                                        </svg>

                                    @elseif($resources->type == "video")  
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                                            <path d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)"/>
                                        </svg>

                                    @elseif($resources->type == "document")  
        
                                    @endif()
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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