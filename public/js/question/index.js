$(function(){
    // CIERRA LA MODAL
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#modalQuestionAdd").css('display', 'none');
        $('#modalQuestionUpdate').css('display', 'none');
        $("#confirmDelete").css('display', 'none');
    }

    //----------------------------- INSERTAR ----------------------------------
    
    // ABRE INSERTAR QUESTION
    $('#btn-add').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalQuestionAdd').css('display', 'block');
    })

     //ABRE LA MODAL PARA SELECCIONAR AUDIO
    $("#btn-audio").click(function(){
        $('#modalQuestionAdd').css('display', 'none');
        $('#modalResource').css('display', 'block');              
    });

    // SELECCIONA EL AUDIO DESEADO
    $('.elementResource').click(function(){
        var audioId = $(this).attr('id');
        $('#resourceValue').val(audioId);
    });

    // BOTÓN PARA GUARDAR EL ID DEL AUDIO 
    $("#saveAudio").click(function(){
        $('#modalQuestionAdd').css('display', 'block');
        $('#modalResource').css('display', 'none');
    });

    // GUARDA EL FORMULARIO DE INSERTAR
    $('#btn-saveNew').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formAdd input[name="_token"]').val());
        dataForm.append('text', $('#formAdd #textAdd').val());
        dataForm.append('answer', $('#formAdd #answerAdd').val());
        dataForm.append('audio', $("#resourceValue").val());

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

            if(data.id_audio!=null){
                $.ajax({
                    url: "{{route('resource.getroute', 'req_id')}}".replace('req_id', data.id_audio), 
                    type: 'get', 
                }).done(function(data){
                    element =  ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                    <div class="col25 sPadding">${data.text}</div>
                    <div class="col25 sPadding">${data.answer}</div>
                    <div class="col30 sPadding">'<audio src="{{url("img/resources/'${data})}}" controls="true" class="col100">Tu navegador no soporta este audio</audio>'
                    })</div>
                    <div class="col10 sPadding"><button class="btn-update col100">Editar</button></div>
                    <div class="col10 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
                    </div>`;
                })
            }else{
                var element = ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                                <div class="col25 sPadding">${data.text}</div>
                                <div class="col25 sPadding">${data.answer}</div>
                                <div class="col30 sPadding">Sin audio</div>
                                <div class="col10 sPadding"><button class="btn-update col100">Editar</button></div>
                                <div class="col10 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
                            </div>`;
            }


            $("#tableContent").append(element);
            closeModal();
            
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(edit);
            $('.btn-delete').click(openDelete);
        }).fail(function(data){
            console.log(data);
        })

    });

    //----------------------------- MODIFICAR ----------------------------------

    function edit(){

        // Obtiene el id de la pregunta donde se pulso el boton modificar.
        var id = $(this).parent().parent().attr('id');

        // Se crea la ruta para obtener los datos de la pregunta.
        var address = questionEdit.replace('insertIdHere', id);

        // Se hace una peticion para obtener los datos de la pregunta.
        $.get(address, function(data){

            // Se rellenan los datos del formulario con la pregunta a editar
            $('#formUpdate #textUpdate').val(data.text); // Campo texto
            $(`#formUpdate select[name="answer"] option[value="${data.answers_id}"]`).prop('selected', true); // Campo respuesta correcta
            if(data.id_audio != null){
                $.ajax({
                    url: gertRouteResource.replace('req_id', data.id_audio),
                    type: 'GET',
                }).done(function(result){
                    $('#audioIfExist').append(
                        "<p class='col30 sMarginLeft'>" + result.title + "</p>" +
                        "<audio src='"+ resourcesRoute.replace('audio', result.route) +"' controls class='col65'></audio>"
                    );
                });
                
            }
            // Abre la modal
            $('#modalWindow').css('display', 'block');
            $('#modalQuestionUpdate').css('display', 'block');

            //EVENTO MODIFICAR AUDIO DE PREGUNTA
            $('#btn-update-audio').click(function(){
                $('#slideUpdateQuestion').slideUp(function(){
                    $('#modalQuestionUpdate').hide();
                    $('#modalSelectUpdateAudio').show();
                    $('#slideUpdateAudio').slideDown();
                });
            });

            //EVENTO BOTÓN DE ACEPTAR ACTUALIZAR AUDIO
            $('#aceptUpdateAudio').click(function(){
                $('#updateResourceValue').val($('input[name="updateAudioInput"]:checked').val());
                $('#slideUpdateAudio').slideUp(function(){
                    $('#modalSelectUpdateAudio').hide();
                    $('#modalQuestionUpdate').show();
                    $('#slideUpdateQuestion').slideDown();
                    //VOY POR AQUÍ FALTA MANDAR EL FORMULARIO
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
                dataForm.append('answer', $('#formUpdate select[name="answer"]').val());
                // dataForm.append('type', $('#formUpdate input[name="type"]:checked').val());
                // dataForm.append('key', $('#formUpdate input[name="key"]:checked').val());
                // dataForm.append('show_clue', $('#formUpdate input[name="show_clue"]:checked').val());
        
                // Se hace una peticion para actualizar los datos en el servidor
                $.ajax({
                    url: addressUpdate,
                    type: 'POST',
                    data: dataForm,
                    contentType: false,
                    processData: false,
                }).done(function(data){

                    // Actualiza la fila correspondiente en la tabla
                    var elementUpdate = $(`#tableContent #${data.id}`).children();
                    var text = $(elementUpdate)[0];
                    $(text).text(data.text);

                    closeModal();


                }).fail(function(data){
                    console.log(data);
                })
            });

        }).fail(function(data){
            alert("No se a podido recuperar la información de esta pregunta.")
            console.log(data);
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
    
});