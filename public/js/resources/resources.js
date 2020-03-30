$().ready(function () {
    //ACCIÓN PARA MOSTRAR O NO EL DROPZONE
    $("#btndResource").click(function () {
        if ($("#dzone").css("display") == "none") {
            $("#dzone").css("display", "block");
            $("#iconClose").show();
            $("#iconUp").hide();
        } else {
            $("#dzone").css("display", "none");
            $("#iconClose").hide();
            $("#iconUp").show();
        }
    });

    //ACCIÓN PAR QUE SE MUESTRE LA VENTANA MODAL DE SUBIR VIDEO
    $("#btnVideo").click(function () {
        $("#modalWindow").css("display", "block");
        $("#video").css("display", "block");
    });

    //FUNCIÓN AJAX PARA BORRAR
    $(".delete").click(function () {
        $("#edit").css("display", "none");
        $("#confirmDelete").css("display", "block");
        $("#aceptDelete").click(function () {
            $("#confirmDelete").css("display", "none");
            $("#modalWindow").css("display", "none");
            var route = "{{ route('resource.delete', 'req_id') }}".replace('req_id', id);
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                }, success: function (result) {
                    if (result.status == true) {
                        $(elementoD).remove();
                        $('.previewResource').empty();
                    } else {
                        alert("Este recurso no puede ser eliminado por que esta siendo usado en una galeria");
                        $('.previewResource').empty();
                    }
                }
            });
        });
        $("#cancelDelete").click(function () {
            $("#confirmDelete").css("display", "none");
            $("#edit").css("display", "block");
        });
    });

    //Boton subir ficheros
    $("#fileSubtOwn").on("click", function () {
        $("#fileSubt").click();
    });


});
