@extends('layouts.backend')
@section('content')
<div id="b" class="col70 xlMarginBottom ">
    <form id="buscador" action="{{route('gallery.edit_resources', $gallery->id)}}" method="GET">
        <input class="search_input" type="text" name="texto" placeholder="Search..." onchange="formulario()" >
        <input type="submit"value="Buscar">
    </form>
</div>
<div  class="col30 xlMarginBottom ">
    <button class="update" onclick="window.location.href='/gallery'">Guardar</button>
    <button name="dalete" class="delete" onclick="window.location.href='/gallery'">Cancelar</button>  
</div>
<div class="col100">
    <form method="POST" action="/gallery/{{ $gallery->id ?? ''}}/update_resources" enctype="multipart/form-data">
         @csrf
        @foreach ($resources as $r )
            @php
                $estaEnLista = false
            @endphp
            @isset($gallery->resources)
            @foreach ($gallery->resources as $g )
                @if($g->id == $r->id)
                    <div class="col20"><input type="checkbox" name="resources[]" value="{{$r->id}}" class="seleccionado" checked><img src={{url( $r->route)}} weigth="100px" height="100px"></i></div>
                    @php
                        $estaEnLista = true
                    @endphp
                    @break
                @endif
            @endforeach
            @endisset
            @if (!$estaEnLista)
                <div class="col20"><input type="checkbox" name="resources[]" value="{{$r->id}}" class="seleccionado"><img src= {{url( $r->route)}} weigth="100px" height="100px"></i></div>
            @endif    
        @endforeach
        <input type="hidden" name="gallery_id" class="idgaleria" id="{{$gallery->id}}">
    </form>
</div>
<script>
    function formulario(){
        var valorAction = $("#buscador").attr('action');
        var texto = $(".search_input").val();
        $("#buscador").attr('action', valorAction+'/'+texto);
    }

    $(".seleccionado").click(function(){
        elemento = $(this).attr("value");
        idGaleria= $(".idgaleria").attr('id');
        console.log(idGaleria);
        $.get('http://celia-tour.test/gallery/save_resource/'+idGaleria+'/'+elemento, function(respuesta){
        });
    });
</script>
@endsection