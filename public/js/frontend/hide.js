
function loadHide(idHotspot, typeHide, idClueQuest){
    $('#contentHotSpot').append(
        "<div id='iframespot' class='hots"+ idHotspot +" hotspotElement hideElement'>"+
            "<div style='border: 2px solid black; position: absolute' class='message hideHotspot' value='"+ idHotspot +"'></div>" + 
        "</div>"
    );
    getHideInfo(idHotspot).done(function(result){
        var hide = result['hide'];
        console.log(hide);
        width = hide['width'];
        height = hide['height'];
        $('.hots' + idHotspot).css('width', width);
        $('.hots' + idHotspot).css('height', height);
    });

    /**
     * COMPROBAR SI EL HIDE MUESTRA UNA PISTA O UNA PREGUNTA
     */
    if(typeHide==0){
        //PREGUNTA
    }else{
        //PISTA
        for(var i=0;i<clues.length;i++){
            //Si esta visible lo aplicamos la accion de click
            if(clues[i].id==idClueQuest && clues[i].show){
                var textClue = clues[i].text;
                $('.hots' + idHotspot).on('click', function(){
                    //Obtener el texto del la pista
                    showClue(textClue);
                });
            }
        }
    }

}