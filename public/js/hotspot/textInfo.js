/*********************************************************
 * HOTSPOT DE TIPO TEXTO CON UN TITULO Y UNA DESCRIPCIÓN
 ********************************************************/

function textInfo(id, title, description, pitch, yaw){

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='textInfo' class='hots"+id+" hotspotElement'>"+
            "<div class='hotspot'>"+
                "<div class='out'></div>"+
                "<div class='in'></div>"+
            "</div>"+
            "<div class='tooltip-content'>"+
                "<strong class='title'>"+title+"</strong></br>"+
                "<span class='description'>"+description+"</span>"+
            "</div>"+
        "</div>"
    );            

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        //Actuamos si no estaba ya seleccionado esto hotspot previamente para su edicion
        if( !$(".hots"+id).hasClass('active') ){
            //Eliminar la clase de todo los anterior hotspot seleccionados
            $(".hotspotElement").removeClass('active');
            $(".hots"+id).addClass('active');

            //Ocultar paneles correspondientes
            $("#addHotspot").hide();
            $(".containerEditHotspot").css('display', 'none');
            $('#jumpHotspot').css('display', 'none');
            $("#typesHotspot").hide();
            $("#helpHotspotAdd").hide();
            $("#helpHotspotMove").hide();

            //Rellenar con la informacion del hotspot
            $("#textHotspot input").val(title);
            $("#textHotspot textarea").val(description);
            //Mostrar el panel de edicion
            $("#editHotspot").show();
            $("#textHotspot").show();

            ////////////// EDITAR ///////////////
            //Poner a la escucha los cambios de datos para almacenar en la base de datos
            $("#textHotspot input, #textHotspot textarea").unbind(); //desvincular previos
            $("#textHotspot input, #textHotspot textarea").keyup(function(){
                //Controlar error de no guardar datos nulos
                if(!$(this).val()==""){
                    //Actualizar
                    var newTitle = $("#textHotspot input").val();
                    var newDescription = $("#textHotspot textarea").val();
                    updateHotspot(id,newTitle,newDescription,pitch,yaw,0)
                        //Datos almacenados correctamente
                        .done(function(){
                            title = newTitle;
                            description = newDescription;
                            $(".hots"+id+" .title").text(title);
                            $(".hots"+id+" .description").text(description);
                        }) 
                }                       
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


            /////////// ELIMINAR //////////////
            $("#editHotspot .buttonDelete, #btnModalOk").off(); //desvincular previos
            $("#editHotspot .buttonDelete").on('click', function(){
                //Mostrar modal
                $("#modalWindow").show();
                $("#deleteHotspotWindow").show();
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
                        alert("error al eliminar");
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

                    //Volver a desactivar las acciones de doble click
                    $("#pano").off( "dblclick");
                    //Quitar el cursor de tipo cell
                    $("#pano").removeClass("cursorAddHotspot");
                    //Mostrar el menu inicial
                    showMain();
                }
            }); 
        }
    });
}