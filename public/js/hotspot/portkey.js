////////////// MOSTRAR ESCENA DE DESTINO ///////////////
function showDestinationScene(jump){
    var route = sceneDestinationRoute.replace('req_id', jump);
    // alert("...."+jump+"....");
    // alert(route);
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
                panoElement.empty();
            }
        },
        error:function() {
            alert("Error en la petición AJAXx");
        }
    });
}

function getIdType(hotspot){
    return $.ajax({
        url: getIdTypeRoute.replace('hotspot', hotspot),
        type: 'post',
        data: {
            '_token': token
        }
    });
}


var jumpId = 0;
function portkey(id){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='hintspot' class='jump hots"+ id +"' value='"+ id +"'>"+
            "<img width='100%' src='"+ iconsRoute +"/elevator.png' />" +
        "</div>"
    );
    $('.hots' + id).click(function(){
        $("#addHotspot").hide();
        $(".containerEditHotspot").hide();
        //Rellenar con la informacion del hotspot
        $("#jumpTitle").val(title);
        $("#jumpHotspot > textarea").val(description);
        //Mostrar el panel de edicion
        $("#editHotspot").show();
        $("#jumpHotspot").show();
        
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
        $("#editHotspot .buttonDelete").off(); //desvincular previos
        $("#editHotspot .buttonDelete").on('click', function(){
            deleteHotspot(id)
            //Si se elimina correctamente
            .done(function(){
                $(".hots"+id).remove();
                $("#addHotspot").show();
                $("#editHotspot").hide();
            })
            .fail(function(){
                alert("error al eliminar");
            })
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
        });
    });


    /*********************ELEGIR ESCENA DE DESTINO**********************/
    $('#selectDestinationSceneButton').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#map').css('display', 'block');
    });
    //
    
});