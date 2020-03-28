$().ready(function(){
   //Accion para examinar imagen de restauracion al hacer clic sobre el elemento HTML
   $('#upBackup').on("click", function(){
      $('#fileInput').trigger('click');
   });
   //Enviar formulario al seleccionar un elemento
   $("#formRestore").on("change", function(){
      $("#modalWindow").css("display", "block");
      $("#containerModal").css("display", "block");
      $("#confirmDelete").css("display", "block");
      $("#aceptDelete").click(function(){
         console.log("enviando");
         $("#formRestore").submit();
      });
      $("#cancelDelete").click(function(){
         $("#modalWindow").css("display", "none");
         $("#containerModal").css("display", 'none');
         $("#confirmDelete").css("display", "none");
      }); 
      $("#closeModalWindowButton").click(function(){
         $("#modalWindow").css("display", "none");
         $("#containerModal").css("display", 'none');
         $("#confirmDelete").css("display", "none");
      });
   });

   $("#downBackup").click(function(){
      console.log("click");
      $("#modalWindow").css("display", "block");
      $("#containerModal").css("display", "block");
      $("#confirmDelete").css("display", "block");
         $("#aceptDelete").click(function(){
            $("#modalWindow").css("display", "none");
            $("#containerModal").css("display", 'none');
            $("#confirmDelete").css("display", "none");
            window.location.href="{{route('backup.create')}}"
         });
         $("#cancelDelete").click(function(){
            $("#modalWindow").css("display", "none");
            $("#containerModal").css("display", 'none');
            $("#confirmDelete").css("display", "none");
         });
      $("#closeModalWindowButton").click(function(){
         $("#modalWindow").css("display", "none");
         $("#containerModal").css("display", 'none');
         $("#confirmDelete").css("display", "none");
      });   
   });
});
