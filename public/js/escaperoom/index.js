$().ready(function(){
    //BOTÓN DE AÑADIR NUEVO ESCAPE ROOM
    $('#addEscapeRoom').click(function(){
        $('#modalNewEscapeRoom').show();
        $('#modalWindow').show();
    });

    //BOTÓN DE EDITAR ESCAPE ROOM
    $('.editEscapeRoom').click(function(){
        
    });

    //MOUSE SOBRE LOS PUNTOS DE DIFICULTAD EN LA MODAL DE NUEVO ESCAPE ROOM
    $('.difficultyLevel').mouseenter(function(){
        var nivel = $(this).attr('id');
        for( var i = nivel; i >= 2; i--){
            $('#difficultyPointsNewEscapeRoom > #' + i).css('background-color', '#8500FF');
        }
        for(var x = (parseInt(nivel) + 1); x <= 5; x++){
            $('#difficultyPointsNewEscapeRoom > #' + x).css('background-color', 'white');
        }
    });

    //CLICK SOBRE UN PUNTO DE DIFICULTAD EN LA MODAL DE NUEVO ESCAPE ROOM
    $('.difficultyLevel').click(function(){
        var nivel = $(this).attr('id');
        $('#newEscapeRoomLevelSelected').val(nivel);
    });

    //MANTENER MARCADA LA DIFICULTAD QUE HA ELEGIDO EL USUARIO EN LA MODAL DE NUEVO ESCAPE ROOM
    $('#difficultyPointsNewEscapeRoom').mouseleave(function(){
        var nivel = $('#newEscapeRoomLevelSelected').val();
        for( var i = nivel; i >= 2; i--){
            $('#difficultyPointsNewEscapeRoom > #' + i).css('background-color', '#8500FF');
        }
        for(var x = (parseInt(nivel) + 1); x <= 5; x++){
            $('#difficultyPointsNewEscapeRoom > #' + x).css('background-color', 'white');
        }
    });

    //GUARDAR EL NUEVO ESPARE ROOM
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
                $('.window, #modalWindow').hide();
                $('#newEscapeRoomName, #newEscapeRoomDescription').val('');
                $('#newEscapeRoomLevelSelected').val(1);
                for(var i = 1; i <= 5; i++){
                    $('#difficultyPointsNewEscapeRoom > #' + i).css('background-color', 'white');
                }
                $('#escapeRoomsList').append(
                    "<div class='oneEscapeRoom col100 lMarginBottom'>" +
                        "<div class='col20 sPadding mMarginRight'>" + escaperoom['name'] + "</div>" +
                        "<div class='col30 sPadding mMarginRight expand'>" + escaperoom['description'] + "</div>" +
                        "<div class='col10 sPaddingTop mMarginRight'><img class='col100' src='"+ difficultyLevelsUrl.replace('lvl', 'nivel' + escaperoom['difficulty'] + '.svg') +"' alt='"+ escaperoom['difficulty'] +"' ></div>" +
                        "<div class='col15 mMarginLeft'><button id='" + escaperoom['id'] + "' class='col80 editEscapeRoom'>Editar</button></div>" +
                        "<div class='col15'><button id='" + escaperoom['id'] + "' class='col80 deleteEscapeRoom delete'>Eliminar</button></div>" +
                    "</div>"
                )
            }
        });
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