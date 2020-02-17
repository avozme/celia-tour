$(function() {
    	$('#newportkey').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalportkey').css('display', 'block');
    })
    
    $('.newportkeyedit').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalportkeyedit').css('display', 'block');
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        var direccion = "http://celia-tour.test/portkey/"+id;
        var url = "http://celia-tour.test/portkey/portkeyScene/"+id;
        var direccionscene = "window.location.href='"+url+"'";
        var volver = "http://celia-tour.test/portkey/";
        $('#modificarportkey').attr("action", direccion);
        $('#portkeyscene').attr("onclick", direccionscene);
        $('#volver').attr("onclick", volver);
        
    })
    

    // Boton que elimina una fila
    $(".deleteportkey").click(function(){
        var isDelte = confirm("¿Desea eliminar esta visita guiada?");
        if(isDelte){
            var domElement = $(this).parent().parent();
            var id = $(domElement).attr("id");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){ 
                    if (xhttp.responseText == 1) {
                        $(domElement).fadeOut(500, function(){
                            $(domElement).remove();
                        });
                    } else {
                        alert("Algo fallo!");
                    }
                }
            }
            var direccion = "http://celia-tour.test/portkey/delete/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
    }); // Fin boton eliminar
})