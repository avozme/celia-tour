var sceneSelected = 0; // Para saber si se a seleccionado escena
var audioSelected = 0; // Para saber si se a seleccionado audio
var audioIdSelected = null; // Audio seleccionado.

$(function() {

    //----------------------------------------------------  Elimina fila  --------------------------------------------------------------------------
    function remove(){
        var isDelte = confirm("¿Desea eliminar esta visita guiada?");
        if(isDelte){
            var domElement = $(this).parent().parent();
            var id = $(domElement).attr("id");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){ 
                    if (xhttp.responseText == 1) {
                            $(domElement).remove();
                    } else {
                        alert("Algo fallo!");
                    }
                }
            }
            var direccion = "http://celia-tour.test/guidedVisit/deleteScenes/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
    }

    $(".btn-delete").click(remove);

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
        $('.elementResource').removeClass('resourceSelected');
    }
    $(".closeModal").click(closeModal);


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
                console.log('eliminado')
                
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
            $.post($("#addsgv").attr('action'), {
                _token: $('#addsgv input[name="_token"]').val(),
                scene: $('#sceneValue').val(), 
                resource: $('#resourceValue').val()
            }).done(function(data){
                var element = `<tr id="${data.sgv.id}">
                        <td>${data.scene.name}</td>
                        <td><audio src="${data.sgv.id_resources}" controls="true">Tu navegador no soporta este audio</audio></td>
                        <td><button class="btn-delete">Eliminar</button></td>
                    </tr>`;

                $("#tableContent").append(element);
                $('.btn-delete').unbind('click');
                $('.btn-delete').click(remove);
                closeModal();
            });
        }
    });
    
}); // Fin metodo ejecutado despues de cargar html