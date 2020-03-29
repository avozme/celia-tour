@extends('layouts.backend')
@section('content')
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
<div  class="col25 xlMarginBottom ">
    <button class="update" onclick="window.location.href='{{route('gallery.index')}}'">Guardar</button>
</div>
<div class="col100" id="container">
    <form method="POST" action="/gallery/{{ $gallery->id ?? ''}}/update_resources" enctype="multipart/form-data">
         @csrf
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
                <div class="preview col100 l2"><img class="l2"src="{{url('img/resources/'.$r->route)}}" weigth="100px" height="100px"></i></div>
                </div>
            </div>
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
        var url = "{{url('')}}";
        if( $(this).prop("checked")){
            estado="true";
        }else{
            estado="false";
        }
        console.log(estado);
        console.log(idGaleria);
        if(estado=="true"){
            $.get(url+'/gallery/save_resource/'+idGaleria+'/'+elemento, function(respuesta){
            console.log("entre pòr el if");
        }); 
        }else{
            $.get(url+'/gallery/delete_resource/'+idGaleria+'/'+elemento, function(respuesta){
            console.log("entre pòr el else");
        });
        }
    });
</script>
@endsection