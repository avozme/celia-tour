@extends('layouts/backend')

@section('title', 'Zonas Destacadas Celia-Tour')

@section('content')

<div id="title" class="col80"><h1>Zonas Destacadas</h1></div>

<div id="contentbutton" class="col20">
    <input type="button" value="Insertar Zona Destacada" onclick="window.location.href='{{ route('highlight.create')}}'">
</div>

<div id="content" class="col100">
    <table>
        <tr>
            @php 
                $i=0;
            @endphp
            @foreach($highlightList as $highlight)
                <td>
                    <br><br>
                    <div class="col100" align='center'>
                        {{$highlight->title}}
                    </div>
                    <div class='col100' align='center'>
                        <img style="height:120px;" src='{{ url('img/highlights/miniaturas/'.$highlight->scene_file)}}'>
                    </div>
                    <div class="col50" align='center'>
                        <input type="button" value="Modificar" onclick="window.location.href='{{ route('highlight.edit', $highlight->id) }}'">
                    </div>
                    <div class="col50" align='center'>
                        <input type="button" value="Eliminar" onclick="window.location.href='{{ route('highlight.borrar', $highlight->id) }}'">
                    </div>
                </td>
                @php 
                    $i = $i + 1;
                    if ($i % 3 == 0){
                        echo "</tr><tr>";
                        $i = 0;
                    }
                @endphp
            @endforeach
        </tr>           
    </table><br><br><br><br>
</div>

<div id="contentmodal">
    <div id="windowsmodal">
        <div class="col100">
        </div>
        <div id="actionbutton">
            <div id="acept" class="col50">
            <div id="cancel" class="col50">
        </div>
    </div>
</div>
@endsection