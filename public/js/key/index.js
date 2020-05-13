$(function(){
    // CIERRA LA MODAL
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $('.window, .slide').hide();
        $('.slideShow').show();
    }
   // ABRE INSERTAR KEY
    $('#addKey').click(function(){
        //Desselecciono la escena (por si antes de abrir esta modal se hubiese abierto la de 
        // editar y se hubiese cerrado sin guardar)
        $('.scenepoint').removeClass('selected');
        $('.scenepoint').attr('src', pointImgRoute);

        //Desselecciono la pregunta
        $('#modalAddQuestionForKey input').prop('checked', false);

        $('#modalWindow').css('display', 'block');
        $('#modalKeyAdd').show();
    })

    //ABRIR MODAL PARA SELECCIONAR PREGUNTA 
    $("#btn-pregunta").click(function(){
        $('#slideModalKeyAdd').slideUp(function(){
            $('#modalKeyAdd').css('display', 'none');
            $('#modalAddQuestionForKey').css('display', 'block');
            $('#slideModalAddQuestionForKey').slideDown();
        });
    });

    //ABRIR MODAL PARA SELECCIONAR PREGUNTA DESDE EDITAR
    $("#btn-preguntaUpdate").click(function(){
        $('#aceptPregunta').addClass('edit');
        $('#slideModalKeyUpdate').slideUp(function(){
            $('#modalKeyUpdate').css('display', 'none');
            $('#modalAddQuestionForKey').css('display', 'block');
            $('#slideModalAddQuestionForKey').slideDown();
        });
    });

   //SELECCIONA EL ID DE LA PREGUNTA
   $('.seleccionado').click(function(){
    var preguntaId = $(this).attr('id');
    $('#QuestionValue').val(preguntaId);
    $('#QuestionValueUpdate').val(preguntaId);
    });

    //GUERDA LA PREGUNTA SELECCIONADA
    $("#aceptPregunta").click(function(){
        if($('#aceptPregunta').hasClass('edit')==true){
            $('#slideModalAddQuestionForKey').slideUp(function(){
                $('#modalAddQuestionForKey').css('display', 'none');
                $('#modalKeyUpdate').css('display', 'block');
                $('#slideModalKeyUpdate').slideDown();
            });
        }else{
            $('#slideModalAddQuestionForKey').slideUp(function(){
                $('#modalAddQuestionForKey').css('display', 'none');
                $('#modalKeyAdd').css('display', 'block');
                $('#slideModalKeyAdd').slideDown();
            });
        }
        $('#aceptPregunta').removeClass('edit')
    });

    //INSERTAR NUEVA LLAVE
    $("#btn-saveKey").click(function(){
        dataForm = new FormData();
        dataForm.append('_token', $('#formAddK input[name="_token"]').val());
        dataForm.append('name', $('#formAddK #textAdd').val());
        dataForm.append('question', $("#QuestionValue").val());
        dataForm.append('scenes_id', $("#idSelectedScene").val());
        dataForm.append('finish',$('#formAddK input[name="key"]:checked').val());

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
                if(data.finish=="0"){
                    final="No"
                }else{
                    final="Si"
                }
                element = ` <div id="${data.id}" class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                                <div class=col35 sPadding">${data.name}</div>
                                <div class="col35 sPadding">${pregunta}</div>
                                <div class="col10 sPadding">${final}</div>
                                <div class="col10 sPadding"><button class="btn-updatek col100">Editar</button></div>
                                <div class="col10 sPadding"><button class="btn-deletek delete col100">Eliminar</button></div>
                            </div>`;
                $("#KeyContent").append(element);
                closeModal();
                $('#formAddK #textAdd').val('');
                $('.scenepoint').removeClass('selected');
                $(".seleccionado").prop('checked', false);
                $("#idSelectedScene").val('');
                $('.btn-updatek').unbind('click');
                $('.btn-deletek').unbind('click');
                $(".btn-deletek").click(openDelete);
                $(".btn-updatek").click(edit);
            });
        }).fail(function(data){
        })

    });

    //ABRIR LA MODAL DE MAPA
    $("#btn-escena").click(function(){
        $('#slideModalKeyAdd').slideUp(function(){
            $('#modalKeyAdd').css('display', 'none');
            $('#modalMap').css('display', 'block');
            $('#mapSlide').slideDown();
        });
    });

     //ABRIR LA MODAL DE MAPA DESDE EDITAR
     $("#btn-escenaUpdate").click(function(){
         var idScene = $('#idSelectedSceneUpdate').val();
        $('#map2 #scene'+idScene).attr('src', pointImgHoverRoute);
        $('#map2 #scene'+idScene).addClass('selected');
        $('#addSceneToKey').addClass('edit');
        $('#slideModalKeyUpdate').slideUp(function(){
            $('#modalKeyUpdate').css('display', 'none');
            $('#modalMap').css('display', 'block');
            $('#mapSlide').slideDown();
        });
    });

    //AÑADIR VALOR AL ID DE LA ESCENA 
    //Al hacer click en un punto del mapa
    $('.scenepoint').on({
        click: function(){
            //La clase SELECTED sirve para saber que punto concreto está seleccionado y así
            //evitar que se cambie el icono amarillo al hacer mouseout
            $('.scenepoint').attr('src', pointImgRoute);
            $('.scenepoint').removeClass('selected');
            $(this).attr('src', pointImgHoverRoute);
            $(this).addClass('selected');
            var sceneId = $(this).attr('id');
            $('#idSelectedScene').attr('value', sceneId.substr(5));
            $("#idSelectedSceneUpdate").val(sceneId.substr(5));
        },
        mouseover: function(){
            $(this).attr('src', pointImgHoverRoute);
        },
        mouseout: function(){
            if(!$(this).hasClass('selected'))
                $(this).attr('src', pointImgRoute);
        }
    });

    //BOTÓN ACEPTAR DE LA MODAL MAPA
    $("#addSceneToKey").click(function(){
        if($('#addSceneToKey').hasClass('edit')==true){
            $('#mapSlide').slideUp(function(){
                $('#modalMap').css('display', 'none');
                $('#modalKeyUpdate').css('display', 'block');
                $('#slideModalKeyUpdate').slideDown();
            });
        }else{
            $('#mapSlide').slideUp(function(){
                $('#modalMap').css('display', 'none');
                $('#modalKeyAdd').css('display', 'block');
                $('#slideModalKeyAdd').slideDown();
            });
        }
        $('#addSceneToKey').removeClass('edit')
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
            if(data.status){
                $(`#KeyContent #${id}`).remove();
            } else {
                alert("Ocurrio un error al eliminar la pregunta")
            }
        })
    }

    //FUNCIÓN PARA ACTUALIZAR KEY
    function edit(){
        $('.scenepoint').attr('src', pointImgRoute);
        $('.scenepoint').removeClass('selected');
    // Obtiene el id de la pregunta donde se pulso el boton modificar.
    var id = $(this).parent().parent().attr('id');
    // Se crea la ruta para obtener los datos de la pregunta.
    var address = keyEdit.replace('req_id', id);
    // Se hace una peticion para obtener los datos de la pregunta.
    $.get(address, function(data){
        // Se rellenan los datos del formulario con la pregunta a editar
        $('#formUpdateK #textKUpdate').val(data.name); // Campo nombre
        $('#formUpdateK #QuestionValueUpdate').val(data.id_question); //Campo pregunta
        $('#formUpdateK #idSelectedSceneUpdate').val(data.scenes_id); //Campo escena
        $(`#formUpdateK input[name="key"][value="${data.finish}"]`).prop('checked', true); 
        //seleccionamos la pregunta que tiene asignada actualmente
        $('#modalAddQuestionForKey #' + data.id_question + ' input').prop('checked', true);

        // Abre la modal
        $('#modalWindow').css('display', 'block');
        $('#modalKeyUpdate').css('display', 'block');  
        // Asigna evento al boton de guardar
        $(`#modalKeyUpdate #btn-updatek`).unbind("click");
        $(`#modalKeyUpdate #btn-updatek`).click(function(){

            //Creamos la ruta de actualizar 
            var rutaUpdate = keyUpdate.replace('req_id', id); 
            // Se obtienen los datos del formulario
            dataForm = new FormData();
            dataForm.append('_token', $('#formUpdateK input[name="_token"]').val());
            dataForm.append('name', $('#formUpdateK #textKUpdate').val());
            dataForm.append('id_question', $('#formUpdateK #QuestionValueUpdate').val());
            dataForm.append('scenes_id', $('#formUpdateK #idSelectedSceneUpdate').val());
            dataForm.append('finish',$('#formUpdateK input[name="key"]:checked').val());

            // Se hace una peticion para actualizar los datos en el servidor
            $.ajax({
                url: rutaUpdate,
                type: 'POST',
                data: dataForm,
                contentType: false,
                processData: false,
            }).done(function(data){

                // Actualiza la fila correspondiente en la tabla
                var elementUpdate = $(`#KeyContent #${data.id}`).children();
                var text = $(elementUpdate)[0];
                var pregunta = $(elementUpdate)[1];
                var final = $(elementUpdate)[2];
                $(text).text(data.name);
                $.ajax({
                    url: rutaK.replace('req_id', data.id_question), 
                    type: 'get', 
                }).done(function(respuesta){
                    $(pregunta).text(respuesta);
                });
                if(data.finish=="0"){
                    solcuion="No"
                }else{
                    solcuion="Si"
                }
                $(final).text(solcuion);
                closeModal();


            }).fail(function(data){
            });
        });
    }).fail(function(data){
        alert("No se a podido recuperar la información de esta pregunta.")
    });
}


    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $(".btn-deletek").click(openDelete);
    $(".btn-updatek").click(edit);
});