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
            $('#top').attr('value', result.top);
            $('left').attr('value', result.left);
            $('#menuModalAddScene').hide();
            $('#menuModalUpdateScene').css('display', 'block');
        });
        /*FUNCIÓN PARA SACAR LA INFO DE LAS ESCENAS SECUNDARIAS*/
        s_sceneInfo(sceneId).done(function(result){
            var div = document.getElementById('infosscene');
            while (div.firstChild) {
                div.removeChild(div.firstChild);
            }
            for(var i=0; i<result.length; i++){
                var url = routeEditSecondart.replace("id", result[i].id);
                $('#infosscene').append("<div><p>"+result[i].name+"</p>"+
                "<p>"+result[i].date+"</p>"+
                "<button id="+result[i].id+" class='delete'>Eliminar</button>"+
                "<button id="+result[i].id+" class='update'>Modificar</button> </div>"+
                "<a href='"+url+"'><button class='bBlack'>Editar Hotspots</button></a></div>");
            }
            $(".delete").click(function(){
                elementoD = $(this);
                id=elementoD.attr("id");
                $('#confirmDelete').css('width', '20%');
                $('#modalWindow').show();
                $('#modalWindow:nth-child(2)').css('display', 'none');
                $('#confirmDelete').show();
                $("#aceptDelete").click(function(){
                    $("#confirmDelete").css("display", "none");
                    $("#modalWindow").css("display", "none"); 
                    $.get(direccion+'/secondaryscenes/delete/'+id, function(respuesta){
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
            //Recupero el id de la escena para hacer las comprobaciones
            var sceneId = $('#editActualScene').attr('value');
            //Compruebo que la escena no tenga hotspots
            checkHotspot(sceneId).done(function(result){
                //Si no tiene hotspots
                if(result['num'] == 0){
                    //Compruebo que no tenga escenas secundarias
                    checkSecondaryScenes(sceneId).done(function(result){
                        //si no tiene escenas secundarias
                        if(result['num'] == 0){
                            //Modifico el tamaño de la modal a mostrar
                            $('#confirmDelete').css('width', '20%');
                            $('#modalWindow').show();
                            $('#modalWindow:nth-child(2)').css('display', 'none');
                            //Muestro la modal de confirmación
                            $('#confirmDelete').show();
                            //Click del botón de aceptar borrar escena
                            $('#aceptDelete').click(function(){
                                //Ejecuto la función de eliminar escena
                                deleteScenePoint($('#sceneId').val()).done(function(result){
                                    //Escondo la modal
                                    $('#modalWindow').hide();
                                    $('#confirmDelete').hide();
                                    //Si se ha borrado correctamente
                                    if(result){
                                        //Vacío la capa donde se muestra la previsualización de la escena eliminada
                                        $('#pano').empty();
                                        //Escondo el punto de la escena eliminada
                                        $('#scene'+ $('#sceneId').val()).hide();
                                        //Escondo el menú de modificación de escena
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
                        //Si tiene escenas secundarias
                        }else{
                            //Ajusto el tamaño de la modal de información y la muestro
                            $('#cancelDeleteSs').css('width', '40%');
                            $('#modalWindow').css('display', 'block');
                            $('#cancelDeleteSs').css('display', 'block');
                        }
                    });
                //Si tiene hotspots
                }else{
                    //Ajusto el tamaño de la modal de información y la muestro
                    $('#cancelDeleteHotspots').css('width', '40%');
                    $('#modalWindow').css('display', 'block');
                    $('#cancelDeleteHotspots').css('display', 'block');
                }
            });
        });

        //Click del botón Aceptar de las modales de información
        $('#aceptCondition').click(function(){
            $('#modalWindow').hide();
            $('#cancelDeleteSs').hide();
            $('#cancelDeleteHotspots').hide();
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
            var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
            var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
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
            var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
            var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
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
        seconInfo(s_scenId).done(function(result){
            loadScene(result, 0);
            $('#upSceneName').val(result.name);
            $('#upSceneDate').val(result.date);
            $('#ids').val(s_scenId);
        }).fail(function(){
            // alert("Hay un problema ");
        });
        $("#modalWindow").css("display", "block");
        $("#upSscene").css("display", "block");
    }

