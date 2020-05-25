
function loadHide(idHotspot){
    $('#contentHotSpot').append(
        "<div id='iframespot' class='hots"+ idHotspot +" hotspotElement hideElement'>"+
            "<div style='border: 2px solid black; position: absolute' class='message hideHotspot' value='"+ idHotspot +"'></div>" + 
        "</div>"
    );

    //Obtener informacion del hotspot hide
    getHideInfo(idHotspot).done(function(result){
        var hide = result['hide'];
        //Comprobar si el hide corresponde al juego seleccionado

        if(hide.id_escaperoom == idGameSelect){
            width = hide['width'];
            height = hide['height'];
            $('.hots' + idHotspot).css('width', width);
            $('.hots' + idHotspot).css('height', height);
            loadContentHide(hide.id, hide.type);
        }else{
            //Eliminar el hotspot previamente creado
            $('.hots' + idHotspot).remove();
        }
    });

    /**
     * METODO PARA CARAGAR EL CONTENIDO DEL HIDE AL HACER CLICK EN EL
     */
    function loadContentHide(idHide, typeHide){
        //Comprobar si el contenido es una pregunta o una pista
        if(typeHide==1){
            //PREGUNTA

            for(var i=0;i<questions.length;i++){
                //Buscar la pregunta asociada
                if(idHide == questions[i].id_hide){
                    var index = i;
                    questions[index].show = true; //Valor inicial por defecto
                    $('.hots' + idHotspot).on('click', function(){
                        //Cargar la pregunta en ventana modal si esta visible
                        if(questions[index].show){
                            loadQuestion(questions[index]);
                        }
                    });
                }
            }

        }else{
            //PISTA

            //Buscar la pista asocida siempre que esta este visible
            for(var i=0; i<clues.length;i++){
                if(idHide == clues[i].id_hide){
                    var index = i;
                    $('.hots' + idHotspot).on('click', function(){
                        //Mostrar la pista si está visible
                        if(clues[index].show){
                            showClue(clues[index]);
                        }
                    });
                }
            }

        }
    }
   
}