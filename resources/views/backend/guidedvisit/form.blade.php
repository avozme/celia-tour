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
    
    <h4>Recurso</h4>
    <select name='resource'>
        @foreach ($resource as $value)
            <option value="{{ $value->id }}">{{ $value->title }}</option>
        @endforeach
    </select><br>

    <h4>Escena</h4>
    <select name='scene'>
        @foreach ($scene as $value)
            <option value="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select><br>

    <label for="position">Posicion</label>
    <input type="text" name="position" placeholder="1" required><br>

    <input type="submit" value="Guardar">

    @foreach ($sgv as $value)
        <table>
            <tr>
                <th>id recurso</th>
                <th>id escena</th>
                <th>id visita guiada</th>
                <th>Posición</th>
            </tr>
            <tr>
                <td>{{ $value->id_resources }}</td>
                <td>{{ $value->id_scenes }}</td>
                <td>{{ $value->id_guided_visit }}</td>
                <td>{{ $value->position }}</td>
            </tr>
        </table>    
    @endforeach
    
</form>
@endsection