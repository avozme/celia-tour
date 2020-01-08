@extends('layouts.frontend')
<form action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $zone->name }}"><br><br>
    <!-------------------------------FILE IMAGE------------------------------------------------>
    <label for="file_image">File Image</label>
    <img src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image' height="100" width="150">
    <input type="file" name="file_image"><br><br>
    <!-------------------------------FILE MINIATURE------------------------------------------------>
    <label for="file_miniature">File miniature</label>
    <img src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature' height="100" width="150">
    <input type="file" name="file_miniature"><br><br>
    <input type="submit" value="Editar">
</form>
