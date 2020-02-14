function jump(id, destId, destPitch, destYaw){

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='hintspot' class='hots" + id + " hint--right hint--info hint--bounce' data-hint='hint.css!'>"+
                "<img src='../../img/icons/jump.png' >" +
            "</a>" +
        "</div>"
    );        

     //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        changeScene(destId);
    });
}