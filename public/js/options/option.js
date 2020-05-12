$( document ).ready(function() {
    //Función para el botón cerrar de la modal
    $(".closeModal").click(function(){
        console.log("hago click en el cerrar ventana");
        $("#img-port").empty();
        $("#modalWindow").css("display", "none");
        $(".window").css("display", "none");
    });

    //CAMBIAR APARIENCIA DE LOS PUNTOS DEL MAPA AL ESTAR SOBRE ELLOS
    $(".scenepoint").hover(function(){
        $(this).attr('src', urlPointSceneHover);
    }, function(){
        if(!($(this).hasClass('selected'))){
            $(this).attr('src', urlPointScene);
        }
    });

    $(".scenepoint").click(function(){
        //Le quito la clase selected a todos los puntos para que la url de la imagen sea la de la imagen blanca
        $('.scenepoint').removeClass('selected');
        $('.scenepoint').attr('src', urlPointScene)
        //Se la añado al punto seleccionado para que se marque como tal
        $(this).addClass('selected');
        $(this).attr('src', urlPointSceneHover);
        var idScene = ($(this).attr('id')).substr(5);
        $("#idScene").val(idScene);
        $('#optionIdScene').val(idScene)
        $('#IdSceneER').val(idScene)
    });
    //Funcionalidad del botón aceptar de la modal
    $("#addPanoramica").click(function(){
        $("#img-port").empty();
        $("#modalWindow").css("display", "none");
        $("#modalMap").css("display", "none");
        $("#mapSlide").css("display", "none"); 
    });

    //ONCLICK DE PREVISUALIZAR ESCENA
    $('#scenePreview').click(function(){
        var sceneId = $('#optionIdScene').attr('value');
        loadSceneIfExist(sceneId);
        $('#pano').css('overflow', 'visible');
        $('#previewModal').css('display', 'block');
        $('#modalWindow').show();
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

});