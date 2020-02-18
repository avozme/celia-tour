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
        //console.log($(this).attr('id'));
        //Recojo el id del punto al que se ha hecho click
        var pointId = $(this).attr('id');
        //Escondo el punto que se muestra al hacer click en la capa de la zona
        $('#zoneicon').css('display', 'none');
        //Saco el id de la escena que corresponde a ese punto
        var sceneId = parseInt(pointId.substr(5));
        $('#actualScene').attr('value', sceneId);
        sceneInfo(sceneId).done(function(result){
            //loadScene(result);
            $('#showScene').show();
            $('#updateSceneName').val(result.name);
            $('#sceneId').val(result.id);
            $('#menuModalAddScene').hide();
            $('#menuModalUpdateScene').css('display', 'block');
            $('#formUpdateScene').attr('action', routeEdit.replace('req_id', result.id));
            //alert(result.id + '\n' + result.pitch + '\n' + result.yaw);
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
            $(".delete").click(remove);
            $(".update").click(open_update);
        });
        /*FUNCIÓN PARA ELIMINAR PUNTO Y ESCENA*/
        $('#deleteScene').click(function(){
            deleteScenePoint($('#sceneId').val()).done(function(result){
                if(result){
                    $('#scene'+ $('#sceneId').val()).hide();
                    $('#menuModalUpdateScene').css('display', 'block');
                }
            });
        });
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
            var top = (alto * 100) / ($('#zoneimg').innerHeight());
            var left = (ancho * 100) / ($('#zoneimg').innerWidth());
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
            var top = (alto * 100) / ($('#zoneimg').innerHeight());
            var left = (ancho * 100) / ($('#zoneimg').innerWidth());
            $('#zoneicon').css('top' , top + "%");
            $('#zoneicon').css('left', left + "%");
            $('#top').attr('value', top);
            $('#left').attr('value', left);
        }
    });
});

        //FUNCIÓN PARA ELIMINAR A TRAVÉS DE AJAX
        function remove(){
            console.log("Estoy llegando a la función de borrar")
            id = $(this).attr("id");
            elementoD = $(this);
            var confirmacion = confirm("¿Esta seguro de que desea eliminarlo?")
            if(confirmacion){
                $.get('http://celia-tour.test/secondaryscenes/delete/'+id, function(respuesta){
                $(elementoD).parent().remove();
            });
        }
    }

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

