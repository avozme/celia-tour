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
    $('#modalVideo .elementResource').click(selectResource);
    $('#modalAddImage .elementResource').click(selectResource);
});