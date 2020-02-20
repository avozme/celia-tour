@extends('layouts.backend')

@section('headExtension')
    <script src="{{url('js/portkey/index.js')}}"></script>
    <!-- Recursos de zonas -->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>

    <!-- MDN para usar sortable -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

@endsection
@section('content')
	<div>
	<h2>Selección de escenas</h2>
	
        <button id="newportkey"> Añadir </button>
        <button onclick="window.location.href='{{ route('portkey.index')}}'"> Volver </button>  
        
		<table id="tableContent">
            
		@foreach($portkeySceneList as $prk)
            <tr id={{$prk->id}}>
                <td>{{ $portkey->name }}</td>
                <td>{{ $prk->name }}</td> 
				<td><button class="newportkeyedit"> Previsualizar </button></td>
				<td><button class="deleteScene"> Eliminar </button></td>
			</tr>

		@endforeach
	</table>
	</div>
@endsection
@section('modal')
    <!-- Form añadir portkey -->
    <div id="modalportkey" class="window" style="display:none">
        <span class="titleModal col100">Nueva escena</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
			@include('backend.zone.map.zonemap')
        </div>

        <!-- form para guardar la escena -->
        <form id="addsgv" style="clear:both;" action="{{ route('portkey.guardar', $portkey->id) }}" method="post">
            @csrf
            <input id="sceneValue" type="text" name="scene" value="" hidden>
        </form>

        <!-- Botones de control -->
        <div id="actionbutton">
            <div id="acept" class="col20"> <button class="btn-acept">Guardar</button> </div>
        </div>
	</div>
@endsection
