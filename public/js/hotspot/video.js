/********************************************************
 *               HOTSPOT DE TIPO VIDEO                  *
 ********************************************************/

function video(id, title, description, pitch, yaw){

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
            "<iframe src='https://player.vimeo.com/video/2910853' width='640' height='360' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
        "</div>"+
        "</div>"
    );            

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        //Ocultar paneles correspondientes
        $("#addHotspot").hide();
        $(".containerEditHotspot").hide();
        //Rellenar con la informacion del hotspot
        $("#videoHotSpot input").val(title);
        $("#videoHotSpot textarea").val(description);
        //Mostrar el panel de edicion
        $("#editHotspot").show();
        $("#videoHotSpot").show();

        ////////////// EDITAR ///////////////
        getVideosPreview();
        //Poner a la escucha los cambios de datos para almacenar en la base de datos
        $("#videoHotSpot input, #videoHotSpot textarea").unbind(); //desvincular previos
        $("#videoHotSpot input, #videoHotSpot textarea").change(function(){
            //Controlar error de no guardar datos nulos
            if(!$(this).val()==""){
                //Actualizar
                var newTitle = $("#videoHotSpot input").val();
                var newDescription = $("#videoHotSpot textarea").val();
                updateHotspot(id,newTitle,newDescription,pitch,yaw,0)
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

    //--------------------------------------------------------------------
    

    /*
     *METODO PARA OBTENER TODOS LOS VIDEOS DISPONIIBLES EN RECURSOS DE LA BASE DE DATOS
     */
    function getVideosPreview(){
        console.log("hot");
        //Obtener listado de todos los videos disponibles en la base de datos
        $.ajax({
            url: routeGetVideos,
            type: 'post',
            data: {
                "_token": token,
            },
            dataType:"json",
            success:function(json){
                //Eliminar el contenido previo del panel con todos los videos
                $('#videoHotSpot .content').empty();
                //Procesar resultados y crear un elemento html por cada video obtenido;
                for(var i=0;i<json.length; i++){
                    $('#videoHotSpot .content').append(
                        "</br><div id='"+json[i].id+"' class='previewVideo'>"+
                            "<span>"+json[i].title+"</span>"+
                        "</div>"
                    );  
                }

                //Establecer funcionalidad a cada uno de los elementos
                $(".previewVideo").on('click', function(){
                    //Obtener la ruta del video de vimeo que hemos pulsado
                    for(var i=0; i<json.length; i++){
                        if(json[i].id==$(this).attr('id')){
                            //Cambiar url iframe
                            $(".hots"+id+" iframe").attr('src', "https://player.vimeo.com/video/"+json[i].route);
                            console.log(json[i].route);
                        }
                    }
                });
                
            }
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