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
                $('#confirmDelete').css('width', '40%');
                $('#confirmDelete').show();
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
            var test = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(name));
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            if(!test){
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


        //----------------------------------------------------  Lista ordenable  --------------------------------------------------------------------------

        $(".sortable").sortable({
            // Al cambiar la lista se guardan todos los id en un input hidden
            update: function(){ 
                var ordenElementos = $(this).sortable("toArray").toString(); // Guarda los ids de zonas nativo (zone2,zone3,zone1)
                var ordenElementos_js; // Guarda los ids de zonas limpios (2,3,1) con la coma incluida
                
                alert(ordenElementos);
                //alert(ordenElementos.length);
                //alert(ordenElementos.substring(4,5));

               /**
                * Recorre el String obtenido por el método sortable de JQueryUi
                * Ejemplo del String que recorre : zone2,zone3,zone1
                */

                for (let i = 0; i < ordenElementos.length; i++) {

                    //alert(ordenElementos.substring(1,4));
                    /**
                     * Obtiene el primer id de zonas
                     */
                    if(i == 4){
                        alert(ordenElementos.substring(4,5));
                        ordenElementos_js = ordenElementos.substring(4,5) + ",";
                    }
                  
                    /**
                     * Obtiene el resto de ids (después del primero)
                     */
                    if(i > 4){
                        var texto = ordenElementos.substring(i,(i+1));
                        if(texto == ','){
                            //alert("Hay coma");
                           
                            alert(ordenElementos.substring((i+5),((i+4)+2)));
                            ordenElementos_js += ordenElementos.substring((i+5),((i+4)+2)) + ","; // Concatena los ids con la coma
                            
                        }
                    }

                    /**
                     * Borra la coma final del String
                     * 2,3,1, => 2,3,1
                     */
                    if(i == (ordenElementos.length - 1)){
                        ordenElementos_js = ordenElementos_js.substring(0, (ordenElementos_js.length - 1));
                    }
                }

                alert(ordenElementos_js);
                

                //$('#position').val(ordenElementos).change();
                $('#position').val(ordenElementos_js).change();
                
                //document.getElementById("btn-savePosition").disabled = false; 
                
                var orden1 = $('#position').val();
                //alert(orden1); // Variable donde se guardan las posiciones (JS) aún no están en la BD
            },

            // Deshabilita los controles del audio ya que se queda pillado al intentar ordenar
            start: function(event, ui){
                //$("div[id="+ui.item[0].id+"]").css('display', 'none');
            },
            
            // Se habilitan los controles de audio
            stop: function(event, ui){
                //$("tr[id="+ui.item[0].id+"] audio").attr("controls", "true");
            }
        });

});