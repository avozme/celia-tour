$(function() {

    $('#li-developers').click(function(){
        $(this).addClass("menu-selected");
        $("#li-teachers").removeClass("menu-selected");
        $("#li-collaborators").removeClass("menu-selected");

        $('#teachers').css('display', "none");
        $('#collaborators').css('display', "none");
        $('#developers').css('display', "block");
    });
    $('#li-teachers').click(function(){
        $(this).addClass("menu-selected");
        $("#li-developers").removeClass("menu-selected");
        $("#li-collaborators").removeClass("menu-selected");

        $('#developers').css('display', "none");
        $('#collaborators').css('display', "none");
        $('#teachers').css('display', "block");
    });
    $('#li-collaborators').click(function(){
        $(this).addClass("menu-selected");
        $("#li-developers").removeClass("menu-selected");
        $("#li-teachers").removeClass("menu-selected");

        $('#developers').css('display', "none");
        $('#teachers').css('display', "none");
        $('#collaborators').css('display', "block");
    });
    
});