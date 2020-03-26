/********************************************************
 *               HOTSPOT DE TIPO AUDIO                  *
 ********************************************************/
function audio(id, src){

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='audio' class='hots"+id+" hostAudio hotspotElement hotsLowOpacity'>"+
            "<div class='icon_wrapper'>"+
                "<div class='icon'>"+
                    "<div id='inner_icon' class='inner_icon'>"+
                        "<svg version='1.1' id='audioIcon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 384 384' style='enable-background:new 0 0 384 384;' xml:space='preserve'>"+
                            "<g>"+
                                "<path d='M288,192c0-37.653-21.76-70.187-53.333-85.867v171.84C266.24,262.187,288,229.653,288,192z'/>"+
                                "<polygon points='0,128 0,256 85.333,256 192,362.667 192,21.333 85.333,128'/>"+
                                "<path d='M234.667,4.907V48.96C296.32,67.307,341.333,124.373,341.333,192S296.32,316.693,234.667,335.04v44.053C320.107,359.68,384,283.413,384,192S320.107,24.32,234.667,4.907z'/>"+
                            "</g>"+
                        "</svg>"+
                        "<svg style='display:none;' id='closeIcon' enable-background='new 0 0 386.667 386.667' viewBox='0 0 386.667 386.667'>"+
                            "<path d='m386.667 45.564-45.564-45.564-147.77 147.769-147.769-147.769-45.564 45.564 147.769 147.769-147.769 147.77 45.564 45.564 147.769-147.769 147.769 147.769 45.564-45.564-147.768-147.77z'/>"+
                        "</svg>"+
                    "</div>"+
                "</div>"+
            "</div>"+
        "</div>"+

        "<div id='contentAudio"+id+"' class='contentAudio l6 hidden centerVH'>"+
            `<div id="controlVisit" class="l6 absolute">
                <div id="actionVisit" class="col10 centerVH">
                    <svg id="play" class="col30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                        <path d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)" fill="#000"/>
                    </svg>
                    <svg id="pause" class="col33" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display: none">
                        <path d="M25.5,357h102V0h-102V357z M229.5,0v357h102V0H229.5z" fill="#000"/>
                    </svg>
                </div>

                <div class="col85 centerVH">
                    <progress class="col100" min="0" value="0"></progress>
                </div>

                <audio id="audioElement" preload="metadata" src='`+indexUrl+"/"+src+`' class="col70"></audio>
            </div>`+
        "</div>"
    );            
    audioControl();
    //----------------------------------------------------------------------

    //ACCIONES AL HACER CLIC EN EL 
    $(".hots"+id).click(function(){        
        if($(".hots"+id).hasClass("expanded")){
            //Cerrar hotspots
            stopAudios();
        }else{
            //Abrir hotspot pulsado
            stopAudios();
            $(".hots"+id).addClass('expanded');
            $("#contentAudio"+id).show();
            $("#contentAudio"+id+" audio")[0].play()
        }        
    });  

    //----------------------------------------------------------------------
    
    /**
     * METODO PARA DETENER TODOS LOS AUDIOS
     */
    function stopAudios(){
        $(".hostAudio").removeClass('expanded');
        $(".contentAudio").hide();
         $('audio').each(function(){
            this.pause(); // Stop playing
            this.currentTime = 0; // Reset time
        });
    }

    //--------------------------------------------------------------------------

    /*
    * METODO PARA CONTROLAR EL AUDIO CON LOS CONTROLES PERSONALIZADOS
    */
   function audioControl(){
        var player = document.querySelector("#contentAudio"+id+" audio");
        var progressBar = document.querySelector("#contentAudio"+id+" progress");

        //Cambiar tiempo audio con la barra
        progressBar.addEventListener("click", seek);
        function seek(e) {
            var percent = e.offsetX / this.offsetWidth;
            player.currentTime = percent * player.duration;
            progressBar.value = percent * player.duration;
        }
        //Actualizar barra de audio
        player.addEventListener("timeupdate", updateBar);
        function updateBar() {
            progressBar.value = player.currentTime;
        }
        //Pausar y reanudar audio
        $("#actionVisit").on("click", function(){
            if( $("#pause").css('display') == 'none' ){
                $("#pause").show();
                $("#play").hide();
                document.querySelector("audio").play();
            }else{
                $("#pause").hide();
                $("#play").show();
                document.querySelector("audio").pause();
            }
        });
    }
}