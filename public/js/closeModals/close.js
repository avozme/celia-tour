$().ready(function(){
    $("#closeModalWindowButton").click(function(){
        $(this).parent().parent().hide();
    });
});