@extends('layouts.backend')
@section('content')
    <h2>Aquí van los datos de la tabla options</h2>
    <form action="{{ route('options.update') }}" method="POST">
        @method("PATCH")
        @csrf
        @foreach($options as $op)
            <td>{{ $op->key }}</td> <br>
            Value:<input type="text" name="option[]" value="{{$op->value ?? '' }}"><br> 
            <td>{{ $op->value }}</td> <br>           
        @endforeach
        <input type="submit">
    </form>
@endsection