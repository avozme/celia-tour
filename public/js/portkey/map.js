$(function() {

    // ELIMINA UNA FILA
    function remove(id){
        var direccion = urlDelete.replace('insertIdHere', id);
        $.get(direccion, function(data){
            if(data.error){
                alert('El traslador no puede ser eliminado mientras tenga escenas asignadas.')
            } else {
                var elemento = $(`#${id}`)[0];
                $(elemento).remove();
            }
        })
    }

    //-------------------------------------------- Ventanas modales ---------------------------------------------------
    
    // CIERRA LA MODAL
    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#modalPortkeyAdd").css('display', 'none');
        $("#modalPortkeyEdit").css('display', 'none');
        $('#confirmDelete').css('display', 'none');
    }

    // ABRE INSERTAR PORTKEY
    $('#btn-add').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#modalPortkeyAdd').css('display', 'block');
    })

    // ABRE MODAL PARA CONFIRMAR ELIMINAR
    function openDelete(){
        $('#modalWindow').css('display', 'block');
        $('#confirmDelete').css('display', 'block');
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        $('#aceptDelete').unbind('click');
        $('#aceptDelete').click(function(){
            remove(id);
            closeModal();
        });
    }

    // ABRE MODAL PARA EDITAR
    function openUpdate(){

        $('#imageUpdate').val('');

        var id = $(this).parent().parent().attr("id");
        var address = urlOpenUpdate.replace('insertIdHere', id);
        $.get( address, function( data ) {
            // Actualiza el titulo
            $('#titlePortkeyEdit').text("Modificar " + data.name);

            // Actualiza los campos
            $('#nameUpdate').val(data.name);

            // Actualiza la foto
            var urlImage = urlResource + data.image;
            $('#fileUpdate').attr('src', urlImage);

            $('#modalWindow').css('display', 'block');
            $('#modalPortkeyEdit').css('display', 'block');
          });

        // Se coloca el action con la ruta correctamente
        var id = $(this).parent().parent().attr("id");
        var url = urlUpdate.replace('insertIdHere', id);
        $('#formUpdate').attr('action', url);
    }



    // EVENTOS INICIALES
    $(".closeModal").click(closeModal);
    $("#cancelDelete").click(closeModal);
    $(".openDelete").click(openDelete);
    $(".openUpdate").click(openUpdate);

});