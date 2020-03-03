/**************************************
 * HOTSPOT DE TIPO GALERÍA DE IMÁGENES
 **************************************/

//SACO EL ID DE LA GALERIA
function getIdGallery(hotspot){
    return $.ajax({
        url: getIdGalleryRoute.replace('hotspotid', hotspot),
        type: 'POST',
        data: {
            '_token': token,
        }
    });
}


//SACAR LAS IMAGENES DE LA GALERÍA A TRAVÉS DE LOS RECURSOS
function getImages(gallery){
    var route = getImagesGalleryRoute.replace('id', gallery);
    return $.ajax({
        url: route,
        type: 'post',
        data: {
            "_token": token,
        },
    });

}
    
function imageGallery(id){
    var resources = null;
    
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        '<div id="reveal" class="hots'+ id +'">' +
            '<img src="'+ galleryImageHotspot +'">' +
            '<div class="reveal-content">' +
                '<img height="100%" id="galleryImage'+ id +'" class="imgGallery">' +
            '</div>' +
        '</div>'
    );

    getIdGallery(id).done(function(result){
        if(result.gallery != -1){
            getImages(result.gallery).done(function(result){
                $('#galleryImage' + id).attr('src', '/'+result.resources[1].route);
            });
        }
    });

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        //Actuamos si no estaba ya seleccionado esto hotspot previamente para su edicion
        // if( !$(".hots"+id).hasClass('active') ){
        //     //Eliminar la clase de todo los anterior hotspot seleccionados
        //     $(".hotspotElement").removeClass('active');
        //     $(".hots"+id).addClass('active');

            //Ocultar paneles correspondientes
            $("#addHotspot").hide();
            $(".containerEditHotspot").hide();
            $('#jumpHotspot').hide();
            $('#portkeyHotspot').hide();
            $('#imageGalleryHotspot').css('display', 'block');
            //asigno el id del hotspot al botón para poder usarlo
            $("#editHotspot").show();
            $('#asingGallery').attr('value', id);

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
                    $(".hotspotElement").removeClass('active');

                    //Volver a desactivar las acciones de doble click
                    $("#pano").off( "dblclick");
                    //Quitar el cursor de tipo cell
                    $("#pano").removeClass("cursorAddHotspot");
                    //Mostrar el menu inicial
                    showMain();
                }
            }); 
        //}
    });

    $('#galleryImage' + id).click(function(){
        getIdGallery(id).done(function(result){
            getImages(result.gallery).done(function(result){
                console.log(urlImagesGallery.replace('image', result['resources'][1].route));
                numImgs = result['resources'].length;
                $("#numImages").attr('value', numImgs);
                $('#actualResource').attr('value', 1);
                $('#galleryResources').empty();
                $('#imageMiniature').empty();
                for(var i = 0; i < result['resources'].length; i++){
                    if(i == 0){
                        $('#galleryResources').prepend(
                            "<div id='n"+ (i+1) +"' class='recurso' style='width:100%;'>" +
                                "<div style='width: 90%; color: black; float: left'><h3>"+ result['resources'][i].title +"</h3></div>"
                                +"<div style='width: 90%; float: left'><img style='width:70%' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' /></div>"
                           +"</div>"
                        );
                    }else{
                        $('#galleryResources').prepend(
                            "<div id='n"+ (i+1) +"' class='recurso' style='width:100%; display:none;'>" +
                                "<div style='width: 90%; color: black; float: left;'><h3>"+ result['resources'][i].title +"</h3></div>"
                                +"<div style='width: 90%; float: left;'><img style='width:70%' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' /></div>"
                            +"</div>"
                        );
                    }
                    
                    $('#imageMiniature').append(
                        "<div id='"+ (i+1) +"' class='miniature' style='width: 10%; float:left; margin-right: 2%'>"+
                            "<img  style='width: 100%;' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' />" +
                        "</div>"
                    );
                    $(".miniature").click(function(){
                        var recurso = $(this).attr('id');
                        $('.recurso').css('display', 'none');
                        $('#n'+recurso).css('display', 'block');
                        $('#actualResource').attr('value', recurso);
                    });
                }
                $('#galleryResources').css('display', 'block');
            });
        });
        
        $(document).delay(200);
        $('#modalWindow').css('display', 'block');
        $('#showAllImages').css('display', 'block');
    });

    


}

$().ready(function(){
    //MOSTRAR GALERÍAS PARA ASIGNARLE UNA AL HOTSPOT
    $('#asingGallery').click(function(){
        $('#allGalleries').show();
    });

    //ASIGNAR LA GALERÍA AL HOTSPOT
    $('.asingThisGallery').click(function(){
        var hotspot = $('#asingGallery').attr('value');
        var idType = $(this).attr('id');
        updateIdType(parseInt(hotspot), parseInt(idType));
    });

    $('#closeModalWindowButton').click(function(){
        $('#modalWindow').css('display', 'none');
        $('#showAllImages').css('display', 'none');
        $('#galleryResources').empty();
    });

    

    $('#backResource').click(function(){
        $('.recurso').css('display', 'none');
        var numImages = $("#numImages").attr('value');
        var actual = $("#actualResource").attr('value');
        if(actual == 1){
            $("#n"+numImages).css('display', 'block');
            $('#actualResource').attr('value', numImages);
        }else{
            var next = parseInt(actual) -1;
            $("#n"+next).css('display', 'block');
            $('#actualResource').attr('value', next);
        }
    });

    $('#nextResource').click(function(){
        $('.recurso').css('display', 'none');
        var numImages = $("#numImages").attr('value');
        var actual = $("#actualResource").attr('value');
        if(actual == numImages){
            $("#n1").css('display', 'block');
            $('#actualResource').attr('value', 1);
        }else{
            var next = parseInt(actual) + 1;
            $('#n' + next).css('display', 'block');
            $('#actualResource').attr('value', next);
        }
    });
    
    
});