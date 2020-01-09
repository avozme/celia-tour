@extends('layouts.backend')
@section('content')
    <form method="POST" action="/resources/{{ $resource->id }}" enctype="multipart/form-data">
            @csrf
        Titulo:<br/><input type='text' name='title' value='{{ $resource->title }}'><br/>
        <br />Descripcion:<br /><textarea name="description" rows="10" cols="40" >{{ $resource->description }}</textarea>
        <br />Tipo:<br /> <input type='text' name='type' value={{ $resource->type }}><br />
        <br />Ruta:<br /> <input type='text' name='route' value={{ $resource->route }}><br />
        <input type="submit" name="edit" value=" Guardar">
    <div id="btn">
@endsection