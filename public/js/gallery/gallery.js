$().ready(function(){
    //VALIDACIÓN DE FORMULARIO DE AÑADIR GALERÍA ANTES DEL SUBMIT
    $('#newGalleryForm').submit(function(event){
        var titulo = document.getElementById('titleNewGallery').value;
        var testTitle = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(titulo));
        //Compruebo que el título de la galería no esté vacío
        if(titulo != ""){
            //Compruebo que el título sea válido
            if(!testTitle){
                event.preventDefault();
                $('#errorMsgNewGallery > span').text('El título solo puede contener letras, números y espacios');
                $("#titleNewGallery").css('border', '1.5px solid red');
            }else{
                $('#errorMsgNewGallery > span').text("");
                $("#titleNewGallery").css('border', '1px solid black');
            }
        }else{
            event.preventDefault();
            $('#errorMsgNewGallery > span').text('El título no puede estar vacío');
            $("#titleNewGallery").css('border', '1.5px solid red');
        }

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