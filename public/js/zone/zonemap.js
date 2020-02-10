$().ready(function(){
    $('#closeModalButton').click(function(){
        $('#modalWindow').hide();
    });

    /* FUNCIÓN PARA CUANDO SE HAGA CLICK EN UNA ESCENA PARA SEÑALARLA COMO ESCENA DE DESTINO */
    $('.scenePoint').click(function(){
        var pointId = $(this).attr('id');
        var sceneId = parseInt(pointId.substr(5));
        getSceneDestination(sceneId).done(function(result){
            $('#modalWindow').hide();
            loadSceneDestination(result);
        });
    });
});