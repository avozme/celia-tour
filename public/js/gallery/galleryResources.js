$().ready(function(){
    /*Función para que funcione el buscador.*/ 
    function formulario(){
        var valorAction = $("#buscador").attr('action');
        var texto = $(".search_input").val();
        $("#buscador").attr('action', valorAction+'/'+texto);
    }
    /*Función para guardar o eliminar un recurso de una galeria*/ 
    $(".seleccionado").click(function(){
        elemento = $(this).attr("value");
        idGaleria= $(".idgaleria").attr('id');
        if( $(this).prop("checked")){
            estado="true";
        }else{
            estado="false";
        }
        console.log(estado);
        console.log(idGaleria);
        if(estado=="true"){
            $.get(url+'/gallery/save_resource/'+idGaleria+'/'+elemento, function(respuesta){
        }); 
        }else{
            $.get(url+'/gallery/delete_resource/'+idGaleria+'/'+elemento, function(respuesta){
        });
        }
    });

});