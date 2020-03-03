var sceneSelected = 0;

$(function() {
    	$('#newportkey').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalportkey').css('display', 'block');
    })
    
    $('.newportkeyedit').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalportkeyedit').css('display', 'block');

        $('#fileValueUpdate').val('');

        var url = $(this).attr('data-openupdateurl');
        $.get( url, function( data ) {
            // Actualiza los campos
            $('#nameValueUpdate').val(data.name);
        });
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        var direccion = "http://celia-tour.test/portkey/"+id;
        var url = "http://celia-tour.test/portkey/portkeyScene/"+id;
        var direccionscene = "window.location.href='"+url+"'";
        $('#modificarportkey').attr("action", direccion);
        $('#portkeyscene').attr("onclick", direccionscene);        
    });

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
        sceneSelected = 1;
        var pointId = $(this).attr("id");
        var sceneId = parseInt(pointId.substr(5))
        $("#sceneValue").val(sceneId);
        $('#modalZone').css('display', 'none');
        $('#modalResource').css('display', 'block');
    });

    // Boton aceptar
    $('#acept').click(function(){
        if(sceneSelected == 0){
            alert('Escena sin seleccionar');
        } else {
            $.post($("#addsgv").attr('action'), {
                _token: $('#addsgv input[name="_token"]').val(),
                scene: $('#sceneValue').val(), 
            }).done(function(data){
                var element = `
                <tr id=${data.scene.id}>
                <td>${data.portkey.name}</td>
                <td>${data.scene.name}</td> 
				<td><button class="newportkeyedit"> Previsualizar </button></td>
				<td><button class="deleteportkey"> Eliminar </button></td>
			</tr>`;
            $("#tableContent").append(element);
             $('#modalWindow').css('display', 'none'); 
            $('#modalportkey').css('display', 'none');
            // $('.btn-update').unbind('click');
            // $('.btn-delete').unbind('click');
            // $('.btn-update').click(openUpdate);
            // $('.btn-delete').click(remove);
            });
            $('#modalWindow').css('display', 'none');
            $('#modalResource').css('display', 'none');
        }
    });

    

    // Boton que elimina un portkey
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

    //  // Boton que elimina una escena
    //  $(".deleteScene").click(function(){
    //     var isDelte = confirm("¿Desea eliminar esta visita guiada?");
    //     if(isDelte){
    //         var domElement = $(this).parent().parent();
    //         var id = $(domElement).attr("id");
    //         var xhttp = new XMLHttpRequest();
    //         xhttp.onreadystatechange = function(){
    //             if(this.readyState == 4 && this.status == 200){ 
    //                 if (xhttp.responseText == 1) {
    //                     $(domElement).fadeOut(500, function(){
    //                         $(domElement).remove();
    //                     });
    //                 } else {
    //                     alert("Algo fallo!");
    //                 }
    //             }
    //         }
    //         var direccion = "http://celia-tour.test/portkey/portkeyScene/delete/"+id;
    //         xhttp.open("GET", direccion, true);
    //         xhttp.send();
    //     }
    // }); // Fin boton eliminar

    $(".deleteScene").click(function(){

        var isDelte = confirm("¿Desea eliminar esta visita guiada?");
        if(isDelte){
            var URLactual = $(location).attr('href'); 
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
            // var direccion = "http://celia-tour.test/portkey/portkeyScene/delete/"+id;
            // xhttp.open("GET", direccion, true);
            // xhttp.send();
            var direccion = URLactual +"/delete/"+id;
        $.get(direccion, function(){
            $(domElement).fadeOut(500, function(){
                $(domElement).remove();
            });
        });
        }
    }); // Fin boton eliminar

    //  // Abre la modal y prepara la ventana
    //  function openUpdate(){

    //     $('#fileValueUpdate').val('');

    //     var url = $(this).attr('data-openupdateurl');
    //     $.get( url, function( data ) {
    //         // Actualiza los campos
    //         $('#nameValueUpdate').val(data.name);

    //         $('#modalWindow').css('display', 'block');
    //         $('#updateGuidedVisit').css('display', 'block');
    //       });

    //     // Se coloca el action con la ruta correctamente
    //     var domElement = $(this).parent().parent();
    //     var id = $(domElement).attr("id");
    //     var url = 'http://celia-tour.test/guidedVisit/'+id;
    //     $('#formUpdate').attr('action', url);
    // }
})