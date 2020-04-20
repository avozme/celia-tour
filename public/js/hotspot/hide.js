
function hide(idHotspot){
    getHotspotInfo(idHotspot).done(function(result){
        var hotspot = result['hotspot'];
        
    })
    $('#contentHotspot').append(
        "<div style='' class='hideHotspot hotspotElement hots"+ idHotspot +"' value='"+ idHotspot +"'></div>"
    );
}

$().ready(function(){
    $('#addHideButton').click(function(){
        $('#pano').mousedown(function(e){
            var view = viewer.view();
            var yaw = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).yaw;
            var pitch = view.screenToCoordinates({x: e.clientX, y: e.clientY,}).pitch;
            console.log('pitch: ' + pitch + "\nYaw: " + yaw);
            $('#drawHide').css('display', 'block');
            //Saco coordenadas de posicionamiento de la capa
            var drawHide = document.getElementById("drawHide");
            var posicion = drawHide.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var alto = (mousey - posicion.top);
            var ancho = (mousex - posicion.left);
            var topInicio = ((alto * 100) / ($('#pano').innerHeight()));
            var leftInicio = ((ancho * 100) / ($('#pano').innerWidth()));
            $('#preHide').css('top', topInicio + "%");
            $('#preHide').css('left', leftInicio + "%");
            $('#preHide').css('border', '1.5px solid #8500FF');
            $('#drawHide').mousemove(function(event){
                var mousex = event.clientX;
                var mousey = event.clientY;
                var alto = (mousey - posicion.top);
                var ancho = (mousex - posicion.left);
                var topFinal = ((alto * 100) / $('#pano').innerHeight());
                var leftFinal = ((ancho * 100) / $('#pano').innerWidth());
                var ancho = leftFinal - leftInicio;
                var alto = topFinal - topInicio;
                document.getElementById('preHide').style.width = ancho + "%";
                document.getElementById('preHide').style.height = alto + "%";
                $('#drawHide').click(function(ev){
                    saveHotspot('Hide', 'Descripción', pitch, yaw, 6);
                    $('#drawHide').hide();

                });
            });
        });
    });
//Fin del ready
});