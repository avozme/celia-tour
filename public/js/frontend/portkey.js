function portkey(id, idType){
    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div class='hotspotElement hotsLowOpacity portkey hots"+ id +"' value='"+ id +"'style='display:none'>"+
            "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 460.56 460.56' fill='white'>"+
                "<path d='M218.82,664.34H19V203.79H218.82ZM119.15,445.49l37.7,38.2,30.34-30.44q-34.08-34.17-68.34-68.52L50.66,453.15l29.91,30.62Z' transform='translate(-19 -203.79)'/>"+
                "<path d='M479.56,664.34H280V203.87H479.56ZM448,415.21l-29.84-30.55-38.26,37.95L342,384.83l-30.2,30.31,68.16,68.39Z' transform='translate(-19 -203.79)'/>"+
            "</svg>" +

        "</div>"
    );

    //Apertura de hotspot (Mostrando contenido)
    $('.hots' + id).click(function(){    
        if($(".hots"+id).hasClass("expanded")){
            $(".hots"+id).removeClass('expanded');
        }else{
            $(".hots"+id).addClass('expanded');
        }
    });

    //Recuperar todas las escenas del ascensor
    var route = getScenesPortkey.replace('id', idType);
    return $.ajax({
        url: route,
        type: 'post',
        data: {
            '_token': token
        },
        success: function(data) {

            if(data.image == null){
                data = data.sceneRelated;

                //Ordenar ascensor por orden de planta
                data = data.sort(function(a, b) {
                    var x = a.pos, y = b.pos;
                    return x > y ? -1 : x < y ? 1 : 0;
                });

                var elementChild = "<div class='contentPortkey'>";
                //Crear cada una de las plantas en el ascensor
                for(var i=0; i<data.length; i++){
                    elementChild += 
                            "<div id='sf"+data[i].id+"' class='floor'>"+
                                "<span>"+data[i].zone+"</span>"+
                            "</div>";
                }
                elementChild += "</div>";
                $(".hots"+id).append(elementChild);

                //Cambiar a la escena correspondiente al pulsar sobre una planta
                $(".floor").click(function(){
                    var idPulse = $(this).attr("id");
                    idPulse = idPulse.replace("sf", "");
                    for(var j=0; j<data.length; j++){
                        if(data[j].id==idPulse){
                            changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                        }
                    }
                });

                $("hots"+ id).show();
            } else {

                // Crea los div que contiene las escenas   
                var content = `
                <div class='contentPortkeyMap contentPortkey'>
                    <div id="zoneMap">
                        <div id="scenes" class="col100 relative">
                `

                // Crea las escenas
                for(var i = 0; i<data.portkeyScene.length; i++){
                    var scene = data.portkeyScene[i];
                    content += `
                        <div class="icon" style="top: ${scene.top}%; left: ${scene.left}%">
                            <img id="scene${scene.id}" class="scenepoint" src="${ScenePointUrl}" alt="icon" width="100%" >
                        </div>
                    `;
                }
                
                // A??ade la imagen de fondo y cierra los div que contienen las escenas, ademas se a??ade el contenido al hotspot correspondiente
                content += `
                        <img width="100%" src="${urlImagesPortkey}/${data.image}" alt="">
                        </div>
                    </div>
                </div>
                `
                $(".hots"+id).append(content);


                //Cambiar a la escena correspondiente al pulsar un punto
                $("#zoneMap .scenepoint").click(function(){
                    var idPulse = $(this).attr("id");
                    idPulse = idPulse.replace("scene", "");
                    for(var j=0; j<data.portkeyScene.length; j++){
                        if(data.portkeyScene[j].id==idPulse){
                            changeScene(data.portkeyScene[j].scene_id, data.scenesRelated[j].pitch, data.scenesRelated[j].yaw, false);
                        }
                    }
                });
            }
        }
    });
}