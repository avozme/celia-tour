$(function() {

    // Boton que elimina una fila de la tabla
    function remove(id){

        var direccion = urlDelete.replace('insertIdHere', id);
        $.get(direccion, function(data){
            if(data.error){
                alert('La visita guiada no puede ser eliminada mientras tenga escenas asignadas.')
            } else {
                var elemento = $(`#${id}`)[0];
                $(elemento).remove();
            }
        })
    }

    //-------------------------------------------- Ventanas modales ---------------------------------------------------

    // Cierra la modal y todos los contenidos
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#newGuidedVisit").css('display', 'none');
        $("#updateGuidedVisit").css('display', 'none');
        $('#confirmDelete').css('display', 'none');
        $('.error').css('display', 'none');
    }
    

    // Abre la modal y prepara la ventana
    function openUpdate(){

        $('#fileValueUpdate').val('');

        var url = $(this).attr('data-openupdateurl');
        $.get( url, function( data ) {
            // Actualiza los campos
            $('#nameValueUpdate').val(data.name);
            $('#descriptionValueUpdate').val(data.description);

            // Actualiza la foto
            var urlPreview = urlResource+data.file_preview;
            $('#fileUpdate').attr('src', urlPreview);

            $('#modalWindow').css('display', 'block');
            $('#updateGuidedVisit').css('display', 'block');
          });

        // Se coloca el action con la ruta correctamente
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        var url = urlUpdate.replace('insertIdHere', id);
        $('#formUpdate').attr('action', url);
    }

    // Abre la modal para eliminar un recurso
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDelete').css('display', 'block');
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        $('#aceptDelete').unbind('click');
        $('#aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
    }

    // Muestra la ventana modal y el formulario para insertar una visita guiada
    $('#btn-add').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#newGuidedVisit').css('display', 'block');

        // Pone los valores vacios | Desactivao. Al colocar un valor vacio los campos se bordean rojos ya que son campos requeridos
        // $('#nameValue').val('');
        // $('#descriptionValue').val('');
        // $('#fileValue').val('');

    })

    // Envia al formulario de insertar visita guiada
    $('#btn-saveNew').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formadd input[name="_token"]').val());
        dataForm.append('name', $('#nameValue').val());
        dataForm.append('description', $('#descriptionValue').val());
        dataForm.append('file_preview', $('#fileValue')[0].files[0]);

        $.ajax({
            url: $("#formadd").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){
            
            var urlImage = urlResource + data.guidedVisit.file_preview;
            var element = `<div id="${data.guidedVisit.id}" class='col100 mPaddingLeft mPaddingRight sPaddingTop'>
                <div class="col15 sPadding">${data.guidedVisit.name}</div>
                <div class="col29 sPadding">${data.guidedVisit.description}</div>
                <div class="col20 sPadding"><img class="miniature" src="${urlImage}"></div>
                <div class="col12 sPadding"><button class="btn-update col100" data-openupdateurl="${data.routeUpdate}" class="btn-update">Editar</button></div>
                <div class="col12 sPadding"><button class="col100 bBlack" onclick="window.location.href='${data.routeScene}'">Escenas</button></div>
                <div class="col12 sPadding"><button class="btn-delete delete col100">Eliminar</button></div>
            </div>`;

            $("#tableContent").append(element);
            $('#modalWindow').css('display', 'none'); 
            $('#newGuidedVisit').css('display', 'none');
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(openUpdate);
            $('.btn-delete').click(openDelete);
        }).fail(function(data){
            // var nameError = clearError(data.responseJSON.errors.name);
            // var descriptionError = clearError(data.responseJSON.errors.description);
            // var file_previewError = clearError(data.responseJSON.errors.file_preview);
            // $('#errorAdd').html(nameError + descriptionError + file_previewError);
            // $('#errorAdd').css('display', 'block');
        })
    });

    // Envia el formulario de actualizar visita guiada
    $('#btn-saveUpdate').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formUpdate input[name="_token"]').val());
        dataForm.append('name', $('#nameValueUpdate').val());
        dataForm.append('description', $('#descriptionValueUpdate').val());

        // Comprueba si se selecciona un archivo
        if($('#fileValueUpdate')[0].files[0] != undefined) {
            dataForm.append('file_preview', $('#fileValueUpdate')[0].files[0]);
        } else {
            dataForm.append('not_file', 'true');
        }

        $.ajax({
            url: $("#formUpdate").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){
            // Modifica los valores de la tabla
            var children = $(`#${data.guidedVisit.id}`).children();
            $(children[0]).html(data.guidedVisit.name);
            $(children[1]).html(data.guidedVisit.description);
            var img = urlResource + data.guidedVisit.file_preview;
            $(`#${data.guidedVisit.id} img`).attr('src', img);
            $(`#${data.guidedVisit.id} button[onclick]`).attr('onclick', `window.location.href='${data.route}'`)

            $('#modalWindow').css('display', 'none'); 
            $('#updateGuidedVisit').css('display', 'none');
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(openUpdate);
            $('.btn-delete').click(openDelete);
        }).fail(function(data){
            // var nameError = clearError(data.responseJSON.errors.name);
            // var descriptionError = clearError(data.responseJSON.errors.description);
            // var file_previewError = clearError(data.responseJSON.errors.file_preview);
            // $('#errorUpdate').html(nameError + descriptionError + file_previewError);
            // $('#errorUpdate').css('display', 'block');
        })
    });


    // ----------- Eventos iniciales -------------------
    $(".btn-delete").click(openDelete);
    $("#cancelDelete").click(closeModal);
    $('.btn-update').click(openUpdate);
    $(".closeModal").click(closeModal);

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
            $('#modalWindow, .window').hide();
        }
    });

}); // Fin metodo ejecutado despues de cargar html