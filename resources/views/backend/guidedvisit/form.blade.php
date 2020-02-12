@extends('layouts.backend')
@section('content')
    <div id="title" class="col80">Visitas guiadas</div>
    @isset($guidedVisit)
        <form action="{{ route('guidedVisit.update', $guidedVisit->id) }}" method="post" enctype="multipart/form-data">    
        @method('PATCH')
    @else
        <form action="{{ route('guidedVisit.store') }}" method="post" enctype="multipart/form-data">

    @endisset
    @csrf

    <!-- Formulario para crear una vista guiada -->
    <div id="content" class="col100"> 
        <div class="col30"><label for="name">Nombre</label></div>
        <div class="col30"><label for="description">Descripción</label></div>
        <div class="col30"><label for="file_preview">Vista previa</label></div>
        <div style="clear: both;">
            <div class="col30"><input type="text" name="name" value="{{$guidedVisit->name ?? ''}}" placeholder="Nombre" required><br></div>
            <div class="col30"><textarea name="description" placeholder="Descripción..." required>{{$guidedVisit->description ?? ''}}</textarea><br></div>
            @isset($guidedVisit->file_preview)
                <div class="col30"><input type="file" name="file_preview"><br></div>    
            @else
                <div class="col30"><input type="file" name="file_preview" required><br></div>
            @endisset
            
        </div>
    </div>
    <input type="submit" value="guardar">
</form>
@endsection