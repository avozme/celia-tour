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
        <svg id="iconClue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 511.84">
            <defs><style>.cls-1{fill:#ffc200;}</style></defs>
            <path class="cls-1" d="M18.59,260.05,73,234.67l12.69,27.18L31.28,287.23Z" transform="translate(0 -0.08)"/><path class="cls-1" d="M426.31,69.84l54.36-25.38,12.69,27.18L439,97Z" transform="translate(0 -0.08)"/>
            <path class="cls-1" d="M18.55,71.77,31.24,44.59,85.6,70,72.91,97.15Z" transform="translate(0 -0.08)"/><path class="cls-1" d="M426.49,262.15,439.18,235l54.36,25.38-12.69,27.18Z" transform="translate(0 -0.08)"/>
            <path class="cls-1" d="M0,150.92H61v30H0Z" transform="translate(0 -0.08)"/><path class="cls-1" d="M452,150.92h60v30H452Z" transform="translate(0 -0.08)"/><path class="cls-1" d="M360.08,37.88C321.36,6.37,270.56-6.82,220.81,3.57c-64.1,13.3-115.12,66.8-127,131.62-8.1,44.21,1.49,88.49,27,124.72a460.36,460.36,0,0,1,53.52,101H337.65a460.86,460.86,0,0,1,53.52-101,162.42,162.42,0,0,0,29.83-94A164.47,164.47,0,0,0,360.08,37.88ZM241,270.92H211V172.13l-25.6-25.6,21.21-21.21L241,159.71Zm60-98.79v98.79H271V159.71l34.39-34.39,21.22,21.21Z" transform="translate(0 -0.08)"/>
            <path d="M181,481.92h15a15,15,0,0,1,15,15v15h90v-15a15,15,0,0,1,15-15h15v-91H181Z" transform="translate(0 -0.08)"/>
        </svg>
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
            console.log(question);
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
            $('#inAnsw').keyup(function (e){
                if(e.keyCode == 13){
                    sendQuestion();
                }
            });
            $("#sendAnswer").off();
            $("#sendAnswer").on("click", function(){
               sendQuestion();
            });

            //Metodo para comprobar la propia respuesta
            function sendQuestion(){
                 //Comprobar si la respuesta es correcta
                 if($("#inAnsw").val().toLowerCase() == question.answer.toLowerCase()){
                    actionWhenResolving(question)
                }else{
                    $("#errorQuest").text("Respuesta incorrecta :(");
                }
            }

            //Mostar ventana
            $('#modalWindow').show();
            $('.window').hide();
            $("#modalQuest").show();
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
        $("#inAnsw").on("change paste keyup", function() {
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
</script>