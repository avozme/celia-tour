@extends('layouts.backend')

@section('modal')
    <!-- VENTANA MODAL SUBIR VIDEO -->
    <div class="window" id="video" style="display: none;">
        <span class="titleModal col100">Insertar Video</span>
        <button class="closeModal" id="closeModalWindowBotton">
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
    <div class="window sizeWindow70" style="display: none;" id="edit">
            <!-- Subir video -->
                <span class="titleModal col100">Editar Recurso</span>
                <button class="closeModal" id="closeModalWindowBotton">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                       <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                   </svg>
                </button>
                <div class="resourceContent col100 xlMarginTop">
                    <div class="previewResource col70">
                    </div>
                    <div class="col30">
                        <label class="col100">Titulo<span class="req">*<span></label>
                        <input type='text' name='title' value='' class="col100">
                        <label class="col100 sMarginTop">Descripción</label>
                        <textarea name="description" class="col100"></textarea>
                    </div>

                    <div class="xlMarginTop col100">
                        <input type="submit" form="updateResource" name="edit" value="Guardar Cambios" class="right" id="btnUpdate">
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
        <!-- BOTON SUBIR RECURSOS -->
        <button class="right round" id="btndzone">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 663.555">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,66.26,65.435,66.276,65.4H440.925V489.79H771.436Z" transform="translate(-125.79 1104.48) rotate(-90)"/>
            </svg>              
        </button>
    </div>
    
    <!-- CONTENIDO -->
    <div id="content" class="col100 resourcesIndex">      
        <!-- Dropzone -->
        <div class="dropzoneContainer col100" id="dzone" style="display: none;">
            <form action="{{ url('/images-save') }}" method="post" enctype="multipart/form-data" class='dropzone sMarginBottom' >
            </form>
            <div class="width100">
                <button class="right" id="btnVideo">Insertar Video</button>
            </div>
        </div>

        <!-- Recursos -->
        <div class="col100" id="generalContent">
                @foreach ($resources as $r )
                    <div id="{{$r->id}}" class="elementResource col166">
                        <div class="insideElement">
                            <!-- MINIATURA -->
                            <div class="preview col100">
                                @if( $r->type == "image")
                                    <img src="{{$r->route}}"/>
                                @elseif($r->type == "audio")  
                                    <img src="{{url('img/spectre.png')}}"/>
                                @elseif($r->type == "video")  
                                    <img src="{{$r->preview}}"/>
                                @elseif($r->type == "document")  
                                    <img src="{{url('img/documentPreview.png')}}"/>
                                @endif()
                            </div>
                            <div class="titleResource col100">
                                <div class="nameResource col80">
                                    {{$r->title}}
                                </div>
                                <div class="col20">
                                    @if( $r->type == "image")
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.821 18">
                                            <g transform="translate(0 -33.331)">
                                            <path d="M22.459,33.331H.362A.362.362,0,0,0,0,33.693V50.969a.362.362,0,0,0,.362.362h22.1a.361.361,0,0,0,.362-.362V33.693A.361.361,0,0,0,22.459,33.331ZM20.651,48.448,15.678,43.3a.148.148,0,0,0-.2-.008l-3.449,3.036L7.617,40.9a.145.145,0,0,0-.118-.055.148.148,0,0,0-.115.059l-5.214,7V35.5H20.651Z"/>
                                            <path d="M187.3,90.039a1.774,1.774,0,1,0-1.774-1.774A1.774,1.774,0,0,0,187.3,90.039Z" transform="translate(-172.115 -49.316)"/>
                                            </g>
                                        </svg>
                                    
                                    @elseif($r->type == "audio")  
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.9 18.81">
                                            <path class="cls-1" d="M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76" transform="translate(-0.07 0)"/>
                                        </svg>

                                    @elseif($r->type == "video")  
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                                            <path d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)"/>
                                        </svg>

                                    @elseif($r->type == "document")  
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m331 8.699v111.301h111.301z"/><path d="m451 150h-150v-150h-240v512h390z"/>
                                        </svg>
                                    @endif()
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>

    <script>
        //ACCIÓN PARA MOSTRAR O NO EL DROPZONE
        $("#btndzone").click(function(){
            if($("#dzone").css("display") == "none"){
                $("#dzone").css("display", "block")
            }else{
                $("#dzone").css("display", "none")
            }
        });

        //DROPZONE
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(".dropzone",{ 
                maxFilesize: 3,  // 3 mb
                acceptedFiles: ".jpeg,.jpg,.png, .pdf, .mp3, .wav",
            });
            myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
            }); 
            //Función para actualizar automaticamente los recursos 
            myDropzone.on("success", function(file, respuesta) {
                var elemento ="";

                console.log(respuesta);
            elemento+="<div id="+respuesta['id']+" class='elementResource col166'>"
                                        +"<div class='insideElement'>"
                                         +"<div class='preview col100'>";
            if(respuesta["type"]=="image"){
                elemento+="<img src='"+respuesta["route"]+"'/>";
            }else if(respuesta["type"]=="audio"){
                elemento+="<img src='img/spectre.png'/>";
            }else if(respuesta["type"]=="video"){
                elemento+="<img src='"+respuesta['preview']+"'/>";
            }else{
                elemento+="<img src='img/documentPreview.png'/>";
            }
            elemento+="</div>"
                       +"<div class='titleResource col100'>"
                       +"<div class='nameResource col80'>"
                       +respuesta['title']
                       +"</div>"
                       +"<div class='col20'>";
            if(respuesta["type"]=="image"){
                elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 22.821 18'>"
                          +"<g transform='translate(0 -33.331)'>"
                          +"<path d='M22.459,33.331H.362A.362.362,0,0,0,0,33.693V50.969a.362.362,0,0,0,.362.362h22.1a.361.361,0,0,0,.362-.362V33.693A.361.361,0,0,0,22.459,33.331ZM20.651,48.448,15.678,43.3a.148.148,0,0,0-.2-.008l-3.449,3.036L7.617,40.9a.145.145,0,0,0-.118-.055.148.148,0,0,0-.115.059l-5.214,7V35.5H20.651Z'/>"
                          +"<path d='M187.3,90.039a1.774,1.774,0,1,0-1.774-1.774A1.774,1.774,0,0,0,187.3,90.039Z' transform='translate(-172.115 -49.316)'/>"
                          +"</g>"
                          +"</svg>";
            }else if(respuesta['type']  == 'audio'){
                elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 19.9 18.81'>"
                          +"<path class='cls-1' d='M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76' transform='translate(-0.07 0)'/>"
                          +"</svg>";
            }else if(respuesta['type']  == 'video'){
                elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 15.429 18'>"
                          +"<path d='M35.353,0,50.782,9,35.353,18Z' transform='translate(-35.353)'/>"
                          +"</svg>";
            }else{
                elemento+="<svg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'>"
                          +"<path d='m331 8.699v111.301h111.301z'/><path d='m451 150h-150v-150h-240v512h390z'/>"
                          +"</svg>";
            }
            elemento+=("</div>"
                      +"</div>"
                      +"</div>"
                      +"</div>");

            console.log(elemento);
            $("#generalContent").prepend(elemento);
            });
    
        //ACCIÓN PAR AQUE SE MUESTRE LA VENTANA MODAL DE SUBIR VIDEO
        $("#btnVideo").click(function(){
                    $("#modalWindow").css("display", "block");
                    $("#video").css("display", "block");
        });

        //RECUPERAR LOS RECURSOS EN OBJETOS
        $( document ).ready(function() {
            var data = @JSON($resources);
            //console.log(data);
        //METODO PARA ABRIR Y MOSTRAR EL CONTENIDO DE UN RECURSO CONCRETO EN LA VENTANA MODAL
        $(".elementResource").click(function(){
            elementoD = $(this);
            for(var i=0; i<data.length; i++){
                if(data[i].id==$(this).attr("id")){
                    id = data[i].id;
                    $('.resourceContent input[name="title"]').val(data[i].title);
                    $('textarea[name="description"]').val(data[i].description);
                    //FUNCIÓN AJAX PARA BORRAR
                    $(".delete").click(function(){
                        var confirmacion = confirm("¿Esta seguro de que desea eliminarlo?")
                        if(confirmacion){
                        $("#modalWindow").css("display", "none");
                        console.log(elementoD)
                        $.get('http://celia-tour.test/resources/delete/'+id, function(respuesta){
                            $(elementoD).remove();
                        });
                        }
                    })
                    //FUNCIÓN PARA ACTUALIZAR
                    $("#btnUpdate").click(function(){
                        var route = "{{ route('resource.update', 'req_id') }}".replace('req_id', id);
                        $.ajax({
                            url: route,
                            type: 'patch',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "title":$('.resourceContent input[name="title"]').val(),
                                "description":$('textarea[name="description"]').val(),
                            },
                            success:function(result){
                                if(result.status == true){
                                    alert("cambios guardados");
                                }else{
                                    alert("ERROR")
                                }
                            }
                        });
                    });
                   if(data[i].type=="image"){
                    $(".previewResource").append("<div class='imageResource col90'>"+
                                                "<img src='"+data[i].route+"'/>"+
                                                "</div>")
                   }else if(data[i].type=="video"){
                    $(".previewResource").append("<div class='videoResource col90'>"+
                                                "<iframe src='"+data[i].route+"'width='100%'' height='100%'' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
                                                "</div>")   
                   }else if(data[i].type=="audio"){
                    $(".previewResource").append("<div class='audioResource col90'>"+
                                                "<audio src='"+data[i].route+"' controls></audio>"+
                                                "</div>")   
                   }else{
                    $(".previewResource").append("<div class='documentResource col90'>"+
                                                "<embed src='"+data[i].route+"' width='100%'' height='51%'' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'>"+
                                                "</div>")  
                   }
                }
            }
            $("#modalWindow").css("display", "block");
            $("#edit").css("display", "block");
        });
        });
    </script>
    <!--SCRIPT PARA CERRAR LAS MODALES-->
    <script src="{{url('js/closeModals/close.js')}}"></script>
        
@endsection