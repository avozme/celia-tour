var audioSelected = 0; // Para saber si se a seleccionado audio
var audioIdSelected = null; // Audio seleccionado.

$(function(){

    $('.expand > p').expander({
        slicePoint: 120,
        expandText: 'Ver más',
        collapseTimer: 0,
        userCollapseText: 'Ver menos'
    });

  // CIERRA LA MODAL
  function closeModal(){
    $("#modalWindow").css('display', 'none');
    $("#modalPistaAdd").css('display', 'none');
    $("#confirmDeletePista").css('display', 'none');
    $('#modalPistaUpdate').css('display', 'none');
    $('#modalAudioPistas').css('display', 'none');
}

    /**
     * Permite modificar el boton para abrir la modal de seleccion de recursos y controla el funcionamiento de los checkbox
     * 
     * modalParentId -> El ID de la modal donde se alojan los checkbox.
     * checkboxName -> El "name" de los checkbox de seleccion.
     * objectEvent -> Objeto que provoco el evento, habitualmente "this".
     */
    function typeResourceSelector(modalParentId, checkboxName, objectEvent){
        
        $(`#${modalParentId} #resourceButton > button`).unbind('click');
        $(`#${modalParentId} input[name="${checkboxName}"]`).prop('checked', false);
        $(objectEvent).prop('checked', true);
        var valor = $(objectEvent).val();

        switch(parseInt(valor)){
            case 0:
                $(`#${modalParentId} #resourceButton`).slideUp();
                break;
            case 1:
                $(`#${modalParentId} #resourceButton > button`).text("Añadir Imagen");
                $(`#${modalParentId} #resourceButton`).slideDown();
                // Da la funcionalidad al botton de añadir imagen
                $(`#${modalParentId} #resourceButton > button`).click(function(){
                    $(`#${modalParentId}`).slideUp(function(){
                        $('#modalAddImage').show();
                        $('#modalAddImage #slideModalAddImage').slideDown();
                    });
                });
                // Da la funcionalidad al botton de guardar imagen
                $(`#modalAddImage #aceptAddImage`).unbind('click');
                $(`#modalAddImage #aceptAddImage`).click(function(){
                    $('#modalAddImage').slideUp(function(){
                        $(`#${modalParentId}`).slideDown();
                    });
                })
                break;
            case 2:
                $(`#${modalParentId} #resourceButton > button`).text("Añadir Video");
                $(`#${modalParentId} #resourceButton`).slideDown();
                // Da la funcionalidad al botton de añadir video
                $(`#${modalParentId} #resourceButton > button`).click(function(){
                    openVideo(modalParentId);
                });
                // Da la funcionalidad al botton de guardar video
                $('#btn-acept-video').unbind('click');
                $('#btn-acept-video').click(function(){
                    $('#modalVideo').slideUp(function(){
                        $(`#${modalParentId}`).slideDown();
                    });
                })
        }

    }


//----------------------------- AUDIODESCRIPCION ----------------------------------
    
    function audio(){
        var audioId = $(this).attr('id');
        $('#modalAudioPistas #audio').val(audioId);

        var classStyle = 'resourceSelected';

        if(audioIdSelected != null){
            if($(this).attr('id') == audioIdSelected){
                $('#modalAudioPistas #audio').val('');
                $(this).removeClass(classStyle);
                audioIdSelected = null;
            } else {
                $('.elementResource').removeClass(classStyle);
                $(this).addClass(classStyle)
                audioIdSelected = $(this).attr('id');
            }
        } else {
            $('.elementResource').removeClass(classStyle);
            $(this).addClass(classStyle);
            audioIdSelected = $(this).attr('id');
        }
        
        audioSelected = $('#modalAudioPistas #audio').val();
    }

    // ABRE LA MODAL DE AUDIOS
    function openAudio(){
        if($('#modalAudioPistas').hasClass('edit')){
            $('#slideModalPistaUpdate').slideUp(function(){
                $('#modalPistaUpdate').hide();
                $('#modalAudioPistas').css('display', 'block');
                $('#slideModalAudioPistas').slideDown();
            });
        }else{
            $('#slideModalPistaAdd').slideUp(function(){
                $('#modalPistaAdd').hide();
                $('#modalAudioPistas').css('display', 'block');
                $('#slideModalAudioPistas').slideDown();
            });
        }
        
    }

    // ABRE LA MODAL DE VIDEOS
    function openVideo(modalCloseId){
        $(`#${modalCloseId}`).slideUp(function(){
            $('#modalVideo').show();
            $('#modalVideo #slideModalVideo').slideDown();
        });
    }

//----------------------------- INSERTAR ----------------------------------

    // ABRE INSERTAR PISTA
    $('#btn-addPista').click(function(){
        $('#modalAudioPistas').removeClass('edit');
        $('#modalWindow').css('display', 'block');
        $('#modalPistaAdd').css('display', 'block');

        // Se colocan los valores vacios
        $('#modalAudioPistas #audio').val('');
        $('input[name="resourceAddPista"]').prop('checked', false); // Todos los checkbox sin seleccionar
        $('input[name="resourceAddPista"][value="0"]').prop('checked', true); // Seleciona el checkbox 'ninguno' 
        $('#modalPistaAdd #resourceButton').hide(); // Oculta el boton de recursos
        clearResource(); // Quita los estilos de los recursos
        audioSelected = 0;
        audioIdSelected = null;

        // Corrige los estilos de los audios y videos
        $('#modalAudioPistas .elementResource').unbind("click");
        $('#modalAudioPistas .elementResource').click(audio);
        
        // Añade el evento de guardar a la modal de audios
        $('#btn-acept-audio-pistas').unbind("click");
        $('#btn-acept-audio-pistas').click(function(){
            if($('#modalAudioPistas').hasClass('edit')){
                $('#slideModalAudioPistas').slideUp(function(){
                    $('#modalAudioPistas').hide();
                    $('#modalPistaUpdate').show();
                    $('#slideModalPistaUpdate').slideDown();
                });
            }else{
                $('#slideModalAudioPistas').slideUp(function(){
                    $('#modalAudioPistas').hide();
                    $('#modalPistaAdd').css('display', 'block');
                    $('#slideModalPistaAdd').slideDown();
                });
            }
        });
        
    })


    // GUARDA EL FORMULARIO DE INSERTAR
    $('#modalPistaAdd #btn-save').click(function(){

        var form = '#formAddPista';

        dataForm = new FormData();
        dataForm.append('_token', $(`${form} input[name="_token"]`).val());
        dataForm.append('text', $(`#textoPista`).val());
        dataForm.append('show', $(`${form} input[name="show"]:checked`).val());
        dataForm.append('id_question', $(`${form} select[name="question"] option:checked`).val());
        dataForm.append('id_audio', $(`#modalAudioPistas #audio`).val());
        dataForm.append('type', $(`${form} input[name="resourceAddPista"]:checked`).val());
        dataForm.append('id_escaperoom', $('#idEscapeRoom').val());

        // Obtiene el recurso
        switch ($(`${form} input[name="resourceAddPista"]:checked`).val()) {
            case '0': // Sin recurso
                dataForm.append('id_resource', '0');
                break;
            case '1': // Imagenes
                dataForm.append('id_resource', resourceIdSelected);
                break;
            case '2': // Videos
                dataForm.append('id_resource', resourceIdSelected);
        }

        console.log("el valor de text es:"+ $(`#textoPista`).val());

        $.ajax({
            url: $(form).attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){

            var show = "null";
            if(data.clue.show == 1){
                show = "Si";
            } else {
                show = "No";
            }

            var question = "";
            if(data.question != null){
                question = data.question.text;
            }

            var audio = "";
            if(data.audio != null){
                audio = `<audio class="col100" src="${data.audio}" controls=""></audio>`;
            }

            var content = `  <div id="${data.clue.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                            <div class="col25 sPadding lMarginRight expand"><p>${data.clue.text}</p></div>
                            <div class="col25 sPadding expand"><p>${question}</p></div>
                            <div class="col25 sPadding">${audio}</div>
                            <div class="col10 sPadding"><button class="btn-update-pista col100">Editar</button></div>
                            <div class="col10 sPadding"><button class="btn-delete-pista delete col100">Eliminar</button></div>
                        </div>`

                            

            $(`#pistaContent`).append(content);
            $(".btn-update-pista").unbind('click');
            $(".btn-update-pista").click(edit);
            $(".btn-delete-pista").unbind('click');
            $(".btn-delete-pista").click(openDelete);
            closeModal();
            $('.elementResource').removeClass('resourceSelected');
            
        }).fail(function(data){
            console.log("el valor de text es:"+ $(`#textoPista`).val());
            alert('Ocurrio un error al guardar');
        })

    });

    //----------------------------- MODIFICAR ----------------------------------

    function edit(){

        $('#modalAudioPistas').addClass('edit');

        // Corrige los estilos de los audios, videos e imagenes
        $('#modalAudioPistas .elementResource').unbind("click");
        $('#modalAudioPistas .elementResource').click(audio);
        clearResource();


        // Añade el evento de guardar a la modal de audios
        $('#btn-acept-audio-pistas').unbind("click");
        $('#btn-acept-audio-pistas').click(function(){
            if($('#modalAudioPistas').hasClass('edit')){
                $('#slideModalAudioPistas').slideUp(function(){
                    $('#modalAudioPistas').hide();
                    $('#modalPistaUpdate').show();
                    $('#slideModalPistaUpdate').slideDown();
                });
            }else{
                $('#slideModalAudioPistas').slideUp(function(){
                    $('#modalAudioPistas').hide();
                    $('#modalPistaAdd').css('display', 'block');
                    $('#slideModalPistaAdd').slideDown();
                });
            }
        });

        // Obtiene el id de la pista donde se pulso el boton modificar.
        var id = $(this).parent().parent().attr('id');

        // Se crea la ruta para obtener los datos de la pregunta.
        var address = clueShow.replace('req_id', id);

        // Se hace una peticion para obtener los datos de la pregunta.
        $.get(address, function(data){

            var form = '#formUpdatePista';

            // Se rellenan los datos del formulario con la pregunta a editar
            $(`${form} #textareaedit`).val(data.clue.text); // Campo texto
            $(`${form} input[name="show"][value="${data.clue.show}"]`).prop('checked', true); // Campo show
            $(`${form} select[name="question"] option[value="${data.clue.id_question}"]`).prop('selected', true); // Campo question
            $('#modalAudioPistas #audio').val(data.clue.id_audio);
            $(`#modalAudioPistas #${data.clue.id_audio}`).addClass('resourceSelected')
            $(`${form} input[name="resourceUpdatePista"]`).prop('checked', false); // Todos los checkbox sin seleccionar
            $(`${form} input[name="resourceUpdatePista"][value="${data.clue.type}"]`).prop('checked', true); // Selecciona el checkbox 'ninguno' 
            typeResourceSelector('modalPistaUpdate', 'resourceAddPista', $(`${form} input[name="resourceUpdatePista"][value="${data.clue.type}"]`)); // Muestra el boton adecuado

            // Asigna el recurso por defecto en las modales de recursos
            switch (data.clue.type) {
                case 1:
                    setResource('modalAddImage', data.clue.id_resource);
                    break;
                case 2:
                    setResource('modalVideo', data.clue.id_resource);
                    break;
            }

            // Abre la modal
            $('#modalWindow').css('display', 'block');
            $('#modalPistaUpdate').css('display', 'block');

            // Asigna evento al boton de guardar
            $(`#modalPistaUpdate #btn-update`).unbind("click");
            $(`#modalPistaUpdate #btn-update`).click(function(){
                
                // Se obtiene la url del action y se asigna el id correspondiente.
                var addressUpdate = $(`#formUpdatePista`).attr("action")
                addressUpdate = addressUpdate.replace('req_id', id); 

                // Se obtienen los datos del formulario
                dataForm = new FormData();
                dataForm.append('_token', $(`${form} input[name="_token"]`).val());
                dataForm.append('text', $(`${form} #editor`).val());
                dataForm.append('show', $(`${form} input[name="show"]:checked`).val());
                dataForm.append('id_question', $(`${form} select[name="question"] option:selected`).val());
                dataForm.append('id_audio', $(`#modalAudioPistas #audio`).val());
                dataForm.append('type', $(`${form} input[name="resourceUpdatePista"]:checked`).val());

                // Obtiene el recurso
                switch ($(`${form} input[name="resourceUpdatePista"]:checked`).val()) {
                    case '0': // Sin recurso
                        dataForm.append('id_resource', '0');
                        break;
                    case '1': // Imagenes
                        dataForm.append('id_resource', resourceIdSelected);
                        break;
                    case '2': // Videos
                        dataForm.append('id_resource', resourceIdSelected);

                }
            
                // Se hace una peticion para actualizar los datos en el servidor
                $.ajax({
                    url: addressUpdate,
                    type: 'POST',
                    data: dataForm,
                    contentType: false,
                    processData: false,
                }).done(function(data){
                    // Actualiza la fila correspondiente en la tabla
                    var elementUpdate = $(`#pistaContent #${data.clue.id}`).children();

                    // Campo text
                    var text = $(elementUpdate)[0];
                    $(text).text(data.clue.text);

                    // Campo question
                    var question = $(elementUpdate)[1];
                    if(data.question != null){
                        $(question).text(data.question.text);
                    }

                    // Campo audio
                    var audio = $(elementUpdate)[2];
                    $(audio).empty();
                    if(data.audio != null) {
                        var routeAudio = `<audio class="col100" src="${data.audio}" controls=""></audio>`;
                        $(audio).html(routeAudio);
                    }

                    closeModal();
                    $('.elementResource').removeClass('resourceSelected');
                }).fail(function(data){
                    alert("Ocurrio un error al guardar");
                })
            });

        }).fail(function(data){
            alert("No se a podido recuperar la información de esta pista.")
        });

    }




    //----------------------------- ELIMINAR ----------------------------------

    // ABRE LA MODAL DE ELIMINAR
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDeletePista').css('display', 'block');
        var id = $(this).parent().parent().attr("id");
        $('#confirmDeletePista #aceptDelete').unbind('click');
        $('#confirmDeletePista #aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
        $('#confirmDeletePista #cancelDelete').unbind('click');
        $('#confirmDeletePista #cancelDelete').click(closeModal);
    }

    // ELIMINA UNA ESCENA
    function remove(id){
        var address = clueDelete.replace('req_id', id);
        $.get(address, function(data){
            if(data == 1){
                $(`#pistaContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pista")
            }
        })
    }



    // EVENTOS INICIALES
    $(".btn-update-pista").click(edit);
    $(".btn-delete-pista").click(openDelete);
    $('.btn-audio-pistas').click(openAudio);
    $('input[name="resourceAddPista"]').click(function(){
        typeResourceSelector("modalPistaAdd", "resourceAddPista", this);
    });
    $('input[name="resourceUpdatePista"]').click(function(){
        typeResourceSelector("modalPistaUpdate", "resourceUpdatePista", this);
    });

});