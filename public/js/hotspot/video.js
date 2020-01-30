/********************************************************
 *               HOTSPOT DE TIPO VIDEO                  *
 ********************************************************/
//IdType corresponde al id del recurso de asociado a traves de la tabla intermedia
function video(id, idType){

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='info' class='hots"+id+"'>"+
        "<div class='icon_wrapper'>"+
            "<div class='icon'>"+
            "<div id='inner_icon' class='inner_icon'>"+
                "<div class='icon1'></div>"+
                "<div class='icon2'></div>"+
            "</div>"+
            "</div>"+
        "</div>"+
        "<div class='content'>"+
            "<iframe src='' width='640' height='360' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
        "</div>"+
        "</div>"
    );            

    //ESTABLECER INICIALMENTE EL VIDEO AL IFRAME
    getVideos()
        .done(function(json){
            //Comprobar si es la primera instanciacion del hotspot (Creacion)
            if(idType==-1){
                //Asociar por defecto con el ultimo recurso del tipo agregado a la base de datos
                updateIdType(json[json.length-1].id)
                    .done(function(){
                        idType=json[json.length-1].id;
                        setVideoIframe(json);
                        $(".hots"+id).click();
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
                $(".hots"+id+" iframe").attr('src', "https://player.vimeo.com/video/"+json[i].route);
            }
        }
    }

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        //Ocultar paneles correspondientes
        $("#addHotspot").hide();
        $(".containerEditHotspot").hide();
        //Mostrar el panel de edicion
        $("#editHotspot").show();
        $("#videoHotSpot").show();
        
        //Mostrar listado de videos al hacer click
        showPreviewVideos();

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

    //--------------------------------------------------------------------
    
    /**
     * METODO PARA MOSTRAR LAS MINIATURAS O PREVIEW DE LOS VIDEOS EN EL PANEL
     */
    function showPreviewVideos(){
        //Quitar elemento seleccionado
        $('#videoHotSpot .previewVideo img').removeClass('videoSelected');

        getVideos()
        .done(function(json){
           //Eliminar el contenido previo del panel con todos los videos
           $('#videoHotSpot .content').empty();
           //Procesar resultados y crear un elemento html por cada video obtenido;
           for(var i=0;i<json.length; i++){
               $('#videoHotSpot .content').append(
                   "<div id='"+json[i].id+"' class='previewVideo col100'>"+
                        "<img class='col100' src='"+json[i].preview+"' /><br>"+
                        "<span class='col100'>"+json[i].title+"</span>"+
                   "</div>"
               );  

               if(json[i].id==idType){
                    $('#videoHotSpot #'+json[i].id+" img").addClass('videoSelected');
                    //Mover automaticamente al video marcado
                    $('#videoHotSpot .content').scrollTop($('#videoHotSpot #'+json[i].id+" img").offset().top-100);
               }
               console.log(json[i].id)
           }

           //Establecer funcionalidad a cada uno de los elementos de preview
           $(".previewVideo").on('click', function(){
               //Obtener la ruta del video de vimeo que hemos pulsado
               for(var i=0; i<json.length; i++){
                   if(json[i].id==$(this).attr('id')){
                       //Marcar borde del video seleccionado
                       $('#videoHotSpot .previewVideo img').removeClass('videoSelected');
                       $('#videoHotSpot #'+json[i].id+" img").addClass('videoSelected');
                       //Cambiar url iframe
                       $(".hots"+id+" iframe").attr('src', "https://player.vimeo.com/video/"+json[i].route);
                       //Guardar valor en la base de datos
                       updateIdType(json[i].id);
                   }
               }
           });
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
                    alert("Error al actualizar el video del hotspot");
                }
            }
        }); 
    }

    //--------------------------------------------------------------------

    /*
     *METODO PARA OBTENER TODOS LOS VIDEOS DISPONIIBLES EN RECURSOS DE LA BASE DE DATOS
     */
    function getVideos(){
        //Obtener listado de todos los videos disponibles en la base de datos
        return $.ajax({
            url: routeGetVideos,
            type: 'post',
            data: {
                "_token": token,
            },
            dataType:"json"
        }); 
    }

    //--------------------------------------------------------------------

    /*
    *Acciones al hacer clic en el icono del apertura del hotspot
    */
    $(".hots"+id+" .icon_wrapper").on('click', function() {
        if($(".hots"+id).hasClass("expanded")){
            $(".hots"+id).removeClass('expanded');
            $(".hots"+id+" #inner_icon").removeClass('closeIcon');
        }else{
            $(".hots"+id).addClass('expanded');
            $(".hots"+id+" #inner_icon").addClass('closeIcon');
        }
    });


}