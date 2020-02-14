$(function() {

    // Boton que elimina una fila

    function remove(){
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
            var direccion = "http://celia-tour.test/guidedVisit/delete/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
    }

    // Abre la modal y prepara la ventana
    function update(){
        $('#modalWindow').css('display', 'block');
        $('#updateGuidedVisit').css('display', 'block');

        // Se coloca el action con la ruta correctamente
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        var url = 'http://celia-tour.test/guidedVisit/'+id;
        $('#formUpdate').attr('action', url);
    }

    // Eventos iniciales ------------------------------------
    // Boton delete
    $(".btn-delete").click(remove);

    // Boton update
    $('.btn-update').click(update)

    // Muestra la ventana modal y el formulario para insertar una visita guiada
    $('#btn-add').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#newGuidedVisit').css('display', 'block');
    })

    $('#acept').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formadd input[name="_token"]').val());
        dataForm.append('name', $('#nameValue').val());
        dataForm.append('description', $('#descriptionValue').val());
        dataForm.append('file_preview', $('#fileValue')[0].files[0]);

        $.ajax({
            url: $("#formadd").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){
            $("#tableContent").append(data);
            $('#modalWindow').css('display', 'none'); 
            $('#newGuidedVisit').css('display', 'none');
            console.log($(this).children('#btn-update'));
            console.log($('#btn-update'));
        })

    }); // Fin boton acept






}); // Fin metodo ejecutado despues de cargar html