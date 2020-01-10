@extends('layouts.backend')
@section('content')
    @isset($guidedVisit)
        <form action="{{ route('guidedVisit.update', $guidedVisit->id) }}" method="post" enctype="multipart/form-data">    
        @method('PATCH')
    @else
        <form action="{{ route('guidedVisit.store') }}" method="post" enctype="multipart/form-data">
    @endisset
    @csrf
    <label for="name">Nombre</label>
    <input type="text" name="name" value="{{$guidedVisit->name ?? ''}}"><br>
    <label for="description">Descripción</label>
    <input type="text" name="description" value="{{$guidedVisit->description ?? ''}}"><br>
    <label for="file_preview">Vista previa</label>
    <input type="text" name="file_preview" value="{{$guidedVisit->file_preview ?? ''}}"><br>
    <input type="submit" value="Guardar">
</form>
@endsection