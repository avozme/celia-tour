@extends('layouts.backend')
@section('content')
<div id="b" class="col40 xlMarginBottom ">
    <form id="buscador" action="{{route('gallery.edit_resources', $gallery->id)}}" method="GET">
            <input class="search_input" type="text" name="texto" placeholder="Search..." onchange="formulario()" >
            <input type="submit"value="Buscar">
        </form>
    </div>
<form method="POST" action="/gallery/{{ $gallery->id ?? ''}}/update_resources" enctype="multipart/form-data">
            @csrf
    @foreach ($resources as $r )
        @php
            $estaEnLista = false
        @endphp
        @isset($gallery->resources)
        @foreach ($gallery->resources as $g )
            @if($g->id == $r->id)
                <div class="col20"><input type="checkbox" name="resources[]" value="{{$r->id}}" checked><img src={{url( $r->route)}} weigth="100px" height="100px"></i></div>
                @php
                    $estaEnLista = true
                @endphp
                @break
            @endif
        @endforeach
        @endisset
        @if (!$estaEnLista)
            <div class="col20"><input type="checkbox" name="resources[]" value="{{$r->id}}"><img src= {{url( $r->route)}} weigth="100px" height="100px"></i></div>
        @endif    
    @endforeach
<input type="submit" name="edit" value="Guardar">
        </form>
        <input type="button" name="cancel" value="Cancelar" onclick="window.location.href='/gallery'"><br />    

<script>
    function formulario(){
        var valorAction = $("#buscador").attr('action');
        var texto = $(".search_input").val();
        $("#buscador").attr('action', valorAction+'/'+texto);
    }
</script>
@endsection