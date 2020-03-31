/********************************************************
 *               HOTSPOT DE TIPO AUDIO                  *
 ********************************************************/
function audio(id, src, idResource){

    var barControl = 
        `<div id="controlVisit" class="l6 absolute">
            <div id="actionVisit" class="col10 centerVH">
                <svg id="play" class="col30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.429 18">
                    <path d="M35.353,0,50.782,9,35.353,18Z" transform="translate(-35.353)" fill="#000"/>
                </svg>
                <svg id="pause" class="col33" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display: none">
                    <path d="M25.5,357h102V0h-102V357z M229.5,0v357h102V0H229.5z" fill="#000"/>
                </svg>
            </div>`;

    //En funcion de la existencia de subtitulos mostramos icono o no
    if(!subt.hasOwnProperty(idResource)){
        barControl+=
            `<div class="col85 centerVH">
                <progress class="col100" min="0" max="0" value="0"></progress>
            </div>

            <audio id="audioElement" preload="metadata" src='`+indexUrl+"/"+src+`' class="col70"></audio>
        </div>`;
    }else{
        barControl+=
            `<div class="col80 centerVH">
                <progress class="col100" min="0" max="0" value="0"></progress>
            </div>
            <div id="subtitleButton`+id+`" class="subtitleButton col10 centerVH">
                <svg class="col38" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 426.667 426.667">
                    <path d="M384,0H42.667C19.093,0,0.213,19.093,0.213,42.667L0,426.667l85.333-85.333H384c23.573,0,42.667-19.093,42.667-42.667
                        v-256C426.667,19.093,407.573,0,384,0z M149.333,192h-42.667v-42.667h42.667V192z M234.667,192H192v-42.667h42.667V192z M320,192
                        h-42.667v-42.667H320V192z"/>
                </svg>
            </div>
            <audio id="audioElement" preload="metadata" src='`+indexUrl+"/"+src+`' class="audio`+id+` col70"></audio>
        </div>

        <div id="listSubt`+id+`" class="listSubt col10 l6 absolute" style="display:none">
            <div id="subtTitle" class="col100 sPaddingTop centerT"><strong>Subtitulos</strong></div>
        </div>

        <div id="subtText`+id+`" class="subtText"> 

        </div>
        `;

        //Lamada al metodo crear listado de subtitulos
        loadSubt();
    }

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
            barControl+
        "</div>"
    );        

    //Aplicar funcionalidad al control    
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

            $("#contentAudio"+id+" #pause").show();
            $("#contentAudio"+id+" #play").hide();
            document.querySelector("#contentAudio"+id+" audio").play();
        }        
    });  

    //----------------------------------------------------------------------
    
    //Boton opcion subtitulos
    $("#subtitleButton"+id).on("click", function(){
        console.log("p");
        if($("#listSubt"+id).is(":visible")){
            $("#listSubt"+id).hide();
            console.log("ocultar "+ id);
        }else{
            $("#listSubt"+id).show();
            console.log("mostrar "+ id);
        }
    });

    //----------------------------------------------------------------------

    /**
     * METODO PARA CARGAR LOS SUBTITULOS DE UNA PISTA DE AUDIO
     */
    function loadSubt(){
        $( document ).ready(function() {
            //Recorrer el array para insertar los subtitulos
            for(var i =0; i<subt[idResource].length; i++){
                //Agregar track al elemento de audio
                var track =`<track kind="subtitles" src="`+indexSubt+"/"+subt[idResource][i]+`" srclang="`+subt[idResource][i]+`" />`;
                $(".audio"+id).append(track);

                //Agregar elemento al listado de subtitulos visual
                var name = subt[idResource][i].split(".");
                $('#listSubt'+id).append(
                    `<div id="`+subt[idResource][i]+`" class="subtOption pointer col100">
                        <svg fill="white" width="10px" style="display:none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 342.357 342.357">
                            <polygon points="290.04,33.286 118.861,204.427 52.32,137.907 0,190.226 118.862,309.071 342.357,85.606 "/>
                        </svg>
                        `+name[name.length-2]+`
                    </div>`
                );
    
            }
            //Agregar opcion de desactivar
            $("#listSubt"+id).append(
                `<div id="subtDis`+id+`" class="col100 pointer">Desactivar</div>`
            );

            ////////////////

            //Accion al pulsar sobre un subtitulo
            $(".subtOption").on("click", function(){
                var audioElement = document.getElementsByClassName('audio'+id)[0];
                document.getElementById('subtText'+id).innerText=""; //Limpiar contenido
                //Marcar la opcion seleccionada
                $(".subtOption").removeClass("activeSubtOption");
                $(".subtOption svg").hide();
                $(this).addClass("activeSubtOption");
                $(this).children().show();
                
                //Recorrer todas las pistas de audio
                for (var i = 0; i < audioElement.textTracks.length; i++) {
                    //Por defecto desactivar el subtitulo y su evento
                    audioElement.textTracks[i].mode = 'disabled';
                    audioElement.textTracks[i].removeEventListener('cuechange', this, false);

                    //Si coincide con el subtitulo pulsado se activará
                    if($(this).attr("id")==audioElement.textTracks[i].language){
                        //Activar el subtitulo
                        audioElement.textTracks[i].mode = 'showing';
                        //Mostrar contenido
                        audioElement.textTracks[i].addEventListener('cuechange', function() {
                            if(this.activeCues[0]!=null){
                                document.getElementById('subtText'+id).innerText = this.activeCues[0].text;
                            }else{
                                document.getElementById('subtText'+id).innerText="";
                            }
                        });
                    }
                }  
                //Ocultar panel de subtitulos
                setTimeout(function(){
                    $("#listSubt"+id).hide();
                }, 500); 
            });

            ////////////////

            //Accion al pulsar sobre desactivar subtitulos
            $("#subtDis"+id).on("click", function(){
                var audioElement = document.getElementsByClassName('audio'+id)[0];
                $(".subtOption").removeClass("activeSubtOption");
                $(".subtOption svg").hide();

                for (var i = 0; i < audioElement.textTracks.length; i++) {
                    //Desactivar el subtitulo y su evento
                    audioElement.textTracks[i].mode = 'disabled';
                    audioElement.textTracks[i].removeEventListener('cuechange', this, false);
                }  
                document.getElementById('subtText'+id).innerText="";

                //Ocultar panel de subtitulos
                setTimeout(function(){
                    $("#listSubt"+id).hide();
                }, 500); 
            });
        });
    }    

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
        player.onloadedmetadata = function() {
            progressBar.setAttribute("max", player.duration);
        };
        player.addEventListener("timeupdate", updateBar);
        function updateBar() {
            progressBar.value = player.currentTime;
        }
        //Pausar y reanudar audio
        $("#contentAudio"+id+" #actionVisit").on("click", function(){
            if( $("#contentAudio"+id+" #pause").css('display') == 'none' ){
                $("#contentAudio"+id+" #pause").show();
                $("#contentAudio"+id+" #play").hide();
                document.querySelector("#contentAudio"+id+" audio").play();
            }else{
                $("#contentAudio"+id+" #pause").hide();
                $("#contentAudio"+id+" #play").show();
                document.querySelector("#contentAudio"+id+" audio").pause();
            }
        });
    }
}