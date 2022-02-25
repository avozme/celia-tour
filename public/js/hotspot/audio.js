/********************************************************
 *               HOTSPOT DE TIPO AUDIO                  *
 ********************************************************/
//IdType corresponde al id del recurso de asociado a traves de la tabla intermedia
function audio(id, idType){

    var codigoHTML = "<div id='audio' class='hots"+id+" hotspotElement'>"+
                        "<div class='icon_wrapper'>"+
                         "<div class='icon'>"+
                     "<div id='inner_icon' class='inner_icon'>";
    if (idType == -1) {  // El hotspot es huérfano y le vamos a poner una clase especial para verlo
        codigoHTML += "<svg version='1.1' class=huerfano id='audioIcon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 384 384' style='enable-background:new 0 0 384 384;' xml:space='preserve'>"+
                        "<g><path d='M288,192c0-37.653-21.76-70.187-53.333-85.867v171.84C266.24,262.187,288,229.653,288,192z'/>"+
                        "<polygon points='0,128 0,256 85.333,256 192,362.667 192,21.333 85.333,128'/>"+
                      "<path d='M234.667,4.907V48.96C296.32,67.307,341.333,124.373,341.333,192S296.32,316.693,234.667,335.04v44.053C320.107,359.68,384,283.413,384,192S320.107,24.32,234.667,4.907z'/></g>"+
                    "</svg>";
    } else {
        codigoHTML += "<svg version='1.1' id='audioIcon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 384 384' style='enable-background:new 0 0 384 384;' xml:space='preserve'>"+
        "<g><path d='M288,192c0-37.653-21.76-70.187-53.333-85.867v171.84C266.24,262.187,288,229.653,288,192z'/>"+
            "<polygon points='0,128 0,256 85.333,256 192,362.667 192,21.333 85.333,128'/>"+
            "<path d='M234.667,4.907V48.96C296.32,67.307,341.333,124.373,341.333,192S296.32,316.693,234.667,335.04v44.053C320.107,359.68,384,283.413,384,192S320.107,24.32,234.667,4.907z'/></g>"+
        "</svg>";

    }               

    codigoHTML += "<svg style='display:none;' id='closeIcon' enable-background='new 0 0 386.667 386.667' viewBox='0 0 386.667 386.667'  xmlns='http://www.w3.org/2000/svg'><path d='m386.667 45.564-45.564-45.564-147.77 147.769-147.769-147.769-45.564 45.564 147.769 147.769-147.769 147.77 45.564 45.564 147.769-147.769 147.769 147.769 45.564-45.564-147.768-147.77z'/></svg>"+
    "</div></div></div><div class='content'><audio src=''controls></audio></div></div>";

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(codigoHTML);        

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
            
            //Mostrar listado de audios al hacer click
            showPreviewAudios();

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
    
    /* METODO PARA MOSTRAR LAS MINIATURAS PARA CADA AUDIO */
    function showPreviewAudios(){
        //Quitar elemento seleccionado
        $('#resourcesList .previewAudio img').removeClass('audioSelected');

        getAudios()
        .done(function(json){
           //Eliminar el contenido previo del panel con todos los audios
           $('#resourcesList .content').empty();
           //Procesar resultados y crear un elemento html por cada video obtenido;
           for(var i=0;i<json.length; i++){
               var description = json[i].description!=null? json[i].description : "";
               $('#resourcesList .content').append(
                   "<div id='"+json[i].id+"' class='previewAudio col100'>"+
                        "<img class='col100' src='../../img/spectre2.png' /><br>"+
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
           $(".previewAudio").on('click', function(){
               //Obtener la ruta del video de vimeo que hemos pulsado
               for(var i=0; i<json.length; i++){
                   if(json[i].id==$(this).attr('id')){
                       //Marcar borde del video seleccionado
                       $('#resourcesList .previewAudio img').removeClass('audioSelected');
                       $('#resourcesList #'+json[i].id+" img").addClass('audioSelected');
                       //Cambiar url iframe
                       $(".hots"+id+" audio").attr('src', indexUrl+"/"+json[i].route);
                       //Guardar valor en la base de datos
                       updateIdType(json[i].id);
                   }
               }
           });

           //Al completarse el proceso de recuperar los audios mostrar panel
           $("#resourcesList .load").hide();
           $("#resourcesList .content").show();
            //Mover automaticamente al video marcado
            //$('#resourcesList .content').scrollTop($('#resourcesList #'+idType+" img").offset().top-100);
        });  
    }

    //---------------------------------------------------------------------------------------------

    /* METODO PARA ACTUALIZAR EL VIDEO ASOCIADO AL HOTSPOT EN LA TABLA INTERMEDIA */
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
                    alert("Error al actualizar el audio del hotspot");
                }
            }
        }); 
    }

    //--------------------------------------------------------------------

    /* METODO PARA OBTENER TODOS LOS VIDEOS DISPONIIBLES EN RECURSOS DE LA BASE DE DATOS */
    function getAudios(){
        //Obtener listado de todos los videos disponibles en la base de datos
        return $.ajax({
            url: routeGetAudios,
            type: 'post',
            data: {
                "_token": token,
            },
            dataType:"json"
        }); 
    }

    //--------------------------------------------------------------------
     
    //Código para asignar automáticamente un recurso, comentado por si se desea volver a la asignación automática
   /* //ESTABLECER INICIALMENTE EL VIDEO AL IFRAME
    getAudios()
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

   //METODO PARA ESTABLECER EL VIDEO DE VIMEO EN EL IFRAME
    function setVideoIframe(json){
        //Obtener la ruta del video de vimeo
        for(var i=0;i<json.length; i++){
            if(json[i].id==idType){
                $(".hots"+id+" audio").attr('src', indexUrl+"/"+json[i].route);
            }
        }
    } */


}