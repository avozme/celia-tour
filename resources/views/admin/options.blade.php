@extends('layouts.backend')
@section('content')
    <h2>Aquí van los datos de la tabla options</h2>
        
        
        @foreach($options as $op)
            <td>{{ $op->key }}</td> <br>
            <form action="{{ route('options.update', ['id' => $op->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (strpos($op->value, 'png')==true || strpos($op->value, 'PNG')==true || strpos($op->value, 'jpg')==true || strpos($op->value, 'jpeg')==true || strpos($op->value, 'JPG')==true || strpos($op->value, 'JPEG')==true)
                Value:<input type="file" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td><br>
                <img src='{{ url('img/options/'.$op->value) }}' alt='options' height='250px' width='250px'>
            @else
                Value:<input type="text" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td> 
            @endif   
            </form>


            <td>{{ $op->value }}</td> <br>           
        @endforeach
        
@endsection