$(document).ready(function(){
    $('.btn-scene').click(boton);
    showTable();
});


function boton(){
    $('.btn-acept').unbind('click');
    $('.btn-acept').click(insert);
}

/**
 * Inserta un nuevo elemento
 */
function insert() {
    var resource = $('#resource').val();
    var scene = $('#scene').val();
    var position = $('#position').val();
    
    var content = $('#fill').append('<div style="clear: both;"><div class="col20">'+resource+'</div><div class="col20">'+scene+'</div><div class="col20">'+position+'</div><div class="col20"><button class="btn-update">Modificar</button></div><div class="col20"><button class="btn-remove">Eliminar</button></div></div>')
    
    // Reasigna el evento a los botones de eliminar
    
    $('.btn-update').unbind('click');
    $('.btn-update').click(update);
    $('.btn-remove').unbind('click');
    $('.btn-remove').click(remove);

    // Revisa si muestra o no la tabla
    showTable();

    /** Contenido que se añade al contenedor fill
        <div style="clear: both;">
            <div class="col20">resource</div>
            <div class="col20">scene</div>
            <div class="col20">position</div>
            <div class="col20"><button>Modificar</button></div>
            <div class="col20"><button>Eliminar</button></div>
        </div>
    */
}


/**
 * Actualiza la fila seleccionada
 */
function update(){
    // Obtiene los objetos de los campos
    var row = $(this).parent().parent().children();
    var resource = $(row).eq(0); // El elemento 0 es el recurso
    var scene = $(row).eq(1); // El elemento 1 es la escena
    var position = $(row).eq(2); // El elemento 2 es la posicion
    
    // Cambia el texto del formulario
    $('#resource').val(resource.text()).change();
    $('#scene').val(scene.text()).change();
    $('#position').val(position.text());

    // Cambia el evento del boton aceptar para guardar el resultado en el elemento a modificar
    $('.btn-acept').unbind('click');
    $('.btn-acept').click(function(){
        $(resource).html($('#resource').val());
        $(scene).html($('#scene').val());
        $(position).html($('#position').val());
    })
}

/*
* Elimina los datos de la fila eliminada
*/
function remove(){
    var isDelte = confirm("¿Desea eliminar esta escena?");
    if(isDelte){
        $(this).parent().parent().remove();
        showTable();
    }
}

/**
 * Muestra u oculta si tiene contenido la tabla
 */
function showTable(){
    
    if($('#fill').children().length){
        $('.content-scene').css('visibility', 'visible')
    } else {
        $('.content-scene').css('visibility', 'hidden')
    }
    
}