var modify = false;
var actId = 0;

$().ready(function(){
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
        sceneInfo(sceneId).done(function(result){
            $('#updateSceneName').val(result.name);
            $('#menuModalUpdateScene').css('display', 'block');
            $('#formUpdateScene').attr('action', routeEdit.replace('req_id', result.id));
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
            var top = mousey - posicion.top -12;
            var left = mousex - posicion.left -12;
            $('#zoneicon').css('top' , top);
            $('#zoneicon').css('left', left);
            $('#zoneicon').css('display', 'block');
            $('#top').attr('value', top);
            $('#left').attr('value', left);
            $('#menuModalAddScene').css('display', 'block');
        }else{
            //Si ya hay un icono, lo muevo
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var top = mousey - posicion.top -12;
            var left = mousex - posicion.left -12;
            $('#zoneicon').css('top' , top);
            $('#zoneicon').css('left', left);
            $('#top').attr('value', top);
            $('#left').attr('value', left);
        }
    });
});