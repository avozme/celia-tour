@extends('layouts.backend')

<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
@section('content')
    <h2>Aquí van los datos de la tabla options</h2>
        
        
        @foreach($options as $op)
            
            <form action="{{ route('options.update', ['id' => $op->id]) }}" method="POST" enctype="multipart/form-data" align="center">
            @csrf
            @if (strpos($op->value, 'png')==true || strpos($op->value, 'PNG')==true || strpos($op->value, 'jpg')==true || strpos($op->value, 'jpeg')==true || strpos($op->value, 'JPG')==true || strpos($op->value, 'JPEG')==true)
                {{$op->key}}: <input type="file" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td><br>
                <img src='{{ url('img/options/'.$op->value) }}' alt='options' height='250px' width='250px'>
            @elseif (strpos($op->value, 'cripcion')==true)
                <input type="hidden" name="option" value="{{$op->value ?? '' }}">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">{{$op->key}}</div>
             
                                <div class="panel-body">
                                    <form>
                                        <textarea class="ckeditor" name="editor1" id="editor1" rows="10" cols="80">
                                            Este es el textarea que es modificado por la clase ckeditor
                                        </textarea>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else          
                {{$op->key}}: <input type="text" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td>
                
            @endif   
            </form> 


                     
            @endforeach
            

@endsection