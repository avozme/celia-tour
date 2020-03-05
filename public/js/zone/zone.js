var modify = false;
var actId = 0;

$().ready(function(){
    $('.icon').on('load', function(){
        var t = $(this).attr('tp') / $('#addScene').innerHeight();
        var l = $(this).attr('lft') / $('#addScene').innerWidth();
        $(this).css('top', t + '%');
        $(this).css('left', l + '%');
        alert($(this).css('top'));
        alert($(this).css('left'));
    });

    $(".scenepoint").hover(function(){
        modify = true;
        $(this).attr('src', $('#urlhover').val());
    }, function(){
        $(this).attr('src', $('#url').val());
        modify = false;
    });
    /*FUNCION PARA MODIFICAR LA INFORMACIÓN DE UNA ESCENA*/
    $('.scenepoint').mouseup(function(){
        //Recojo el id del punto al que se ha hecho click
        var pointId = $(this).attr('id');
        //Escondo el punto que se muestra al hacer click en la capa de la zona
        $('#zoneicon').css('display', 'none');
        //Saco el id de la escena que corresponde a ese punto
        var sceneId = parseInt(pointId.substr(5));
        $('#editActualScene').attr('value', sceneId);
        var formAction = routeUpdate.replace('req_id', sceneId);
        $('#formUpdateScene').attr('action', formAction);
        $('#actualScene').attr('value', sceneId);
        sceneInfo(sceneId).done(function(result){
            $('#updateSceneName').val(result.name);
            $('#sceneId').val(result.id);
            $('#menuModalAddScene').hide();
            $('#menuModalUpdateScene').css('display', 'block');
        });
        /*FUNCIÓN PARA SACAR LA INFO DE LAS ESCENAS SECUNDARIAS*/
        s_sceneInfo(sceneId).done(function(result){
            console.log("llegue a la funcion para rellenar campos");
            var div = document.getElementById('infosscene');
            while (div.firstChild) {
                div.removeChild(div.firstChild);
            }
            console.log(result[0])
            for(var i=0; i<result.length; i++){
                $('#infosscene').append("<div><p>"+result[i].name+"</p>"+"<p>"+result[i].date+"</p>"+ "<button id="+result[i].id+" class='delete'>Eliminar</button> <button id="+result[i].id+" class='update'>Modificar</button> </div>");
            }
            $(".delete").click(function(){
            elementoD = $(this);
            id=elementoD.attr("id");
            console.log(elementoD)
            $('#confirmDelete').css('width', '20%');
            $('#modalWindow').show();
            $('#modalWindow:nth-child(2)').css('display', 'none');
            $('#confirmDelete').show();
            $("#aceptDelete").click(function(){
                $("#confirmDelete").css("display", "none");
                $("#modalWindow").css("display", "none"); 
                $.get('http://celia-tour.test/secondaryscenes/delete/'+id, function(respuesta){
                $(elementoD).parent().remove();
                $('.previewResource').empty();
            });
            });
            $("#cancelDelete").click(function(){
                $('#modalWindow').hide();
                $('#Sscene').hide();
                $('#upSscene').hide();
                $('#confirmDelete').hide();
            });
            });
            $(".update").click(open_update);
        });
        /*FUNCIÓN PARA ELIMINAR PUNTO Y ESCENA*/
        $('#deleteScene').click(function(){
            $('#confirmDelete').css('width', '20%');
            $('#modalWindow').show();
            $('#modalWindow:nth-child(2)').css('display', 'none');
            $('#confirmDelete').show();
            $('#aceptDelete').click(function(){
                deleteScenePoint($('#sceneId').val()).done(function(result){
                    $('#modalWindow').hide();
                    $('#confirmDelete').hide();
                    $('#pano').empty();
                    if(result){
                        $('#scene'+ $('#sceneId').val()).hide();
                        $('#menuModalUpdateScene').css('display', 'none');
                    }
                });
            });
            $('#cancelDelete').click(function(){
                $('#modalWindow').hide();
                $('#Sscene').hide();
                $('#upSscene').hide();
                $('#confirmDelete').hide();
            });
        });


        /* CERRAR VENTANA DE UPDATE */
        $('#closeMenuUpdateScene').click(function(){
            $('#menuModalUpdateScene').hide();
        });

        $('.closeModal').click(function(){
            $('#modalWindow').hide();
            $('#Sscene').hide();
            $('#upSscene').hide();
            $('#confirmDelete').hide();
        });
    });

    $('#editActualScene').click(function(){
        window.location.href = routeEdit.replace('id', $(this).attr('value'));
    });

    /* FUNCIÓN PARA AÑADIR PUNTO */
    $('#addScene').click(function(e){
        //Compruebo que no haya ya un icono puesto
        var iconoDisplay = $('#zoneicon').css('display');
        //Si no hay un icono, lo 'coloco'
        if(iconoDisplay == 'none' && !modify){
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var alto = (mousey - posicion.top); //posición en píxeles
            var ancho = (mousex - posicion.left); //posición en píxeles
            var top = ((alto - 12) * 100) / ($('#zoneimg').innerHeight());
            var left = ((ancho - 12) * 100) / ($('#zoneimg').innerWidth());
            $('#zoneicon').css('top' , top + "%");
            $('#zoneicon').css('left', left + "%");
            $('#zoneicon').css('display', 'block');
            $('#top').attr('value', top);
            $('#left').attr('value', left);
            $('#menuModalUpdateScene').css('display', 'none');
            $('#menuModalAddScene').css('display', 'block');
        }else{
            //Si ya hay un icono, lo muevo
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var alto = (mousey - posicion.top); //posición en píxeles
            var ancho = (mousex - posicion.left); //posición en píxeles
            var top = ((alto - 12) * 100) / ($('#zoneimg').innerHeight());
            var left = ((ancho - 12) * 100) / ($('#zoneimg').innerWidth());
            $('#zoneicon').css('top' , top + "%");
            $('#zoneicon').css('left', left + "%");
            $('#top').attr('value', top);
            $('#left').attr('value', left);
        }
    });

});

    //FUNCIÓN PARA ABRIR LA MODAL DE MODIFICAR ESCENA SECUNDARIA
    function open_update(){
        var s_scenId = $(this).attr('id');
        console.log(s_scenId);
        seconInfo(s_scenId).done(function(result){
            loadScene(result, 0);
            $('#upSceneName').val(result.name);
            $('#upSceneDate').val(result.date);
            $('#ids').val(s_scenId);
        }).fail(function(){
            alert("Falle")
        });
        $("#modalWindow").css("display", "block");
        $("#upSscene").css("display", "block");
    }

