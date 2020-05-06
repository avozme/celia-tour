$(function(){
    // CIERRA LA MODAL
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#modalKeyAdd").css('display', 'none');
        $('#modalKeyUpdate').css('display', 'none');
        $("#confirmDelete").css('display', 'none');
    }
   // ABRE INSERTAR KEY
    $('#addKey').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalKeyAdd').css('display', 'block');
    })

    //ABRIR MODAL PARA SELECCIONAR PREGUNTA 
    $("#btn-pregunta").click(function(){
        console.log("abriendo las preguntas");
        $('#modalKeyAdd').css('display', 'none');
        $('#modalAudio').css('display', 'block');
    });

   //SELECCIONA EL ID DE LA PREGUNTA
   $('.seleccionado').click(function(){
    var preguntaId = $(this).attr('id');
    $('#QuestionValue').val(preguntaId);
    });

    //GUERDA LA PREGUNTA SELECCIONADA
    $("#aceptPregunta").click(function(){
        $('#modalKeyAdd').css('display', 'block');
        $('#modalAudio').css('display', 'none');
    });

    //INSERTAR NUEVA LLAVE
    $("#btn-saveKey").click(function(){
        console.log($("#QuestionValue").val())
        dataForm = new FormData();
        dataForm.append('_token', $('#formAddK input[name="_token"]').val());
        dataForm.append('name', $('#formAddK #textAdd').val());
        dataForm.append('question', $("#QuestionValue").val());
        dataForm.append('scenes_id', 1);

        $.ajax({
            url: $("#formAddK").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){

                var element = ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                                <div class="col25 sPadding">${data.name}</div>
                                <div class="col25 sPadding">${data.question}</div>
                                <div class="col10 sPadding"><button class="btn-updatek col100">Editar</button></div>
                                <div class="col10 sPadding"><button class="btn-deletek delete col100">Eliminar</button></div>
                            </div>`;


            $("#KeyContent").append(element);
            closeModal();
        }).fail(function(data){
            console.log(data);
        })

    });

});