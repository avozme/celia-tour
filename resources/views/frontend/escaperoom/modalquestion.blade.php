{{-- VENTANA MODAL PARA MOSTRAR PISTAS --}}
<div id="modalQuest" class="window" style="display: none">
    <div class="col100">
        <button class="closeModal closeModalWindowButton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                    <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                </svg>
        </button>
    </div>
    <div class="col100 centerV">
        <span class="titleModal sMarginLeft">Un enigma</span>
    </div>

    <div id="resourceQuest" class="resourceClueQuest col100 relative mMarginTop">
        <!-- RECURSO ASOCIADO A LA PISTA -->
    </div>

    <div id="contentQuest" class="col100 lMarginTop">
        <div id="txtQuest" class="col100 mMarginBottom"></div>
        <div id="errorQuest" class="col100 centerT"></div>
        <div class="col100 mMarginTop centerH">
            <div class="width70">
            <input id="inAnsw" type="text" class="inputCustom100 inputCustom" placeholder="Respuesta">
            <button id="sendAnswer" disabled class="sMarginTop buttonCustom100 buttonCustom">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    /**
     * METODO PARA MOSTRAR UNA VENTANA CON UNA PREGUNTA EN FUNCION DE SU TIPO
     */
    function loadQuestion(question){     
        //Previamente comprobar si la pregunta ha sido resuelta y se debe mostrar una pista asociada
        if(question.redirectToClue){
            openClueAssociated(question.id);

        //Si no mostramos la propia pregunta
        }else{
            //Establecer enunciado
            $("#txtQuest").text(question.text);
            $("#inAnsw").val("");
            $("#errorQuest").text("");

            $("#resourceQuest").empty();
            $("#resourceQuest").hide();

            //Establecer imagen o video a la pregunta
            switch(question.type){
                case 1:
                    //Pregunta con imagen
                    var element = `
                    <span></span>
                    <img src="`+indexUrl+"/"+resourcesRoutes[question.id_resource]+`"/>
                    `;
                    $("#resourceQuest").append(element);
                    $("#resourceQuest").show();
                    break;
                case 2:
                    //Pregunta con video
                    var element = `
                    <span></span>
                    <iframe src='https://player.vimeo.com/video/`+resourcesRoutes[question.id_resource]+`' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>
                    `;
                    $("#resourceQuest").append(element);
                    $("#resourceQuest").show();
                    break;
            }

            //Reproducir audio si está asociado y activo el sonido
            if(question.id_audio!=null && enabledSoundEscape){
                //Buscar el recurso de audio
                for(var i=0; i<audios.length; i++){
                    if(question.id_audio == audios[i].id){   
                        console.log("aqui");
                        $("#narrationSound").attr("src", indexUrl+"/"+audios[i].route);
                        document.getElementById('narrationSound').play();
                    }
                }
            }
            
            //Accion de enviar la respuesta boton o enter
            $("#inAnsw").unbind("keyup");
            $('#inAnsw').keyup(function (e){
                if(e.keyCode == 13){
                    sendQuestion(question);
                }
            });
            $("#sendAnswer").off();
            $("#sendAnswer").on("click", function(){
               sendQuestion(question);
            });

            //Mostar ventana
            $('#modalWindow').show();
            $('.window').hide();
            $("#modalQuest").show();
        }
    }

    //------------------------------------------------------------------------------------

    //Metodo para comprobar la propia respuesta
    function sendQuestion(question){
        
        //Comprobar si la respuesta es correcta
        if( normalize($("#inAnsw").val().toLowerCase()) ==  normalize(question.answer.toLowerCase())){
            actionWhenResolving(question);
        }else{
            $("#errorQuest").text("Respuesta incorrecta :(");
        }
    }

    //--------------------------------------------------------------------------

    /**
     * METODO  PARA APLICAR ACCIONES CORRESPONDIENTES AL RESOLVER CORRECTAMENTE UNA PREGUNTA
     */
    function actionWhenResolving(question){
        //Ocultar ventana modal de la pregunta
        $('#modalWindow').hide();
        $('.window').hide();   
        //Detener narración
        document.getElementById('narrationSound').pause();
        document.getElementById('narrationSound').currentTime = 0; // Resetear tiempo
        //Desactivar visualización de la pregunta
        question.show = 0;

        //Obtener pistas asociadas a la pregunta
        var gotClue = false;
        for(var i=0;i<clues.length;i++){
            if(clues[i].id_question == question.id){
                gotClue=true;
                question.redirectToClue = true; //Indicar que la pregunta pasa a ser una pista
                question.show = 1; //Reactivar la visualización para ver la pista
            }
        }
        
        //Comprobar si la pregunta abre una habitacion
        openRoom=false;
        for(var i=0;i<keys.length;i++){
            if(question.id == keys[i].id_question){
                openRoom=true;
            }
        }
        
        //Comprobar que acción ejecutar al resolver la pregunta
        if(openRoom){
            //ABRIR HABITACION

            //Incrementar contador de llaves abiertas
            keysOpen++;
            console.log("sf");

            //Buscar llave para abrir habitacion
            for(var i=0;i<keys.length;i++){
                if(question.id == keys[i].id_question){
                    //Desbloquear habitacion enviando el id de la pista que se tiene que mostrar tras resolver la pregunta
                    unlockPoints(keys[i].id, gotClue?question.id:-1);
                }
            }
        }else{
            //MOSTRAR PISTA
            openClueAssociated(question.id)
        }
    }

    //------------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR UNA PISTA ASOCIADA A LA RESOLUCION DE UNA PREGUNTA
     */
    function openClueAssociated(idQuest){
        //Buscar pista asociada y mostrar ventana
        for(var i=0;i<clues.length;i++){
            if(clues[i].id_question==idQuest){
                showClue(clues[i]);
            }
        }
    }

    //------------------------------------------------------------------------------------------

    $(document).ready(function() {
        /**
         * FUNCIONALIDAD DEL BOTON CONTINUAR
         */
        $("#bContinueClue").on("click", function(){
            $('#modalWindow').hide();
            $('.window').hide();      
            //Detener narración
            document.getElementById('narrationSound').pause();
            document.getElementById('narrationSound').currentTime = 0; // Resetear tiempo
        });

        ////// Poner a la escucha el cuadro de texto para activar el boton de enviar si hay contenido
        $("#inAnsw").on('input', function() {
            if($("#inAnsw").val()==""){
                //Desactivar el boton
                $("#sendAnswer").prop('disabled', true);
            }else{
                //Activar el boton
                $("#sendAnswer").prop('disabled', false);
            }

            //Quitar contenido del error
            $("#errorQuest").text("");
        });
    });

    //--------------------------------------------------------------------------------------

    /**
    * METODO PARA QUITAR LOS SIGNOS DE ACENTUACION DE UNA PALABRA
    */
    var normalize = (function() {
        var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÇç", 
            to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuucc",
            mapping = {};
        
        for(var i = 0, j = from.length; i < j; i++ )
            mapping[ from.charAt( i ) ] = to.charAt( i );
        
        return function( str ) {
            var ret = [];
            for( var i = 0, j = str.length; i < j; i++ ) {
                var c = str.charAt( i );
                if( mapping.hasOwnProperty( str.charAt( i ) ) )
                    ret.push( mapping[ c ] );
                else
                    ret.push( c );
            }      
            return ret.join( '' );
        }
    })();
</script>