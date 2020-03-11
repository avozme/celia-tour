// ENCAPSULA LOS MENSAJES EN UN SPAN
function clearError(array){
    var content = "";
    if(typeof array != "undefined"){
        for(let i = 0; i < array.length; i++) {
            content += "<span>" + array[i] + "</span>";
        }
    }
    return content;
}