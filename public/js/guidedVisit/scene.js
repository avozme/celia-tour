var sceneSelected = 0;
var audioSelected = 0;

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
    }
    $(".closeModal").click(closeModal);


    $('#showModal').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
        $('#modalZone').css('display', 'block');

        // Se colocan los valores vacios
        $('#sceneValue').val('');
        $('#resourceValue').val('');

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
        audioSelected = $('#resourceValue').val(audioId);
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
                $("#tableContent").append(data);
                $('.btn-delete').unbind('click');
                $('.btn-delete').click(remove);
            });
            $('#modalWindow').css('display', 'none');
            $('#modalResource').css('display', 'none');
        }
    });
    
}); // Fin metodo ejecutado despues de cargar html