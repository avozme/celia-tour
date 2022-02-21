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
    
function imageGallery(id, idType){
    var resources = null;

    var codigoHTML = "<div id='imageGalleryIcon' class='hots"+id+" hotspotElement'>"+
                        "<div class='icon_wrapper'>"+
                            "<div class='icon'>"+
                            "<div id='inner_icon' class='inner_icon'>";
    if (idType == -1) {  // El hotspot es huérfano y le vamos a poner una clase especial para verlo
        codigoHTML += "<svg class='huerfano' id='iconIG' viewBox='0 0 488.455 488.455'>"+
                            "<path d='m287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0'/>"+
                            "<path d='m427.397 91.581h-42.187l-30.544-61.059h-220.906l-30.515 61.089-42.127.075c-33.585.06-60.925 27.429-60.954 61.029l-.164 244.145c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059v-244.236c-.001-33.674-27.385-61.058-61.059-61.058zm-183.177 290.029c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118-54.783 122.118-122.118 122.118z'/>"+
                        "</svg>";
    } else {
        codigoHTML += "<svg id='iconIG' viewBox='0 0 488.455 488.455'>"+
                            "<path d='m287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0'/>"+
                            "<path d='m427.397 91.581h-42.187l-30.544-61.059h-220.906l-30.515 61.089-42.127.075c-33.585.06-60.925 27.429-60.954 61.029l-.164 244.145c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059v-244.236c-.001-33.674-27.385-61.058-61.059-61.058zm-183.177 290.029c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118-54.783 122.118-122.118 122.118z'/>"+
                        "</svg>";

    }               

    codigoHTML += "</div></div></div></div>";

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(codigoHTML);

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        //Ocultar paneles correspondientes
        $("#addHotspot").hide();
        $(".containerEditHotspot").hide();
        $('#jumpHotspot').hide();
        $('#portkeyHotspot').hide();
        $("#typesHotspot").hide();
        $("#helpHotspotAdd").hide();
        $("#helpHotspotMove").hide();
        $('#imageGalleryHotspot').css('display', 'block');
        //asigno el id del hotspot al botón para poder usarlo
        $("#editHotspot").show();
        $('#asingGallery').attr('value', id);

        //Actuamos si no estaba ya seleccionado esto hotspot previamente para su edicion
        if( !$(".hots"+id).hasClass('active') ){
            //Eliminar la clase activos de todos los anteriores hotspot seleccionados
            $(".hotspotElement").removeClass('active');
            $(".hots"+id).addClass('active');
        }

        //Establecer id al boton de abrir galeria
        $(".buttonShowGallery").attr("id", id);

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
                $(".hotspotElement").css("pointer-events", "all");
                
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


    $('.buttonShowGallery').click(function(){
        var idSelect = $(".buttonShowGallery").attr("id");
        getIdGallery(idSelect).done(function(result){
            getImages(result.gallery.id_type).done(function(result){
                numImgs = result['resources'].length;
                $("#numImages").attr('value', numImgs);
                $('#actualResource').attr('value', 1);
                $('#galleryResources').empty();
                $('#imageMiniature').empty();

                //Boton cerrar ventana
                $('#galleryResources').append(`
                    <button id="closeModalWindowButton" class="closeModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                    </button>`);
                $('#closeModalWindowButton').click(function(){
                    $('#modalWindow').css('display', 'none');
                    $('#showAllImages').css('display', 'none');
                    $('#galleryResources').empty();
                });

                //Agregar todas las imagenes
                for(var i = 0; i < result['resources'].length; i++){
                    if(i == 0){
                        $('#galleryResources').prepend(
                            "<div id='n"+ (i+1) +"' class='recurso col100'>" +
                                "<span class='titleModal col100'>"+ result['resources'][i].title +"</span>"+
                                "<center class='col100'><img class='imgGallery mmarginTop' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' /></center>"
                           +"</div>"
                        );
                    }else{
                        $('#galleryResources').prepend(
                            "<div id='n"+ (i+1) +"' class='recurso col100' style='display:none'>" +
                                "<span class='titleModal col100'>"+ result['resources'][i].title +"</span>"+
                                "<center class='col100'><img class='imgGallery mmarginTop' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' /></center>"
                           +"</div>"
                        );
                    }
                    
                    $('#imageMiniature').append(
                        "<div id='"+ (i+1) +"' class='elementResource miniature col125'>"+
                            "<div class='insideElement'>"+
                                "<img style='width: 100%;' class='miniatureImg' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' />" +
                            "</div>"+
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
    $('#allGalleries').show();
    
    //ASIGNAR LA GALERÍA AL HOTSPOT
    $('.asingThisGallery').click(function(){
        var hotspot = $('#asingGallery').attr('value');
        var idType = $(this).attr('id');
    //Buscar el hostpot concreto que deseamos eliminar la class huerfano
        var idHost = $('.hots'+parseInt(hotspot)+'> .icon_wrapper > .icon > #inner_icon > svg.huerfano');

        updateIdType(parseInt(hotspot), parseInt(idType)).done(function(){
            $(".asingThisGallery[id="+ idType +"]").siblings(".msgAsingGallery").slideDown(800).delay(1500).slideUp(800);
    //Remover la class huerfano para que asigne el css correspondiente a los hostpots con recurso asignado
            $(idHost[0]).removeClass("huerfano");
        });
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