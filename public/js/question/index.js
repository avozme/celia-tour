var audioSelected = 0; // Para saber si se a seleccionado audio
var audioIdSelected = null; // Audio seleccionado.

function updateAudio(idAudio){
    $.ajax({
        url: getResource.replace('req_id', idAudio),
        type: 'GET',
    }).done(function(result){
        $('#audioIfExist').empty();
        $('#audioIfExist').append(
                "<input type='hidden' id='actualAudio' value='" + result['resource'].id + "'>" + 
                "<p class='col30'>" + result['resource'].title + "</p>" +
                "<audio src='"+ resourcesRoute.replace('audio', result['resource'].route) +"' controls class='col70'></audio>"
        );
        $('#updateResourceValue').val(result['resource'].id);
    });
}

$(function(){
    // CIERRA LA MODAL
    function closeModal(){
        $('.window, .slide').hide();
        $("#modalWindow").css('display', 'none');
        $('.elementResource').removeClass('resourceSelected');
        //Reestablecemos el aspecto de la ventana modal de nueva pregunta
        $('input[name="recurso"]').prop('checked', false);
        $('input[name="recurso"][value="0"]').prop('checked', true);
        $('#resourceButton').hide();
        //Vaciamos la modal de multimedia
        $('.resourceMultimedia, .audioMultimedia').empty();
    }

    //----------------------------- INSERTAR ----------------------------------
    
    // ABRE INSERTAR QUESTION
    $('#btn-add').click(function(){
        $('#saveAudio').removeClass('edit');
        $('#newQuestionAudio').empty();
        $('#modalQuestionAdd').css('display', 'block');
        $('#modalWindow').css('display', 'block');

        // Se colocan los valores vacios
        $('#formAdd #resourceValue').val('');
        audioSelected = 0;
        audioIdSelected = null;

        //Se desselecciona el recurso seleccionado si lo hubiese
        //(esto pasaría si antes de darle al botón de añadir, hubiesemos abierto el editar
        //de alguna pregunta con un recurso)
        $('.elementResource').removeClass('resourceSelected');

    });

    //CLICK DE LOS BOTONES MULTIMEDIA
    $('#preguntasRespuestas .multimediaButton').click(function(){
        var questionId = $(this).attr('id');
        var route = getQuestionMultimedia.replace('req_id', questionId);
        $.ajax({
            url: route,
            type: 'POST',
            data:{
                '_token': token,
            }
        }).done(function(result){
            if(result['audio'] != 0){
                $('.audioMultimedia').append(
                    "<div class='col100' style='font-weight: 600; font-size: large;'>AUDIO</div>" +
                    "<div class='col100'>"+
                        "<div class='col25 mPaddingTop'>" + result['audio'].title + "</div>" +
                        "<div class='col75'><audio class='col100' src='" + resourcesRoute.replace('audio', result['audio'].route) + "' controls></audio></div>" +
                    "</div>"
                );
            }else{
                $('.audioMultimedia').append(
                    "<div class='col100' style='font-weight: 600; font-size: large;'>AUDIO</div>" +
                    "<div class='col100'>Sin audio</div>"
                );
            }
            if(result['resource'] != 0){
                var resource = result['resource'];
                if(resource.type == 'image'){
                    $('.resourceMultimedia').append(
                        "<div class='col100' style='font-weight: 600; font-size: large;'>IMAGEN</div>" +
                        "<div class='col100'>"+
                            "<div class='col50 mPaddingTop'><img style='border-radius: 16px;' class='col100' src='" + resourcesRoute.replace('audio', resource.route) + "'></div>" +
                        "</div>"
                    );
                }
            }else{
                $('.resourceMultimedia').append(
                    "<div class='col100' style='font-weight: 600; font-size: large;'>IMAGEN</div>" +
                    "<div class='col100'>Sin imagen</div>"
                );
            }
            $('#modalMultimedia, #modalWindow').show();

        });
    });

    // CLICK DE LOS CHECKBOX DE TIPO EN MODAL DE NUEVO RECURSO
    $('input[name="recurso"]').click(function(){
        $('input[name="recurso"]').prop('checked', false);
        $(this).prop('checked', true);
        $('#typeNewQuestion').val($(this).val());
        var valor = $('#typeNewQuestion').val();
        switch(parseInt(valor)){
            case 0:
                $('#resourceButton').slideUp();
                break;
            case 1:
                $('#resourceButton > button').text("Añadir imagen");
                $('#resourceButton').slideDown();
                break;
            case 2:
                $('#resourceButton > button').text("Añadir video");
                $('#resourceButton').slideDown();
                break;
        }
    });

    //CLICK DEL BOTÓN DE RECURSO DE NUEVA PREGUNTA
    $('#resourceButton > button').click(function(){
        var valor = $('#typeNewQuestion').val();
        switch(parseInt(valor)){
            case 0:
                $('#resourceButton').slideUp();
                break;
            case 1:
                $('#slideModalQuestionAdd').slideUp(function(){
                    $('#modalQuestionAdd').hide();
                    $('#modalAddImage').show();
                    $('#slideModalAddImage').slideDown();
                });
                //Quitamos los clicks para que no actúe la funcionalidad
                //de pistas
                $('#aceptAddImage').unbind('click');
                $('#deleteImage').unbind('click');
                //Añadimos la funcionalidad del botón para preguntas
                $('#aceptAddImage').click(function(){
                    $('#slideModalAddImage').slideUp(function(){
                        $('#modalAddImage').hide();
                        $('#modalQuestionAdd').show();
                        $('#slideModalQuestionAdd').slideDown();
                    });
                });
                $('#deleteImage').click(function(){
                    $('#idResourceNewQuestion').val(0);
                });
                break;
            case 2:
                $('#slideModalQuestionAdd').slideUp(function(){
                    $('#modalQuestionAdd').hide();
                    $('#modalVideo').show();
                    $('#slideModalVideo').slideDown();
                });
                //Quitamos los clicks para que no actue la funcionalidad de pistas
                $('#btn-acept-video').unbind('click');
                $('#btn-delete-video').unbind('click');
                //Añadimos la funcionalidad de los botones para las preguntas
                $('#btn-acept-video').click(function(){
                    $('#slideModalVideo').slideUp(function(){
                        $('#modalVideo').hide();
                        $('#modalQuestionAdd').show();
                        $('#slideModalQuestionAdd').slideDown();
                    });
                });
                $('#btn-delete-video').click(function(){
                    $('#idResourceNewQuestion').val(0);
                });
                break;
        }
    });

    //MODAL DE AÑADIR IMAGEN A PREGUNTA
    $('.oneImage, .oneVideo').click(function(){
        $('#idResourceNewQuestion').val(resourceIdSelected);
        $('#idResourceUpdateQuestion').val(resourceIdSelected);
    });

     //ABRE LA MODAL PARA SELECCIONAR AUDIO
    $("#btn-audio").click(function(){
        $('#slideModalQuestionAdd').slideUp(function(){
            $('#modalQuestionAdd').css('display', 'none');
            $('#modalResource').css('display', 'block');              
            $('#slideModalResource').slideDown();
        });
    });

    // SELECCIONA EL AUDIO DESEADO
    $('#modalResource .elementResource').click(function(){
        var audioId = $(this).attr('id');
        $('#resourceValue').val(audioId);

        if($('#saveAudio').hasClass('editOp')){
            $('#idAudioA').val(audioId);
        }else{
            $('#idAudioT').val(audioId);
        }

        if($('#saveAudio').hasClass('edit')){
            updateAudio(audioId);
        }else{
            $.ajax({
                url: getResource.replace('req_id', audioId),
                type: 'GET',
            }).done(function(result){
                $('#newQuestionAudio').append(
                    "<p class='col30'>" + result['resource'].title + "</p>" +
                    "<audio src='"+ resourcesRoute.replace('audio', result['resource'].route) +"' controls class='col70'></audio>"
                );
            });
        }

        var classStyle = 'resourceSelected';

        if(audioIdSelected != null){
            if($(this).attr('id') == audioIdSelected){
                $('#resourceValue').val('');
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
        
        audioSelected = $('#resourceValue').val();
    });

    // BOTÓN PARA GUARDAR EL ID DEL AUDIO 
    $("#saveAudio").click(function(){
        if($(this).hasClass('edit')){
            $('#slideModalResource').slideUp(function(){
                $('#modalResource').hide();
                $('#modalQuestionUpdate').show();
                $('#slideUpdateQuestion').slideDown();
            });
        }else if($(this).hasClass('editTOp') || $(this).hasClass('editOp')){
            $('#slideModalResource').slideUp(function(){
                $('#modalResource').hide();
                $('#modalOptionUpdate').show();
                $('#slideModalOptionUpdate').slideDown();
            });
        }else{
            $('#slideModalResource').slideUp(function(){
                $('#modalResource').hide();
                $('#modalQuestionAdd').show();
                $('#slideModalQuestionAdd').slideDown();
            });
        }
    });

    // GUARDA EL FORMULARIO DE INSERTAR
    $('#btn-saveNew').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formAdd input[name="_token"]').val());
        dataForm.append('text', $('#formAdd #textAdd').val());
        dataForm.append('answer', $('#formAdd #answerAdd').val());
        dataForm.append('audio', $("#resourceValue").val());
        dataForm.append('id_escaperoom', $('#idEscapeRoom').val());
        dataForm.append('id_resource', $('#idResourceNewQuestion').val());
        dataForm.append('type', $('#typeNewQuestion').val());

        answer = $('#formAdd select[name="answer"]').val();
        if(answer != undefined){
            dataForm.append('answer', answer);
        }
        
        $.ajax({
            url: $("#formAdd").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){
            element =  ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
            <div class="col30 sPadding xlMarginRight text">${data.text}</div>
            <div class="col25 sPadding answer">${data.answer}</div>
            <div class="col15 sPadding mMarginRight">
                <button id="${data.id}" class="col100 bBlack multimediaButton multimButton">Ver Multimedia</button>
            </div>
            <div class="col10 sPadding"><button class="btn-update col100">Editar</button></div>
            <div class="col10 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
            </div>`;
            $("#tableContent").append(element);
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(edit);
            $('.btn-delete').click(openDelete);
            //Añado el click del botón multimedia añadido por ajax
            //CLICK DE LOS BOTONES MULTIMEDIA
            $('.multimButton').click(function(){
                var questionId = $(this).attr('id');
                var route = getQuestionMultimedia.replace('req_id', questionId);
                $.ajax({
                    url: route,
                    type: 'POST',
                    data:{
                        '_token': token,
                    }
                }).done(function(result){
                    if(result['audio'] != 0){
                        $('.audioMultimedia').append(
                            "<div class='col100' style='font-weight: 600; font-size: large;'>AUDIO</div>" +
                            "<div class='col100'>"+
                                "<div class='col25 mPaddingTop'>" + result['audio'].title + "</div>" +
                                "<div class='col75'><audio class='col100' src='" + resourcesRoute.replace('audio', result['audio'].route) + "' controls></audio></div>" +
                            "</div>"
                        );
                    }else{
                        $('.audioMultimedia').append(
                            "<div class='col100' style='font-weight: 600; font-size: large;'>AUDIO</div>" +
                            "<div class='col100'>Sin audio</div>"
                        );
                    }
                    if(result['resource'] != 0){
                        var resource = result['resource'];
                        if(resource.type == 'image'){
                            $('.resourceMultimedia').append(
                                "<div class='col100' style='font-weight: 600; font-size: large;'>IMAGEN</div>" +
                                "<div class='col100'>"+
                                    "<div class='col50 mPaddingTop'><img style='border-radius: 16px;' class='col100' src='" + resourcesRoute.replace('audio', resource.route) + "'></div>" +
                                "</div>"
                            );
                        }
                    }else{
                        $('.resourceMultimedia').append(
                            "<div class='col100' style='font-weight: 600; font-size: large;'>IMAGEN</div>" +
                            "<div class='col100'>Sin imagen</div>"
                        );
                    }
                    $('#modalMultimedia, #modalWindow').show();

                });
            });

            closeModal();
            $('#formAdd #textAdd').val('');
            $('#formAdd #answerAdd').val('');
            $("#resourceValue").val('');
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(edit);
            $('.btn-delete').click(openDelete);
        }).fail(function(data){
        })

    });

    //----------------------------- MODIFICAR ----------------------------------

    function edit(){

        $('#audioIfExist').empty();
        $('#updateResourceValue').val('');
        $('#saveAudio').addClass('edit');

        // Obtiene el id de la pregunta donde se pulso el boton modificar.
        var id = $(this).parent().parent().attr('id');

        // Se crea la ruta para obtener los datos de la pregunta.
        var address = questionEdit.replace('insertIdHere', id);

        // Se hace una peticion para obtener los datos de la pregunta.
        $.get(address, function(data){

            // Se rellenan los datos del formulario con la pregunta a editar
            $('#formUpdate #textUpdate').val(data.text); // Campo texto
            $(`#formUpdate #answerUpdate`).val(data.answer);
            if(data.id_audio != null){
                updateAudio(data.id_audio);
            }

            //SE PONE A CHECKED EL TYPE DE LA PREGUNTA
            var type = data.type;
            $('#typeUpdateQuestion').val(type);

            //SE SELECCIONA EL RECURSO SI LO TUVIESE
            var recurso = data.id_resource;
            $('#idResourceUpdateQuestion').val(recurso);
            resourceIdSelected = recurso;
            $('#' + recurso).addClass('resourceSelected')

            //CLICK DE LOS INPUT DE MODIFICAR PREGUNTA
            $('input[name="recursoUpdate"]').prop('checked', false);
            $('input[name="recursoUpdate"][value="' + type + '"]').prop('checked', true);
            switch(type){
                case 1:
                    $('#resourceUpdateButton > button').text('Modificar Imagen');
                    $('#resourceUpdateButton').show();
                    break;
                case 2:
                    $('#resourceUpdateButton > button').text('Modificar Video');
                    $('#resourceUpdateButton').show();
                    break;
            }

            //CLICK DE LOS INPUT
            $('input[name="recursoUpdate"]').unbind('click');
            $('input[name="recursoUpdate"]').click(function(){
                $('input[name="recursoUpdate"]').prop('checked', false);
                $(this).prop('checked', true);
                $('#typeUpdateQuestion').val($(this).val())
                var valor = $('#typeUpdateQuestion').val();
                switch(parseInt(valor)){
                    case 0:
                        $('#resourceUpdateButton').slideUp();
                        break;
                    case 1:
                        $('#resourceUpdateButton > button').text("Modificar imagen");
                        $('#resourceUpdateButton').slideDown();
                        break;
                    case 2:
                        $('#resourceUpdateButton > button').text("Modificar video");
                        $('#resourceUpdateButton').slideDown();
                        break;
                }
            });

            //CLICK DEL BOTÓN DE MODIFICAR RECURSO
            $('#resourceUpdateButton > button').unbind('click');
            $('#resourceUpdateButton > button').click(function(){
                var valor = $('#typeUpdateQuestion').val();
                console.log(valor);
                switch(parseInt(valor)){
                    case 1:
                        $('#slideUpdateQuestion').slideUp(function(){
                            $('#modalQuestionUpdate').hide();
                            $('#modalAddImage').show();
                            $('#slideModalAddImage').slideDown();
                        });
                        //Quitamos los clicks para que no actúe la funcionalidad
                        //de pistas
                        $('#aceptAddImage').unbind('click');
                        $('#deleteImage').unbind('click');
                        //Añadimos la funcionalidad del botón para preguntas
                        $('#aceptAddImage').click(function(){
                            $('#slideModalAddImage').slideUp(function(){
                                $('#modalAddImage').hide();
                                $('#modalQuestionUpdate').show();
                                $('#slideUpdateQuestion').slideDown();
                            });
                        });
                        $('#deleteImage').click(function(){
                            $('.oneImage').css('border', 'unset');
                            $('#idResourceNewQuestion').val(0);
                        });
                        break;
                    case 2:
                        $('#slideUpdateQuestion').slideUp(function(){
                            $('#modalQuestionUpdate').hide();
                            $('#modalVideo').show();
                            $('#slideModalVideo').slideDown();
                        });
                        break;
                }
            });

            //BOTÓN DE ACEPTAR DE LA MODAL DE VIDEO
            $('#btn-acept-video').unbind('click');
            $('#btn-acept-video').click(function(){
                $('#slideModalVideo').slideUp(function(){
                    $('#modalVideo').hide();
                    $('#modalQuestionUpdate').show();
                    $('#slideUpdateQuestion').slideDown();
                });
            });
            //Botón de eliminar video
            $('#btn-delete-video').unbind('click');
            $('#btn-delete-video').click(function(){
                $('.elementResource').removeClass('resourceSelected');
                $('#idResourceUpdateQuestion').val(0);
            });



            // Abre la modal
            $('#modalWindow').css('display', 'block');
            $('#modalQuestionUpdate').css('display', 'block');
            $('#slideUpdateQuestion').show();

            //EVENTO MODIFICAR AUDIO DE PREGUNTA
            $('#btn-update-audio').unbind('click');
            $('#btn-update-audio').click(function(){
                var audioActual = $('#actualAudio').val();
                if(audioActual != undefined){
                    $('input.selectAudioForUpdateQuestion[value="'+audioActual+'"]').prop('checked', true);
                }else{
                    $('input.selectAudioForUpdateQuestion').prop('checked', false);
                }
                $('#slideUpdateQuestion').slideUp(function(){
                    $('#modalQuestionUpdate').hide();
                    $('#modalResource').show();
                    $('#slideModalResource').slideDown();
                });
            });

            $('input.selectAudioForUpdateQuestion').unbind('click');
            $('input.selectAudioForUpdateQuestion').click(function(){
                $('input.selectAudioForUpdateQuestion').prop('checked', false);
                $(this).prop('checked', true);
                $('#actualAudio').val($(this).val());
            });

            //EVENTO BOTÓN DE ACEPTAR ACTUALIZAR AUDIO
            $('#aceptUpdateAudio').unbind('click');
            $('#aceptUpdateAudio').click(function(){
                $('#updateResourceValue').val($('input[name="updateAudioInput"]:checked').val());
                updateAudio($('#updateResourceValue').val());
                $('#slideUpdateAudio').slideUp(function(){
                    $('#modalSelectUpdateAudio').hide();
                    $('#modalQuestionUpdate').show();
                    $('#slideUpdateQuestion').slideDown();
                });
            });

            // Asigna evento al boton de guardar
            $(`#modalQuestionUpdate #btn-update`).unbind("click");
            $(`#modalQuestionUpdate #btn-update`).click(function(){
                
                
                // Se obtiene la url del action y se asigna el id correspondiente.
                var addressUpdate = $(`#formUpdate`).attr("action")
                addressUpdate = addressUpdate.replace('insertIdHere', id); 

                // Se obtienen los datos del formulario
                dataForm = new FormData();
                dataForm.append('_token', $('#formUpdate input[name="_token"]').val());
                dataForm.append('text', $('#formUpdate #textUpdate').val());
                dataForm.append('answer', $('#formUpdate #answerUpdate').val());
                if($('#updateResourceValue').val() != undefined)
                    dataForm.append('id_audio', $('#updateResourceValue').val());
                else
                    dataForm.append('id_audio', null);

                dataForm.append('id_resource', $('#idResourceUpdateQuestion').val());
                dataForm.append('type', $('#typeUpdateQuestion').val());
                console.log('actualAudio: ' + $('#actualAudio').val());
                
        
                // Se hace una peticion para actualizar los datos en el servidor
                $.ajax({
                    url: addressUpdate,
                    type: 'POST',
                    data: dataForm,
                    contentType: false,
                    processData: false,
                }).done(function(result){
                    var question = result['question'];

                    // Actualiza la fila correspondiente en la tabla
                    $('#tableContent #'+ question.id + ' .text').text(question.text);
                    $('#tableContent #'+ question.id + ' .answer').text(question.answer);
                    
                    closeModal();

                }).fail(function(data){
                })
            });

        }).fail(function(data){
            alert("No se a podido recuperar la información de esta pregunta.")
        });

    }

    
    //----------------------------- ELIMINAR ----------------------------------

    // ABRE LA MODAL DE ELIMINAR
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDelete').css('display', 'block');
        var id = $(this).parent().parent().attr("id");
        $('#aceptDelete').unbind('click');
        $('#aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
        $('#cancelDelete').unbind('click');
        $('#cancelDelete').click(closeModal);
    }

    // ELIMINA UNA ESCENA
    function remove(id){
        var address = questionDelete.replace('insertIdHere', id);
        $.get(address, function(data){
            if(data == 1){
                $(`#tableContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pregunta")
            }
        })
    }


    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $(".btn-update").click(edit);
    $(".btn-delete").click(openDelete);

    //CÓDIGO PARA QUE LAS MODALES SE CIERREN AL PINCHAR FUERA DE ELLAS
    var dentro = false;
    $('.window').on({
        mouseenter: function(){
            dentro = true;
        },
        mouseleave: function(){
            dentro = false;
        }
    });
    $('#modalWindow').click(function(){
        if(!dentro){
            $('#modalWindow, .window, .slide').hide();
            $('.slideShow').show();
            $('input[name="recurso"]').prop('checked', false);
            $('input[name="recurso"][value="0"]').prop('checked', true);
            $('#resourceButton').hide();
            $('.elementResource').removeClass('resourceSelected');
            //Vaciamos la modal de multimedia
            $('.resourceMultimedia, .audioMultimedia').empty();
        }
    });
    
});