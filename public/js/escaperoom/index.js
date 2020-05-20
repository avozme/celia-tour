$().ready(function(){
    //BOTÓN DE AÑADIR NUEVO ESCAPE ROOM
    $('#addEscapeRoom').click(function(){
        $('#modalNewEscapeRoom').show();
        $('#modalWindow').show();
    });

    //CERRAR MODALES
    $(".closeModal").click(function(){
        $("#modalWindow").hide();
        $(".window").hide();
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
            $('#modalWindow, .window').hide();
        }
    });

    //PRUEBA DE SELECT
    
});