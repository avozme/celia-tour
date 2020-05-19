@extends('layouts.backend')
@section('headExtension')
<!--SCRIPT PARA CERRAR LAS MODALES-->
<script src="{{url('js/closeModals/close.js')}}"></script>
<script src="{{url('js/resources/resources.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/resources/resources.css')}}">
@endsection
@section('modal')
    <!-- VENTANA MODAL SUBIR VIDEO -->
    <div id="video"  class="window">
        <span class="titleModal col100">Insertar Video</span>
        <button id="closew" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="addVideoContent col100 xlMarginTop">
            <form action="{{route('resource.video-save')}}" method="post" class="col60" enctype="multipart/form-data">
                @csrf
                <label class="col100">Titulo<span class="req">*<span></label>
                <input type='text' name='title' class="col100">
                <label class="col100 sMarginTop">URL video en vimeo<span class="req">*<span></label>
                <input type='text' name='route' class="col100" placeholder="https://vimeo.com/000000">
                <input type="submit" value="Añadir Video" class="col100 xlMarginTop">
            </form>
        </div>
    </div>

    <!--VENTANA MODAL MENSAJE DE NO SE PUDO ELIMINAR-->
    <div id="alertaD" class="window">
        <span class="titleModal col100">El recurso no pudo ser eliminado</span><br/><br/>
        <span>Este recurso esta siendo utilizado en una geleria, debe eliminarlo primero de ella para poder ser borrado.</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="confirmDeleteScene col100 xlMarginTop">
            <button align="center" id="ACEP">Aceptar</button>
        </div>
    </div>

    <!-- VENTANA MODAL RECURSO -->
    <div id="edit" class="window sizeWindow70">
            <!-- Info recurso -->
                <span class="titleModal col100">Editar Recurso</span>
                <button id="closew" class="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                       <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                   </svg>
                </button>
                <div class="resourceContent col100 xlMarginTop">
                    <div class="previewResource col70">
                    </div>
                    <div class="col30">
                        <form id="updateResource" enctype="multipart/form-data">
                            <label class="col100">Titulo<span class="req">*<span></label>
                            <input type='text' name='title' value='' class="col100">
                            <label class="col100 sMarginTop">Descripción</label>
                            <textarea name="description" class="col100"></textarea>
                            <div id="subtitles">
                                <label class="col100 sMarginTop">Subtitulos:</label>
                                <div id="subsAsociated" class="col100 sMarginBottom">
                                    {{-- Se insertan con javascript --}}
                                </div>
                                <input id="fileSubt" type="file" class="col100" name="subt" value="selec" accept=".vtt">
                                <div id="fileSubtOwn" class="col100 centerH">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 433.5 433.5">
                                        <polygon points="140.25,331.5 293.25,331.5 293.25,178.5 395.25,178.5 216.75,0 38.25,178.5 140.25,178.5 		"/>
                                        <rect x="38.25" y="382.5" width="357" height="51"/>
                                    </svg>
                                    <span>Añadir subtitulo</span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="xlMarginTop col100">
                        <input type="button" name="edit" value="Guardar Cambios" class="right" id="btnUpdate">
                        <button class="delete ">Eliminar</button>
                    </div>
                    
                </div>
            </div>
    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR RECURSOS -->
    <div class="window" id="confirmDelete">
        <span class="titleModal col100" style="margin-left: 13%">¿Eliminar recurso?</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>
        </button>
        <div class="confirmDeleteScene col100 xlMarginTop">
            <button id="aceptDelete" class="delete sMarginRight">Aceptar</button>
            <button id="cancelDelete" >Cancelar</button>
        </div>
    </div>
    
@endsection

@section('content')
<!--Muestra los errores si intentas mandar un formulario incomplemto-->
@if($errors->any())
<div class="alert alert-warning" role="alert">
    <p class="claseroja" >No se pudo subir el video por los siguientes motivos:</p>
   @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
</div>
@endif
    <!-- Archivos necesarios para la libreria de dropzone -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dropzone.css')}}"> <!-- CSS -->
    <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script> <!-- JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TITULO -->
    <div id="title" class="col20 xlMarginBottom">
        <span>RECURSOS</span>
    </div>
    <div class="col20">
    <form>
    <select onchange="cambiarTipo()" id="tipo_recurso">
     <option value="" selected> Todos los recursos
     <option value="video">Videos</option>
     <option value="image">Imagenes
     <option value="audio">Audios
     <option value="document">Documentos
    </select>
    </form>
    </div>
    <div id="buscador" class="col40 xlMarginBottom ">
    <form action="{{route('resource.buscar')}}" method="POST">
            @csrf
            <input class="search_input" type="text" name="texto" placeholder="Buscar...">
            <input type="submit"value="Buscar">
        </form>
    </div>
    <div id="contentbutton" class="col20 xlMarginBottom">
        <!-- BOTON SUBIR RECURSOS -->
        <button class="right round col45" id="btndResource">
            <svg id="iconUp" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 663.555">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,66.26,65.435,66.276,65.4H440.925V489.79H771.436Z" transform="translate(-125.79 1104.48) rotate(-90)"/>
            </svg>
            <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"> 
                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
            </svg>                          
        </button>

        <div class="right col5 row1">
        </div>
        <!-- BOTON SUBIR VIDEO -->
        <button class="right round col45" id="btnVideo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                <path id="music-and-multimedia" d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)" fill="#fff"/>
              </svg>                          
        </button>
        <div class="right col5 row1">
        </div>
        <!-- BOTON ELIMINAR RECURSOS -->
        <button class="right round col45" id="btnDestroy">
            <svg id="iconUpD" viewBox="-47 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path d="m416.875 114.441406-11.304688-33.886718c-4.304687-12.90625-16.339843-21.578126-29.941406-21.578126h-95.011718v-30.933593c0-15.460938-12.570313-28.042969-28.027344-28.042969h-87.007813c-15.453125 0-28.027343 12.582031-28.027343 28.042969v30.933593h-95.007813c-13.605469 0-25.640625 8.671876-29.945313 21.578126l-11.304687 33.886718c-2.574219 7.714844-1.2695312 16.257813 3.484375 22.855469 4.753906 6.597656 12.445312 10.539063 20.578125 10.539063h11.816406l26.007813 321.605468c1.933594 23.863282 22.183594 42.558594 46.109375 42.558594h204.863281c23.921875 0 44.175781-18.695312 46.105469-42.5625l26.007812-321.601562h6.542969c8.132812 0 15.824219-3.941407 20.578125-10.535157 4.753906-6.597656 6.058594-15.144531 3.484375-22.859375zm-249.320312-84.441406h83.0625v28.976562h-83.0625zm162.804687 437.019531c-.679687 8.402344-7.796875 14.980469-16.203125 14.980469h-204.863281c-8.40625 0-15.523438-6.578125-16.203125-14.980469l-25.816406-319.183593h288.898437zm-298.566406-349.183593 9.269531-27.789063c.210938-.640625.808594-1.070313 1.484375-1.070313h333.082031c.675782 0 1.269532.429688 1.484375 1.070313l9.269531 27.789063zm0 0"/><path d="m282.515625 465.957031c.265625.015625.527344.019531.792969.019531 7.925781 0 14.550781-6.210937 14.964844-14.21875l14.085937-270.398437c.429687-8.273437-5.929687-15.332031-14.199219-15.761719-8.292968-.441406-15.328125 5.925782-15.761718 14.199219l-14.082032 270.398437c-.429687 8.273438 5.925782 15.332032 14.199219 15.761719zm0 0"/><path d="m120.566406 451.792969c.4375 7.996093 7.054688 14.183593 14.964844 14.183593.273438 0 .554688-.007812.832031-.023437 8.269531-.449219 14.609375-7.519531 14.160157-15.792969l-14.753907-270.398437c-.449219-8.273438-7.519531-14.613281-15.792969-14.160157-8.269531.449219-14.609374 7.519532-14.160156 15.792969zm0 0"/>
                <path d="m209.253906 465.976562c8.285156 0 15-6.714843 15-15v-270.398437c0-8.285156-6.714844-15-15-15s-15 6.714844-15 15v270.398437c0 8.285157 6.714844 15 15 15zm0 0"/>
            </svg>   
            <svg id="iconCloseD" enable-background="new 0 0 64 64"  viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <path d="m50 22h-31.042l14.749-14.749c.188-.188.293-.442.293-.707s-.105-.52-.293-.707l-2.828-2.828c-1.134-1.134-3.11-1.134-4.243 0l-2.284 2.284 1.414 1.414 2.285-2.284c.377-.378 1.036-.378 1.414 0l2.122 2.121-24.043 24.042-2.121-2.122c-.189-.188-.293-.439-.293-.707s.104-.518.293-.707l18.343-18.343-1.414-1.414-1.373 1.373-1.414-1.414c-1.171-1.171-3.074-1.17-4.243 0l-7.071 7.071c-1.17 1.17-1.17 3.073 0 4.243l1.414 1.414-5.657 5.657c-.567.567-.879 1.32-.879 2.122s.312 1.555.879 2.121l2.828 2.829c.188.186.443.291.708.291s.52-.105.707-.293l5.318-5.318 4.211 32.003c.196 1.486 1.474 2.608 2.974 2.608h22.492c1.5 0 2.778-1.122 2.975-2.609l3.455-26.261-1.983-.261-3.455 26.26c-.066.497-.492.871-.992.871h-22.492c-.5 0-.926-.374-.991-.87l-4.411-33.524 1.606-1.606h31.902l-.641 4.87 1.983.261.79-6c.038-.286-.049-.573-.239-.79-.191-.217-.465-.341-.753-.341zm-40.334-4.849c-.39-.39-.39-1.024 0-1.415l7.071-7.071c.389-.389 1.024-.39 1.415 0l1.414 1.414-8.485 8.485z"/>
                <path d="m29 31v22c0 1.654 1.346 3 3 3s3-1.346 3-3v-22c0-1.654-1.346-3-3-3s-3 1.346-3 3zm4 0v22c0 .551-.449 1-1 1s-1-.449-1-1v-22c0-.551.449-1 1-1s1 .449 1 1z"/><path d="m21 31v22c0 1.654 1.346 3 3 3s3-1.346 3-3v-22c0-1.654-1.346-3-3-3s-3 1.346-3 3zm4 0v22c0 .551-.449 1-1 1s-1-.449-1-1v-22c0-.551.449-1 1-1s1 .449 1 1z"/><path d="m37 31v22c0 1.654 1.346 3 3 3s3-1.346 3-3v-22c0-1.654-1.346-3-3-3s-3 1.346-3 3zm4 0v22c0 .551-.449 1-1 1s-1-.449-1-1v-22c0-.551.449-1 1-1s1 .449 1 1z"/><path d="m37.243 13.03-4-1c-.391-.097-.802.049-1.042.37l-3 4c-.178.237-.242.541-.173.83.068.289.261.532.526.665l4 2c.137.069.291.105.446.105h5c.332 0 .642-.165.828-.439s.224-.624.101-.932l-2-5c-.12-.298-.375-.521-.686-.599zm-3.007 4.97-2.717-1.358 1.883-2.51 2.859.715 1.262 3.153z"/><path d="m49.854 11.472-.959-1.919c-.202-.404-.651-.622-1.091-.533l-5 1c-.468.093-.804.503-.804.98v2c0 .082.01.163.03.243l1 4c.112.449.516.757.969.757.042 0 .083-.002.125-.008l8-1c.354-.044.657-.273.796-.602s.093-.706-.121-.991zm-5.099 4.426-.755-3.021v-1.057l3.447-.689.658 1.317c.027.054.059.105.095.153l1.966 2.622z"/>
                <path d="m44 2h2v2h-2z"/><path d="m52.804 8.207 1.219 1.586c2.211-1.698 5.048-2.358 7.781-1.813l.393-1.961c-3.304-.66-6.726.138-9.393 2.188z"/><path d="m57 12h2v2h-2z"/><path d="m48 7h2c0-1.654 1.346-3 3-3v-2c-2.757 0-5 2.243-5 5z"/>
            </svg>                 
        </button>
    </div>
    
    <!-- CONTENIDO -->
    <div id="content" class="col100 resourcesIndex">      
        <!-- Dropzone -->
        <div class="dropzoneContainer col100" id="dzone">
            <form action="{{ url('/images-save') }}" method="post" enctype="multipart/form-data" class='dropzone sMarginBottom' >
            </form>
        </div>

        <!-- Recursos -->
        <div class="col100" id="generalContent">
                @foreach ($resources as $r )
                    <div id="{{$r->id}}" class="elementResource col166 tooltip">
                        {{-- Descripcion si la tiene --}}
                        @if($r->description!=null)
                            <span class="tooltiptext">{{$r->description}}</span>
                        @endif
                    
                        <div class="insideElement ">
                            <!-- MINIATURA -->
                            <div class="preview col100">
                                @if( $r->type == "image")
                                    <img src="{{url('img/resources/miniatures/'.$r->route)}}"/>
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
        var data = @JSON($resources);
        var subtDeleted = [];

        $( document ).ready(function() {
            //FUNCIÓN PARA ACTUALIZAR
            $("#btnUpdate").click(function(){
                ajaxUpdateRes(id);
            });

            
    //FUNCIÓN AJAX PARA BORRAR
    $(".delete").click(function () {
        $(".window").css("display", "none");
        $("#edit").css("display", "none");
        $("#confirmDelete").css("display", "block");
        $("#aceptDelete").click(function () {
            $("#confirmDelete").css("display", "none");
            $("#modalWindow").css("display", "none");
            var route = "{{ route('resource.delete', 'req_id') }}".replace('req_id', id);
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                }, success: function (result) {
                    if (result.status == true) {
                        $(elementoD).remove();
                        $('.previewResource').empty();
                    } else {
                        //alert("Este recurso no puede ser eliminado por que esta siendo usado en una galeria");
                        console.log("no pude ser eliminada");
                        $("#confirmDelete").css("display", "none");
                        $("#modalWindow").css("display", "block");
                        $("#alertaD").css("display", "block");
                        $('.previewResource').empty();
                    }
                }
            });
        });
        $("#cancelDelete").click(function () {
            $("#confirmDelete").css("display", "none");
            $("#edit").css("display", "block");
        });
    });


            $("#fileSubt").on("change", function(){
                if($("#fileSubt").val()!=null && $("#fileSubt").val()!=""){
                    var path = $("#fileSubt").val().toString().replace(/\\/g, '/');
                    var name = path.split("/");
                    $("#fileSubtOwn span").text(name[name.length-1]);
                    $("#fileSubtOwn svg").hide();

                }else{
                    $("#fileSubtOwn span").text("Añadir Subtitulo");
                    $("#fileSubtOwn svg").show();
                }
            });

            
            //ACCIÓN PARA CERRAR LA MODAL 
            $('.closeModal').click(function(){
                $('.previewResource').empty();
                $("#modalWindow").css("display", "none");
                $("#video").css("display", "none");
                $("#edit").css("display", "none");
                subtDeleted = [];
                $("#fileSubt").val("");
                $("#fileSubt").change();
            });

            //CERRAR LA VENTANA DE ALERTAS: 
            $("#ACEP").click(function(){
                $("#modalWindow").css("display", "none");
                $("#alertaD").css("display", "none");
                $('.previewResource').empty();
            });
        });

        ////////////////////////////////////////////////////////////////////
        //                          DROPZONE                              //
        ////////////////////////////////////////////////////////////////////
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(".dropzone",{ 
                maxFilesize: 16,  // 16 mb
                acceptedFiles: ".jpeg,.jpg,.png, .pdf, .mp3, .wav",
            });
            myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
            }); 
            //Función para actualizar automaticamente los recursos 
            myDropzone.on("success", function(file, respuesta) {
                var elemento ="";

            elemento+="<div id="+respuesta['id']+" class='elementResource col166 tooltip'>"
                                        +"<div class='insideElement'>"
                                         +"<div class='preview col100'>";
            if(respuesta["type"]=="image"){
                elemento+="<img src='{{ url('img/resources/miniatures') }}/"+respuesta['route']+"'/>";
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

            //Añadir el elemento al objeto JSON data
            var jsonStr = JSON.parse('{"id":'+respuesta['id']+', "title":"'+respuesta['title']+
                            '","description":"'+respuesta['description']+'", "type":"'+respuesta['type']+
                            '","route":"'+respuesta['route']+'"}');
            data.push(jsonStr);
            
            $("#generalContent").prepend(elemento);
                $("#"+respuesta['id']).click(function(){
                    elementoD = $(this);
                    id = respuesta['id'];
                    var url = "{{url('')}}";
                    $('.resourceContent input[name="title"]').val(respuesta['title']);
                    $('textarea[name="description"]').val(respuesta['description']);
                    $('.resourceContent textarea[name="description"]').removeClass("smallText");
                    $("#subtitles").hide();                   

                    if(respuesta['type']=="image"){
                        $(".previewResource").append("<div class='imageResource col90'>"+
                                                    "<img src='{{ url('img/resources') }}/"+respuesta['route']+"'/>"+
                                                    "</div>")
                    }else if(respuesta['type']=="video"){
                        $(".previewResource").append("<div class='videoResource col90'>"+
                                                    "<iframe src='https://player.vimeo.com/video/"+respuesta['route']+"'width='100%'' height='100%'' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
                                                    "</div>")   
                    }else if(respuesta['type']=="audio"){
                        $(".previewResource").append("<div class='audioResource col90'>"+
                                                    "<audio src='{{ url('img/resources') }}/"+respuesta['route']+"' controls></audio>"+
                                                    "</div>");
                        //Insertar subtitulos
                        insertSubt(data.length-1);
                    }else{
                        $(".previewResource").append("<div class='documentResource col90'>"+
                                                    "<embed src='{{ url('img/resources') }}/"+respuesta['route']+"' width='100%'' height='51%'' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'>"+
                                                    "</div>")  
                    }
                     $(".window").css("display", "none");
                    $("#alertD").css("display", "none");
                    $("#modalWindow").css("display", "block");
                    $("#edit").css("display", "block");
                });
            });
        
        //-------------------------------------------------------------------------------------------------

        //CARGAR LOS RECURSOS
        $( document ).ready(function() {
            //METODO PARA ABRIR Y MOSTRAR EL CONTENIDO DE UN RECURSO CONCRETO EN LA VENTANA MODAL
            $(".elementResource").click(function(){
                $('.tooltiptext').hide();
                elementoD = $(this);
                for(var i=0; i<data.length; i++){
                        if(data[i].id==$(this).attr("id")){
                            id = data[i].id;
                            $('.resourceContent input[name="title"]').val(data[i].title);
                            $('textarea[name="description"]').val(data[i].description);
                            $('.resourceContent textarea[name="description"]').removeClass("smallText");
                            $("#subtitles").hide();
                            
                        
                        var direccion="{{url('')}}";
                        if(data[i].type=="image"){
                            $(".previewResource").append("<div class='imageResource col90'>"+
                                                        "<img src='{{ url('img/resources') }}/"+data[i].route+"'/>"+
                                                        "</div>")
                        }else if(data[i].type=="video"){
                            $(".previewResource").append("<div class='videoResource col90'>"+
                                                        "<iframe src='https://player.vimeo.com/video/"+data[i].route+"'width='100%'' height='100%'' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
                                                        "</div>")   
                        }else if(data[i].type=="audio"){
                            $(".previewResource").append("<div class='audioResource col90'>"+
                                                        "<audio src="+direccion+"/img/resources/"+data[i].route+" controls></audio>"+
                                                        "</div>");
                            //Insertar subtitulos
                            insertSubt(i);
                        }else{
                            $(".previewResource").append("<div class='documentResource col90'>"+
                                                        "<embed src="+direccion+"'"+data[i].route+"' width='100%'' height='51%'' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'>"+
                                                        "</div>")  
                        }
                    }
                }
                 $(".window").css("display", "none");
                $("#elertD").css("desplay", "none");
                $("#edit").css("display", "block");
                $("#modalWindow").css("display", "block");
            });
        });

        //-----------------------------------------------------------------------------------------------------

        //FUNCION PARA CAMBIAR EL TIPO DE RECURSO A MOSTRAR: 
        function cambiarTipo(){
            var data = @JSON($resources);
            elemento=document.getElementById("tipo_recurso");
            indice=elemento.selectedIndex;
            tipo_seleccionado = elemento.options[indice].value;
            $('#generalContent').empty();
            if(tipo_seleccionado!=""){
                for(var i=0; i<data.length; i++){
                    if(data[i].type==tipo_seleccionado){
                        var elemento ="";
                        elemento+="<div id="+data[i].id+" class='elementResource col166 tooltip'>";
                        //Descripcion
                        if(data[i].description!=null){
                            elemento+="<span class='tooltiptext'>"+data[i].description+"</span>";
                        }

                        elemento+="<div class='insideElement'>"
                        +"<div class='preview col100'>";

                        if(data[i].type=="image"){
                            elemento+="<img src='img/resources/miniatures/"+data[i].route+"'/>";
                        }else if(data[i].type=="audio"){
                            elemento+="<img src='img/spectre.png'/>";
                        }else if(data[i].type=="video"){
                            elemento+="<img src='"+data[i].preview+"'/>";
                        }else{
                            elemento+="<img src='img/documentPreview.png'/>";
                        }
                        elemento+="</div>"
                                +"<div class='titleResource col100'>"
                                +"<div class='nameResource col80'>"
                                +data[i].title
                                +"</div>"
                                +"<div class='col20'>";
                        if(data[i].type=="image"){
                            elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 22.821 18'>"
                                    +"<g transform='translate(0 -33.331)'>"
                                    +"<path d='M22.459,33.331H.362A.362.362,0,0,0,0,33.693V50.969a.362.362,0,0,0,.362.362h22.1a.361.361,0,0,0,.362-.362V33.693A.361.361,0,0,0,22.459,33.331ZM20.651,48.448,15.678,43.3a.148.148,0,0,0-.2-.008l-3.449,3.036L7.617,40.9a.145.145,0,0,0-.118-.055.148.148,0,0,0-.115.059l-5.214,7V35.5H20.651Z'/>"
                                    +"<path d='M187.3,90.039a1.774,1.774,0,1,0-1.774-1.774A1.774,1.774,0,0,0,187.3,90.039Z' transform='translate(-172.115 -49.316)'/>"
                                    +"</g>"
                                    +"</svg>";
                        }else if(data[i].type  == 'audio'){
                            elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 19.9 18.81'>"
                                    +"<path class='cls-1' d='M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76' transform='translate(-0.07 0)'/>"
                                    +"</svg>";
                        }else if(data[i].type == 'video'){
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

                        $("#generalContent").prepend(elemento);
                    }
                }
            }else{
                for(var i=0; i<data.length; i++){
                        var elemento ="";
                        elemento+="<div id="+data[i].id+" class='elementResource col166 tooltip'>";
                        //Descripcion
                        if(data[i].description!=null){
                            elemento+="<span class='tooltiptext'>"+data[i].description+"</span>";
                        }

                        elemento+="<div class='insideElement'>"
                        +"<div class='preview col100'>";

                        if(data[i].type=="image"){
                            elemento+="<img src='img/resources/miniatures/"+data[i].route+"'/>";
                        }else if(data[i].type=="audio"){
                            elemento+="<img src='img/spectre.png'/>";
                        }else if(data[i].type=="video"){
                            elemento+="<img src='"+data[i].preview+"'/>";
                        }else{
                            elemento+="<img src='img/documentPreview.png'/>";
                        }
                        elemento+="</div>"
                                +"<div class='titleResource col100'>"
                                +"<div class='nameResource col80'>"
                                +data[i].title
                                +"</div>"
                                +"<div class='col20'>";
                        if(data[i].type=="image"){
                            elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 22.821 18'>"
                                    +"<g transform='translate(0 -33.331)'>"
                                    +"<path d='M22.459,33.331H.362A.362.362,0,0,0,0,33.693V50.969a.362.362,0,0,0,.362.362h22.1a.361.361,0,0,0,.362-.362V33.693A.361.361,0,0,0,22.459,33.331ZM20.651,48.448,15.678,43.3a.148.148,0,0,0-.2-.008l-3.449,3.036L7.617,40.9a.145.145,0,0,0-.118-.055.148.148,0,0,0-.115.059l-5.214,7V35.5H20.651Z'/>"
                                    +"<path d='M187.3,90.039a1.774,1.774,0,1,0-1.774-1.774A1.774,1.774,0,0,0,187.3,90.039Z' transform='translate(-172.115 -49.316)'/>"
                                    +"</g>"
                                    +"</svg>";
                        }else if(data[i].type  == 'audio'){
                            elemento+="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 19.9 18.81'>"
                                    +"<path class='cls-1' d='M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76' transform='translate(-0.07 0)'/>"
                                    +"</svg>";
                        }else if(data[i].type == 'video'){
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

                        $("#generalContent").prepend(elemento);
                
                    }
            }

            //Pulsar sobre recurso
            $(".elementResource").click(function(){
                $('.resourceContent textarea[name="description"]').removeClass("smallText");
                $("#subtitles").hide();
                var id=$(this).attr("id");

                for(var i=0; i<data.length; i++){
                    if(id==data[i].id){
                        /*Inicio*/
                        $('.resourceContent input[name="title"]').val(data[i].title);
                        $('textarea[name="description"]').val(data[i].description);
                    
                    var direccion="{{url('')}}";
                   if(data[i].type=="image"){
                    $(".previewResource").append("<div class='imageResource col90'>"+
                                                "<img src='{{ url('img/resources') }}/"+data[i].route+"'/>"+
                                                "</div>")
                   }else if(data[i].type=="video"){
                    $(".previewResource").append("<div class='videoResource col90'>"+
                                                "<iframe src='https://player.vimeo.com/video/"+data[i].route+"'width='100%'' height='100%'' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
                                                "</div>")   
                   }else if(data[i].type=="audio"){
                    $(".previewResource").append("<div class='audioResource col90'>"+
                                                "<audio src="+direccion+"/img/resources/"+data[i].route+" controls></audio>"+
                                                "</div>");
                    //Insertar subtitulos
                    insertSubt(i);
                   }else{
                    $(".previewResource").append("<div class='documentResource col90'>"+
                                                "<embed src="+direccion+"'"+data[i].route+"' width='100%'' height='51%'' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'>"+
                                                "</div>")  
                   }
                    $(".window").css("display", "none");
                    $("#alertD").css("display", "none");
                    $("#modalWindow").css("display", "block");
                    $("#edit").css("display", "block");
                    }
                }
            });
        }

        //---------------------------------------------------------------------------------------

        /*
        * METODO PARA ACTUALIZAR RECURSOS POR AJAX
        */
        function ajaxUpdateRes(id){

            ///// ELIMINAR SUBTITULOS QUITADOS ANTES DE ACTUALIZAR
            for(var i=0; i<subtDeleted.length;i++){
                ajaxDeleteSub(subtDeleted[i]);
            }
            /**
             * FUNCION PARA REALIZAR LA LLAMADA AJAX CORRESPONDIENTE CON LA ELIMINACION DEL 
             * ARCHIVO DE SUBTITULOS INDICADO POR PARAMETRO
             */
            function ajaxDeleteSub(name){
                var routeSub = "{{ route('resource.deleteSubtitle') }}";
                //Llamada al metodo para eliminar el subtitulo
                $.ajax({
                    type: "POST",
                    url: routeSub,
                    data:  {
                        _token: "{{ csrf_token() }}",
                        subt:name
                    },
                    success: function(result){
                        if(result.status == true){
                            //Eliminar el elemento del objeto data
                            for(var i=0; i<data.length; i++){
                                if(data[i].hasOwnProperty('subs') && data[i].subs.length>0){
                                    for(var j=0; j<data[i].subs.length; j++){
                                        if(data[i].subs[j]==name){
                                            data[i].subs.splice(j,1);
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            }

            
            //////// REALIZAR LA PROPIA ACTUALIZACIÓN DE DATOS + SUBTITULOS
            
            var route = "{{ route('resource.update', 'req_id') }}".replace('req_id', id);
            var formData = new FormData($("#updateResource")[0]);
            formData.append('_method', 'patch');

            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success:function(result){
                    if(result.status == true){
                        //Actualizar contenido
                        var title = $('.resourceContent input[name="title"]').val();
                        var description = $('.resourceContent textarea[name="description"]').val();

                        for(var i=0; i<data.length; i++){
                            if(data[i].id==id){
                                data[i].title=title;
                                $("#"+id+" .nameResource").text(title);
                                
                                $("#"+id+" .tooltiptext").remove();
                                if(description!=""){
                                    data[i].description=description;
                                    $("#"+id).append("<span class='tooltiptext'>"+description+"</span>");
                                }else{
                                    data[i].description=null;
                                }

                                //Agregar subtitulo a data si no lo estamos sobreescribiendo
                                if(result.nameSubt!=null){
                                    if(data[i].hasOwnProperty('subs') && data[i].subs.length>0){
                                        var exist = false;
                                        for(var j=0; j<data[i].subs.length; j++){
                                            if(data[i].subs[j]==result.nameSubt){
                                                exist=true;
                                            }
                                        }
                                        //Si no esta lo añadimos
                                        if(!exist){
                                            data[i].subs.push(result.nameSubt);
                                        }
                                    }else{
                                        data[i].subs = [];
                                        data[i].subs.push(result.nameSubt);
                                    }
                                    subtDeleted = [];
                                    $("#fileSubt").val("");
                                    $("#fileSubt").change();
                                }
                            }
                        }

                        //Ocultar ventana
                        $("#modalWindow").css("display", "none");
                        $("#edit").css("display", "none");
                        $('.previewResource').empty();
                    
                    }else{
                        //Actuar segun el error producido
                        if(result.errorCode==1){
                            alert("El formato del archivo de subtitulos no es correcto\n"+
                            "Debe presentar la siguiente estructura de nombres:\n"+
                            "nombre.idioma.vtt");
                        }else{
                            alert("Error desconocido al actualizar");
                        }
                    }
                }
            });     
        }

        ////////////////////////////////////////////////////////////////////
        //                          SUBTITULOS                            //
        ////////////////////////////////////////////////////////////////////

        /**
         * METODO PARA MOSTRAR SUBTITULOS EN LOS ELEMENTOS 
         */
        function insertSubt(i){
            //INSERTAR SUBTITULOS
            $("#subtitles").show(); 
            $("#subsAsociated").html(`<div class="notSubs centerT col100">No hay subtitulos</div>`);
            if(data[i].hasOwnProperty('subs') && data[i].subs.length>0){
                for(var j=0; j<data[i].subs.length; j++){
                    //Eliminar el mensaje sin subtitulos
                    if(j==0){
                        $("#subsAsociated").html("");
                    }
                    var separated = data[i].subs[j].split(".");
                    //Añadir los elementos a la vista
                    $("#subsAsociated").append(`
                        <div id="`+data[i].subs[j]+`" class="elementSubt col100">
                            <span class="textSubt col90">• Subtitulos <strong>(versión `+separated[separated.length-2]+`)</strong></span>
                            <svg class="deleteSubt" class="right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                                <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                            </svg>   
                        </div>`);
                };
            }
            $('.resourceContent textarea[name="description"]').addClass("smallText");
            
            //////////////////////

            //FUNCION PARA QUITAR UN SUBTITULO
            $(".deleteSubt").on("click", function(){
                var subt = $(this).parent().attr("id");

                //Agregar subtitulos al array para eliminarlos al guardar cambios
                subtDeleted.push(subt);
                
                //Marcar elemento html
                $(this).parent().children("span").addClass("subDel");
                $(this).hide();
                
            });
        }
        
    </script>
        
@endsection