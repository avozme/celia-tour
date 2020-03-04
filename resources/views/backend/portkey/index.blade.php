@extends('layouts.backend')

@section('headExtension')
	<script src="{{url('js/portkey/index.js')}}"></script>
@endsection
@section('content')
	<div>
		<!-- TITULO -->
		<div id="title" class="col80 xlMarginBottom">
			<span>TRASLADORES</span>
		</div>
	
		<!-- BOTON AGREGAR -->   
		<div id="contentbutton" class="col20 xlMarginBottom">   
			<button class="right round col45" id="newportkey">
				<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
					<polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
							8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
				</svg>                                        
			</button>
		</div>
        
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
