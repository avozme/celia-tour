
@extends('layouts.backend')

<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>


@section('content')
    
    <h2>Opciones generales</h2>
        
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
                {{$op->key}}: <select name="option" id="opciones">
                  <option value="Spartan">Spartan</option>
                  <option value="Acme">Acme</option>
                  <option value="Domine">Domine</option>
                  <option value="Gloria Hallelujah">Gloria Hallelujah</option>
                  <option value="PT Mono">PT Mono</option>
                  <option value="Poiret One">Poiret One</option>
                  <option value="Indie Flower">Indie Flower</option>
                  <option value="Rubik">Rubik</option>
                  <option value="Raleway">Raleway</option>
                </select>
                <input type="submit" value="Editar">
            @elseif ($op->type=='boton')
               {{$op->key}}: <select name="option">
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
                <input type="submit" value="Editar">
            @elseif ($op->type=='selector')
                {{$op->key}}:<select name="option">
                  <option value="Mapa">Mapa</option>
                  <option value="Ascensor">Ascensor</option>
                </select>
                <input type="submit" value="Editar">
            @elseif ($op->type=='color')
                {{$op->key}}:<input type=color name="option" value="{{$op->value ?? '' }}">
                <input type="submit" value="Editar">
            @else         
                {{$op->key}}: <FONT FACE="roman"> <input type="text" name="option" value="{{$op->value ?? '' }}"></FONT> <input type="submit" value="Editar"></td>
                
            @endif   
            </form>
            @endforeach
            <!-- SCRIPT PARA MARCA LA FUENTE COMO SELECTED -->
            <script>
                var id = "{{$options[10]->value}}";
                $("#opciones option[value='" + id + "']").attr("selected","selected");
            </script>   
            
@endsection

