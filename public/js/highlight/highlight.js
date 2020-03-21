var sceneSelected = 0;

$(function(){
    $('#btnMap').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#ventanaModal').css('display', 'block');

        // Se colocan los valores vacios
        $('#sceneValue').val('');
        $('#resourceValue').val('');

    });

    // Al clicar en un punto de escena, guardara el id de la escena en un input hidden y cierra la modal
    $(".scenepoint").click(function(){ 
        var pointId = $(this).attr("id");
        var sceneId = parseInt(pointId.substr(5))
        $("#sceneValue").val(sceneId);
        $('#ventanaModal').css('display', 'none');
        $('#modalResource').css('display', 'block');
        sceneSelected = $("#sceneValue").val(sceneId);
    });

    // Aceptar
    $('#acept').click(function(){
        if(sceneSelected == 0 || audioSelected == 0){
            alert('Escena sin seleccionar');
        } else {
            $.post($("#addsgv").attr('action'), {
                _token: $('#addsgv input[name="_token"]').val(),
                scene: $('#sceneValue').val(), 
                resource: $('#resourceValue').val()
            }).done(function(data){
                $("#tableContent").append(data);
            });
            $('#modalWindow').css('display', 'none');
            $('#modalResource').css('display', 'none');
        }
    });

    // Cancelar
    $('#cancel').click(function(){
        $('#modalWindow').css('display', 'none');
        $('#modalResource').css('display', 'none');
    });

    function borrarHL(ruta){
        $("#modalWindow").css("display", "block");
        $("#ventanaModal").css("display", "block");
        $("#btnModal").attr("onclick", "window.location.href='"+ ruta +"'");
    }

    function idScene(){
        idValue = document.getElementById("sceneValue");
        if(idValue.value == ""){
            event.preventDefault();   // Detenemos el submit!!
            document.getElementById("msmError").innerHTML = " Debes seleccionar una zona para este punto destacado";
        }
    }
  
    $(document).ready(function() {

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
            },
            mouseover: function(){
                $(this).attr('src', rutaIconoEscenaHover);
            },
            mouseout: function(){
                if(!$(this).hasClass('selected'))
                    $(this).attr('src', rutaIconoEscena);
            }
        });

        //botón de cancelar de modal de confirmación
        $("#btnNo").click(function(){
            $("#modalWindow").css("display", "none");
            $("#ventanaModal").css("display", "none");
        });

        //ABRIR MODAL DE NUEVO PUNTO DESTACADO
        $('#newHighlight').click(function(){
            $('#addSceneToHl').removeClass('modifying');
            $('#modalDelete').hide();
            $('#newSlide').show();
            $('#newHlModal').show();
            $('#modalWindow').show();
        });

        //ABRIR MAPA CON EFECTOS
        $('#btnMap').click(function(){
            $('#newSlide').slideUp(function(){
                $('#newHlModal').hide();
                $('#modalMap').show();
                $('#mapSlide').slideDown();
            });
        });

        //ACEPTAR DE LA MODAL DEL MAPA
        $('#addSceneToHl').click(function(){
            if($('#addSceneToHl').hasClass('modifying')){
                $('#mapSlide').slideUp(function(){
                    $('#newHlModal').hide();
                    $('#newSlide').hide();
                    $('#modalMap').hide();
                    $('#modifyHlModal').show();
                    $('#newSlideUpdate').slideDown();
                });
            }else{
                $('#mapSlide').slideUp(function(){
                    $('#modalMap').hide();
                    $('#modifyHlModal').hide();
                    $('#newSlideUpdate').hide();
                    $('#newHlModal').show();
                    $('#newSlide').slideDown();
                });
            }
        });

        //MODIFICAR
        $('.modifyHl').click(function(){
            $('#addSceneToHl').addClass('modifying');
            idHl = $(this).attr('id');
            var route = rutaShow.replace('req_id', idHl);
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                "_token": token,
            },
            success:function(result){                   
                hl = result['highlight'];
                //RELLENO LOS INPUT DEL FORMULARIO DE MODIFICAR
                $('#hlTitle').attr('value', hl.title);
                $('#hlSceneImg').attr('src', rutaImg.replace('image', hl.scene_file));
                $('#idSelectedSceneUpdate').attr('value', hl.id_scene);
                //SEÑALAR LA ESCENA QUE ESTÁ MARCADA CON EL PUNTO DESTACADO
                $('#scene'+hl.id_scene).attr('src', rutaIconoEscenaHover);
                $('#scene'+hl.id_scene).addClass('selected');
                var actualAction = $('#formUpdateHl').attr('action');
                $('#formUpdateHl').attr('action', actualAction.replace('id', hl.id));
                $('#modalDelete').hide();
                $('#modifyHlModal').show();
                $('#newSlideUpdate').show();
                $('#modalWindow').show();

                //MOSTRAR LA MODAL DE MODIFICAR
                $('#updateHlMap').click(function(){
                    $('#newSlideUpdate').slideUp(function(){
                        $('#modifyHlModal').hide();
                        $('#modalMap').show();
                        $('#mapSlide').slideDown();
                    });
                });
            },
            error:function() {
                alert('Error AJAX');
            }
            });
        });

        //cerrar modal
        $('.closeModal').click(function(){
            $('.icon > *').removeClass('selected');
            $('.scenepoint').attr('src', rutaIconoEscena);
            $('#modalDelete, #newHlModal, #newSlide, #modifyHlModal, #newSlideUpdate, #modalMap, #mapSlide, #modalWindow').hide();
        });

        //borrar punto destacado
        $('.delete').click(function(){
            $('#modalDelete').show();
            $('#modalWindow').show();
        });
    });

});