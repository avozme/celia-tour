function portkey(id){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div class='portkey hots"+ id +"' value='"+ id +"'>"+
            "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 460.56 460.56' fill='white'>"+
                "<path d='M218.82,664.34H19V203.79H218.82ZM119.15,445.49l37.7,38.2,30.34-30.44q-34.08-34.17-68.34-68.52L50.66,453.15l29.91,30.62Z' transform='translate(-19 -203.79)'/>"+
                "<path d='M479.56,664.34H280V203.87H479.56ZM448,415.21l-29.84-30.55-38.26,37.95L342,384.83l-30.2,30.31,68.16,68.39Z' transform='translate(-19 -203.79)'/>"+
            "</svg>" +
           
            "<div class='contentPortkey'>"+
                
            "</div>"+
        "</div>"
    );

    //--------------------------------------------------------------------------------------------------------

    //Obtener el id del tipo de recurso (tabla portkey)
    $( document ).ready(function() {
        loadFloors(id);

        ////////////////// ASIGNAR PORTKEY //////////////////
        $('.asingThisPortkey').click(function(){
            var hotspot = $('#asingPortkey').attr('value');
            var portkey = $(this).attr('id');
            updateIdType(hotspot, portkey).done(function(){
                loadFloors(id);
            });
        });
    });

    //--------------------------------------------------------------------------------------------------------
  
    /**
     * ACCIONES AL PULSAR SOBRE ESTE TIPO DE HOTSPOT
     */
    $('.hots' + id).click(function(){
        $("#addHotspot").hide();
        $(".containerEditHotspot").hide();
        $("#typesHotspot").hide();
        $("#helpHotspotAdd").hide();
        $("#helpHotspotMove").hide();

        //Mostrar el panel de edicion
        $("#editHotspot").show();
        $("#portkeyHotspot").show();
        $('#asingPortkey').attr('value', id);
        
        //Apertura de hotspot (Mostrando contenido)
        if($(".hots"+id).hasClass("expanded")){
            $(".hots"+id).removeClass('expanded');
        }else{
            $(".hots"+id).addClass('expanded');
        }
        
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

//---------------------------------------------------------------------------------

/**
 * FUNCION PARA OBTENER EL ID DEL PORTKEY ASOCIADO
 */
function getIdType(hotspot){
    return $.ajax({
        url: getIdTypeRoute.replace('id', hotspot),
        type: 'post',
        data: {
            '_token': token
        }
    });
}


//---------------------------------------------------------------------------------

/**
 * FUNCION PARA CARGAR LAS PLANTAS DE UN TRASLADOR
 */
function loadFloors(id){
    getIdType(id)
    .done(function(json){
        var portId = json.id_type;
        //Recuperar todas las escenas del ascensor recuperado
        $.ajax({
            url: getScenesPortkey.replace('id', portId),
            type: 'post',
            data: {
                '_token': token
            },
            success: function(data) {
               
                //Ordenar ascensor por orden de planta
                data = data.sort(function(a, b) {
                    var x = a.pos, y = b.pos;
                    return x > y ? -1 : x < y ? 1 : 0;
                });

                //Eliminar contenido previo
                $(".hots"+id+" .contentPortkey").html("");

                //Crear cada una de las plantas en el ascensor
                for(var i=0; i<data.length; i++){
                    var elementChild = 
                        "<div class='floor'>"+
                            "<span>"+data[i].zone+"</span>"+
                        "</div>";

                    $(".hots"+id+" .contentPortkey").append(elementChild);
                }
            }
        });
    });
}