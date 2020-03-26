/********************************************************
 *               HOTSPOT DE TIPO VIDEO                  *
 ********************************************************/
//IdType corresponde al id del recurso de asociado a traves de la tabla intermedia
function video(id, src){
    var open=false;

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='video' class='hots"+id+" hotspotElement hotsLowOpacity'>"+
            "<div class='icon_wrapper'>"+
                "<div class='icon'>"+
                    "<div id='inner_icon' class='inner_icon'>"+
                        "<svg id='videoIcon' enable-background='new 0 0 494.942 494.942' viewBox='0 0 494.942 494.942' xmlns='http://www.w3.org/2000/svg'><path d='m35.353 0 424.236 247.471-424.236 247.471z'/></svg>"+
                        "<svg style='display:none;' id='closeIcon' enable-background='new 0 0 386.667 386.667' viewBox='0 0 386.667 386.667'  xmlns='http://www.w3.org/2000/svg'><path d='m386.667 45.564-45.564-45.564-147.77 147.769-147.769-147.769-45.564 45.564 147.769 147.769-147.769 147.77 45.564 45.564 147.769-147.769 147.769 147.769 45.564-45.564-147.768-147.77z'/></svg>"+
                    "</div>"+
                "</div>"+
            "</div>"+
        "</div>"+

        "<div id='contentVideo"+id+"' class='contentVideo l6 hidden centerVH'>"+
            "<svg id='closeButton' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 28 28'>"+
                "<polygon points='28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28'/>"+
            "</svg>"+
            "<div class='aspectRatioVideo'>"+
                "<iframe src='https://player.vimeo.com/video/"+src+"' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
            "</div>"+
        "</div>"
    );            

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){  
        //Apertura de hotspot
        if(open==false){
            //$(".hots"+id).removeClass('expanded');
            //$(".hots"+id+" #inner_icon").removeClass('closeIcon');
            open=true;
            $("#contentVideo"+id).show();

            //Cerrrar los audios abiertos
            $(".hostAudio").removeClass('expanded');
            $(".contentAudio").hide();
            $('audio').each(function(){
                this.pause(); // Stop playing
                this.currentTime = 0; // Reset time
            });
    
        }
    });

    //ACCIONES PARA CERRAR LA VENTANA MODAL
    $("#closeButton, .contentVideo").on("click", function(){
        if(open==true){
            open=false;
            $("#contentVideo"+id).hide();

            //Detener video
            var url =  $("#contentVideo"+id+" iframe").attr('src');
            $("#contentVideo"+id+" iframe").attr('src','');
            $("#contentVideo"+id+" iframe").attr('src',url);
        }
    });


}