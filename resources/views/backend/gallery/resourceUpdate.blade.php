@extends('layouts.backend')
@section('content')
@section('headExtension')
<!--SCRIPT -->
<script src="{{url('js/gallery/galleryResources.js')}}" ></script> 
@endsection

    <!-- TITULO -->
    <div class="col0 sMarginRight">
        <svg class="btnBack" onclick="window.location.href='{{ route('gallery.index') }}'" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 405.333 405.333" style="enable-background:new 0 0 405.333 405.333;" xml:space="preserve">
            <polygon points="405.333,96 362.667,96 362.667,181.333 81.707,181.333 158.187,104.853 128,74.667 0,202.667 128,330.667 
                158.187,300.48 81.707,224 405.333,224"/>        
        </svg>
    </div>
    <div id="title" class="col80 xlMarginBottom">
        <span>{{ $gallery->title }}</span>
    </div>

<!--BUSCADOR-->
<div id="b" class="col45 xlMarginBottom ">
    <form id="buscador" action="{{route('gallery.edit_resources', $gallery->id)}}" method="GET">
        <input class="search_input" type="text" name="texto" placeholder="Search..." onchange="formulario()" >
        <input type="submit" value="Buscar">
    </form>
</div>
<div class="col30 xlMarginBottom ">
    @if($estado=="true")
    <form id="buscador" action="{{route('gallery.edit_resources', $gallery->id)}}" method="GET">
        <input class="search_input" type="hidden" name="texto" onchange="formulario()" >
        <input type="submit" value="Ver todas las Imagenes">
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
                    <label class="image-checkbox">
                        <input type="checkbox" name="resources[]" value="{{$r->id}}" class="seleccionado l3 absolute" style="bottom:0; left:0;" checked>
                        <div class="preview col100 l2"><img src="{{url('img/resources/miniatures/'.$r->route)}}" weigth="100px" height="100px"></i></div>
                    </label>
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
                <label class="image-checkbox">
                    <input type="checkbox" name="resources[]" value="{{$r->id}}" class="seleccionado l3 absolute" style="bottom:0; left:0;">
                    <div class="preview col100 l2"><img class="l2"src="{{url('img/resources/miniatures/'.$r->route)}}" weigth="100px" height="100px"></i></div>
                </label>
                </div>
            </div>
            @endif    
        @endforeach
        <input type="hidden" name="gallery_id" class="idgaleria" id="{{$gallery->id}}">
    </form>
</div>
<script>
    /*Dato necesario para guardar y eliminar recursos de una galeria.*/
    var url = "{{url('')}}";
</script>
@endsection