@extends('layouts.backend')

@section('content')
    <div id="title" class="col20"></div>
    <div id="contentbutton"></div>
    <div id="content" class="col100">
        <form action="{{ route('zone.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name"><br><br>
            <label for="file_image">File Image</label>
            <input type="file" name="file_image"><br><br>
            <label for="file_miniature">File miniature</label>
            <input type="file" name="file_miniature"><br><br>
            <label for="position">Position</label>
            <input type="number" name="position"><br><br>
            <input type="submit" value="Añadir">
        </form>
    </div>
@endsection
