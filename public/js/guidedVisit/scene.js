$(function() { 

    //----------------------------------------------------  Elimina fila  --------------------------------------------------------------------------
    $(".btn-delete").click(function(){
    var isDelte = confirm("¿Desea eliminar la escena de la visita guiada?");
        if(isDelte){
            var domElement = $(this);
            var id = $(this).attr("id");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){ 
                    if (xhttp.responseText == 1) {
                        $(domElement.parent().parent()).fadeOut(500, function(){
                            $(domElement).parent().parent().remove();
                        });
                    } else {
                        alert("Algo fallo!");
                    }
                }
            }
            var direccion = "http://celia-tour.test/guidedVisit/deleteScenes/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
    });

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


    //----------------------------------------------------  Ventanas modales  --------------------------------------------------------------------------

    $('#showModal').click(function(){
        //Muestro la imagen de la zona en el mapa
        $('#modalWindow').css('display', 'block');
    });

    // Al clicar en un punto de escena, guardara el id de la escena en un input hidden y cierra la modal
    $(".scenepoint").click(function(){ 
        var pointId = $(this).attr("id");
        var sceneId = parseInt(pointId.substr(5))
        $("#sceneValue").val(sceneId);
        $('#modalZone').css('display', 'none');
        $('#modalResource').css('display', 'block');
    });

}); // Fin metodo ejecutado despues de cargar html