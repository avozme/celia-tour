function jump(id, destId, destPitch, destYaw){

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='hintspot' class='hots" + id + "'>"+
            "<svg  xmlns='http://www.w3.org/2000/svg' viewBox='0 0 250.1 127.22'><path d='M148.25,620.61l1.15-.79q61.83-39.57,123.65-79.15a1.71,1.71,0,0,1,2.2,0Q336,580.08,396.72,619.44l1.63,1.11a8,8,0,0,0-1.18.74l-46.73,45.15c-1.4,1.36-1.41,1.36-3,.15q-36.37-27.75-72.71-55.53a1.78,1.78,0,0,0-2.62,0q-37.26,28-74.56,55.86c-.85.64-1.37.72-2.2-.09q-23.1-22.68-46.24-45.32C148.84,621.25,148.58,621,148.25,620.61Z' transform='translate(-148.25 -540.26)' fill='white'/></svg>"+
        "</div>"
    );        

     //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){
        //MANTENIENDO EL PITCH/YAW DE LA ESCENA ANTERIOR AL SALTO
        //changeScene(destId, viewer.view().pitch(), viewer.view().yaw(), true);

        //OBTENIENDO EL PITCH/YAW DEL PROPIO SALTO
        changeScene(destId, destPitch, destYaw, true);
    });
}