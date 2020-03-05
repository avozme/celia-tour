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
        <span>VITAS GUIADAS</span>
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

    <div id="content" class="col100 centerH">
        <div class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col15 sPadding"><strong>Nombre</strong></div>
                <div class="col30 sPadding"><strong>Descripción</strong></div>
                <div class="col20 sPadding"><strong>Vista previa</strong></div>
            </div>

            <div id="tableContent">
                @foreach ($guidedVisit as $value)
                {{-- Modificar este div y su contenido afectara a la insercion dinamica mediante ajax --}}
                    <div id="{{$value->id}}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                        <div class="col15 sPadding">{{$value->name}}</div>
                        <div class="col30 sPadding">{{$value->description}}</div>
                        <div class="col25 sPadding"><img class="miniature" src="{{ url('/img/resources/'.$value->file_preview) }}"></div>
                        <div class="col10 sPadding"><button data-openupdateurl="{{ route('guidedVisit.openUpdate', $value->id) }}" class="btn-update col100">Editar</button></div>
                        <div class="col10 sPadding"><button onclick="window.location.href='{{ route('guidedVisit.scenes', $value->id) }}'" class="col100">Escenas</button></div>
                        <div class="col10 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
                    </div>
                {{----------------------------------------------------------------------------------------}}
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <!-- Form añadir visita guiada -->
    <div id="newGuidedVisit" class="window" style="display:none">
        <span class="titleModal col100">NUEVA VISITA GUIADA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
            <form id="formadd" action="{{ route('guidedVisit.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100 centerH"> 
                    <div class="col70">
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="name" class="col100">Nombre<span class="req">*<span></label></div>
                            <div class="col100"><input id="nameValue" type="text" name="name" required class="col100 sMarginTop"><br></div>
                        </div>
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="description">Descripción<span class="req">*<span></label></div>
                            <div class="col100"><textarea id="descriptionValue" name="description" required class="col100 sMarginTop" style="height:110px"></textarea><br></div>
                        </div>
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="file_preview">Vista previa <span class="req">*<span></label></div>
                            <div class="col100"><input id="fileValue" type="file" name="file_preview" required class="col100 sMarginTop"><br></div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop">
                <div id="acept" class="col100 centerH"><button id="btn-saveNew" class="col70">Guardar</button> </div>
            </div>
        </div>
    </div>


    <!-- Form modificar visita guiada -->
    <div id="updateGuidedVisit" class="window" style="display:none">
        <span class="titleModal col100">MODIFICAR VISITA GUIADA</span>
        <button class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
            <form id="formUpdate" method="post" enctype="multipart/form-data">
                @csrf
                <div id="content" class="col100 centerH"> 
                    <div class="col70">
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="name">Nombre <span class="req">*<span></label></div>
                            <div class="col100"><input id="nameValueUpdate" class="sMarginTop col100" type="text" name="name" placeholder="Nombre"><br></div>
                        </div>
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="description">Descripción <span class="req">*<span></label></div>
                            <div class="col100"><textarea id="descriptionValueUpdate" class="sMarginTop col100" name="description" placeholder="Descripción..." style="height:80px"></textarea><br></div>
                        </div>
                        <div class="col100 mMarginTop">
                            <div class="col100"><label for="file_preview">Vista previa <span class="req">*<span></label></div>
                            <div class="col100 sMarginTop ">
                                <div class="col100 centerH">
                                    <img id="fileUpdate" class="col60" src=''>
                                </div>
                                <div class="col100 centerH">
                                    <input id="fileValueUpdate" type="file" class="col0 sMarginTop" name="file_preview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop">
                <div id="acept" class="col100 centerH"> <button id="btn-saveUpdate" class="col70">Guardar</button> </div>
            </div>
        </div>
    </div>
@endsection