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
        $('#modalKeyAdd').show();
    })

    //ABRIR MODAL PARA SELECCIONAR PREGUNTA 
    $("#btn-pregunta").click(function(){
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

            $.ajax({
                url: rutaK.replace('req_id', data.id_question), 
                type: 'get', 
            }).done(function(pregunta){
                element = ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                                <div class=col40 sPadding">${data.name}</div>
                                <div class="col40 sPadding">${pregunta}</div>
                                <div class="col10 sPadding"><button class="btn-updatek col100">Editar</button></div>
                                <div class="col10 sPadding"><button class="btn-deletek delete col100">Eliminar</button></div>
                            </div>`;
                $("#KeyContent").append(element);
            });
            closeModal();
        }).fail(function(data){
            console.log(data);
        })

    });

    //ABRIR LA MODAL DE MAPA
    $("#btn-escena").click(function(){
        $('#modalKeyAdd').css('display', 'none');
        $('#modalMap').css('display', 'block');
        $('#mapSlide').slideDown();
    });

    //AÑADIR VALOR AL ID DE LA ESCENA 
    //Al hacer click en un punto del mapa
    $('.scenepoint').on({
        click: function(){
            //La clase SELECTED sirve para saber que punto concreto está seleccionado y así
            //evitar que se cambie el icono amarillo al hacer mouseout
            $('.scenepoint').attr('src', rutaIconoEscena);
            $('.scenepoint').removeClass('selected');
            $(this).attr('src', rutaIconoEscenaHover);
            $(this).addClass('selected');
            var sceneId = $(this).attr('id');
            $('#idSelectedScene').attr('value', sceneId.substr(5));
            $("#idSelectedSceneUpdate").val(sceneId.substr(5));
        },
        mouseover: function(){
            $(this).attr('src', rutaIconoEscenaHover);
        },
        mouseout: function(){
            if(!$(this).hasClass('selected'))
                $(this).attr('src', rutaIconoEscena);
        }
    });

    //BOTÓN ACEPTAR DE LA MODAL MAPA
    $("#addSceneToKey").click(function(){
        $('#modalKeyAdd').css('display', 'block');
        $('#modalMap').css('display', 'none');
        $('#mapSlide').slideDown();
    });

        //----------------------------- ELIMINAR ----------------------------------

    // ABRE LA MODAL DE ELIMINAR
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDeleteK').css('display', 'block');
        var id = $(this).parent().parent().attr("id");
        $('#DeleteKey').unbind('click');
        $('#DeleteKey').click(function(){
            remove(id);
            closeModal();
        });
        $('#cancelDelete').unbind('click');
        $('#cancelDelete').click(closeModal);
    }

    // ELIMINA UNA KEY
    function remove(id){
        var address = keyDelete.replace('req_id', id);
        $.get(address, function(data){
            console.log("los datos son: "+data);
            if(data.status){
                $(`#KeyContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pregunta")
            }
        })
    }



    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $(".btn-deletek").click(openDelete);
});