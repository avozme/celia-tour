@extends('layouts.backend')
@section('content')
@section('headExtension')
<!--SCRIPT -->
<script src="{{url('js/gallery/galleryResources.js')}}" ></script> 
@endsection
<!--BUSCADOR-->
<div id="b" class="col45 xlMarginBottom ">
    <form id="buscador" action="{{route('gallery.edit_resources', $gallery->id)}}" method="GET">
        <input class="search_input" type="text" name="texto" placeholder="Search..." onchange="formulario()" >
        <input type="submit"value="Buscar">
    </form>
</div>
<div class="col30 xlMarginBottom ">
    @if($estado=="true")
    <form id="buscador" action="{{route('gallery.edit_resources', $gallery->id)}}" method="GET">
        <input class="search_input" type="hidden" name="texto" onchange="formulario()" >
        <input type="submit"value="Ver todoas las Imagenes">
    </form>
    @endif
</div>
<!--BOTÓN DE GUARDAR-->
<div  class="col25 xlMarginBottom ">
    <button class="update" onclick="window.location.href='{{route('gallery.index')}}'">Guardar</button>
</div>
<!--RECURSOS-->
<div class="col100" id="container">
    <form method="POST" action="/gallery/{{ $gallery->id ?? ''}}/update_resources" enctype="multipart/form-data">
         @csrf
         <!--Comprobamos si los recursos estan en la lista de los recursos que pertenecen a una galeria, si lo estan si lo pone el atributo checked, 
         sino se dejan sin el atributo checked-->
        @foreach ($resources as $r )
            @php
                $estaEnLista = false
            @endphp
            @isset($gallery->resources)
            @foreach ($gallery->resources as $g )
                @if($g->id == $r->id)
                <div class="elementResource col166">
                    <div class="insideElement relative">
                    <!-- MINIATURA -->
                    <input type="checkbox" name="resources[]" value="{{$r->id}}" class="seleccionado l3 absolute" style="bottom:0; left:0;" checked>
                    <div class="preview col100 l2"><img src="{{url('img/resources/miniatures/'.$r->route)}}" weigth="100px" height="100px"></i></div>
                </div>
            </div>
                    @php
                        $estaEnLista = true
                    @endphp
                    @break
                @endif
            @endforeach
            @endisset
            @if (!$estaEnLista)
            <div class="elementResource col166">
                <div class="insideElement relative">
                <!-- MINIATURA -->
                <input type="checkbox" name="resources[]" value="{{$r->id}}" class="seleccionado l3 absolute" style="bottom:0; left:0;">
                <div class="preview col100 l2"><img class="l2"src="{{url('img/resources/miniatures/'.$r->route)}}" weigth="100px" height="100px"></i></div>
                </div>
            </div>
            @endif    
        @endforeach
        <input type="hidden" name="gallery_id" class="idgaleria" id="{{$gallery->id}}">
    </form>
</div>
<script>
    /*Dato necesario para guardar y eliminar recursos de una geleria.*/
    var url = "{{url('')}}";
</script>
@endsection