/***********************************************************
 *               HOTSPOT DE TIPO MODELO 3D                  *
 ***********************************************************/
//IdType corresponde al id del recurso de asociado a traves de la tabla intermedia
function model3d(id, idType){

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='imageGalleryIcon' class='hots"+id+" hotspotElement'>"+
        "<div class='icon_wrapper'>"+
        "<div class='icon'>"+
        "<div id='inner_icon' class='inner_icon'>"+
        "<svg version='1.1' id='iconIG' width?'16' height='16' viewBox='0 0 16 16' >"+
        "<path d='M4.52 8.368h.664c.646 0 1.055.378 1.06.9.008.537-.427.919-1.086.919-.598-.004-1.037-.325-1.068-.756H3c.03.914.791 1.688 2.153 1.688 1.24 0 2.285-.66 2.272-1.798-.013-.953-.747-1.38-1.292-1.432v-.062c.44-.07 1.125-.527 1.108-1.375-.013-.906-.8-1.57-2.053-1.565-1.31.005-2.043.734-2.074 1.67h1.103c.022-.391.383-.751.936-.751.532 0 .928.33.928.813.004.479-.383.835-.928.835h-.632v.914zm3.606-3.367V11h2.189C12.125 11 13 9.893 13 7.985c0-1.894-.861-2.984-2.685-2.984H8.126zm1.187.967h.844c1.112 0 1.621.686 1.621 2.04 0 1.353-.505 2.02-1.621 2.02h-.844v-4.06z'/>"+
        "<path d='M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z'/>"+
        "</svg>"+
        "</div>"+
        "</div>"+
        "</div>"+
        "</div>"
    );

    //ESTABLECER INICIALMENTE EL VIDEO AL IFRAME
    getModel3D()
        .done(function(json){
            //Comprobar si es la primera instanciacion del hotspot (Creacion)
            if(idType==-1){
                //Asociar por defecto con el ultimo recurso del tipo agregado a la base de datos
                updateIdType(json[json.length-1].id)
                    .done(function(){
                        idType=json[json.length-1].id;
                        setVideoIframe(json);
                    });
            }else{
                //Si no es su creacion cargamos directamente el video
                setVideoIframe(json);
            }
        });

    //------------------------------------------------------------------------------------------------------

    /**
     * METODO PARA ESTABLECER EL VIDEO DE VIMEO EN EL IFRAME
     */
    function setVideoIframe(json){
        //Obtener la ruta del video de vimeo
        for(var i=0;i<json.length; i++){
            if(json[i].id==idType){
                $(".hots"+id+" model3D").attr('src', indexUrl+"/"+json[i].route);
            }
        }
    }

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL
    $(".hots"+id).click(function(){

        //Apertura de hotspot
        if($(".hots"+id).hasClass("expanded")){
            $(".hots"+id).removeClass('expanded');
            $(".hots"+id+" #inner_icon").removeClass('closeIcon');
        }else{
            $(".hots"+id).addClass('expanded');
            $(".hots"+id+" #inner_icon").addClass('closeIcon');
        }
        //Actuamos si no estaba ya seleccionado esto hotspot previamente para su edicion
        if( !$(".hots"+id).hasClass('active') ){
            //Eliminar la clase activos de todos los anteriores hotspot seleccionados
            $(".hotspotElement").removeClass('active');
            $(".hots"+id).addClass('active');

            //Mostrar panel de carga
            $("#resourcesList .load").show();
            $("#resourcesList .content").hide();

            //Ocultar paneles correspondientes
            $("#addHotspot").hide();
            $(".containerEditHotspot").hide();
            $("#typesHotspot").hide();
            $("#helpHotspotAdd").hide();
            $("#helpHotspotMove").hide();
            //Mostrar el panel de edicion
            $("#editHotspot").show();
            $("#resourcesList").show();

            //Mostrar listado de los modelos al hacer click
            showPreviewModel3D();

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
                $(".hotspotElement").css("pointer-events", "none");
                //Cambiar estado hotspot
                $(".hots"+id).find(".icon_wrapper").addClass("moveA");
                $(".hots"+id).find(".icon").addClass("moveB");
                $(".hots"+id).find(".icon svg").addClass("moveC");

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
                    //Cambiar estado hotspot para que no parpadee
                    $(".hots"+id).find(".icon_wrapper").removeClass("moveA");
                    $(".hots"+id).find(".icon").removeClass("moveB");
                    $(".hots"+id).find(".icon svg").removeClass("moveC");
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
        }
    });

    //--------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LAS MINIATURAS PARA CADA MODELO 3D
     */
    function showPreviewModel3D(){
        //Quitar elemento seleccionado
        $('#resourcesList .previewModel3D img').removeClass('audioSelected');

        getModel3D()
            .done(function(json){
                //Eliminar el contenido previo del panel con todos los modelos 3D

                $('#resourcesList .content').empty();
                //Procesar resultados y crear un elemento html por cada video obtenido;
                for(var i=0;i<json.length; i++){
                    var description = json[i].description!=null? json[i].description : "";
                    $('#resourcesList .content').append(
                        "<div id='"+json[i].id+"' class='previewModel3D col100'>"+
                        "<img class='col40' src='../../img/model3d.png' /><br>"+
                        "<span class='col100'><strong>"+json[i].title+"</strong></span>"+
                        "<span class='col100'>"+description+"</span>"+
                        "</div>"
                    );
                    //Marcar el video que tiene asignado el hotspot al cargar
                    if(json[i].id==idType){
                        $('#resourcesList #'+json[i].id+" img").addClass('audioSelected');

                    }
                }

                //Establecer funcionalidad a cada uno de los elementos de preview
                $(".previewModel3D").on('click', function(){
                    //Obtener la ruta del video de vimeo que hemos pulsado
                    for(var i=0; i<json.length; i++){
                        if(json[i].id==$(this).attr('id')){
                            //Marcar borde del video seleccionado
                            $('#resourcesList .previewModel3D img').removeClass('audioSelected');
                            $('#resourcesList #'+json[i].id+" img").addClass('audioSelected');
                            //Cambiar url iframe
                            $(".hots"+id+" model3d").attr('src', indexUrl+"/"+json[i].route);
                            //Guardar valor en la base de datos
                            updateIdType(json[i].id);
                        }
                    }
                });

                //Al completarse el proceso de recuperar los modelos 3D mostrar panel
                $("#resourcesList .load").hide();
                $("#resourcesList .content").show();
                //Mover automaticamente al video marcado
                $('#resourcesList .content').scrollTop($('#resourcesList #'+idType+" img").offset().top-100);
            });
    }

    //---------------------------------------------------------------------------------------------

    /*
     * METODO PARA ACTUALIZAR EL VIDEO ASOCIADO AL HOTSPOT EN LA TABLA INTERMEDIA
     */
    function updateIdType(newIdType){
        //Obtener listado de todos los videos disponibles en la base de datos
        return $.ajax({
            url: routeUpdateIdType.replace('req_id', id),
            type: 'post',
            data: {
                "_token": token,
                "newId":newIdType
            },
            dataType:"json",
            success:function(result){
                //Obtener el resultado de la accion
                if(result['status']){
                    //Actualizar variable local
                    idType = newIdType;
                }else{
                    alert("Error al actualizar el modelo 3D del hotspot");
                }
            }
        });
    }

    //--------------------------------------------------------------------

    /*
     *METODO PARA OBTENER TODOS LOS VIDEOS DISPONIIBLES EN RECURSOS DE LA BASE DE DATOS
     */
    function getModel3D(){
        //Obtener listado de todos los videos disponibles en la base de datos
        return $.ajax({
            url: routeGetModel3D,
            type: 'post',
            data: {
                "_token": token,
            },
            dataType:"json"
        });
    }

    //--------------------------------------------------------------------



}
