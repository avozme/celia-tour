@extends('layouts.backend')
@section('headExtension')
    <script src="{{url('js/guidedVisit/index.js')}}"></script>
    <style>
        img {
            max-width: 100%;
            min-width: 100%;
        }
    </style>
@endsection
@section('content')
    <div id="title" class="col80">Visitas guiadas</div>
    <div id="contentbutton" class="col20">
        <button id="btn-add">Añadir</button>
    </div>
    <div id="content" class="col100">
        <div class="col5">ID</div>
        <div class="col15">Nombre</div>
        <div class="col30">Descripción</div>
        <div class="col20">Vista previa</div>
        <div class="col10">Escenas</div>
        <div class="col10">Modificar</div>
        <div class="col10">Eliminar</div>
        <div id="tableContent">
            @foreach ($guidedVisit as $value)
            {{-- Modificar este div y su contenido afectara a la insercion dinamica mediante ajax --}}
                <div id="{{$value->id}}" style="clear: both;">
                    <div class="col5">{{$value->id}}</div>
                    <div class="col15">{{$value->name}}</div>
                    <div class="col30">{{$value->description}}</div>
                    <div class="col20"><img src="/img/guidedVisit/miniatures/{{$value->file_preview}}"></div>
                    <div class="col10"><button onclick="window.location.href='{{ route('guidedVisit.scenes', $value->id) }}'">Escenas</button></div>
                    <div class="col10"><button class="btn-update">Modificar</button></div>
                    <div class="col10"><button class="btn-delete">Eliminar</button></div>
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
                        <div class="col30"><input id="fileValueUpdate" type="file" name="file_preview"><br></div>
                    </div>
                </div>
            </form>
            <!-- Botones de control -->
            <div id="actionbutton">
                <div id="acept" class="col20"> <button id="btn-saveUpdate">Guardar</button> </div>
            </div>
        </div>
    </div>
@endsection