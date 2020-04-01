var sceneSelected = 0;
var previsualizacion = 0;
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
        var direccion = ruta+"/portkey/"+id;
        $('#modificarportkey').attr("action", direccion);       
    });
        
    

    function borrar(){
        var isDelte = confirm("¿Desea eliminar este portkey?");
        if(isDelte){
            var URLactual = $(location).attr('href'); 
            var domElement = $(this).parent().parent();
            var id = $(domElement).attr("id");
            var hidePano = document.getElementById("pano");
            var direccion = URLactual +"/delete/"+id;
        $.get(direccion, function(){
            $(domElement).fadeOut(500, function(){
                if(previsualizacion == id){
                    hidePano.style.display = "none";
                    hidePano.innerHTML="";
                    previsualizacion = 0;
                }                
                $(domElement).remove();
            });
        });
        }
     }

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
                $("#tableContent").append( `
                <tr id=${data.scene.id}>
                    <td class="col60">${data.scene.name}</td> 
                    <td class="col20 sPaddingRight"><button id="${data.scene.id}" class="prueba col100"> Previsualizar </button></td>
                    <td class="col20 sPaddingLeft"><button class="deleteScene deleteportkeyscene delete col100"> Eliminar </button></td>
                </tr>`);
                $(".prueba").click(function(){
                    var id = $(this).attr("id");
                    previsualizacion = id;
                    sceneInfo(id).done(function(result){
                        loadScene(result);
                    });
                    $("#pano").css("display","block");
                    
                });
            $('#modalWindow').css('display', 'none'); 
            $('#modalportkey').css('display', 'none');
            $('.deleteScene').unbind('click');
            $(".deleteScene").click(borrar);
            });
            $('#modalWindow').css('display', 'none');
            $('#modalResource').css('display', 'none');
        }
    });

    // Boton aceptar para escenas
    $('#aceptscene').click(function(){
        if(sceneSelected == 0){
            alert('Escena sin seleccionar');
        } else {
            $.post($("#addsgv").attr('action'), {
                _token: $('#addsgv input[name="_token"]').val(),
                scene: $('#sceneValue').val(), 
            }).done(function(data){
                $("#tableContent").append( `
                <tr id=${data.scene.id} class="tabla">
                    <td class="col25">${data.scene.name}</td>
                    <td class="col25">${data.zone.name}</td>
                    <td class="col25 sPaddingRight"><button id="${data.scene.id}" class="prueba col100"> Previsualizar </button></td>
                    <td class="col25 sPaddingLeft"><button id="${data.scene.id}" class="deleteportkeyscene delete col100"> Eliminar </button></td>
                </tr>`);
                $(".prueba").click(function(){
                    var id = $(this).attr("id");
                    previsualizacion = id;
                    sceneInfo(id).done(function(result){
                        loadScene(result);
                    });
                    $(".tabla").css('color','black');
                    $("#"+id).css("color", "blue");
                    $("#pano").css("display","block");
                   
                });
            $('#modalWindow').css('display', 'none'); 
            $('#modalportkey').css('display', 'none');
            $('.deleteportkeyscene').unbind('click');
            $(".deleteportkeyscene").click(borrarEscena);
            });
            $('#modalWindow').css('display', 'none');
            $('#modalResource').css('display', 'none');
        }
    });

    //FUNCIÓN PARA ELIMINAR A TRAVÉS DE AJAX
    //.delete es el nombre de la clase
    //peticion_http es el objeto que creamos de Ajax
    $(".deleteportkey").click(function(){
        id = $(this).attr("id");
        elementoD = $(this);
        var direccion = ruta+"/portkey/delete/"+id;
            $("#modalWindow").css("display", "block");
            $("#confirmDelete").css("display", "block");
            $("#aceptDelete").click(function(){
                $("#confirmDelete").css("display", "none");
                $("#modalWindow").css("display", "none");
                $.get(direccion, function(data){
                    // Boton que elimina una fila de la tabla
                    if(data.error){
                        alert('El traslador no puede ser eliminado mientras tenga escenas asignadas.')
                    } else {
                        $(elementoD).parent().parent().remove();
                    }
                });
            });
            $("#cancelDelete").click(function(){
                $("#confirmDelete").css("display", "none");
                $("#modalWindow").css("display", "none");
            });
        });

    //FUNCIÓN PARA ELIMINAR ESCENAS DEL PORTKEY A TRAVÉS DE AJAX
    //.delete es el nombre de la clase
    //peticion_http es el objeto que creamos de Ajax
    function borrarEscena(){
        var URLactual = $(location).attr('href'); 
        id = $(this).attr("id");
        elementoD = $(this);
        var hidePano = document.getElementById("pano");
        var direccion = URLactual +"/delete/"+id;        
            $("#modalWindow").css("display", "block");
            $("#confirmDelete").css("display", "block");
            $("#aceptDelete").click(function(){
                $("#confirmDelete").css("display", "none");
                $("#modalWindow").css("display", "none");
                $.get(direccion, function(){
                        if(previsualizacion == id){
                            hidePano.style.display = "none";
                            hidePano.innerHTML="";
                            previsualizacion = 0;
                        }                
                        $(elementoD).parent().parent().remove();   
                });
            });
            $("#cancelDelete").click(function(){
                $("#confirmDelete").css("display", "none");
                $("#modalWindow").css("display", "none");
            });
    }

    // Boton que elimina un portkey
    // $(".deleteportkey").click(function(){
    //     var isDelte = confirm("¿Desea eliminar este portkey?");
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
    //         var direccion = ruta+"/portkey/delete/"+id;
    //         xhttp.open("GET", direccion, true);
    //         xhttp.send();
    //     }
    // });
     
    $(".deleteScene").click(borrar); // Fin boton eliminar
    $(".deleteportkeyscene").click(borrarEscena); // Fin boton eliminar


    // Cierra la modal y todos los contenidos
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $('#modalportkey').css('display', 'none');
        $('#modalportkeyedit').css('display', 'none');
        $('#confirmDelete').css('display', 'none');
        $('#deleteportkeyscene').css('display', 'none');
    }
    $(".closeModal").click(closeModal);

    // Abre la modal para eliminar un recurso
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDelete').css('display', 'block');
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        $('#aceptDelete').unbind('click');
        $('#aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
    }

    //CÓDIGO PARA QUE LAS MODALES SE CIERREN AL PINCHAR FUERA DE ELLAS
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
        }
    });
    
});

