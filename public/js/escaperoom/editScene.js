$(function() {

    // PONE LOS SELECT POR DEFECTO EN 'TODO'
    $('#allQuestions #question-order option:eq(0)').prop('selected', true)
    $('#allClues #clue-order option:eq(0)').prop('selected', true)

    // FILTRO DE PISTAS
    $("#allQuestions #question-order").change(function(){
        var address = questionFilter.replace('insertIdHere', $("#allQuestions #question-order option:selected").val());
        $.get(address, function(data){
            var content = $("#allQuestions #question-content");
            filter(content, data, 8);
        }).fail(function(data){
            alert("Ocurrio un error al filtrar las preguntas");
        });
    })

    // FILTRO DE PISTAS
    $("#allClues #clue-order").change(function(){
        var address = clueFilter.replace('insertIdHere', $("#allClues #clue-order option:selected").val());
        $.get(address, function(data){
            var content = $("#allClues #clue-content");
            filter(content, data, 4);
        }).fail(function(data){
            alert("Ocurrio un error al filtrar las pistas");
        });;
    })

})