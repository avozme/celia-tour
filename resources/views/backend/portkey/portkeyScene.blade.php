@extends('layouts.backend')

@section('headExtension')
	<script src="{{url('js/portkey/index.js')}}"></script>
@endsection
@section('content')
	<div>
	<h2>Portkeys</h2>
	
		<button id="newportkey"> Añadir </button>
		<button id="volver"> Volver </button> 
        
		<table>
		@foreach($portkeySceneList as $prk)
			<tr id={{$prk->id}}>
				<td>{{ $prk->name }}</td> 
				<td><button class="newportkeyedit"> Previsualizar </button></td>
				<td><button class="deleteportkey"> Eliminar </button></td>
			</tr>

		@endforeach
	</table>
	</div>
@endsection