@extends('layouts.backend')

@section('headExtension')
	<script src="{{url('js/portkey/index.js')}}"></script>
@endsection
@section('content')
	<div>
	<h2>Portkeys</h2>
	
        <button id="newportkey"> Añadir </button> 
        
		<table>
		@foreach($portkeyList as $prk)
			<tr id={{$prk->id}}>
				<td>{{ $prk->name }}</td> 
				<td><button class="newportkeyedit"> Editar </button></td>
				<td><button class="deleteportkey delete" > Eliminar </button></td>
			</tr>

		@endforeach
	</table>
	</div>
@endsection
@section('modal')
    <!-- Form añadir portkey -->
    <div id="modalportkey" class="window" style="display:none">
        <span class="titleModal col100">Nuevo Portkey</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
			<form action="{{ route('portkey.store') }}" method="post">
                @csrf
				<input type="text" name="name" placeholder="Nombre" required><br>
				<input type="submit" value="guardar(sin ajax)">
			</form>
        </div>
	</div>
	<div id="modalportkeyedit" class="window" style="display:none">
        <span class="titleModal col100">Editar portkey</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
			<form id="modificarportkey" method="post">
				@csrf
				@method('PATCH')
			<input type="text" name="name" placeholder="Nombre" required><br>
				<input type="submit" value="guardar(sin ajax)">
			</form>
			<button id="portkeyscene"> Añadir escenas </button>
        </div>
    </div>
@endsection
