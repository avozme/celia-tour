@extends('layouts.backend')
@section('headExtension')
    <script src="{{url('js/question/index.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/question/question.css')}}" />

    <!-- URL GENERADAS PARA SCRIPT -->
    <script>
        // Para las urls con identificador se asignara 'insertIdHere' por defecto para posteriormente modificar ese valor.
        const questionDelete = "{{ route('question.destroy', 'insertIdHere') }}";
        const questionEdit = "{{ route('question.edit', 'insertIdHere') }}";
    </script>
@endsection
@section('content')



    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
        <span>Preguntas</span>
    </div>

    <!-- BOTON AGREGAR -->   
    <div class="col20 xlMarginBottom">   
        <button class="right round col45" id="btn-add">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                        8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
            </svg>
        </button>
    </div>

    <!-- TABLA DE CONTENIDO -->
    <div id="content" class="col100 centerH">
        <div class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="sPadding"><strong>Texto</strong></div>
            </div>

            <div id="tableContent">
                @foreach ($question as $value)
                {{-- Modificar este div y su contenido afectara a la insercion dinamica mediante ajax --}}
                    <div id="{{$value->id}}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                        <div class="col70 sPadding">{{$value->text}}</div>
                        <div class="col12 sPadding"><button class="btn-update col100">Editar</button></div>
                        <div class="col12 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
                    </div>
                {{----------------------------------------------------------------------------------------}}
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('modal')

    <!-- FORM NUEVO QUESTION -->
    <div id="modalQuestionAdd" class="window" style="display:none">
        <span class="titleModal col100">NUEVA PREGUNTA</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="col100">
			<form id="formAdd" action="{{ route('question.store') }}" method="POST" class="col100">
                @csrf
                <p class="xlMarginTop">Pregunta<span class="req">*<span></p>
                <input type="text" id="textAdd" name="text" class="col100" required><br>

                <p class="xlMarginTop">Tipo de pregunta<span class="req">*<span></p>
                <input type="radio" id="typeUnique" name="type" value="unique_answer" checked>
                <label for="typeUnique">Pregunta unica</label>
                <input type="radio" id="typeBoolean" name="type" value="boolean">
                <label for="typeBoolean">Verdadero o Falso</label>
                <input type="radio" id="typeTest" name="type" value="test">
                <label for="typeTest">Tipo test</label>
                <br>
                <div class="col50">
                    <p class="xlMarginTop">¿Desbloquea una llave?<span class="req">*<span></p>
                    <input type="radio" id="keyTrue" name="key" value="1">
                    <label for="keyTrue">Si</label>
                    <input type="radio" id="keyFalse" name="key" value="0" checked>
                    <label for="keyFalse">No</label>
                </div>

                <div class="col50">
                    <p class="xlMarginTop">¿Muestra una pista?<span class="req">*<span></p>
                    <input type="radio" id="clueTrue" name="show_clue" value="1">
                    <label for="clueTrue">Si</label>
                    <input type="radio" id="clueFalse" name="show_clue" value="0" checked>
                    <label for="clueFalse">No</label>
                </div>

                @if (count($answer) > 0)
                    <p class="selectAnswer">Seleciona la respuesta correcta</p>
                    <select name="answer">
                        @foreach ($answer as $value)
                            <option value="{{ $value->id }}"> {{ $value->text }} </option>
                        @endforeach
                    </select>
                @endif           
            </form>
            <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop" style="clear: both;">
                <div id="acept" class="col100 centerH"><button id="btn-saveNew" class="col70">Guardar</button> </div>
            </div>
        </div>
    </div>

    <!-- FORM MODIFICAR QUESTION -->
    <div id="modalQuestionUpdate" class="window" style="display:none">
        <span class="titleModal col100">MODIFICAR PREGUNTA</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div class="col100">
			<form id="formUpdate" action="{{ route('question.update', 'insertIdHere') }}" method="POST" class="col100">
                @csrf
                @method("patch")
                <p class="xlMarginTop">Pregunta<span class="req">*<span></p>
                <input type="text" id="textUpdate" name="text" class="col100" required><br>

                <p class="xlMarginTop">Tipo de pregunta<span class="req">*<span></p>
                <input type="radio" id="typeUnique" name="type" value="unique_answer" checked>
                <label for="typeUnique">Pregunta unica</label>
                <input type="radio" id="typeBoolean" name="type" value="boolean">
                <label for="typeBoolean">Verdadero o Falso</label>
                <input type="radio" id="typeTest" name="type" value="test">
                <label for="typeTest">Tipo test</label>
                <br>
                <div class="col50">
                    <p class="xlMarginTop">¿Desbloquea una llave?<span class="req">*<span></p>
                    <input type="radio" id="keyTrue" name="key" value="1">
                    <label for="keyTrue">Si</label>
                    <input type="radio" id="keyFalse" name="key" value="0" checked>
                    <label for="keyFalse">No</label>
                </div>
                
                <div class="col50">
                    <p class="xlMarginTop">¿Muestra una pista?<span class="req">*<span></p>
                    <input type="radio" id="clueTrue" name="show_clue" value="1">
                    <label for="clueTrue">Si</label>
                    <input type="radio" id="clueFalse" name="show_clue" value="0" checked>
                    <label for="clueFalse">No</label>
                </div>

                @if (count($answer) > 0)
                    <p class="selectAnswer">Seleciona la respuesta correcta</p>
                    <select name="answer">
                        @foreach ($answer as $value)
                            <option value="{{ $value->id }}"> {{ $value->text }} </option>
                        @endforeach
                    </select>
                @endif
            </form>
            <!-- Botones de control -->
            <div id="actionbutton" class="col100 lMarginTop" style="clear: both;">
                <div id="acept" class="col100 centerH"><button id="btn-update" class="col70">Guardar</button> </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
    <div class="window" id="confirmDelete" style="display: none;">
        <span class="titleModal col100">¿Eliminar pregunta?</span>
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