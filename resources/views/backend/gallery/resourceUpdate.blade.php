@extends('layouts.backend')
@section('content')
<form method="POST" action="/gallery/{{ $gallery->id }}/update_resources" enctype="multipart/form-data">
            @csrf
    @foreach ($resources as $r )
        @php
            $estaEnLista = false
        @endphp
        @isset($gallery->recursos)
        @foreach ($gallery->recursos as $g )
            @if($g->id == $r->id)
                <div class="col20"><input type="checkbox" name="recursos[]" value="{{$r->id}}" checked><img src={{url( $r->route)}} weigth="100px" height="100px"></i></div>
                @php
                    $estaEnLista = true
                @endphp
                @break
            @endif
        @endforeach
        @endisset
        @if (!$estaEnLista)
            <div class="col20"><input type="checkbox" name="recursos[]" value="{{$r->id}}"><img src= {{url( $r->route)}} weigth="100px" height="100px"></i></div>
        @endif    
    @endforeach
<input type="submit" name="edit" value="Guardar">
        </form>
        <input type="button" name="cancel" value="Cancelar" onclick="window.location.href='/gallery'"><br />    
@endsection