$(document).ready(function() {

    //FUNCIÓN PARA ABRIR LA MODAL DE EDITAR OPCIONES
    $("#btn-editOptions").click(function(){
        //Obtenemos el id del Escape que estamos modificando: 
        var id= $('#idEscapeRoom').val();
        //Hacemos una llamada al controlador para recuperar los datos:
        $.ajax({
            url:OptionEdit.replace('req_id', id),
            type: 'POST',
            data: {
                '_token': token,
            }
        }).done(function(data){
                $("#HistoryAdd").val(data.history);
                $('#idAudioA').val(data.environment_audio);
                $('#idAudioT').val(data.id_audio);
                $('#idSelectedScene').val(data.start_scene);
                $('#modalWindow').css('display', 'block');
                $('#modalOptionUpdate').css("display", 'block');
            });
    });

    //FUNCIÓN PARA ABRIR LA MODAL DE SELECCIONAR ESCENA
    $("#escenaOp").click(function(){
        var idScene = $('#idSelectedSceneUpdate').val();
       $('#map2 #scene'+idScene).attr('src', pointImgHoverRoute);
       $('#map2 #scene'+idScene).addClass('selected');
       $('#addSceneToKey').addClass('editOp');
       $('#slideModalOptionUpdate').slideUp(function(){
           $('#modalOptionUpdate').css('display', 'none');
           $('#modalMap').css('display', 'block');
           $('#mapSlide').slideDown();
       });
   });

   //FUNCIÓN PARA ABRIR MODAL DE SELECCIONAR AUDIO PARA EL DEL TEXTO
   $("#audioTOp").click(function(){
    $('#saveAudio').addClass('editTOp');
    $('#slideModalOptionUpdate').slideUp(function(){
        $('#modalOptionUpdate').hide();
        $('#modalResource').css('display', 'block');
        $('#slideModalResource').slideDown();
    });
   });

   //FUNCIÓN PARA ABRIR LA MODAL DE SELECCIONAR AUDIO PARA EL FONDO
   $("#audioAOp").click(function(){
    $('#saveAudio').addClass('editOp');
    $('#slideModalOptionUpdate').slideUp(function(){
        $('#modalOptionUpdate').hide();
        $('#modalResource').css('display', 'block');
        $('#slideModalResource').slideDown();
    });
   });

   //FUNCIÓN PARA EL BOTÓN DE GUARDAR CAMBIOS 
   $("#btn-saveOP").click(function(){

    dataForm = new FormData();
    dataForm.append('_token', $('input[name="_token"]').val());
    dataForm.append('history', $("#HistoryAdd").val());
    dataForm.append('id_audio', $('#idAudioT').val());
    dataForm.append('environment_audio', $('#idAudioA').val());
    dataForm.append('start_scene', $("#idSelectedScene").val());

    console.log(dataForm);

     // Se obtiene la url del action y se asigna el id correspondiente.
     var id = $('#idEscapeRoom').val();
     var addressUpdate = $(`#formAddOP`).attr("action")
     addressUpdate = addressUpdate.replace('req_id', id); 

    $.ajax({
        url: addressUpdate,
        type: 'post',
        data: dataForm,
        contentType: false,
        processData: false,
    }).done(function(data){
        
        closeModal();
    }).fail(function(data){
    })
   });

   // CIERRA LA MODAL
   function closeModal(){
    $('.window, .slide').hide();
    $("#modalWindow").css('display', 'none');
    $('.elementResource').removeClass('resourceSelected');
}


});

