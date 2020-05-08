$(function(){

  // CIERRA LA MODAL
  function closeModal(){
    $("#modalWindow").css('display', 'none');
    $("#modalPistaAdd").css('display', 'none');
    $("#confirmDeletePista").css('display', 'none');
}

//----------------------------- INSERTAR ----------------------------------

    // ABRE INSERTAR PISTA
    $('#btn-addPista').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalPistaAdd').css('display', 'block');
    })

    // GUARDA EL FORMULARIO DE INSERTAR
    $('#modalPistaAdd #btn-save').click(function(){

        var form = '#formAddPista';

        dataForm = new FormData();
        dataForm.append('_token', $(`${form} input[name="_token"]`).val());
        dataForm.append('text', $(`${form} #text`).val());
        dataForm.append('show', $(`${form} input[name="show"]:checked`).val());
        dataForm.append('id_question', $(`${form} select[name="question"] option:checked`).val());

        hotspot = $('#formAdd select[name="hotspot"] option:selected').val();
        
        $.ajax({
            url: $(form).attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){

            var show = "null";
            if(data.show == 1){
                show = "Si";
            } else {
                show = "No";
            }

            var content =   `<div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                                <div class="col40 sPadding">${data.text}</div>
                                <div class="col40 sPadding">${show}</div>
                                <div class="col10 sPadding"><button class="btn-update-pista col100">Editar</button></div>
                                <div class="col10 sPadding"><button class="btn-delete-pista delete col100">Eliminar</button></div>
                            </div>`

            $(`#pistaContent`).append(content);
            $(".btn-delete-pista").unbind('click');
            $(".btn-delete-pista").click(openDelete);
            closeModal();
            
        }).fail(function(data){
            alert('Ocurrio un error al guardar');
            console.log(data);
        })

    });

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
                alert("Pregunta elminada")
                $(`#pistaContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pregunta")
            }
        })
    }



    // EVENTOS INICIALES
    // $(".btn-update").click(edit);
    $(".btn-delete-pista").click(openDelete);

});