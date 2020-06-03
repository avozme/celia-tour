var resourceIdSelected = null; // ID del recurso seleccionado

function selectResource(){
    var classStyle = 'resourceSelected';
    if(resourceIdSelected != null){
        if($(this).attr('id') == resourceIdSelected){
            $(this).removeClass(classStyle);
            resourceIdSelected = null;
        } else {
            $('.elementResource').removeClass(classStyle);
            $(this).addClass(classStyle)
            resourceIdSelected = $(this).attr('id');
        }
    } else {
        $('.elementResource').removeClass(classStyle);
        $(this).addClass(classStyle);
        resourceIdSelected = $(this).attr('id');
    }
    console.log(resourceIdSelected);
}


$().ready(function(){
    $('#modalVideo .elementResource').click(selectResource);
});