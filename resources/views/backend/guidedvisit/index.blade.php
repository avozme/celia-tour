@extends('layouts.backend')
@section('headExtension')
    <script src="{{url('js/guidedVisit/index.js')}}"></script>
    <style>
        .miniature {
            max-width: 100%;
            min-width: 100%;
        }
    </style>
@endsection
@section('content')
    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>VIITAS GUIADAS</span>
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

    <div id="content" class="col100">
        <div class="col5">ID</div>
        <div class="col15">Nombre</div>
        <div class="col30">Descripción</div>
        <div class="col20">Vista previa</div>

        <div id="tableContent">
            @foreach ($guidedVisit as $value)
            {{-- Modificar este div y su contenido afectara a la insercion dinamica mediante ajax --}}
                <div id="{{$value->id}}" style="clear: both;">
                    <div class="col5">{{$value->id}}</div>
                    <div class="col15">{{$value->name}}</div>
                    <div class="col30">{{$value->description}}</div>
                    <div class="col20"><img class="miniature" src="{{ url('/img/resources/'.$value->file_preview) }}"></div>
                    <div class="col10"><button onclick="window.location.href='{{ route('guidedVisit.scenes', $value->id) }}'">Escenas</button></div>
                    <div class="col10"><button data-openupdateurl="{{ route('guidedVisit.openUpdate', $value->id) }}" class="btn-update">Modificar</button></div>
                    <div class="col10"><button class="btn-delete delete">Eliminar</button></div>
                </div>
            {{----------------------------------------------------------------------------------------}}
            @endforeach
        </div>
    </div>
@endsection
@section('modal')


    <!-- Form añadir visita guiada -->
    <div id="newGuidedVisit" class="window" style="display:none">
        <span class="titleModal col100">Nueva Visita Guiada</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
            <form id="formadd" action="{{ route('guidedVisit.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100"> 
                    <div style="clear: both;">
                        <div class="col30"><label for="name">Nombre</label></div>
                        <div class="col30"><input id="nameValue" type="text" name="name" placeholder="Nombre" required><br></div>
                    </div>
                    <div style="clear: both;">
                        <div class="col30"><label for="description">Descripción</label></div>
                        <div class="col30"><textarea id="descriptionValue" name="description" placeholder="Descripción..." required></textarea><br></div>
                    </div>
                    <div style="clear: both;">
                        <div class="col30"><label for="file_preview">Vista previa</label></div>
                        <div class="col30"><input id="fileValue" type="file" name="file_preview" required><br></div>
                    </div>
                </div>
            </form>
            <!-- Botones de control -->
            <div id="actionbutton">
                <div id="acept" class="col20"> <button id="btn-saveNew">Guardar</button> </div>
            </div>
        </div>
    </div>


    <!-- Form modificar visita guiada -->
    <div id="updateGuidedVisit" class="window" style="display:none">
        <span class="titleModal col100">Modificar Visita Guiada</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
            <form id="formUpdate" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100"> 
                    <div style="clear: both;">
                        <div class="col30"><label for="name">Nombre</label></div>
                        <div class="col30"><input id="nameValueUpdate" type="text" name="name" placeholder="Nombre"><br></div>
                    </div>
                    <div style="clear: both;">
                        <div class="col30"><label for="description">Descripción</label></div>
                        <div class="col30"><textarea id="descriptionValueUpdate" name="description" placeholder="Descripción..."></textarea><br></div>
                    </div>
                    <div style="clear: both;">
                        <div class="col30"><label for="file_preview">Vista previa</label></div>
                        <div class="col30">
                            <img id="fileUpdate" class="miniature" src=''>
                            <br>
                            <input id="fileValueUpdate" type="file" name="file_preview">
                        </div>
                    </div>
                </div>
            </form>
            <!-- Botones de control -->
            <div id="actionbutton">
                <div id="acept" class="col20"> <button id="btn-saveUpdate">Guardar</button> </div>
            </div>
        </div>
    </div>


    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
    <div class="window" id="confirmDelete" style="display: none;">
        <span class="titleModal col100">¿Eliminar recurso?</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
            <button id="aceptDelete" class="delete">Aceptar</button>
            <button id="cancelDelete">Cancelar</button>
        </div>
    </div>
@endsection