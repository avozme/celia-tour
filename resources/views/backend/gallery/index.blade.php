 @extends('layouts.backend')
@section('content')
<div id="title" class="col80"> Administración de Gallerias de Fotos: </div>
<div id="contentbutton" class="col20"> <input type="button" value="Añadir Galeria"> </div>
<div id="content" class="col100">
                <div class="col20">Titulo</div>
                <div class="col20">Descripcion</div>
                <div class="col20">Editar</div>
                <div class="col20">Eliminar</div>
                <div class="col20">Recursos</div>
            @foreach ($gallery as $gallery )
                <div style="clear:both;">
                <div class="col20">{{$gallery->title}}</div>
                <div class="col20">{{$gallery->description}}</div>
                <div class="col20"><a href='/gallery/{{$gallery->id}}/edit'>Modificar</a> </div> 
                <div class="col20"><span id="{{$gallery->id}}" class="delete">Eliminar</span></div>
                <div class="col20"><span id="{{$gallery->id}}" class="">Recursos</span></div>
                </div>
            @endforeach

   <form action="/gallery" method="post" enctype="multipart/form-data">
            @csrf
        <br/><br />Titulo:<br/><input type='text' name='title'><br/>
        <br />Descripcion:<br /><textarea name="description" rows="10" cols="40" ></textarea>
        <br/><input type="submit" value=" Añadir Galeria">
    </form>
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
                    $.get('http://celia-tour.test/gallery/delete/'+id, function(respuesta){
                        $(elementoD).parent().parent().remove();
                    });
                    }
                })
            })
        </script>
{{-- <div id="contentmodal">
	<div id="windowsmodarl"> 
     	<div class="col100"> COLOCA TU FORMULARIO AQUÍ </div>
		<div id="actionbutton">
			<div id="acept" class="col50"> COLOCA TU BOTÓN DE ACEPTAR AQUÍ </div>
			<div id="cancel" class="col50"> COLOCA TU BOTÓN DE CANCELAR AQUÍ </div>
		</div>
	</div>
</div> --}}
@endsection