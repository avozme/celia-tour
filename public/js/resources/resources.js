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
    
});
