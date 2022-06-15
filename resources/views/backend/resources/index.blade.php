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
        <span id="infoAlertD"></span>
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
            <svg id="iconCloseD" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 396.72 577.92">
                <defs><style>.cls-1,.cls-2{stroke:#000;stroke-miterlimit:10;}.cls-2{fill:none;stroke-width:23px;}</style>
                </defs><title>interfac</title>
                <g id="delete"><path class="cls-1" d="M76.5,408a51.15,51.15,0,0,0,51,51h204a51.15,51.15,0,0,0,51-51V102H76.5ZM325.71-117.73,248.86-72.34l-34.92-9L104.16-16.49l-9,34.92L18.32,63.82l25.94,43.91L351.65-73.82ZM306.15-15.11l86-11,10,75-101,7M214,31.89l-8,48,80-7-40-41" transform="translate(-17.64 118.42)"/></g>
                <line class="cls-2" x1="373.93" y1="42.88" x2="359.93" y2="59.5"/><line class="cls-2" x1="387.93" y1="193.52" x2="373.93" y2="210.15"/>
            </svg>
            <svg id="iconUpD" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 459"><defs>
                <style>.cls-1{fill:none;stroke:#fff;stroke-miterlimit:10;stroke-width:20px;}</style></defs>
                <title>trashOpen2</title>
                <g id="delete">
                    <path d="M336.25,267A87.93,87.93,0,0,1,382.5,280V102H76.5V408a51.15,51.15,0,0,0,51,51h204a51.09,51.09,0,0,0,43.32-24.17A88.37,88.37,0,1,1,336.25,267ZM318.75,25.5,293.25,0H165.75l-25.5,25.5H51v51H408v-51Z" transform="translate(-51 0)"/>
                    <circle cx="285.25" cy="355.31" r="71.75"/>
                    <line class="cls-1" x1="245.99" y1="394.58" x2="324.52" y2="316.05"/><line class="cls-1" x1="245.99" y1="316.05" x2="324.52" y2="394.58"/>
                </g>
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
                                @elseif($r->type == "model3D")
                                    <img src="{{url('img/model3d.png')}}"/>
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
                                            <path d="M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76" transform="translate(-0.07 0)"/>
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
                        <input type='checkbox' id="{{$r->id}}" class='checkeliminar' style="display: none;">
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
                        // Se prepara el mensaje informativo
                        var info = 'No se a podido eliminar el recurso por que se usa en otras zonas de la aplicación: <br><br>';
                        if(result.resourceGallery > 0){

                            let text = 'resultado';
                            if(result.resourceGallery > 1){
                                text += 's';
                            }

                            info += 'Galerias: ' + result.resourceGallery + ' ' + text + '.<br>';
                        }
                        if(result.guidedVisit > 0){

                            let text = 'resultado';
                            if(result.guidedVisit > 1){
                                text += 's';
                            }

                            info += 'Visitas guiadas: ' + result.guidedVisit + ' ' + text + '.<br>';
                        }

                        // Se abre la modal adecuada y se añade el texto
                        $("#confirmDelete").css("display", "none");
                        $("#modalWindow").css("display", "block");
                        $("#infoAlertD").html(info);
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
                maxFilesize: 60,  // 60 mb
                acceptedFiles: ".jpeg,.jpg,.png, .pdf, .mp3, .wav, .glb",
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
            }else if(respuesta["type"]=="model3D"){
                elemento+="<img src='img/model3d.png'/>";
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
                          +"<path d='M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76' transform='translate(-0.07 0)'/>"
                          +"</svg>";
            }else if(respuesta['type']  == 'model3D'){
                elemento+="<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-badge-3d' viewBox='0 0 16 16'>"
                    +"<path d='M4.52 8.368h.664c.646 0 1.055.378 1.06.9.008.537-.427.919-1.086.919-.598-.004-1.037-.325-1.068-.756H3c.03.914.791 1.688 2.153 1.688 1.24 0 2.285-.66 2.272-1.798-.013-.953-.747-1.38-1.292-1.432v-.062c.44-.07 1.125-.527 1.108-1.375-.013-.906-.8-1.57-2.053-1.565-1.31.005-2.043.734-2.074 1.67h1.103c.022-.391.383-.751.936-.751.532 0 .928.33.928.813.004.479-.383.835-.928.835h-.632v.914zm3.606-3.367V11h2.189C12.125 11 13 9.893 13 7.985c0-1.894-.861-2.984-2.685-2.984H8.126zm1.187.967h.844c1.112 0 1.621.686 1.621 2.04 0 1.353-.505 2.02-1.621 2.02h-.844v-4.06z'/>"
                    +"<path d='M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z'/>"
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
                                    +"<path d='M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76' transform='translate(-0.07 0)'/>"
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
                                    +"<path d='M4.76,12.21a3.42,3.42,0,1,0,1.9,4.45,3.49,3.49,0,0,0,.24-1.27V4.3H17.82v7.92a3.41,3.41,0,1,0,1.9,4.44A3.49,3.49,0,0,0,20,15.39V0H4.76' transform='translate(-0.07 0)'/>"
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

        function eliminarVariosRecursos(ids){
            //console.log("entrando a eliminar");
                return $.ajax({
                    url: "{{route('resource.eliminarRecursos')}}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "ids": ids,
                    }
                });
            }

        var direccionEliminar = "{{route('resource.eliminarRecursos')}}";
        var token = "{{ csrf_token() }}";
    </script>

@endsection
