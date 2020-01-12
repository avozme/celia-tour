@extends('layouts.backend')
<script>
function init(x) {
if (x=="h") {document.getElementById('txtbox').style.display='none';document.getElementById('text').style.display='block';}
if (x=="s") {document.getElementById('txtbox').style.display='block';document.getElementById('text').style.display='none';}
document.getElementById('text').value=document.getElementById('txtbox').innerHTML;
if (x!="h" || x!="s") document.execCommand(x,false,null);
document.getElementById('txtbox').focus();
}
</script>
@section('content')
    <h2>Aquí van los datos de la tabla options</h2>
        
        
        @foreach($options as $op)
            
            <form action="{{ route('options.update', ['id' => $op->id]) }}" method="POST" enctype="multipart/form-data" align="center">
            @csrf
            @if (strpos($op->value, 'png')==true || strpos($op->value, 'PNG')==true || strpos($op->value, 'jpg')==true || strpos($op->value, 'jpeg')==true || strpos($op->value, 'JPG')==true || strpos($op->value, 'JPEG')==true)
                {{$op->key}}: <input type="file" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td><br>
                <img src='{{ url('img/options/'.$op->value) }}' alt='options' height='250px' width='250px'>
            @elseif (strpos($op->value, 'cripcion')==true)
                <input type="hidden" name="option" value="{{$op->value ?? '' }}"> </td>
                <p> 
                <button onclick="init('bold')">Negrita</button>
                <button onclick="init('italic')">Itálica</button>
                <button onclick="init('underline')">Subrayado</button>
                <button onclick="init('justifycenter')">Centrado</button>
                <button onclick="init('increasefontsize')">Fuente +</button>
                <button onclick="init('inserthorizontalrule')">Línea Hr.</button>
                <button onclick="init('redo')">Rehacer</button>
                <button onclick="init('undo')">Deshacer</button>
                <button onclick="init('s')">Vista Real</button>
                <button onclick="init('h')">Vista HTML</button>
                </p>
                <div id="txtbox" contenteditable="true">
                <h2>{{$op->value}}</h2>
                <p>Escribe aquí ...</p>
                <p>Etc ...</p>
                </div>
                <textarea id="text" name="text"></textarea>
            @else          
                {{$op->key}}: <input type="text" name="option" value="{{$op->value ?? '' }}"> <input type="submit" value="Editar"></td>
                
            @endif   
            </form> 

                     
            @endforeach
            
            
            

@endsection