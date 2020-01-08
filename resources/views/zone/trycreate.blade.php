@extends('layouts.fortend')
<form action="{{ route('zone.store') }}" method="POST">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name">
    <label for="file_image">File Image</label>
    <input type="text" name="file_image">
    <label for="file_miniature">File miniature</label>
    <input type="text" name="file_miniature">
    <input type="submit" value="Añadir">
</form>
