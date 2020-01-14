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
    <input type="text" name="name" value="{{$guidedVisit->name ?? ''}}" placeholder="Nombre" required><br>
    <label for="description">Descripción</label>
    <textarea name="description" placeholder="Descripción..." required>{{$guidedVisit->description ?? ''}}</textarea><br>
    <label for="file_preview">Vista previa</label>
    <input type="file" name="file_preview" value="{{$guidedVisit->file_preview ?? ''}}" required><br>
    <input type="submit" value="Guardar">
</form>
@endsection