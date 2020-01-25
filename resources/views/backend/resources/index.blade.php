@extends('layouts.backend')
@section('content')
    <div id="title" class="col80">
        Administración de recursos
    </div>
    <div id="contentbutton" class="col20">
        <input type="button" value="Añadir Recursos">
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="content" class="col100">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dropzone.css')}}">
    <!-- JS -->
    <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script>
    <!-- Dropzone -->
    <form action="{{ url('/images-save') }}" method="post" enctype="multipart/form-data" class='dropzone' >
      </form>

    <!-- Script -->
    <script>
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone",{ 
            maxFilesize: 3,  // 3 mb
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
        });
        myDropzone.on("sending", function(file, xhr, formData) {
           formData.append("_token", CSRF_TOKEN);
        }); 
        </script>
    
        {{-- {!! Form::open(['route'=> 'resource.store', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone', 'name' => 'file']) !!}
                    <div class="dz-message" style="height:200px;" name="file">
                        Drop your files here
                    </div>
                    <div class="dropzone-previews"></div>
                    <button type="submit" class="btn btn-success" id="submit">Save</button>
                    {!! Form::close() !!}
                </div>
                {!! Html::script('js/dropzone.js'); !!}
                <script>
                    Dropzone.options.myDropzone = {
                        autoProcessQueue: false,
                        uploadMultiple: true,
                        maxFilezise: 10,
                        maxFiles: 2,
                        
                        init: function() {
                            var submitBtn = document.querySelector("#submit");
                            myDropzone = this;
                            
                            submitBtn.addEventListener("click", function(e){
                                e.preventDefault();
                                e.stopPropagation();
                                myDropzone.processQueue();
                            });
                            
                            this.on("complete", function(file) {
                                myDropzone.removeFile(file);
                            });
             
                            this.on("success", 
                                myDropzone.processQueue.bind(myDropzone)
                            );
                        }
                    };
                </script> --}}
    </div>
    <div id="content" class="col100">
                <div class="col25">Titlo</div>
                <div class="col25">Miniatura</div>
                <div class="col25">Eliminar</div>
                <div class="col25">Editar</div>
            @foreach ($resources as $resources )
                <div id="{{$resources->id}}">
                <div class="col25">{{$resources->title}}</div>
                <div class="col25">Miniatura</div>
                <div class="col25"><span id="{{$resources->id}}" class="delete">Eliminar</span></div>
                <div class="col25"><a href='/resources/{{$resources->id}}/edit'>Modificar</a> </div> 
                </div>
            @endforeach
    </div>
    <div id="contentmodal">
        <div id="windowsmodarl">
            <form action="/resources" method="post" enctype="multipart/form-data">
            @csrf
                <br /> Titlo:<br /> <input type='text' name='title'><br />
                <br /> Descripción:<br /> <input type='text' name='description'><br />
                <br /> Tipo:<br /> <input type='text' name='type'><br />
                <br /> Ruta:<br /> <input type='text' name='route'><br />
                <br /> <input type="submit" value="Añadir Recurso">
            </form>
        </div>
</div>
<script>
            $(function(){
                //.delete es el nombre de la clase
                //peticion_http es el objeto que creamos de Ajax
                $(".delete").click(function(){
                    id = $(this).attr("id");
                    elementoD = $(this);
                    var confirmacion = confirm("¿Esta seguro de que desea eliminarlo?")
                    if(confirmacion){
                    $.get('http://celia-tour.test/resources/delete/'+id, function(respuesta){
                        $(elementoD).parent().parent().remove();
                    });
                    }
                })
            })
        </script>
@endsection