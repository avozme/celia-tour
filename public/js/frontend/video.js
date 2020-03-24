/********************************************************
 *               HOTSPOT DE TIPO VIDEO                  *
 ********************************************************/
//IdType corresponde al id del recurso de asociado a traves de la tabla intermedia
function video(id, src){

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
        "<div class='content'>"+
            "<iframe src='https://player.vimeo.com/video/"+src+"' width='640' height='360' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>"+
        "</div>"+
        "</div>"
    );            

    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){  
        //Apertura de hotspot
        if($(".hots"+id).hasClass("expanded")){
            $(".hots"+id).removeClass('expanded');
            $(".hots"+id+" #inner_icon").removeClass('closeIcon');
        }else{
            $(".hots"+id).addClass('expanded');
            $(".hots"+id+" #inner_icon").addClass('closeIcon');
        }
    });
}