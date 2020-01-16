@extends('layouts.backend')

<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js">
    // "myAwesomeDropzone" es el ID de nuestro formulario usando la notación camelCase
Dropzone.options.myAwesomeDropzone = {
    paramName: "file", // Las imágenes se van a usar bajo este nombre de parámetro
    maxFilesize: 2 // Tamaño máximo en MB
};
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">

@section('content')
    
    <h2>Aquí van los datos de la tabla options</h2>
        
        @foreach($options as $op)
            
            <form action="{{ route('options.update', ['id' => $op->id]) }}" method="POST" enctype="multipart/form-data" align="center"> 
            @csrf
            @if ($op->type=='file')
                {{$op->key}}: <input type="file" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td><br>
                <img src='{{ url('img/options/'.$op->value) }}' alt='options' height='250px' width='250px'>
            @elseif ($op->type=='textarea')
                <input type="hidden" name="option" value="{{$op->value ?? '' }}">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">{{$op->key}}</div>
             
                                <div class="panel-body">
                                    <form>
                                        <textarea class="ckeditor" name="option"  id="editor1" rows="10" cols="80">
                                            {{$op->value}}
                                        </textarea>
                                        <input type="submit" value="Editar">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($op->type=='list')
                <select>
                  <option value="{{$op->value ?? '' }}">Times new roman</option>
                  <option value="{{$op->value ?? '' }}">courier</option>
                  <option value="{{$op->value ?? '' }}">arial</option>
                  <option value="{{$op->value ?? '' }}">small font</option>
                </select>
                <input type="submit" value="Editar">
            @else          
                {{$op->key}}: <FONT FACE="roman"> <input type="text" name="option" value="{{$op->value ?? '' }}"></FONT> <input type="submit" value="Editar"></td>
                
            @endif   
            </form>
            @if ($op->type=='list')
            <style>
                input[type="text"]{
                    font-family: "{{$op->value}}";
                }
            </style>
            @endif
                     
            @endforeach
            
            <form action="{{ asset('/public/img/options') }}"
                class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
                  {{ csrf_field() }}
            </form> 
@endsection