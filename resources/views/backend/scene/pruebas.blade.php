@extends('layouts/backend')

@section('title', 'Agregar escena')

@section('content')

<form  action="{{route('resource.getvideos')}}" method="post">
    @csrf
    <input type="text"name="newId">

    <input type="submit">
</form>
<span>JEJEJE</span>

@endsection