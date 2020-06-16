resourceIdSelected = null; // ID del recurso seleccionado

/**
 * Pone la animacion al recurso que ejecuta esta funcion y guarda el id del recurso que esta seleccionado
 */
function selectResource(){
    var classStyle = 'resourceSelected';
    if(resourceIdSelected != null){
        if($(this).attr('id') == resourceIdSelected){
            $(this).removeClass(classStyle);
            resourceIdSelected = null;
        } else {
            $('.elementResource').removeClass(classStyle);
            $(this).addClass(classStyle);
            resourceIdSelected = $(this).attr('id');
        }
    } else {
        $('.elementResource').removeClass(classStyle);
        $(this).addClass(classStyle);
        resourceIdSelected = $(this).attr('id');
    }
}

/**
 * Obtiene los recursos de una busqueda con criterios y los filtra.
 * 
 * Importante: Es necesario asignar una variable llamada searchResourceUrl con la ruta a resource.searchResources
 *              en el archivo html principal.
 *              Tambien se debe exportar el js llamado filter.js
 * 
 * modalParent -> Ventana modal del buscador
 * idTable -> ID de la caja donde estan los recursos almacenados.
 * typeResource -> Tipo de recurso, como audio, video, etc. Corresponde al campo type de la tabla recursos en la BD
 */
function searchResources(modalParent, idTable, typeResource){

    var dataForm = new FormData();
    dataForm.append('_token', token);
    dataForm.append('search', $(`#${modalParent} input[name="searchResource"]`).val());
    dataForm.append('typeResource', typeResource);
    console.log($(`#${modalParent} input[name="searchResource"]`).val());

    $.ajax({
        url: searchResourceUrl,
        type: 'post',
        data: dataForm,
        contentType: false,
        processData: false,
    }).done(function(data){
        console.log(data);
        var container = $(`#${modalParent} #${idTable}`);
        filter(container, data);
    });
}


/**
 * Quita la animacion de los recursos que contiene la ventana modal especificada 
 * y pone el valor del recurso por defecto
 */
function clearResource(){
    $(`.elementResource`).removeClass('resourceSelected');
    resourceIdSelected = null;
}

/**
 * Añade la animacion al recurso especificado y se guarda el id.
 * modalParent -> ID de la ventana modal donde estan los recursos
 * id -> ID del recurso que se va a seleccionar
 */
function setResource(modalParent, id){
    $(`#${modalParent} #${id}`).addClass('resourceSelected');
    resourceIdSelected = id;
}


$().ready(function(){
    //video
    $('#modalVideo .elementResource').click(selectResource);
    $('#modalVideo .searchResource').click(function(){
        searchResources('modalVideo', 'containerVideos', 'video');
    })
    $('#modalVideo .searchTxtResource').keypress(function (e) {
        if (e.which == 13) {
            searchResources('modalVideo', 'containerVideos', 'video');
        }
    });

    // imagen
    $('#modalAddImage .elementResource').click(selectResource);
    $('#modalAddImage .searchResource').click(function(){
        searchResources('modalAddImage', 'image');
    })
    $('#modalAddImage .searchTxtResource').keypress(function (e) {
        if (e.which == 13) {
            searchResources('modalAddImage', 'modalAddImageContent', 'image');
        }
      });
});