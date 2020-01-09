@extends('layouts.frontend')
<form action="{{ route('zone.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name"><br><br>
    <label for="file_image">File Image</label>
    <input type="file" name="file_image"><br><br>
    <label for="file_miniature">File miniature</label>
    <input type="file" name="file_miniature"><br><br>
    <input type="submit" value="Añadir">
</form>
