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
            //console.log(estado);
            if(estado == 'block'){
                capasZonas[i].style.display = 'none';
            }else {
                if(i+1 == parseInt(idZone)){
                    capasZonas[i].style.display = 'block';
                }
            }
        }
    });

    $('#floorUp').click(function(){
        var actualZone = $('#actualZone').val();
        var totalZones = $('#totalZones').val();
        if(actualZone == 1){
            $('#actualZone').attr('value', totalZones);
            $('#zone'+actualZone).hide();
            $('#zone'+totalZones).show();
        }else{
            var newZone = actualZone - 1;
            $('#actualZone').attr('value', newZone);
            $('#zone'+actualZone).hide();
            $('#zone'+newZone).show();
        }
    });

    $('#floorDown').click(function(){
        var actualZone = $('#actualZone').val();
        var totalZones = $('#totalZones').val();
        if(actualZone == totalZones){
            $('#actualZone').attr('value', 1);
            $('#zone'+actualZone).hide();
            $('#zone1').show();
        }else{
            var newZone = actualZone + 1;
            $('#actualZone').attr('value', newZone);
            $('#zone'+actualZone).hide();
            $('#zone'+newZone).show();
        }
    });

});