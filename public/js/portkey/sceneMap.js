var modify = false; // Permite saber si se va a modificar o añadir una escena
var idPortkeyScene = 0; // Permite saber que escena se esta modificando
var dataScene = undefined; // Datos de la escena a modificar

$(function() {

    // CAMBIA EL ICONO DE LA ESCENA
    function inside(){
        modify = true;
        $(this).attr('src', urlResourceZones + "icon-zone-hover.png");
    }

    function outside(){
        $(this).attr('src', urlResourceZones + "icon-zone.png");
        modify = false;
    }

    function toggleImage(icon){
        var src = $(icon).attr('src');
        var compare = urlResourceZones + "icon-zone.png";
        console.log(src);
        console.log(compare);
        if(src == compare){
            $(icon).attr('src', urlResourceZones + "icon-zone.png");
            console.log("True");
        } else {
            $(icon).attr('src', urlResourceZones + "icon-zone-hover.png");
            console.log("False");
        }
    }

    // --------------------------------- INSERCION DE ESCENAS -------------------------------------

    // FUNCIÓN PARA AÑADIR PUNTO AL MAPA
    function addScene(e){

        // Restaura la posicion de la ultima escena modificada.
        restorePosition();

        //Compruebo que no haya ya un icono puesto
        var iconoDisplay = $('#zoneicon').css('display');
        //Si no hay un icono, lo 'coloco'
        if(!modify) {
            closeForms();
            
            if(idPortkeyScene != 0){
                $(`#scene${idPortkeyScene}`).attr('src', urlResourceZones + "icon-zone.png")
                idPortkeyScene = 0;
            }

            if(iconoDisplay == 'none'){
                var capa = document.getElementById("addScene");
                var posicion = capa.getBoundingClientRect();
                var mousex = e.clientX;
                var mousey = e.clientY;
                var alto = (mousey - posicion.top); //posición en píxeles
                var ancho = (mousex - posicion.left); //posición en píxeles
                var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
                var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
                $('#zoneicon').css('top' , top + "%");
                $('#zoneicon').css('left', left + "%");
                $('#zoneicon').css('display', 'block');
                $('#formAddScene input[name="top"]').val(top);
                $('#formAddScene input[name="left"]').val(left);
                $('.menuUpdateScene').css('display', 'none');
                $('#menuAddScene').css('display', 'block');
            }else{
                //Si ya hay un icono, lo muevo
                var capa = document.getElementById("addScene");
                var posicion = capa.getBoundingClientRect();
                var mousex = e.clientX;
                var mousey = e.clientY;
                var alto = (mousey - posicion.top); //posición en píxeles
                var ancho = (mousex - posicion.left); //posición en píxeles
                var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
                var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
                $('#zoneicon').css('top' , top + "%");
                $('#zoneicon').css('left', left + "%");
                $('#formAddScene input[name="top"]').val(top);
                $('#formAddScene input[name="left"]').val(left);
                $('.menuUpdateScene').css('display', 'none');
                $('#menuAddScene').css('display', 'block');
            }
        }
    }

    // MUESTRA EL MAPA DE ESCENAS PARA INSERTAR
    $('#selectSceneInsert').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalZone').css('display', 'block');
        
        // SELECCIONA LA ESCENA
        $("#zoneImage .scenepoint").click(function(){ 
            var pointId = $(this).attr("id");
            var sceneId = parseInt(pointId.substr(5))
            $("#formAddScene input[name='scene']").val(sceneId);
            sceneInfo(sceneId).done(function(result){
                loadScene(result, $('#panoInsert')[0]);
            });
            // Muestra el div de la previsualizacion y lo vacia por si ya tenia una cargada
            $('#panoInsert').css('display', 'block');
            $('#saveSceneInsert').css('display', 'block');
            $('#panoInsert').empty();
            closeModal();
            $("#zoneImage .scenepoint").unbind();
        });
    });

    // GUARDA LA ESCENA
    $('#saveSceneInsert').click(function(){
        $.post($("#formAddScene").attr('action'), {
            _token: $('#formAddScene input[name="_token"]').val(),
            scene: $('#formAddScene input[name="scene"]').val(),
            top: $('#formAddScene input[name="top"]').val(),
            left: $('#formAddScene input[name="left"]').val(),
            map: true
        }).done(function(data){
            closeForms();

            var newPortkeyScene = "scene" + data.portkey_scene.id;
            var newTop = data.portkey_scene.top;
            var newLeft = data.portkey_scene.left;
            var content = `
                <div class="icon iconHover" style="top: ${newTop}%; left: ${newLeft}%">
                    <img id="${newPortkeyScene}" class="scenepoint" src="${urlResourceZones + "icon-zone.png"}" alt="icon" width="100%">
                </div>`
            $("#addScene").append(content);
            
            // Pone los campos vacios
            $('.previewPortkeyMap').empty();
            $('.previewPortkeyMap').css('display', 'none');
            $('#formAddScene input[name="scene"]').val('');
            $('#formAddScene input[name="top"]').val('');
            $('#formAddScene input[name="left"]').val('');

            // Esconde el icono de nueva escena
            $('#zoneicon').css('display', 'none');

            // Esconde el boton borrar
            $('#saveSceneInsert').css('display', 'none');

            // Reasigna los eventos
            asignEvents();

            alert("Escena guardada.");

        }).fail(function(data){
            alert("Ocurrio un error al guardar la escena.")
            console.log(data);
        });
    });




    // ------------------------------------------- MODIFICACION DE ESCENAS -------------------------------------------

    // ABRE LA VENTANA PARA MODIFICAR E INSERTA LOS CAMPOS DE LA ESCENA
    function updateScene(){
        closeForms();
        $('#zoneicon').css('display', 'none'); // Esconde el icono de la nueva escena
        $('#panoUpdate').empty(); // Limpia la previsualizacion 360 cargada en el div

        // Se obtiene el id de la escena
        var pointId = $(this).attr("id");
        var portkeyScene = parseInt(pointId.substr(5))
        idPortkeyScene = portkeyScene;

        // Se obtienen los datos de la escena y se agregan al formulario
        var address = urlgetPortkeyScene.replace('insertIdHere', portkeyScene);

        $.get(address, function(data){
            // Carga la escena
            sceneInfo(data.scene_id).done(function(result){
                loadScene(result, $("#panoUpdate")[0]);
                $("#panoUpdate").css("display", "block");
            });
            
            // Actualiza los datos del formulario
            var formAddress = urlupdatePortkeyScene.replace('insertIdHere', data.id);
            $('#formUpdateScene').attr('action', formAddress)
            $('#formUpdateScene input[name="scene"]').val(data.scene_id);
            $('#formUpdateScene input[name="top"]').val(data.top);
            $('#formUpdateScene input[name="left"]').val(data.left);

            dataScene = data;
        }).fail(function(data){
            alert("No se pudo cargar los datos de esta escena.")
        })
        
        $('#menuUpdateScene').css('display', 'block');
    }

    // MUESTRA EL MAPA DE ESCENAS PARA ACTUALIZAR
    $('#selectSceneUpdate').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalZone').css('display', 'block');
        // SELECCIONA LA ESCENA
        $("#zoneImage .scenepoint").click(function(){ 
            var pointId = $(this).attr("id");
            var sceneId = parseInt(pointId.substr(5))
            $("#formUpdateScene input[name='scene']").val(sceneId);
            sceneInfo(sceneId).done(function(result){
                loadScene(result, $('#panoUpdate')[0]);
                $("#panoUpdate").css("display", "block");
            });
            // Vacia el div de previsualizar por si ya habia alguno cargado.
            $('#panoUpdate').empty();
            closeModal();
            $("#zoneImage .scenepoint").unbind();
        });
    });

    // ACTUALIZA LA ESCENA
    $('#saveSceneUpdate').click(function(){
        $.post($("#formUpdateScene").attr('action'), {
            _token: $('#formUpdateScene input[name="_token"]').val(),
            scene: $('#formUpdateScene input[name="scene"]').val(),
            top: $('#formUpdateScene input[name="top"]').val(),
            left: $('#formUpdateScene input[name="left"]').val(),
        }).done(function(data){
            dataScene = data;
            alert("Escena actualizada.");
        }).fail(function(data){
            alert("Ocurrio un error al actualizar la escena.");
            console.log(data);
        });
    })

    /* PERMITE MODIFICAR LA POSICION DE UN PUNTO */
    $('#changePosition').click(function(){
        if($('#changePosition').prop('checked')) {
            $('#addScene').unbind();
            $('#zoneMap .scenepoint').unbind();
            $('#addScene').bind("click", function(e){
                $('#zoneicon').hide();
                var capa = document.getElementById("addScene");
                var posicion = capa.getBoundingClientRect();
                var mousex = e.clientX;
                var mousey = e.clientY;
                var alto = (mousey - posicion.top); //posición en píxeles
                var ancho = (mousex - posicion.left); //posición en píxeles
                var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
                var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
                $('#scene'+idPortkeyScene).parent().css('top', top + "%");
                $('#scene'+idPortkeyScene).parent().css('left', left + "%");
                $('#formUpdateScene input[name="top"]').val(top);
                $('#formUpdateScene input[name="left"]').val(left);
            })
        } else {
            // Devuelve el evento a insertar escena
            asignEvents();
        }
    });

    // ------------------------------------------- ELIMINAR ESCENAS -------------------------------------------

    // ABRE LA MODAL DE CONFIRMACION PARA ELIMINAR
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDelete').css('display', 'block');
        var id = dataScene.id;
        $('#aceptDelete').unbind('click');
        $('#aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
    }

    // ELIMINA UNA ESCENA
    function remove(id){
        var address = urldeletePortkeyScene.replace('insertIdHere', id);
        $.get(address, function(){
            var element = $(`#scene${id}`).parent();
            $(element).remove();
            closeForms();
            dataScene = undefined;
        })
    }

    // RESTAURA LA ESCENA A SU POSICION INICIAL
    function restorePosition(){
        if(typeof dataScene != "undefined"){
            var element = $(`#scene${dataScene.id}`).parent();
            $(element).css('top', dataScene.top + "%");
            $(element).css('left', dataScene.left + "%");
        }
    }

    // ESCONDE LOS FORMULARIOS
    function closeForms(){
        $('#menuAddScene').css('display', 'none');
        $('#menuUpdateScene').css('display', 'none');
        $('#confirmDelete').css('display', 'none');
    }

    // CIERRA LA MODAL
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $('#modalZone').css('display', 'none');
    }

    // REASIGNA LOS EVENTOS
    function asignEvents(){
        // Quita los eventos
        $('#zoneMap .scenepoint').unbind();
        $('#addScene').unbind();

        // Asigna los eventos
        $('#zoneMap .scenepoint').mouseup(updateScene);
        $("#zoneMap .scenepoint").hover(inside, outside);
        $('#addScene').click(addScene);
        
    }

    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $('#zoneMap .scenepoint').mouseup(updateScene);
    $('#addScene').click(addScene);
    $("#zoneMap .scenepoint").hover(inside, outside);
    $('#deleteScene').click(openDelete);
    $('#cancelDelete').click(closeModal);
});