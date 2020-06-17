$().ready(function(){
    //BOTÓN DE AÑADIR NUEVO ESCAPE ROOM
    $('#addEscapeRoom').click(function(){
        $('#state').val(0);
        $('#modalNewEscapeRoom').show();
        $('#modalWindow').show();
    });

    //BOTÓN DE EDITAR ESCAPE ROOM
    $('.editEscapeRoom').click(function(){
        var erId = $(this).attr('id');
        $('#state').val(1);
        $.ajax({
            url: getOneRoute.replace('req_id', erId),
            type: 'POST',
            data: {
                '_token': token,
            }
        }).done(function(escaperoom){
            $('#updateEscapeRoomName').val(escaperoom['name']);
            $('#updateEscapeRoomDescription').val(escaperoom['description']);
            $('#updateEscapeRoomLevelSelected').val(escaperoom['difficulty']);
            $('#idUpdateEscapeRoom').val(escaperoom['id']);
            var nivel = escaperoom['difficulty'];
            for(var i = 0; i <= nivel; i++){
                $('#difficultyPointsUpdateEscapeRoom > #' + i).css('background-color', '#8500FF');
            }
            $('#modalUpdateEscapeRoom, #modalWindow').show();
        });
    });

    //BOTÓN DE GUARDAR DE LA MODAL DE EDITAR ESCAPE ROOM
    $('#saveUpdateEscapeRoom').click(function(){
        $.ajax({
            url: updateEscapeRoomRoute.replace('req_id', $('#idUpdateEscapeRoom').val()),
            type: 'PUT',
            data: {
                '_token': token,
                'name': $('#updateEscapeRoomName').val(),
                'description': $('#updateEscapeRoomDescription').val(),
                'difficulty': $('#updateEscapeRoomLevelSelected').val(),
            }
        }).done(function(result){
            if(result['status']){
                var escaperoom = result['escaperoom'];
                $('#escapeRoom' + escaperoom['id'] + ' .name').text(escaperoom['name']);
                $('#escapeRoom' + escaperoom['id'] + ' .description').text(escaperoom['description']);
                $('#escapeRoom' + escaperoom['id'] + ' .difficulty > img').attr('src', difficultyLevelsUrl.replace('lvl', 'nivel' + escaperoom['difficulty'] + '.svg'))
                $('#modalUpdateEscapeRoom, #modalWindow').hide();
            }
        });
    });

    //MOUSE SOBRE LOS PUNTOS DE DIFICULTAD
    $('.difficultyLevel').mouseenter(function(){
        var nivel = $(this).attr('id');
        //Comprobamos si se está añadiendo o editando para actuar sobre los puntos de dificultad correctos
        //ya que ambos (tanto los de editar como los de añadir) tienen los mismos ids
        if($('#state').val() == 0){ //Añadiendo 
            for( var i = nivel; i >= 2; i--){
                $('#difficultyPointsNewEscapeRoom > #' + i).css('background-color', '#8500FF');
            }
            for(var x = (parseInt(nivel) + 1); x <= 5; x++){
                $('#difficultyPointsNewEscapeRoom > #' + x).css('background-color', 'white');
            }
        }else{ //Editando
            for( var i = nivel; i >= 2; i--){
                $('#difficultyPointsUpdateEscapeRoom > #' + i).css('background-color', '#8500FF');
            }
            for(var x = (parseInt(nivel) + 1); x <= 5; x++){
                $('#difficultyPointsUpdateEscapeRoom > #' + x).css('background-color', 'white');
            }
        }
        
    });

    //CLICK SOBRE UN PUNTO DE DIFICULTAD
    $('.difficultyLevel').click(function(){
        var nivel = $(this).attr('id');
        if($('#state').val() == 0){
            $('#newEscapeRoomLevelSelected').val(nivel);
        }else{
            $('#updateEscapeRoomLevelSelected').val(nivel);
        }
    });

    //MANTENER MARCADA LA DIFICULTAD QUE HA ELEGIDO EL USUARIO
    $('.difficultyPointsEscapeRoom').mouseleave(function(){
        if($('#state').val() == 0){
            var nivel = $('#newEscapeRoomLevelSelected').val();
            for( var i = nivel; i >= 2; i--){
                $('#difficultyPointsNewEscapeRoom > #' + i).css('background-color', '#8500FF');
            }
            for(var x = (parseInt(nivel) + 1); x <= 5; x++){
                $('#difficultyPointsNewEscapeRoom > #' + x).css('background-color', 'white');
            }
        }else{
            var nivel = $('#updateEscapeRoomLevelSelected').val();
            for( var i = nivel; i >= 2; i--){
                $('#difficultyPointsUpdateEscapeRoom > #' + i).css('background-color', '#8500FF');
            }
            for(var x = (parseInt(nivel) + 1); x <= 5; x++){
                $('#difficultyPointsUpdateEscapeRoom > #' + x).css('background-color', 'white');
            }
        }
    });

    //GUARDAR EL NUEVO ESCAPE ROOM
    $('#saveNewEscapeRoom').click(function(){
        $.ajax({
            url: newEscapeRoomRoute,
            type: 'POST',
            data: {
                '_token': token,
                'name': $('#newEscapeRoomName').val(),
                'description': $('#newEscapeRoomDescription').val(),
                'difficulty': $('#newEscapeRoomLevelSelected').val(),
            }
        }).done(function(result){
            if(result['status']){
                var escaperoom = result['er'];
                //Vacío los campos de la modal para dejarla limpia
                $('.window, #modalWindow').hide();
                $('#newEscapeRoomName, #newEscapeRoomDescription').val('');
                $('#newEscapeRoomLevelSelected').val(1);
                //Reestablezco el color de los puntos de dificultad
                for(var i = 1; i <= 5; i++){
                    $('#difficultyPointsNewEscapeRoom > #' + i).css('background-color', 'white');
                }
                //Añado la fila a la tabla del listado de escape rooms
                $('#escapeRoomsList').append(
                    "<div id='escapeRoom" + escaperoom['id'] + "' class='oneEscapeRoom col100 lMarginBottom'>" +
                        "<div class='name col10 sPadding mMarginRight'>" + escaperoom['name'] + "</div>" +
                        "<div class='description col30 sPadding mMarginRight expand'>" + escaperoom['description'] + "</div>" +
                        "<div class='difficulty col10 sPaddingTop mMarginRight'><img class='col100' src='"+ difficultyLevelsUrl.replace('lvl', 'nivel' + escaperoom['difficulty'] + '.svg') +"' alt='"+ escaperoom['difficulty'] +"' ></div>" +
                        "<div class='col10 sMarginRight mMarginLeft'><button id='" + escaperoom['id'] + "' class='col100 editEscapeRoom'>Editar</button></div>" +
                        "<div class='col10 sMarginRight'><button id='" + escaperoom['id'] + "' class='configureEscapeRoom col100 bBlack'>Configurar</button></div>" +
                        "<div class='col10 sMarginRight'><button id='" + escaperoom['id'] + "' class='col100 deleteEscapeRoom delete'>Eliminar</button></div>" +
                        "<div class='col10'><button id='" + escaperoom['id'] + "' class='ActivaEscaperoom col100'>Inactivo</button></div>" + 
                    "</div>"
                );
                //Añado la funcionalidad al botón de editar añadido por ajax
                $('.editEscapeRoom').click(function(){
                    var erId = $(this).attr('id');
                    $('#state').val(1);
                    $.ajax({
                        url: getOneRoute.replace('req_id', erId),
                        type: 'POST',
                        data: {
                            '_token': token,
                        }
                    }).done(function(escaperoom){
                        $('#updateEscapeRoomName').val(escaperoom['name']);
                        $('#updateEscapeRoomDescription').val(escaperoom['description']);
                        $('#updateEscapeRoomLevelSelected').val(escaperoom['difficulty']);
                        $('#idUpdateEscapeRoom').val(escaperoom['id']);
                        var nivel = escaperoom['difficulty'];
                        for(var i = 0; i <= nivel; i++){
                            $('#difficultyPointsUpdateEscapeRoom > #' + i).css('background-color', '#8500FF');
                        }
                        $('#modalUpdateEscapeRoom, #modalWindow').show();
                    });
                });
                //Añado la funcionalidad al botón de eliminar añadido por ajax
                $('.deleteEscapeRoom').click(function(){
                    var erId = $(this).attr('id');
                    $('#idEscapeRoomToDelete').val(erId);
                    $('#modalConfirmDelete, #modalWindow').show();
                });
                //Añado la funcionalidad al botón de configurar añadido por ajax
                $('.configureEscapeRoom').click(function(){
                    location.href = configureEscapeRoomRoute.replace('escapeRoomId', $(this).attr('id'));
                });
                //Añado la funcionalidad del botón de activar o desactivar escape room añadido por ajax
                $(".ActivaEscaperoom").click(function(){
                    dataForm = new FormData();
                    dataForm.append('active', 1);
                    dataForm.append('_token', token);
                    var id = $(this).attr("id"); 
                    var route = escapeRoomActiveRoute.replace('id', id);
                    $.ajax({
                        url: route,
                        type: 'post',
                        data: dataForm,
                        contentType: false,
                        processData: false,
                    }).done(function(data){
                        location.reload();
                    }).fail(function(data){
                    })
                });
            }
        });
    });

    //ELIMINAR UN ESCAPE ROOM
    $('.deleteEscapeRoom').click(function(){
        var erId = $(this).attr('id');
        $('#idEscapeRoomToDelete').val(erId);
        $('#modalConfirmDelete, #modalWindow').show();
    });

    $('#confirmDelete').click(function(){
        var erId = $('#idEscapeRoomToDelete').val();
        $.ajax({
            url: deleteEscapeRoomRoute.replace('req_id', erId),
            type: 'DELETE',
            data: {
                '_token': token,
            }
        }).done(function(result){
            if(result['status']){
                $('#escapeRoom' + erId).remove();
                $('#modalConfirmDelete, #modalWindow').hide();
            }
        });
    });

    $('#cancelDelete').click(function(){
        $('#modalConfirmDelete, #modalWindow').show();
    });

    //BOTÓN DE CONFIGURAR ESCAPE ROOM
    $('.configureEscapeRoom').click(function(){
        location.href = configureEscapeRoomRoute.replace('escapeRoomId', $(this).attr('id'));
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

});