var sceneSelected = 0;

$(function(){

    $('#btnMap').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#ventanaModal').css('display', 'block');

        // Se colocan los valores vacios
        $('#sceneValue').val('');
        $('#resourceValue').val('');

    });

    //Al hacer click en un punto del mapa
    $('.scenepoint').on({
        click: function(){
            //La clase SELECTED sirve para saber que punto concreto está seleccionado y así
            //evitar que se cambie el icono amarillo al hacer mouseout
            $('.scenepoint').attr('src', rutaIconoEscena);
            $('.scenepoint').removeClass('selected');
            $(this).attr('src', rutaIconoEscenaHover);
            $(this).addClass('selected');
            var sceneId = $(this).attr('id');
            $('#idSelectedScene').attr('value', sceneId.substr(5));
            $("#idSelectedSceneUpdate").val(sceneId.substr(5));
        },
        mouseover: function(){
            $(this).attr('src', rutaIconoEscenaHover);
        },
        mouseout: function(){
            if(!$(this).hasClass('selected'))
                $(this).attr('src', rutaIconoEscena);
        }
    });

    //Submit del formulario de añadir nuevo punto destacado
    $('#newHlForm').submit(function(event){
        //Le quito la clase selected al punto que la tuviese
        $('.icon > *').removeClass('selected');
        //Pongo blancos todos los puntos
        $('.scenepoint').attr('src', rutaIconoEscena);
        //Oculto todas las zonas para mostrar por defecto el sótano
        $('.addScene').hide();
        $('#zone1').show();
        $('#actualZone').attr('value', 1);
        var escenaSeleccionada = $('#idSelectedScene').attr('value');
        if(escenaSeleccionada == undefined){
            event.preventDefault();
            $('#msmError').text(" Debes seleccionar una escena para este punto destacado");
        }
    });

    //botón de cancelar de modal de confirmación
    $("#btnNo").click(function(){
        $("#modalWindow").css("display", "none");
        $("#ventanaModal").css("display", "none");
    });

    //ABRIR MODAL DE NUEVO PUNTO DESTACADO
    $('#newHighlight').click(function(){
        $('#addSceneToHl').removeClass('modifying');
        $('#modalDelete').hide();
        $('#newSlide').show();
        $('#newHlModal').show();
        $('#modalWindow').show();
        var escenaSeleccionada = $('#idSelectedScene').attr('value');
        //Si ya se seleccionó una escena previamente pero se cerró la modal por lo que sea
        //se comprueba la escena que se seleccionó y se muestra esa zona y la escena
        //seleccionada en amarillo
        if(escenaSeleccionada != undefined){
            $('#scene' + escenaSeleccionada).attr('src', rutaIconoEscenaHover);
            var ruta = rutaSceneZone.replace('req_id', escenaSeleccionada);
            $.ajax({
                url: ruta,
                type: 'POST',
                data: {
                "_token": token,
            },
            success:function(resul){ 
                var zone = resul['zone'];
                $('.addScene').hide();
                $('#zone' + zone).show();
                $('#actualZone').attr('value', zone);
            },
            error:function(){
                //alert("ERROR AJAX");
                alertify.error('ERROR AJAX', 5); 
            }
            });
        }
    });

    //ABRIR MAPA CON EFECTOS
    $('#btnMap').click(function(){
        $('#newSlide').slideUp(function(){
            $('#newHlModal').hide();
            $('#modalMap').show();
            $('#mapSlide').slideDown();
        });
    });

    //ACEPTAR DE LA MODAL DEL MAPA
    $('#addSceneToHl').click(function(){
        if($('#addSceneToHl').hasClass('modifying')){
            $('#mapSlide').slideUp(function(){
                $('#newHlModal').hide();
                $('#newSlide').hide();
                $('#modalMap').hide();
                $('#modifyHlModal').show();
                $('#newSlideUpdate').slideDown();
            });
        }else{
            $('#mapSlide').slideUp(function(){
                $('#modalMap').hide();
                $('#modifyHlModal').hide();
                $('#newSlideUpdate').hide();
                $('#newHlModal').show();
                $('#newSlide').slideDown();
            });
        }
    });

    //MODIFICAR
    $('.modifyHl').click(function(){
        $('#addSceneToHl').addClass('modifying');
        idHl = $(this).attr('id');
        var route = rutaShow.replace('req_id', idHl);
        $.ajax({
            url: route,
            type: 'POST',
            data: {
            "_token": token,
        },
        success:function(result){                   
            hl = result['highlight'];
            //RELLENO LOS INPUT DEL FORMULARIO DE MODIFICAR
            $('#hlTitle').attr('value', hl.title);
            $('#hlSceneImg').attr('src', rutaImg.replace('image', hl.scene_file));
            $('#idSelectedSceneUpdate').attr('value', hl.id_scene);
            //SEÑALAR LA ESCENA QUE ESTÁ MARCADA CON EL PUNTO DESTACADO
            $('#scene'+hl.id_scene).attr('src', rutaIconoEscenaHover);
            $('#scene'+hl.id_scene).addClass('selected');
            //Petición AJAX para sacar la zona de la escena seleccionada y que sea esta la 
            //zona que se muestre al modificar la escena del punto destacado
            var ruta = rutaSceneZone.replace('req_id', hl.id_scene);
            $.ajax({
                url: ruta,
                type: 'POST',
                data: {
                "_token": token,
            },
            success:function(resul){ 
                var zone = resul['zone'];
                $('.addScene').hide();
                $('#zone' + zone).show();
                $('#actualZone').attr('value', zone);
            },
            error:function(){
                //alert("ERROR AJAX, Error en la modificación");
                alertify.error('ERROR AJAX, Error en la modificación', 5); 
            }
            });
            var actualAction = $('#formUpdateHl').attr('action');
            $('#formUpdateHl').attr('action', actualAction.replace('id', hl.id));
            $('#modalDelete').hide();
            $('#modifyHlModal').show();
            $('#newSlideUpdate').show();
            $('#modalWindow').show();

            //MOSTRAR LA MODAL DE MODIFICAR
            $('#updateHlMap').click(function(){
                $('#newSlideUpdate').slideUp(function(){
                    $('#modifyHlModal').hide();
                    $('#modalMap').show();
                    $('#mapSlide').slideDown();
                });
            });
        },
        error:function() {
            alert('Error AJAX');
        }
        });
    });

    //cerrar modal
    $('.closeModal').click(function(){
        //Oculto todas las modales
        $('#modalWindow, .window, .slide').hide();
        //Le quito la clase selected al punto que la tuviese
        $('.icon > *').removeClass('selected');
        //Pongo blancos todos los puntos
        $('.scenepoint').attr('src', rutaIconoEscena);
        //Oculto todas las zonas para mostrar por defecto el sótano
        $('.addScene').hide();
        $('#zone1').show();
        $('#actualZone').attr('value', 1);
        /* Todas estas modificaciones vienen porque hay puntos del código en los que se realizan cambios necesarios
        para que funcione correctamente pero, si el usuario se pone por ejemplo a modificar un punto destacado y cierra
        la ventana sin haber terminado, hay que dejarlo todo preparado por si acto seguido le da a añadir nuevo punto destacado */
    });

    //borrar punto destacado
    $('.delete').click(function(){
        $('#modalDelete').show();
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
            $('#modalWindow, .window, .slide').hide();
            $('.icon > *').removeClass('selected');
            $('.scenepoint').attr('src', rutaIconoEscena);
            $('.addScene').hide();
            $('#zone1').show();
            $('#actualZone').attr('value', 1);
        }
    });




        //----------------------------------------------------  Lista ordenable  --------------------------------------------------------------------------

        $(".sortable").sortable({
            // Al cambiar la lista se guardan todos los id en un input hidden
            update: function(){ 
                var ordenElementos = $(this).sortable("toArray").toString();
                $('#position').val(ordenElementos).change();
                //document.getElementById("btn-savePosition").disabled = false; 
                
                /**
                 * Depuración JS
                 */
                //var orden = $('#position').val();
                //alert(orden); // Variable donde se guardan las posiciones (JS) aún no están en la BD
            },
    
            // Deshabilita los controles del audio ya que se queda pillado al intentar ordenar
            start: function(event, ui){
                //$("tr[id="+ui.item[0].id+"] audio").removeAttr("controls");
            },
            
            // Se habilitan los controles de audio
            stop: function(event, ui){
                //$("tr[id="+ui.item[0].id+"] audio").attr("controls", "true");
                
                // Guarda la posición
                if($('#position').val() == 'null'){
                    // Acción cuando no hay posiciones nuevas
                } else {
                    $.post($("#addPosition").attr('action'), {
                        _token: $('#addPosition input[name="_token"]').val(),
                        position: $('#position').val()
                    }).done(function(data){
                        //alert('Posición guardada');
                        alertify.success('Posición guardada', 5); 
                    }).fail( function() {
                        alertify.error('Error al guardar la posición', 5); 
                    });   
                }
            }
        });



});