$(function() {

    // Boton que elimina una fila
    $(".btn-delete").click(function(){
        var isDelte = confirm("¿Desea eliminar esta visita guiada?");
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
            var direccion = "http://celia-tour.test/guidedVisit/delete/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
    }); // Fin boton eliminar

    $('#add-guided-visit').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modal-visit-guided').css('display', 'block');
    })


}); // Fin metodo ejecutado despues de cargar html