$(function(){

    // CIERRA LA MODAL
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#modalQuestionAdd").css('display', 'none');
        $("#confirmDelete").css('display', 'none');
    }

    // ABRE INSERTAR QUESTION
    $('#btn-add').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalQuestionAdd').css('display', 'block');
    })

    // GUARDA EL FORMULARIO DE INSERTAR
    $('#btn-saveNew').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formAdd input[name="_token"]').val());
        dataForm.append('text', $('#formAdd #textAdd').val());
        dataForm.append('type', $('#formAdd input[name="type"]:checked').val());
        dataForm.append('key', $('#formAdd input[name="key"]:checked').val());
        dataForm.append('show_clue', $('#formAdd input[name="show_clue"]:checked').val());
        
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
            
            var element = ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                                <div class="col70 sPadding">${data.text}</div>
                                <div class="col12 sPadding"><button class="btn-update col100">Editar</button></div>
                                <div class="col12 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
                            </div>`;

            $("#tableContent").append(element);
            closeModal();
            
            // $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            // $('.btn-update').click(openUpdate);
            $('.btn-delete').click(openDelete);
            alert("Pregunta guardada");
        }).fail(function(data){
            alert("Ocurrio un error al guardar la pregunta")
            console.log(data);
        })

    });


    // ------------------- ELIMINAR --------------------

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
                alert("Pregunta elminada")
                $(`#tableContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pregunta")
            }
        })
    }


    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $(".btn-delete").click(openDelete);
});