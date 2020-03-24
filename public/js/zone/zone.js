//FUNCIÓN QUE SACA LAS ESCENAS DE UNA ZONA PARA EVITAR ELIMINAR ZONAS QUE CONTENGAN ESCENAS
function checkScenes(zoneId){
    var route = checkScenesRoute.replace('req_id', zoneId);
    return $.ajax({
        url: route,
        type: 'POST',
        data: {
            "_token": token,
        }
    });
}

$().ready(function(){
    //Botón de borrar zona
    $('.delete').click(function(){
        var zoneId = $(this).attr('id');
        //Comprobar que la zona no tenga escenas
        checkScenes(zoneId).done(function(result){
            if(result['num'] != 0){
                $('#confirmDelete, #newZoneModal').hide();
                $('#cancelDeleteForScenes').css('width', '40%');
                $('#cancelDeleteForScenes').show()
                $('#modalWindow').show();
            }else{
                $('#confirmDelete').css('width', '20%');
                $('#modalWindow').show();
                $('#aceptDelete').click(function(){
                    $('#modalWindow').hide();
                    var route = deleteZoneRoute.replace('req_id', zoneId);
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            "_token": token,
                        },
                        success:function(result){
                            if(result['status']){
                                $(location).attr('href', indexRoute);
                            }
                        }
                    });
                });
            }
        });
    });

    //COMPROBAR FORMULARIO DE NUEVA ZONA ANTES DE ENVIARLO
    $('#formAddNewZone').submit(function(event){
        var name = document.getElementById('name').value;
        var image = document.getElementById('file_image').value;
        //Comprobamos que el nobre no esté vacío
        if(name != ""){
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            if(!(/^[A-Za-z0-9\s]+$/.test(name))){
                event.preventDefault();
                $('#errorMessagge > span').text('El nombre solo puede contener letras, números y espacios');
                $('#name').css('border', '1.5px solid red');
            //Si el nombre pasa las comprobaciones, comprobamos que se haya seleccionado una imagen
            }else{
                //Si o se ha seleccionado una imagen, se detiene el evento submit y se lanza un mensaje de error
                if(image == "" || image == null || image == undefined){
                    event.preventDefault();
                    $('#errorMessagge > span').text('Tiene que seleccionar una imagen');
                    $('#name').css('border', '1px solid black');
                }
            }
        //Si el nombre estuviese vacío, se detiene el evento submit y se lanza un mensaje de error
        }else{
            event.preventDefault();
            $('#errorMessagge > span').text('Por favor, rellene todos los campos');
            $('#name').css('border', '1.5px solid red');
        }
    });

    //BOTONES DE CERRAR DE LAS VENTANAS MODALES
    $('.closeModal').click(function(){
        $('.window').hide();
        $('#modalWindow').hide();
    });

    $('#cancelDelete, #aceptCondition').click(function(){
        $('.window').hide();
        $('#modalWindow').hide();
    });

    $('#addNewZone').click(function(){
        $('.window').hide();
        $('#newZoneModal').show();
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