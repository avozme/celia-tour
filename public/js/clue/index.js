$(function(){

  // CIERRA LA MODAL
  function closeModal(){
    $("#modalWindow").css('display', 'none');
    $("#modalPistaAdd").css('display', 'none');
    $("#confirmDeletePista").css('display', 'none');
    $('#modalPistaUpdate').css('display', 'none');
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
            $(".btn-update-pista").unbind('click');
            $(".btn-update-pista").click(edit);
            $(".btn-delete-pista").unbind('click');
            $(".btn-delete-pista").click(openDelete);
            closeModal();
            
        }).fail(function(data){
            alert('Ocurrio un error al guardar');
            console.log(data);
        })

    });

    //----------------------------- MODIFICAR ----------------------------------

    function edit(){

        // Obtiene el id de la pista donde se pulso el boton modificar.
        var id = $(this).parent().parent().attr('id');

        // Se crea la ruta para obtener los datos de la pregunta.
        var address = clueShow.replace('req_id', id);

        // Se hace una peticion para obtener los datos de la pregunta.
        $.get(address, function(data){

            console.log(data);

            var form = '#formUpdatePista';

            // Se rellenan los datos del formulario con la pregunta a editar
            $(`${form} #text`).val(data.text); // Campo texto
            $(`${form} input[name="show"][value="${data.show}"]`).prop('checked', true); // Campo show
            $(`${form} select[name="question"] option[value="${data.id_question}"]`).prop('selected', true); // Campo question
            
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
                dataForm.append('text', $(`${form} #text`).val());
                dataForm.append('show', $(`${form} input[name="show"]:checked`).val());
                dataForm.append('id_question', $(`${form} select[name="question"] option:selected`).val());

            
                // Se hace una peticion para actualizar los datos en el servidor
                $.ajax({
                    url: addressUpdate,
                    type: 'POST',
                    data: dataForm,
                    contentType: false,
                    processData: false,
                }).done(function(data){
                    // Actualiza la fila correspondiente en la tabla
                    var elementUpdate = $(`#pistaContent #${data.id}`).children();

                    // Campo text
                    var text = $(elementUpdate)[0];
                    $(text).text(data.text);

                    // Campo show
                    var show = $(elementUpdate)[1];
                    var showText = null;
                    if(data.show == '1'){
                        showText = 'Si';
                    } else {
                        showText = 'No';
                    }
                    $(show).text(showText);

                    closeModal();
                }).fail(function(data){
                    alert("Ocurrio un error al guardar");
                    console.log(data);
                })
            });

        }).fail(function(data){
            alert("No se a podido recuperar la información de esta pista.")
            console.log(data);
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
                alert("Pista elminada");
                $(`#pistaContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pregunta")
            }
        })
    }



    // EVENTOS INICIALES
    $(".btn-update-pista").click(edit);
    $(".btn-delete-pista").click(openDelete);

});