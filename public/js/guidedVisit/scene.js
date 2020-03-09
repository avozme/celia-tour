var sceneSelected = 0; // Para saber si se a seleccionado escena
var audioSelected = 0; // Para saber si se a seleccionado audio
var audioIdSelected = null; // Audio seleccionado.

$(function() {

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
            document.getElementById("btn-savePosition").disabled = false; 
        },

        // Deshabilita los controles del audio ya que se queda pillado al intentar ordenar
        start: function(event, ui){
            $("tr[id="+ui.item[0].id+"] audio").removeAttr("controls");
        },
        
        // Se habilitan los controles de audio
        stop: function(event, ui){
            $("tr[id="+ui.item[0].id+"] audio").attr("controls", "true");
        }
    });

    // Boton que guarda la posición
    $('#btn-savePosition').click(function(){
        if($('#position').val() == 'null'){
            // Acción cuando no hay posiciones nuevas
        } else {
            $.post($("#addPosition").attr('action'), {
                _token: $('#addPosition input[name="_token"]').val(),
                position: $('#position').val()
            }).done(function(data){
                alert('Posición guardada')
            });    
        }
    })


    //----------------------------------------------------  Ventanas modales  --------------------------------------------------------------------------

    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#modalResource").css('display', 'none');
        $("#modalZone").css('display', 'none');
        $('#confirmDelete').css('display', 'none');
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


    $('#showModal').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#modalZone').css('display', 'block');

        // Se colocan los valores vacios
        $('#sceneValue').val('');
        $('#resourceValue').val('');
        sceneSelected = 0;
        audioSelected = 0;
        audioIdSelected = null;

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
            $(this).addClass(classStyle)
            audioIdSelected = $(this).attr('id');
        }
        
        audioSelected = $('#resourceValue').val();
    });


    // Boton aceptar
    $('#acept').click(function(){
        if(sceneSelected == 0 || audioSelected == 0){
            alert('Escena o audio sin seleccionar');
        } else {
            $.post(urlAdd, {
                _token: $('#addsgv input[name="_token"]').val(),
                scene: $('#sceneValue').val(), 
                resource: $('#resourceValue').val()
            }).done(function(data){
                var routeAudio = urlResource+data.sgv.id_resources;
                var element = `<tr id="${data.sgv.id}" class="col100">
                        <td class="sPadding col20">${data.scene.name}</td>
                        <td class="sPadding col60"><audio src="${routeAudio}" controls="true" class="col100">Tu navegador no soporta este audio</audio></td>
                        <td class="sPadding col20" style="text-align: right;"><button class="btn-delete delete">Eliminar</button></td>
                    </tr>`;

                $("#tableContent").append(element);
                $('.btn-delete').unbind('click');
                $('.btn-delete').click(openDelete);
                closeModal();
            });
        }
    });


    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $(".btn-delete").click(openDelete);
    $("#cancelDelete").click(closeModal);

}); // Fin metodo ejecutado despues de cargar html