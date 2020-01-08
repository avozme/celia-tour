@extends('layouts/backend')

@section('title', 'Agregar escena')

@section('content')
    <center>
        <form enctype='multipart/form-data' action="{{route('scene.store')}}" method="post">
            @csrf
            <input type="file" required="required" name="image360" accept=".png, .jpg, .jpeg">
            <br><br>
            <button type="submit">Agregar</button>
        </a>    
    </center>
@endsection