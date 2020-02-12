@extends('layouts.backend')
@section('headExtension')
    <script src="{{url('js/guidedVisit/index.js')}}"></script>
    <script src="{{url('js/closeModals/close.js')}}"></script>
@endsection
@section('content')
    <div id="title" class="col80">Visitas guiadas</div>
    <div id="contentbutton" class="col20">
        <button id="add-guided-visit">Añadir</button>
    </div>
    <div id="content" class="col100">
        <div class="col5">ID</div>
        <div class="col15">Nombre</div>
        <div class="col30">Descripción</div>
        <div class="col20">Vista previa</div>
        <div class="col10">Escenas</div>
        <div class="col10">Modificar</div>
        <div class="col10">Eliminar</div>
        @foreach ($guidedVisit as $value)
        <div style="clear: both;">
            <div class="col5">{{$value->id}}</div>
            <div class="col15">{{$value->name}}</div>
            <div class="col30">{{$value->description}}</div>
            <div class="col20"><img src="/img/guidedVisit/miniatures/{{$value->file_preview}}"></div>
            <div class="col10"><button onclick="window.location.href='{{ route('guidedVisit.scenes', $value->id) }}'">Escenas</button></div>
            <div class="col10"><button onclick="window.location.href='{{ route('guidedVisit.edit', $value->id) }}'">Modificar</button></div>
            <div class="col10"><button class="btn-delete" id="{{$value->id}}">Eliminar</button></div>
        </div>
        @endforeach
    </div>

@section('modal')
    <!-- Form añadir visita guiada -->
    <div id="modal-visit-guided" class="window" style="display:none">
        <span class="titleModal col100">Nueva Visita Guiada</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
            <form action="{{ route('guidedVisit.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100"> 
                    <div style="clear: both;">
                        <div class="col30"><label for="name">Nombre</label></div>
                        <div class="col30"><input type="text" name="name" placeholder="Nombre" required><br></div>
                    </div>
                    <div style="clear: both;">
                        <div class="col30"><label for="description">Descripción</label></div>
                        <div class="col30"><textarea name="description" placeholder="Descripción..." required></textarea><br></div>
                    </div>
                    <div style="clear: both;">
                        <div class="col30"><label for="file_preview">Vista previa</label></div>
                        <div class="col30"><input type="file" name="file_preview" required><br></div>
                    </div>
                </div>
                <input type="submit" value="guardar(test)">
            </form>
            <button>Guardar</button>
        </div>
    </div>
@endsection


@endsection