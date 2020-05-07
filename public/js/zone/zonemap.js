$().ready(function(){
    $('.closeModalButton').click(function(){
        $('#modalWindow').hide();
        $('#map').hide();
    });
    $('.zoneImgForChange').click(function(){
        var idZone = ($(this).attr('id')).substr(4); //Id de la zona a mostrar
        //Recojo cada capa que contiene una zona
        var capasZonas = document.getElementsByClassName('addScene');
        //Recorro las capas para esconder la que está visible y mostrar a la cual se quiere acceder
        for(var i = 0; i < capasZonas.length; i++){
            var estado = capasZonas[i].style.display;
            if(estado == 'block'){
                capasZonas[i].style.display = 'none';
            }else {
                if(i+1 == parseInt(idZone)){
                    capasZonas[i].style.display = 'block';
                }
            }
        }
    });

    //MODIFICACIÓN EN LAS CLASES E IDS DE LOS MAPAS PARA QUE PUEDAN
    //SUBSISTIR VARIOS INCLUDES DEL MAPA EN UNA MISMA VISTA
    /* Todos los include deben ir dentro de un div con in id tipo 'mapa1', 'mapa2'...
    ** para poder añadir este mismo id como id de los botones de subir y bajar planta.
    ** De esta forma podemos usar los selectores de hijos que nos da JQuery para especificar
    ** que mapa es sobre el que tiene que actuar un botón concreto
     */
    var mapas = document.getElementsByClassName('oneMap');
    if(mapas.length > 1){
        for(var i = 0; i < mapas.length; i++){
            var idDelMapa = mapas[i].id;
            $('#' + idDelMapa + ' .floorUp').attr('id', idDelMapa);
            $('#' + idDelMapa + ' .floorDown').attr('id', idDelMapa);
            $('#' + idDelMapa + ' .addEscene').attr('value', idDelMapa);
        }
    }
    

    $('#floorUp, .floorUp').click(function(){
        var numMapa = $(this).attr('id');
        var actualZone = $('#'+ numMapa +' #actualZone').val();
        var totalZones = $('#'+ numMapa +' #totalZones').val();
        if(actualZone == totalZones){
            $('#'+ numMapa +' #actualZone').attr('value', totalZones);
            $('#'+ numMapa +' #zone'+actualZone).hide();
            $('#'+ numMapa +' #zone'+totalZones).show();
        }else{
            var newZone = (parseInt(actualZone) + 1);
            $('#'+ numMapa +' #actualZone').attr('value', newZone);
            $('#'+ numMapa +' #zone'+actualZone).hide();
            $('#'+ numMapa +' #zone'+newZone).show();
        }
    });

    $('#floorDown, .floorDown').click(function(){
        var numMapa = $(this).attr('id');
        var actualZone = $('#'+ numMapa +' #actualZone').val();
        var totalZones = $('#'+ numMapa +' #totalZones').val();
        if(actualZone == 1){
            $('#'+ numMapa +' #actualZone').attr('value', 1);
            $('#'+ numMapa +' #zone'+actualZone).hide();
            $('#'+ numMapa +' #zone1').show();
        }else{
            var newZone = (parseInt(actualZone) - 1);
            $('#'+ numMapa +' #actualZone').attr('value', newZone);
            $('#'+ numMapa +' #zone'+actualZone).hide();
            $('#'+ numMapa +' #zone'+newZone).show();
        }
    });

});