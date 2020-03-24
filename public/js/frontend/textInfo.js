/*********************************************************
 * HOTSPOT DE TIPO TEXTO CON UN TITULO Y UNA DESCRIPCIÓN
 ********************************************************/

function textInfo(id, title, description){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='textInfo' class='hotspotElement hotsLowOpacity hots"+id+"'>"+
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