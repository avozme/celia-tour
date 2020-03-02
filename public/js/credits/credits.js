$(function() {

    $('#li-developer').click(function(){
        $('#teachers').css('display', "none");
        $('#collaborators').css('display', "none");
        $('#developers').css('display', "block");
    });
    $('#li-teachers').click(function(){
        $('#developers').css('display', "none");
        $('#collaborators').css('display', "none");
        $('#teachers').css('display', "block");
    });
    $('#li-collaborators').click(function(){
        $('#developers').css('display', "none");
        $('#teachers').css('display', "none");
        $('#collaborators').css('display', "block");
    });
    
});