var sceneSelected = 0; // Para saber si se a seleccionado escena
var audioSelected = 0; // Para saber si se a seleccionado audio
var audioIdSelected = null; // Audio seleccionado.

$(function() {

    console.log($(`#tableContent #2 .scenePreview`).attr('id'));

    //----------------------------------------------------  Elimina fila  --------------------------------------------------------------------------

    // Boton que elimina una fila de la tabla
    function remove(id){
        var direccion = urlDelete.replace('insertIdHere', id);
        $.get(direccion, function(){
            var elemento = $(`#${id}`)[0];
            $(elemento).remove();
        })
    }

    //----------------------------------------------------  Lista ordenable  --------------------------------------------------------------------------

    $(".sortable").sortable({
        // Al cambiar la lista se guardan todos los id en un input hidden
        update: function(){ 
            var ordenElementos = $(this).sortable("toArray").toString();
            $('#position').val(ordenElementos).change();
            //document.getElementById("btn-savePosition").disabled = false; 
            
            /**
             * Depuración JS
             */
            //var orden = $('#position').val();
            //alert(orden); // Variable donde se guardan las posiciones (JS) aún no están en la BD
        },

        // Deshabilita los controles del audio ya que se queda pillado al intentar ordenar
        start: function(event, ui){
            $("tr[id="+ui.item[0].id+"] audio").removeAttr("controls");
        },
        
        // Se habilitan los controles de audio
        stop: function(event, ui){
            $("tr[id="+ui.item[0].id+"] audio").attr("controls", "true");
            
            // Guarda la posición
            if($('#position').val() == 'null'){
                // Acción cuando no hay posiciones nuevas
            } else {
                $.post($("#addPosition").attr('action'), {
                    _token: $('#addPosition input[name="_token"]').val(),
                    position: $('#position').val()
                }).done(function(data){
                    //alert('Posición guardada');
                    alertify.success('Posición guardada', 5); 
                }).fail( function() {
                    alertify.error('Error al guardar la posición', 5); 
                });   
            }
        }
    });

    /*
    // Boton que guarda la posición
    $('#btn-savePosition').click(function(){
        
    });
    */

    //----------------------------------------------------  Ventanas modales  --------------------------------------------------------------------------

    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $(".window").css('display', 'none');
        $('.elementResource').removeClass('resourceSelected');
    }
    

    // Abre la modal para eliminar un recurso
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDelete').css('display', 'block');
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        $('#aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
    }

    // ------------------------------------------- MODIFICAR --------------------------------------

    function edit(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#modalZone').css('display', 'block');

        // Se colocan los valores
        $('#sceneValue').val('');
        $('#resourceValue').val('');
        sceneSelected = 0;
        audioSelected = 0;
        audioIdSelected = null;

        // Se asigna el id de la escena
        $('#sgvId').val($(this).parent().parent().attr("id"));

        // Se cambia el evento del boton aceptar para que actualice los datos
        $('#acept').unbind("click");
        $('#acept').click(function(){

            // Recopila los datos del formulario
            dataForm = new FormData();
            dataForm.append('_token', $('#addsgv input[name="_token"]').val());
            dataForm.append('id_scenes', $('#addsgv #sceneValue').val());
            dataForm.append('id_resources', $('#addsgv #resourceValue').val());

            // Se obtiene la url y se asigna el id correspondiente.
            var address = urlUpdate.replace('insertIdHere', $('#sgvId').val());

            // Se hace una peticion para actualizar los datos en el servidor
            $.ajax({
                url: address,
                type: 'POST',
                data: dataForm,
                contentType: false,
                processData: false,
            }).done(function(data){
                console.log(data);
                
                // nombre de la escena
                var tableRow = $(`#tableContent #${data.sgv.id}`).children();
                var escene = $(tableRow)[0];
                $(escene).text(data.sceneName);

                // Audiodescripcion
                $(`#tableContent #${data.sgv.id} audio`).attr('src', data.audioRoute)
                console.log($(`#tableContent #${data.sgv.id} audio`).attr('src'));

                // escena preview
                $(`#tableContent #${data.sgv.id} .scenePreview`).attr('id', data.sgv.id_scenes);
                console.log($(`#tableContent #${data.sgv.id} .scenePreview`).attr('id'));

                closeModal();
            }).fail(function(data){
                alert("Ocurrio un error al actualizar los datos");
                console.log(data);
            })
        });
    }

    



    $('#showModal').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#modalZone').css('display', 'block');

        // Se colocan los valores vacios
        $('#sgvId').val('');
        $('#sceneValue').val('');
        $('#resourceValue').val('');
        sceneSelected = 0;
        audioSelected = 0;
        audioIdSelected = null;

        $('#acept').unbind("click");
        $('#acept').click(save);

    });

    // Al clicar en un punto de escena, guardara el id de la escena en un input hidden y cierra la modal
    $(".scenepoint").click(function(){ 
        var pointId = $(this).attr("id");
        var sceneId = parseInt(pointId.substr(5))
        $("#sceneValue").val(sceneId);
        $('#modalZone').css('display', 'none');
        $('#modalResource').css('display', 'block');
        sceneSelected = $("#sceneValue").val(sceneId);
    });


    // Selecciona un audio
    $('.elementResource').click(function(){
        var audioId = $(this).attr('id');
        $('#resourceValue').val(audioId);
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


    // Boton aceptar
    function save(){
        if(sceneSelected == 0 || audioSelected == 0){
            alert('Escena o audio sin seleccionar');
        } else {
            $.post(urlAdd, {
                _token: $('#addsgv input[name="_token"]').val(),
                scene: $('#sceneValue').val(), 
                resource: $('#resourceValue').val()
            }).done(function(data){
                var routeAudio = urlResource+data.sgv.id_resources;
                var element = `
                    <tr id="${data.sgv.id}" class="col100">
                        <td class="sPadding col20">${data.scene.name}</td>
                        <td class="sPadding col30"><audio src="${routeAudio}" controls="true" class="col100">Tu navegador no soporta este audio</audio></td>
                        <td class="sPadding col20" style="text-align: right;"><button id="${data.sgv.id_scenes}" class="scenePreview">Ver Escena</button></td>
                        <td class="sPadding col10"><button class="btn-update col100">Editar</button></td>
                        <td class="sPadding col10" style="text-align: right;"><button class="btn-delete delete">Eliminar</button></td>
                    </tr>
                    `;

                $("#tableContent").append(element);
                $('.scenePreview').unbind('click');
                $('.scenePreview').click(scenePreview);
                $('.btn-update').unbind('click');
                $('.btn-update').click(edit);
                $('.btn-delete').unbind('click');
                $('.btn-delete').click(openDelete);
                closeModal();
            });
        }
    }

    // PREVISUALIZACION DE ESCENAS
    function scenePreview(){
        var sceneId = $(this).attr('id');
        loadSceneIfExist(sceneId);
        $('#previewModal').show();
        $('#modalWindow').show();
    }


    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $('.btn-update').click(edit);
    $(".btn-delete").click(openDelete);
    $("#cancelDelete").click(closeModal);
    $('.scenePreview').click(scenePreview);
    $('#acept').click(save);


    //CERRAR MODALES PINCHANDO FUERA DE ELLAS
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
            $('#pano').empty();
        }
    });

}); // Fin metodo ejecutado despues de cargar html