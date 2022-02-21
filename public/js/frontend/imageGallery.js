/**************************************
 * HOTSPOT DE TIPO GALERÍA DE IMÁGENES
 **************************************/

//SACO EL ID DE LA GALERIA
function getIdGallery(hotspot){
    return $.ajax({
        url: getIdGalleryRoute.replace('hotspotid', hotspot),
        type: 'POST',
        data: {
            '_token': token,
        }
    });
}

//SACAR LAS IMAGENES DE LA GALERÍA A TRAVÉS DE LOS RECURSOS
function getImages(gallery){
    var route = getImagesGalleryRoute.replace('id', gallery);
    return $.ajax({
        url: route,
        type: 'post',
        data: {
            "_token": token,
        },
    });
}
    
function imageGallery(id, idType){
    var resources = null;

    //AGREGAR HTML DEL HOTSPOT
    $("#contentHotSpot").append(
        "<div id='imageGalleryIcon' value='"+id+"' class='hots"+id+" hotspotElement hotsLowOpacity'>"+
        "<div class='icon_wrapper'>"+
            "<div class='icon'>"+
            "<div id='inner_icon' class='inner_icon'>"+
                "<svg id='iconIG' viewBox='0 0 488.455 488.455'>"+
                    "<path d='m287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0'/>"+
                    "<path d='m427.397 91.581h-42.187l-30.544-61.059h-220.906l-30.515 61.089-42.127.075c-33.585.06-60.925 27.429-60.954 61.029l-.164 244.145c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059v-244.236c-.001-33.674-27.385-61.058-61.059-61.058zm-183.177 290.029c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118-54.783 122.118-122.118 122.118z'/>"+
                "</svg>"+
                "</div>"+
            "</div>"+
        "</div>"+
        "</div>"
    );

    //----------------------------------------------------------------------

    /**
     * ACCION AL PULSAR SOBRE LA GALERIA RECUPERAR TODAS LAS IMAGENES
     */
    $(".hots"+id).click(function(){
        var idSelect = $(this).attr("value");
        getIdGallery(idSelect).done(function(result){
            getImages(result.gallery).done(function(result){
                numImgs = result['resources'].length;
                $("#numImages").attr('value', numImgs);
                $('#actualResource').attr('value', 1);
                $('#galleryResources').empty();
                $('#imageMiniature').empty();

                console.log(idSelect);


                //Boton cerrar ventana
                $('#galleryResources').append(`
                    <button id="closeModalWindowButton" class="closeModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                    </button>`);
                $('#closeModalWindowButton').click(function(){
                    $('#modalWindow').css('display', 'none');
                    $('#showAllImages').css('display', 'none');
                    $('#galleryResources').empty();
                });

                //Agregar todas las imagenes
                for(var i = 0; i < result['resources'].length; i++){
                    if(i == 0){
                        $('#galleryResources').prepend(
                            "<div id='n"+ (i+1) +"' class='recurso col100'>" + 
                                "<span class='titleModal col100'>"+ result['resources'][i].title +"</span>"+ 
                                "<center class='col100'><a href="+ urlImagesGallery.replace('image', result['resources'][i].route) +" target='_blank'><img class='imgGallery mmarginTop' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' /></a></center>"+
                                "<span id='description' class='DescriptionModal col100'>"+ result['resources'][i].description +"</span>"
                           +"</div>"
                        );
                    }else{
                        $('#galleryResources').prepend(
                            "<div id='n"+ (i+1) +"' class='recurso col100' style='display:none'>" + 
                                "<span class='titleModal col100'>"+ result['resources'][i].title +"</span>"+
                                "<center class='col100'><a href="+ urlImagesGallery.replace('image', result['resources'][i].route) +" target='_blank'><img class='imgGallery mmarginTop' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' /></a></center>"+
                                "<span id='description' class='DescriptionModal col100'>"+ result['resources'][i].description +"</span>"
                           +"</div>"
                        );
                    }
                    $('#imageMiniature').append(
                        "<div id='"+ (i+1) +"' class='elementResource miniature col125'>"+
                            "<div class='insideElement'>"+
                                "<img style='width: 100%;' class='miniatureImg' src='"+ urlImagesGallery.replace('image', result['resources'][i].route) +"' />" +
                            "</div>"+
                        "</div>"
                    );
                    $(".miniature").click(function(){
                        var recurso = $(this).attr('id');
                        $('.recurso').css('display', 'none');
                        $('#n'+recurso).css('display', 'block');
                        $('#actualResource').attr('value', recurso);
                    });

                    //Quitar el NULL de las imagenes que no tengan descripción
                    var text = result['resources'][i].description;
                        if (text==null) {
                            document.getElementById('description').innerHTML = " ";
                    }
                }
                $('#galleryResources').css('display', 'block');
            });
        });
        
        //$(document).delay(200);
        $('#modalWindow').css('display', 'block');
        $('#showAllImages').css('display', 'block');
    });
}

$().ready(function(){
    
    $('#backResource').click(function(){
        $('.recurso').css('display', 'none');
        var numImages = $("#numImages").attr('value');
        var actual = $("#actualResource").attr('value');
        if(actual == 1){
            $("#n"+numImages).css('display', 'block');
            $('#actualResource').attr('value', numImages);
        }else{
            var next = parseInt(actual) -1;
            $("#n"+next).css('display', 'block');
            $('#actualResource').attr('value', next);
        }
    });

    $('#nextResource').click(function(){
        $('.recurso').css('display', 'none');
        var numImages = $("#numImages").attr('value');
        var actual = $("#actualResource").attr('value');
        if(actual == numImages){
            $("#n1").css('display', 'block');
            $('#actualResource').attr('value', 1);
        }else{
            var next = parseInt(actual) + 1;
            $('#n' + next).css('display', 'block');
            $('#actualResource').attr('value', next);
        }
    });
});
