@extends('layouts/backend')

@section('title', 'Agregar escena')

@section('content')

<form  action="{{route('hotspot.store')}}" method="post">
    @csrf
    <input type="text"name="title">
    <input type="text"name="description">
    <input type="text"name="pitch">
    <input type="text"name="yaw">
    <input type="text"name="type">
    <input type="text"name="highlight_point">
    <input type="text"name="scene_id">
    <input type="submit">
</form>
<span>JEJEJE</span>

@endsection