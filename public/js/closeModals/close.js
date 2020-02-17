$().ready(function(){
    $("#closeModalWindowButton").click(function(){
        $(this).parent().parent().parent().hide();
    });
});