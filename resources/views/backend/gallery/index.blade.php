@extends('layouts.backend')
@section('headExtension')
<!--SCRIPT-->
<script src="{{url('js/closeModals/close.js')}}"></script>    
<script src="{{url('js/gallery/gallery.js')}}" ></script> 
<link rel="stylesheet" type="text/css" href="{{asset('/css/gallery/gallery.css')}}">
@endsection
@section('modal')
    <!-- VENTANA MODAL PARA AÑADIR GALERIA -->
    <div class="window" id="galeria">
        <span class="titleModal col100">Insertar Galeria</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="addVideoContent col100 xlMarginTop">
            <form id="newGalleryForm" action="{{route('gallery.store')}}" method="post" class="col90" enctype="multipart/form-data">
                @csrf
                <label class="col100">Titulo<span class="req">*<span></label>
                <input id="titleNewGallery" type='text' name='titleadd' class="col100" required>
                <label class="col100 sMarginTop">Descripción<span class="req">*<span></label>
                <textarea name="descriptionadd" class="col100" id="textareadescripcion"></textarea>
                <div id="errorMsgNewGallery" class="col100">
                    <span></span>
                </div>
            </form>
        </div>
        <div class="col100 mMarginTop">
            <input type="submit" form="newGalleryForm" value="Añadir Galeria" class="col100">
        </div>
    </div>

    <!-- VENTANA MODAL PARA MODIFICAR LAS GALERIAS -->
    <div class="window"  id="editG">
        <span class="titleModal col100">Editar Galeria</span>
        <button id="closeModalWindowButton" class="closeModal">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="galleryContent col100 xlMarginTop">
            <div class="col100">
                <label class="col100">Titulo<span class="req">*<span></label>
                <input type='text' name='title' class="col100">
                <label class="col100 sMarginTop">Descripción<span class="req">*<span></label>
                <textarea name="description" class="col100" id="textareadescripcion"></textarea>
            </div>      
        </div>
        <div class="xlMarginTop col100">
            <input type="submit" class="col100" form="updateResource" name="edit" value="Guardar Cambios" id="btnUpdate">
        </div> 
    </div>

    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR GALERIAS -->
    <div class="window" id="confirmDelete">
    <span class="titleModal col100">¿Eliminar galeria?</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div id="mensaje" style="color: red; font-weight: bold;"><br/></div>
    <div class="confirmDeleteScene col100 xlMarginTop" id="btnmodaleliminar">
        <button id="aceptDelete" class="delete">Aceptar</button>
        <button id="cancelDelete" >Cancelar</button>
    </div>
    
</div>
@endsection
@section('content')
<!--DIV PARA DAR INFO DE POR QUE NO SE CREO LA GALERÍA-->
@if($errors->any())
<div class="alert alert-warning" role="alert">
    <p class="claseroja">No se pudo crear la galeria por los siguientes motivos:</p>
   @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
</div>
@endif

<!-- TITULO -->
<div id="title" class="col80 xlMarginBottom">
    <span>GALERIAS</span>
</div>

<!-- BOTON AGREGAR -->   
<div id="contentbutton" class="col20 xlMarginBottom">   
    <button class="right round col45" id="btngaleria">
        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
            <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                    8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
        </svg>                                        
    </button>
</div>

<!--TABLA DE GALERIAS-->
<div id="content" class="col100 centerH">
    <div class="col90">
        <div class="col100 mPaddingLeft mPaddingRight sPaddingBottom">
            <div class="col20 sPadding"><strong>Titulo</strong></div>
            <div class="col20 sPadding"><strong>Descripción</strong></div>
        </div>

        @foreach ($gallery as $g )
            <div class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                <div class="col20 sPadding">{{$g->title}}</div>
                <div class="col35 sPadding">{{$g->description}}</div>
                <div class="col15 sPadding"><button class="btnModificarG col100" id="{{$g->id}}">Editar</button></div> 
                <div class="col15 sPadding"><button class="col100 bBlack" onclick="window.location.href='gallery/{{$g->id}}/edit_resources'">Recursos</button></div> 
                <div class="col15 sPadding"><button id="{{$g->id}}" class="delete col100">Eliminar</button></div>
            </div>
        @endforeach
    </div>
</div>


<script>
   var url = "{{url('')}}";

//FUNCIÓN PARA ELIMINAR A TRAVÉS DE AJAX
$(".delete").click(function(){
    id = $(this).attr("id");
    elementoD = $(this);
    var route = "{{ route('gallery.contenido', 'req_id') }}".replace('req_id', id);
            $.ajax({
                url: route,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}",
                }, success: function (result) {
                    if (result.status == true) {
                        $("#mensaje").empty();
                        $("#modalWindow").css("display", "block");
                        $("#confirmDelete").css("display", "block");
                        $("#aceptDelete").click(function(){
                            $("#confirmDelete").css("display", "none");
                            $("#modalWindow").css("display", "none");
                            $.get(url+'/gallery/delete/'+id, function(respuesta){
                            $(elementoD).parent().parent().remove();
                            $('.previewResource').empty();
                            });
                        });
                        $("#cancelDelete").click(function(){
                            $("#confirmDelete").css("display", "none");
                            $("#modalWindow").css("display", "none");
                        });
                    } else {
                        $("#mensaje").empty();
                        $("#mensaje").prepend("<br/><br/>Esta galeria tiene "+result.num+" imagenes asociadas. <br/> ¿Esta seguro que desea eliminarla?");
                        $("#modalWindow").css("display", "block");
                        $("#confirmDelete").css("display", "block");
                        $("#aceptDelete").click(function(){
                            $("#confirmDelete").css("display", "none");
                            $("#modalWindow").css("display", "none");
                            $.get(url+'/gallery/delete/'+id, function(respuesta){
                            $(elementoD).parent().parent().remove();
                            $('.previewResource').empty();
                            });
                        });
                        $("#cancelDelete").click(function(){
                            $("#confirmDelete").css("display", "none");
                            $("#modalWindow").css("display", "none");
                        });
                    }
                }
    });
    });

//FUNCIÓN PARA RECUPERAR TODOS LOS DATOS EN OBJEROS:
$(document).ready(function(){
    var data = @JSON($gallery);

//FUNCIÓN PARA ABRIR LA VENTANA MODAL DE MOFICIAR GALERIA
$(".btnModificarG").click(function(){
    for(var i=0; i<data.length; i++){
    if(data[i].id==$(this).attr("id")){
        id = data[i].id;
        $('.galleryContent input[name="title"]').val(data[i].title);
        $('textarea[name="description"]').val(data[i].description);
        $("#modalWindow").css("display", "block");
        $("#editG").css("display", "block");
    }
    }
//FUNCIÓN PARA ACTUALIZAR
$("#btnUpdate").click(function(){
    var route = "{{ route('gallery.update', 'req_id') }}".replace('req_id', id);
    $.ajax({
       url: route,
       type: 'patch',
       data: {
        "_token": "{{ csrf_token() }}",
        "title":$('.galleryContent input[name="title"]').val(),
        "description":$('textarea[name="description"]').val(),
       },
       success:function(result){
         if(result.status == true){
            window.location.href="{{route('gallery.index')}}";
         }else{
            alert("ERROR")
         }
       }
    });
});
});
});
</script>
@endsection