////////////// MOSTRAR ESCENA DE DESTINO ///////////////
function showDestinationScene(jump){
    var route = sceneDestinationRoute.replace('req_id', jump);
    $.ajax({
        url: route,
        type: 'post',
        data: {
            "_token": token,
        },
        success:function(result){                   
            var destScene = result['destSceneId'];
            var pitch = result['pitch'];
            var yaw = result['yaw'];
            if(destScene != null && destScene != "0"){
                getSceneDestination(destScene).done(function(result){
                    $('#modalWindow').hide();
                    $('#destinationSceneView').show();
                    loadSceneDestination(result, pitch, yaw);
                    $('#setViewDefaultDestinationScene').show();
                });
            }else{
                var padre = document.getElementById('destinationSceneView');
                var panoElement = padre.firstElementChild;
            }
        },
        error:function() {
            // alert("Error en la petición AJAXx");
        }
    });
}

function getIdJump(idHotspot){
    return $.ajax({
        url: getIdJumpRoute.replace('hotspotid', idHotspot),
        type: 'post',
        data: {
            '_token': token
        }
    });
}

function jump(id, title, description, pitch, yaw, destId){
    var codigoHTML = "<div id='hintspot' class='hotspotElement jump hots"+ id +"' value='"+ id +"'>";
    if (destId == 0) {
        codigoHTML += "<svg class='huerfano' value='"+ id +"' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 250.1 127.22'><path d='M148.25,620.61l1.15-.79q61.83-39.57,123.65-79.15a1.71,1.71,0,0,1,2.2,0Q336,580.08,396.72,619.44l1.63,1.11a8,8,0,0,0-1.18.74l-46.73,45.15c-1.4,1.36-1.41,1.36-3,.15q-36.37-27.75-72.71-55.53a1.78,1.78,0,0,0-2.62,0q-37.26,28-74.56,55.86c-.85.64-1.37.72-2.2-.09q-23.1-22.68-46.24-45.32C148.84,621.25,148.58,621,148.25,620.61Z' transform='translate(-148.25 -540.26)' fill='white'/></svg>";
    } else {
        codigoHTML +="<svg value='"+ id +"' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 250.1 127.22'><path d='M148.25,620.61l1.15-.79q61.83-39.57,123.65-79.15a1.71,1.71,0,0,1,2.2,0Q336,580.08,396.72,619.44l1.63,1.11a8,8,0,0,0-1.18.74l-46.73,45.15c-1.4,1.36-1.41,1.36-3,.15q-36.37-27.75-72.71-55.53a1.78,1.78,0,0,0-2.62,0q-37.26,28-74.56,55.86c-.85.64-1.37.72-2.2-.09q-23.1-22.68-46.24-45.32C148.84,621.25,148.58,621,148.25,620.61Z' transform='translate(-148.25 -540.26)' fill='white'/></svg>";
    }

    codigoHTML += "</div>";

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(codigoHTML);


    $('.hots' + id).click(function(){
        $(".hotspotElement").removeClass('active');
        $("#addHotspot").hide();
        $(".containerEditHotspot").hide();
        $('#portkeyHotspot').hide();
        $("#typesHotspot").hide();
        $("#helpHotspotAdd").hide();
        $("#helpHotspotMove").hide();
        //Rellenar con la informacion del hotspot
        $("#jumpTitle").val(title);
        $("#jumpHotspot > textarea").val(description);
        //Mostrar el panel de edicion
        $("#editHotspot").css('display', 'block');
        $("#jumpHotspot").css('display', 'block');

        //Vaciar pano de vista previa de escena de destino
        $('.destinationPano').empty();
        $('#setViewDefaultDestinationScene').hide();

        //Actuamos si no estaba ya seleccionado esto hotspot previamente para su edicion
        if( !$(".hots"+id).hasClass('active') ){
            //Eliminar la clase activos de todos los anteriores hotspot seleccionados
            $(".hotspotElement").removeClass('active');
            $(".hots"+id).addClass('active');
        }

        /* PONER EL ID DEL HOTSPOT EN UN INPUT HIDDEN PARA LA ACTUALIZACIÓN DEL CAMPO HILGHLIGTH_POINT */
        $('#actualHotspotJump').attr('value', $(this).attr('value'));
        
        //////////////////// MOSTRAR ESCENA DE DESTINO ACTUAL /////////////////////////
        getIdJump(parseInt($(this).attr('value'))).done(function(result){
            //Asigno el id dej JUMP al botón de escena de destino para que se
            //actualice cada vez que se pincha en un hotspot de salto y así
            //poder usarlo desde la vista
            $('#selectDestinationSceneButton').attr('value', result.jump);
            showDestinationScene(result.jump);
        });
        
        /////////// VOLVER //////////////
        $("#editHotspot .buttonClose").off(); //desvincular previos
        $("#editHotspot .buttonClose").on('click', function(){
            //Cambiar estado hotspot
            $(".hots"+id).find(".in").removeClass("move");
            $(".hots"+id).find(".out").removeClass("moveOut");
            $(".hotspotElement").removeClass('active');

            //Volver a desactivar las acciones de doble click
            $("#pano").off( "dblclick");
            //Quitar el cursor de tipo cell
            $("#pano").removeClass("cursorAddHotspot");
            //Mostrar el menu inicial
            showMain();
        });     

        ////////////// EDITAR ///////////////
        //Poner a la escucha los cambios de datos para almacenar en la base de datos
        $("#jumpTitle, #jumpHotspot > textarea").unbind(); //desvincular previos
        $("#jumpTitle, #jumpHotspot > textarea").change(function(){
            //Controlar error de no guardar datos nulos
            if(!$(this).val()==""){
                //Actualizar
                var newTitle = $("#jumpTitle").val();
                var newDescription = $("#jumpHotspot > textarea").val();
                updateHotspot(id,newTitle,newDescription,pitch,yaw,1)
                    //Datos almacenados correctamente
                    .done(function(){
                        title = newTitle;
                        description = newDescription;
                        $(".hots"+id+" .title").text(title);
                        $(".hots"+id+" .description").text(description);
                    })
                    .fail(function(){
                        alert("error al guardar");
                    });     
            }                       
        });
        
        /////////// ELIMINAR //////////////
        $("#editHotspot .buttonDelete, #btnModalOk").off(); //desvincular previos
        $("#editHotspot .buttonDelete").on('click', function(){
            //Mostrar modal
            $("#modalWindow").show();
            $("#deleteHotspotWindow").show();
            $("#map").hide();
            //Asignar funcion al boton de aceptar en modal
            $("#btnModalOk").on("click", function(){
                deleteHotspot(id)
                //Si se elimina correctamente
                .done(function(){
                    $(".hots"+id).remove();
                    $("#addHotspot").show();
                    $("#editHotspot").hide();
                })
                .fail(function(){
                    //alert("error al eliminar");
                })
                .always(function(){
                    $('#modalWindow').hide();
                    $('#deleteHotspotWindow').hide();
                });
            });                
        });     
    
        /////////// MOVER //////////////
        $("#editHotspot .buttonMove").off(); //desvincular previos
        $("#editHotspot .buttonMove").on('click', function(){
            //Cambiar estado hotspot
            $(".hots"+id).find(".in").addClass("move");
            $(".hots"+id).find(".out").addClass("moveOut");
            
            //Mostar info mover en menu
            $("#editHotspot").hide();
            $("#helpHotspotMove").show();
            $("#pano").addClass("cursorAddHotspot"); //Cambiar el cursor a tipo cell
        
            //Doble click para la nueva posicion
            $("#pano").on( "dblclick", function(e) {
                $(".hotspotElement").css("pointer-events", "none");
                //Obtener nueva posicion
                var view = viewer.view();
                var yaw = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).yaw;
                var pitch = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).pitch;
                //Mover hotspot
                moveHotspot(id, yaw, pitch)
                    .done(function(result){
                        //Obtener el resultado de la accion
                        if(result['status']){                        
                            //Cambiar la posicion en la escena actual
                            hotspotCreated["hots"+id].setPosition( { "yaw": yaw, "pitch": pitch })
                        }else{
                            alert("Error al actualizar el hotspot");
                        }
                    })
                    .fail(function(){
                        alert("Error al actualizar el hotspot");
                    })
                    .always(function(){
                        finishMove();
                    });
            });
            
            //Boton cancelar mover hotspot
            $("#CancelMoveHotspot").on("click", function(){ finishMove() }); 
            
            //Metodo para finalizar accion de mover
            function finishMove(){
                //Cambiar estado hotspot
                $(".hots"+id).find(".in").removeClass("move");
                $(".hots"+id).find(".out").removeClass("moveOut");
                $(".hotspotElement").removeClass('active');
                $(".hotspotElement").css("pointer-events", "all");

                //Volver a desactivar las acciones de doble click
                $("#pano").off( "dblclick");
                //Quitar el cursor de tipo cell
                $("#pano").removeClass("cursorAddHotspot");
                //Mostrar el menu inicial
                showMain();
            }
        });

        
        
    });
}
    
        //----------------------------------------------------------------------
        
        
$().ready(function(){
    $('.scenepoint').click(function(){
        //Recojo el id del punto al que se ha hecho click
        var pointId = $(this).attr('id');
        //Escondo el punto que se muestra al hacer click en la capa de la zona
        $('#zoneicon').css('display', 'none');
        //Saco el id de la escena que corresponde a ese punto
        var sceneId = parseInt(pointId.substr(5));
        $('#sceneDestinationId').val(sceneId);
        $('#actualDestScene').attr("value", sceneId);
        //Obtengo la escena completa que se ha seleccionado como escena de destino
        getSceneDestination(sceneId).done(function(result){
            //la guardo como escena de destino
            saveDestinationScene($('#selectDestinationSceneButton').attr('value'), sceneId);
            $('#modalWindow').hide();
            $('#destinationSceneView').show();
            loadSceneDestination(result, null, null);
            $('#setViewDefaultDestinationScene').show();
            $('#setViewDefaultDestinationScene').show();
        });
    });


    /*********************ELEGIR ESCENA DE DESTINO**********************/
    $('#selectDestinationSceneButton').click(function(){
        //Cambio el color del punto de la escena en la que se está actualmente
        var actualScene = $('#actualScene').attr('value');
        $('#scene' + actualScene).attr('src', actualScenePointUrl);
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#map').css('display', 'block');
    });

    /* INFORMACIÓN DE CHACKBOX */
    $('#infoCheckboxJumpImg').click(function(){
        var estado = $('#infoCheckboxJump').css('display');
        if(estado == "none")
            $('#infoCheckboxJump').slideDown(800);
        else
            $('#infoCheckboxJump').slideUp(800);
    });

    $('#principal').click(function(){
        var hotspotId = $('#actualHotspotJump').attr('value');
        updateJumpHotspotHlPoint(hotspotId);
    });

    
    
});