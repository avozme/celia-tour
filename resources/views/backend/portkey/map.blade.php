@extends('layouts.backend')

@section('headExtension')
    <script src="{{url('js/portkey/map.js')}}"></script>

    <!-- URL GENERADAS PARA SCRIPT -->
    <script>
        // Para las urls con identificador se asignara "insertIdHere" por defecto para posteriormente modificar ese valor.
        const urlResource = "{{ url('img/portkeys') }}/";
        const urlOpenUpdate = "{{ route('portkey.openUpdate', 'insertIdHere') }}";
        const urlUpdate = "{{ route('portkey.update', 'insertIdHere') }}";
        const urlDelete = "{{ route('portkey.delete', 'insertIdHere') }}";
        
    </script>
@endsection

@section('content')


<div>
    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>TRASLADORES TIPO MAPA</span>
    </div>

    <!-- BOTON AGREGAR -->   
    <div id="contentbutton" class="col20 xlMarginBottom">   
        <button class="right round col45" id="btn-add">
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
            <td class="col55 sPadding"><strong>Nombre</strong></td>
        </tr>

        @foreach($portkeyList as $prk)
        <tr id={{$prk->id}}>
            <td class="col55 sPadding">{{ $prk->name }}</td> 
            <td class="col15 sPadding"><button class="openUpdate col100"> Editar </button></td>
            <td class="col15 sPadding"><button class="col100 bBlack"> Escenas </button></td>
            <td class="col15 sPadding"><button class="openDelete delete col100" > Eliminar </button></td>
        </tr>
        @endforeach
    </table>
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


    <!-- FORM NUEVO PORTKEY -->
    <div id="modalPortkeyAdd" class="window" style="display:none">
        <span class="titleModal col100">NUEVO TRASLADOR</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="col100 centerH">
			<form id="formAdd" action="{{ route('portkey.store') }}" method="post" enctype="multipart/form-data" class="col50">
                @csrf
                <input type="text" id="nameAdd" name="name" placeholder="Nombre" class="col100 xlMarginTop" required><br>
                <input type="file" id="imageAdd" name="image" class="col100" accept="image/*" required>
				<input type="submit" value="Guardar" class="col100 mMarginTop">
            </form>
        </div>
	</div>

    {{-- FORM EDITAR PORTKEY --}}
	<div id="modalPortkeyEdit" class="window" style="display:none">
        <span id="titlePortkeyEdit" class="titleModal col100">EDITAR TRASLADOR</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            	<polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        	</svg>
		</button>
		
        <div>
            <form id="formUpdate" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div id="content" class="col100 centerH"> 
                    <div class="col70">
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="name">Nombre <span class="req">*<span></label></div>
                            <div class="col100"><input id="nameUpdate" class="sMarginTop col100" type="text" name="name" placeholder="Nombre"><br></div>
                        </div>
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="image">Imagen<span class="req">*<span></label></div>
                            <div class="col100 sMarginTop ">
                                <div class="col100 centerH">
                                    <img id="fileUpdate" class="col60" src=''>
                                </div>
                                <div class="col100 centerH">
                                    <input id="imageUpdate" type="file" accept="image/*" class="col0 sMarginTop" name="image">
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="submit" class="col100 lMarginTop" value="Guardar">
                        </div>
                    </div>
                </div>
            </form>
            {{-- <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop">
                <div id="acept" class="col100 centerH"> <button id="btn-saveUpdate" class="col70">Guardar</button> </div>
            </div> --}}
        </div>
    </div>
@endsection