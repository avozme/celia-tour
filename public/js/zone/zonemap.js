$().ready(function(){
    $('.closeModalButton').click(function(){
        $('#modalWindow').hide();
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

});