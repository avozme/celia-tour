$().ready(function(){

    //ACCIÓN PARA MOSTRAR O NO EL DROPZONE
    $("#btndResource").click(function(){
        if($("#dzone").css("display") == "none"){
            $("#dzone").css("display", "block");
            $("#iconClose").show();
            $("#iconUp").hide();
        }else{
            $("#dzone").css("display", "none");
            $("#iconClose").hide();
            $("#iconUp").show();
        }
    });

    //ACCIÓN PAR QUE SE MUESTRE LA VENTANA MODAL DE SUBIR VIDEO
    $("#btnVideo").click(function () {
        $("#modalWindow").css("display", "block");
        $("#video").css("display", "block");
    });

    //Boton subir ficheros
    $("#fileSubtOwn").on("click", function () {
        $("#fileSubt").click();
    });
    
    //CÓDIGO PARA QUE LAS MODALES SE CIERREN AL PINCHAR FUERA DE ELLAS
    var dentro = false;
    $('.window').on({
        mouseenter: function(){
            dentro = true;
        },
        mouseleave: function(){
            dentro = false;
        }
    });
    $('#modalWindow').click(function(){
        if(!dentro){
            $('.previewResource').empty();
            $('#modalWindow, .window').hide();
            $("#video").css("display", "none");
            $("#edit").css("display", "none");
        }
    });
    
    //CÓDIGO PARA EL BOTÓN DE ELIMINAR VARIOS RECURSOS  
    $("#btnDestroy").click(function(){
        if($(".checkeliminar").css("display") == "block"){
            var elementos =$("input[type=checkbox]:checked");
            console.log(elementos);
            var ids = new Array();
            for(var i=0; i<elementos.length; i++){
                ids.push(elementos[i].id);
            }
<<<<<<< HEAD
            console.log(ids);
            $.ajax({
                url: direccionEliminar,
                type: 'post',
                data: {
                    "ids": ids,
                    "_token": token,
                },
                contentType: false,
                processData: false,
            }).done(function(){
                location.reload();// Recargar página
            });
=======
            eliminarVariosRecursos(ids);
>>>>>>> 343c36c7307858f5e9daad47fc50722adb2920cc
            $("#iconCloseD").hide();
            $("#iconUpD").show();
        }else{
            $("#iconCloseD").show();
            $("#iconUpD").hide();
            $(".elementResource").attr("onclick", "").unbind("click");
            $(".checkeliminar").css("display", "block");
        }
    });
});
