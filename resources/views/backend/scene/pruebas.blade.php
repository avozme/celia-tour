@extends('layouts/backend')

@section('title', 'Agregar escena')

@section('content')

<form  action="{{route('scene.setViewDefault',13)}}" method="post">
    @csrf
    <input type="text"name="pitch">
    <input type="text"name="yaw">
    <input type="submit">
</form>
<span>JEJEJE</span>

@endsection