@extends('layouts.backend')
<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
<style>
button{
    margin: 5px;
}
</style>
@section('content')
    <h2>Opciones generales</h2>
        @foreach($options as $op)
            <button class="col30 btnopciones" id="{{$op->id}}">{{$op->key}}</button>
        @endforeach
        <div class="col100" id="contenido" aling="center"></div>
        <div class="col100" id="textaarea" style="display:none">
            <input type="hidden" name="option" value="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading" id="titulo"></div>
             
                                <div class="panel-body">
                                    <form>
                                        <textarea class="ckeditor" name="option"  id="editor1" rows="10" cols="80">
                                            
                                        </textarea><br/>
                                        <input type="submit" value="Editar">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <script>
        var data = @JSON($options);
        $(".btnopciones").click(function(){
            $("#textaarea").css("display", "none");
            $("#contenido").empty();
            console.log("hago click");
            var idop=$(this).attr("id");
            console.log(idop);
            console.log(data);
            for(var i=0; i<data.length; i++){
                console.log(data[i].id);
                if(data[i].id == idop){
                    $("#contenido").append("<form action='{{ route('options.update', ['id' => "+idop+"])}}'  method='POST' enctype='multipart/form-data' aling='center'>"); //Cabecera del form
                    $("#contenido").append("<input type='hidden' name='_token' value='LWraQPJuNDpRsfmJdYIOq6gdBKMCO9SJtCwosb4o'>"); //Añadimos la protección de laravel  
                    //Aqui hacemos un if para que añada según el tipo de opción que sea:
                    if(data[i].type=="file"){
                        $("#contenido").append("<p>"+data[i].key+"</p>"); //Contenido del form
                        $("#contenido").append("<input type='file' name='option' value='"+data[i].value+"'> <br/><br/><img src'{{url('img/options/"+data[i].value+"')}} alt='options' height='250px' wigth='250px'> <br/><br/><input type='submit' value='Editar'>");
                    }else if(data[i].type=="textarea"){
                        $("#cabecera").val(data[i].val);
                        $("#titulo").append(data[i].key+"<br/><br/>")
                        $('#try').text(data[i].value);
                        $("#textaarea").css("display", "block");
                    }else if(data[i].type=="list"){
                        $("#contenido").append(data[i].key+": <select name='option' id='opciones'><option value='Spartan'>Spartan</option><option value='Acme'>Acme</option><option value='Domine'>Domine</option><option value='Gloria Hallelujah'>Gloria Hallelujah</option><option value='PT Mono'>PT Mono</option><option value='Poiret One'>Poiret One</option><option value='Indie Flower'>Indie Flower</option><option value='Rubik'>Rubik</option><option value='Raleway'>Raleway</option></select><br/><br/><input type='submit' value='Editar'>");
                    }else if(data[i].type=="boton"){
                        $("#contenido").append(data[i].key+": <select name='option'><option value='Si'>Si</option><option value='No'>No</option></select><br/><br/><input type='submit' value='Editar'>"); //Contenido del form
                    }else if(data[i].type=="selector"){
                        $("#contenido").append(data[i].key+":<select name='option'><option value='Mapa'>Mapa</option><option value='Ascensor'>Ascensor</option></select><br/><br/><input type='submit' value='Editar'>")
                    }else if(data[i].type=="color"){
                        $("#contenido").append(data[i].key+":<input type=color name='option' value='{{"+data[i].value+"?? '' }}'><br/><br/><input type='submit' value='Editar'>");
                    }else{
                        $("#contenido").append(data[i].key+": <FONT FACE='roman'> <input type='text' name='option' value='"+data[i].value+"'></FONT><br/><br/><input type='submit' value='Editar'>");
                    }
                    $("#contenido").append("</form>"); //Cierre del form
                }
            }
        })

        var id = "{{$options[10]->value}}";
        $("#opciones option[value='" + id + "']").attr("selected","selected");
    </script>
@endsection