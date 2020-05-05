

function loadHide(idHotspot){
    $('#contentHotSpot').append(
        "<div id='iframespot' class='hots"+ idHotspot +" hotspotElement'>"+
            "<div class='col100 row55 message hideHotspot' value='"+ idHotspot +"'><p class='col100' style='height: 81%;overflow: auto; font-size: 85%; padding: 0 6%'></p></div>" +
            "<input type='hidden' value=''>" +
        "</div>"
    );
    getHideInfo(idHotspot).done(function(result){
        var hide = result['hide'];
        width = hide['width'];
        height = hide['height'];
        $('.hots' + idHotspot).css('width', width);
        $('.hots' + idHotspot).css('height', height);
        $('.hots' + idHotspot + ' > input').val(hide['id']);
        if(!hide.type){
            $('.hots' + idHotspot).addClass('clue');
        }else{
            $('.hots' + idHotspot).addClass('question');
        }
        getHideContent(hide['id'], hide['type'], idHotspot);
    });

/******************************* AL HACER CLICK EN ÉL *******************************/
    $(".hots"+idHotspot).click(function(){
        $('#actualHideId').val($(".hots"+idHotspot + ' > input').val());
        //Apertura de hotspot
        if($(".hots"+idHotspot).hasClass("expanded")){
            $(".hots"+idHotspot).removeClass('expanded');
            $(".hots"+idHotspot+" #inner_icon").removeClass('closeIcon');
        }else{
            $(".hots"+idHotspot).addClass('expanded');
            $(".hots"+idHotspot+" #inner_icon").addClass('closeIcon');
        }
        //Actuamos si no estaba ya seleccionado esto hotspot previamente para su edicion
        if( !$(".hots"+idHotspot).hasClass('active') ){
            //Eliminar la clase activos de todos los anteriores hotspot seleccionados
            $(".hotspotElement").removeClass('active');
            $(".hots"+idHotspot).addClass('active');

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

            //Mostrar listado de preguntas o pistas en función de a que le pinche
            if($(".hots"+idHotspot).hasClass('clue')){
                getAllClues().done(function(result){
                    var clues = result['clues'];
                    $('#textHotspot').empty();
                    clues.forEach(function(clue, index){
                        var arrayTexto = (clue.text).split(" ");
                        $('#textHotspot').append(
                            "<div id='clue"+ clue.id +"' class='col95 sPaddingBottom'>"+ 
                                "<div style='max-height: 30%; overflow: auto' class='sMarginBottom'><p>"+ clue.text +"</p></div>" + 
                                "<span style='display: none; padding-left:13%'>Pista asignada correctamente</span>"+
                                "<button id='asingThisClue"+ clue.id +"' class='col100 sMarginTop mMarginBottom'>Asignar pista</button>" +
                            "</div>"
                        );
                        var idHide = $('#actualHideId').val();
                        console.log('idHide: ' + idHide);
                        $('#asingThisClue'+clue.id).click(function(){
                            asignarPista(idHide, clue.id)
                            .done(function(result){
                                if(result['status']){
                                    $('#clue' + clue.id + ' > span').slideDown(850).delay(1300).slideUp(850);
                                }else{
                                    alert('algo salió mal');
                                }
                            })
                            .fail(function(){
                                alert('Error AJAX al asignar la pista al hide');
                            });
                        });
                        $('#textHotspot').show();
                    });
                });
            }else{
                getAllQuestions().done(function(result){
                    var questions = result['questions'];
                    $('#textHotspot').empty();
                    questions.forEach(function(question, index){
                        $('#textHotspot').append(
                            "<div id='question"+ question.id +"' class='col100 mPaddingBottom'>"+ 
                                "<p>"+ question.text +"</p>" + 
                                "<span style='display: none; padding-left:13%'>Pregunta asignada correctamente</span>"+
                                "<button id='asingThisQuestion"+ question.id +"' class='col100 mMarginTop'>Asignar pregunta</button>" +
                            "</div>"
                        );
                        var idHide = $('#actualHideId').val();
                        console.log('idHide: ' + idHide);
                        $('#asingThisQuestion'+question.id).click(function(){
                            asignarPregunta(idHide, question.id)
                            .done(function(result){
                                if(result['status']){
                                    $('#question' + question.id + ' > span').slideDown(850).delay(1300).slideUp(850);
                                }else{
                                    alert('algo salió mal');
                                }
                            })
                            .fail(function(){
                                alert('Error AJAX al asignar la pregunta al hide');
                            });
                        });
                        $('#textHotspot').show();
                    });
                });
            }

            /////////// VOLVER //////////////
            $("#editHotspot .buttonClose").off(); //desvincular previos
            $("#editHotspot .buttonClose").on('click', function(){
                //Cambiar estado hotspot
                $(".hots"+idHotspot).find(".in").removeClass("move");
                $(".hots"+idHotspot).find(".out").removeClass("moveOut");
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
                    deleteHotspot(idHotspot)
                    //Si se elimina correctamente
                    .done(function(){
                        $(".hots"+idHotspot).remove();
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
                $(".hots"+idHotspot).find(".icon_wrapper").addClass("moveA");
                $(".hots"+idHotspot).find(".icon").addClass("moveB");
                $(".hots"+idHotspot).find(".icon svg").addClass("moveC");
                
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
                    moveHotspot(idHotspot, yaw, pitch)
                        .done(function(result){
                            //Obtener el resultado de la accion
                            if(result['status']){                        
                                //Cambiar la posicion en la escena actual
                                hotspotCreated["hots"+idHotspot].setPosition( { "yaw": yaw, "pitch": pitch })
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
                    $(".hots"+idHotspot).find(".icon_wrapper").removeClass("moveA");
                    $(".hots"+idHotspot).find(".icon").removeClass("moveB");
                    $(".hots"+idHotspot).find(".icon svg").removeClass("moveC");
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

}

function jump(id, title, description, pitch, yaw){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='hintspot' class='hotspotElement jump hots"+ id +"' value='"+ id +"'>"+
            "<svg value='"+ id +"' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 250.1 127.22'><path d='M148.25,620.61l1.15-.79q61.83-39.57,123.65-79.15a1.71,1.71,0,0,1,2.2,0Q336,580.08,396.72,619.44l1.63,1.11a8,8,0,0,0-1.18.74l-46.73,45.15c-1.4,1.36-1.41,1.36-3,.15q-36.37-27.75-72.71-55.53a1.78,1.78,0,0,0-2.62,0q-37.26,28-74.56,55.86c-.85.64-1.37.72-2.2-.09q-23.1-22.68-46.24-45.32C148.84,621.25,148.58,621,148.25,620.61Z' transform='translate(-148.25 -540.26)' fill='white'/></svg>"+
        "</div>"
    );
}

function audio(id, idType){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='audio' class='hots"+id+" hotspotElement'>"+
        "<div class='icon_wrapper'>"+
            "<div class='icon'>"+
            "<div id='inner_icon' class='inner_icon'>"+
                "<svg version='1.1' id='audioIcon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 384 384' style='enable-background:new 0 0 384 384;' xml:space='preserve'>"+
                "<g><path d='M288,192c0-37.653-21.76-70.187-53.333-85.867v171.84C266.24,262.187,288,229.653,288,192z'/>"+
                    "<polygon points='0,128 0,256 85.333,256 192,362.667 192,21.333 85.333,128'/>"+
                    "<path d='M234.667,4.907V48.96C296.32,67.307,341.333,124.373,341.333,192S296.32,316.693,234.667,335.04v44.053C320.107,359.68,384,283.413,384,192S320.107,24.32,234.667,4.907z'/></g>"+
                "</svg>"+
                
                "<svg style='display:none;' id='closeIcon' enable-background='new 0 0 386.667 386.667' viewBox='0 0 386.667 386.667'  xmlns='http://www.w3.org/2000/svg'><path d='m386.667 45.564-45.564-45.564-147.77 147.769-147.769-147.769-45.564 45.564 147.769 147.769-147.769 147.77 45.564 45.564 147.769-147.769 147.769 147.769 45.564-45.564-147.768-147.77z'/></svg>"+
            "</div>"+
            "</div>"+
        "</div>"+
        "<div class='content'>"+
            "<audio src='' controls></audio>"+
        "</div>"+
        "</div>"
    );            
}

function video(id, idType){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='video' class='hots"+id+" hotspotElement'>"+
        "<div class='icon_wrapper'>"+
            "<div class='icon'>"+
            "<div id='inner_icon' class='inner_icon'>"+
                "<svg id='videoIcon' enable-background='new 0 0 494.942 494.942' viewBox='0 0 494.942 494.942' xmlns='http://www.w3.org/2000/svg'><path d='m35.353 0 424.236 247.471-424.236 247.471z'/></svg>"+
                "<svg style='display:none;' id='closeIcon' enable-background='new 0 0 386.667 386.667' viewBox='0 0 386.667 386.667'  xmlns='http://www.w3.org/2000/svg'><path d='m386.667 45.564-45.564-45.564-147.77 147.769-147.769-147.769-45.564 45.564 147.769 147.769-147.769 147.77 45.564 45.564 147.769-147.769 147.769 147.769 45.564-45.564-147.768-147.77z'/></svg>"+
            "</div>"+
            "</div>"+
        "</div>"+
        "<div class='content'>"+
            "<iframe src='' width='640' height='360' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
        "</div>"+
        "</div>"
    );            
}

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
}

function imageGallery(id){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='imageGalleryIcon' class='hots"+id+" hotspotElement'>"+
        "<div class='icon_wrapper'>"+
            "<div class='icon'>"+
            "<div id='inner_icon' class='inner_icon'>"+
                "<svg id='iconIG' viewBox='0 0 488.455 488.455'>"+
                    "<path d='m287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0'/>"+
                    "<path d='m427.397 91.581h-42.187l-30.544-61.059h-220.906l-30.515 61.089-42.127.075c-33.585.06-60.925 27.429-60.954 61.029l-.164 244.145c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059v-244.236c-.001-33.674-27.385-61.058-61.059-61.058zm-183.177 290.029c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118-54.783 122.118-122.118 122.118z'/>"+
                "</svg>"+
            "</div>"+
            "</div>"+
        "</div>"+
        "</div>"
    );
}

function portkey(id){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div class='portkey hotspotElement hots"+ id +"' value='"+ id +"'>"+
            "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 460.56 460.56' fill='white'>"+
                "<path d='M218.82,664.34H19V203.79H218.82ZM119.15,445.49l37.7,38.2,30.34-30.44q-34.08-34.17-68.34-68.52L50.66,453.15l29.91,30.62Z' transform='translate(-19 -203.79)'/>"+
                "<path d='M479.56,664.34H280V203.87H479.56ZM448,415.21l-29.84-30.55-38.26,37.95L342,384.83l-30.2,30.31,68.16,68.39Z' transform='translate(-19 -203.79)'/>"+
            "</svg>" +

        "</div>"
    );
}

$().ready(function(){
    
//Fin del ready
});