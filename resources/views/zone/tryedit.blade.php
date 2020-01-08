@extends('layouts.frontend')
<form action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST">
    @method('PUT')
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $zone->name }}">
    <label for="file_image">File Image</label>
    <input type="text" name="file_image" value="{{ $zone->file_image }}">
    <label for="file_miniature">File miniature</label>
    <input type="text" name="file_miniature" value="{{ $zone->file_miniature }}">
    <input type="submit" value="Editar">
</form>
