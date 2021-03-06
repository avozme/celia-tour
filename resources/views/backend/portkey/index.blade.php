@extends('layouts.backend')

@section('headExtension')
	<script src="{{url('js/portkey/index.js')}}"></script>
@endsection
@section('content')
<script>
var ruta = "{{url('')}}";
</script>
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
	</div>
		
		{{-- CONTENIDO --}}
        <div id="content" class="col100 centerH">
			<table class="col70">
				<tr>
					<td class="col70 sPadding"><strong>Nombre</strong></td>
				</tr>

				@foreach($portkeyList as $prk)
				<tr id={{$prk->id}}>
					<td class="col50 sPadding">{{ $prk->name }}</td> 
					<td class="col15 sPadding"><button class="newportkeyedit col100"> Editar </button></td>
					<td class="col15 sPadding"><button type="button" id="portkeyscene" class="col100 bBlack" onclick="window.location.href='{{ route('portkey.mostrar', $prk->id) }}'"> Escenas </button></td>
					<td class="col15 sPadding"><button id="{{$prk->id}}" class="deleteportkey delete col100" > Eliminar </button></td>
				</tr>
				@endforeach
			</table>
        </div>
	</div>
@endsection
@section('modal')
<!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR PORTKEYS -->
	<div class="window" id="confirmDelete" style="display: none;">
		<span class="titleModal col100">¿Eliminar portkey?</span>
		<button id="closeModalWindowButton" class="closeModal" >
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
			<polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
		</svg>
		</button>
		<div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
			<button id="aceptDelete" class="delete">Aceptar</button>
			<button id="cancelDelete" >Cancelar</button>
		</div>
	</div>
    <!-- Form añadir portkey -->
    <div id="modalportkey" class="window" style="display:none">
        <span class="titleModal col100">NUEVO TRASLADOR</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="col100 centerH">
			<form action="{{ route('portkey.store') }}" method="post" class="col50">
                @csrf
				<input type="text" name="name" placeholder="Nombre" class="col100 xlMarginTop" required><br>
				<input type="submit" value="Guardar" class="col100 mMarginTop">
			</form>
        </div>
	</div>

	<div id="modalportkeyedit" class="window" style="display:none">
        <span class="titleModal col100">EDITAR TRASLADOR</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            	<polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        	</svg>
		</button>
		
        <div class="col100 centerH">
			<div class="col50">
				<form id="modificarportkey" method="post">
					@csrf
					@method('PATCH')
					<input type="text" name="name" placeholder="Nombre" class="col100 xlMarginTop" required>
					<input type="submit"  class="col100 lMarginTop" value="Guardar">
				</form>
				
			</div>
        </div>
    </div>
@endsection
