
function loadHide(idHotspot){
    $('#contentHotSpot').append(
        "<div id='iframespot' class='hots"+ idHotspot +" hotspotElement'>"+
            "<div style='border: 2px solid black; position: absolute' class='message hideHotspot' value='"+ idHotspot +"'></div>" + 
        "</div>"
    );
    getHideInfo(idHotspot).done(function(result){
        var hide = result['hide'];
        console.log(hide);
        width = hide['width'];
        height = hide['height'];
        $('.hots' + idHotspot).css('width', width);
        $('.hots' + idHotspot).css('height', height);
    });
}

$().ready(function(){
    
//Fin del ready
});