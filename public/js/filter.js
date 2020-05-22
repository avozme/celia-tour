/*
* Ordena una lista mostrando y ocultando sus elementos. 
* Cada elemento debe tener un attributo ID que hace referencia al ID del elemento en la base de datos.
*
* elementList -> Contenedor que tiene la lista de los elementos que se va a mostar u ocultar, se obtiene: "$('#mitabla')".
* whoElementShow -> Array que contiene los objetos de la BD de los elementos que se van a mostrar
* substrCont -> En caso de tener un id compuesto con nombre, se indica
*               el numero de letras que debe saltarse para obtener solo el identificador.
                Si no se especifica, se entiende que solo esta el identificador.
*/
function filter(elementList, whoElementShow, substrCont = 0){
    elementList = $(elementList).children();

    // Recorre cada elemento de la tabla
    for(let i = 0; i < elementList.length; i++){ 
        var child = elementList[i];
        var show = false;

        // Recorre cada elemento que se debe mostrar
        for(let j = 0; j < whoElementShow.length; j++){ 
            // Compara el elemento de la tabla con el element que se debe mostrar
            var id = $(child).attr('id')
            id = parseInt(id.substr(substrCont))
            if(id == whoElementShow[j].id){
                show = true; // El elemento child se muestra
                j = whoElementShow.length; // Sale de bucle
            }
        }

        // Muestra o esconde el elemento
        if(show){
            $(child).show('slow');
        } else {
            $(child).hide('slow');
        }
    }
} 