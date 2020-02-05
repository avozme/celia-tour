@extends('layouts.backend')
@section('content')
    <div id="title" class="col80">Visitas guiadas</div>
    @isset($guidedVisit)
        <form action="{{ route('guidedVisit.update', $guidedVisit->id) }}" method="post" enctype="multipart/form-data">    
        @method('PATCH')
    @else
        <form action="{{ route('guidedVisit.store') }}" method="post" enctype="multipart/form-data">

    @endisset
    @csrf

    <!-- Formulario para crear una vista guiada -->
    <div id="content" class="col100"> 
        <div class="col30"><label for="name">Nombre</label></div>
        <div class="col30"><label for="description">Descripción</label></div>
        <div class="col30"><label for="file_preview">Vista previa</label></div>
        <div style="clear: both;">
            <div class="col30"><input type="text" name="name" value="{{$guidedVisit->name ?? ''}}" placeholder="Nombre" required><br></div>
            <div class="col30"><textarea name="description" placeholder="Descripción..." required>{{$guidedVisit->description ?? ''}}</textarea><br></div>
            @isset($guidedVisit->file_preview)
                <div class="col30"><input type="file" name="file_preview"><br></div>    
            @else
                <div class="col30"><input type="file" name="file_preview" required><br></div>
            @endisset
            
        </div>
    </div>
    <input type="submit" value="guardar">
</form>
    
    <!-- Tabla donde se muestran las escenes de la visita guiada -->
        {{-- <div id="contentbutton" class="col20"> <button class="btn-scene">Añadir una escena</button> </div>
        <div id="content" class="col100 content-scene" style="visibility: hidden;";> 
            <div class="col20">Recurso</div>
            <div class="col20">Escena</div>
            <div class="col20">Posicion</div>
            <div class="col20">Tools</div>
            <div id="fill">
            @isset($sgv)
            @foreach ($sgv as $value)
                <div style="clear: both;">
                    <div class="col20">{{$value->id_resources}}</div>
                    <div class="col20">{{$value->id_scenes}}</div>
                    <div class="col20">{{$value->position}}</div>
                    <div class="col20"><button>Modificar</button></div>
                    <div class="col20"><button>Eliminar</button></div>
                </div>
                @endforeach
            @endisset
            </div>
        </div>            --}}

    <!-- Ventana modal del formulario para añadir una escena a la vista guiada -->
        {{-- <div id="contentmodal">
            <div id="windowsmodarl"> 
                <div class="col100">
                    <h4>Recurso</h4>
                    <select id="resource" name='resource'>
                        @foreach ($resource as $value)
                            <option value="{{ $value->id }}">{{ $value->title }}</option>
                        @endforeach
                    </select><br>
                    <h4>Escena</h4>
                    <select id="scene" name='scene'>
                        @foreach ($scene as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select><br>
                
                    <label for="position">Posicion</label>
                    <input id="position" type="text" name="position" placeholder="1" required><br>
                
                    <!-- <input type="submit" value="Guardar"> -->
                </div>
                <div id="actionbutton">
                    <div id="acept" class="col10"> <button class="btn-acept">Aceptar</button> </div>
                    <div id="cancel" class="col10"> <button class="btn-cancel">Cancelar</button> </div>
                </div>
            </div>
        </div> --}}
    <!-- Fin ventana modal -->

@endsection