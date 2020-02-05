@extends('layouts/backend')

@section('title', 'insertar escenas destacadas Celia-Tour')

@section('content')
    @isset($highlight)
        <form action="{{ route('highlight.update', ['id' => $highlight->id])}}" method="post">
        @method("put")
    @else
        <form action="{{ route('highlight.store')}}" method='post'>
    @endisset
        @csrf
        <!--Fila: 
        <div><input type='int' name='row' value="{{$highlight->row ?? ''}}"><div>
        Columna: 
        <div><input type='int' name='column' value="{{$highlight->column ?? ''}}"><div>-->
        Nombre de la escena: 
        <div><input type='text' name='title' value="{{$highlight->title ?? ''}}"><div>
        <!--ID escena:
        <div><input type='int' name='id_scene' value="{{$highlight->id_scene ?? ''}}"></div>-->
        Archivo de escena:
        <div><input type='file' name='scene_file' value="{{$highlight->scene_file ?? ''}}"></div>
        <br><input type='submit' value='Aceptar'>
    </form>
@endsection