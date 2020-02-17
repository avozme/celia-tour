@extends('layouts.frontend')

@section('content')
    <div id="menuHigh" class="col100 row100">
        {{-- TITULO --}}
        <div id="titleHigh" class="col100">
            <span>PUNTOS DESTACADOS</span>
        </div>
        {{-- ELEMENTOS --}}
        <div id="tableHigh" class="col100">
            <div id="row1"></div>
            <div id="row2"></div>
            <div id="row3"></div>
        </div>
    </div>

    <script>
        var element=" <div id='idHigh' class='highlight col'>"+
                    "<div class='highInside col100 row100'>"+
                        "<span class='l2'>Sala profesorado</span>"+
                        "<img class='l1' src='https://www.imgacademy.mx/sites/www.imgacademy.mx/files/styles/scale_600w/public/2017-05/cc%20copy.jpg'>"+
                    "</div>"+
                "</div>";
        var highCounts=7;
        
        var increment=1;
        var rowCount = parseInt(highCounts/3); //Media de elementos por fila
        var rest = highCounts - rowCount; //Elementos restantes 

        if(rest==0){
            count = rowCount; //TODAS LAS FILAS CON EL MISMO NUMERO DE ELEMENTOS
        }else{
            count = parseInt(rest/2); //NUMERO ELEMENTOS FILA 1
        }
        
        //Añadir puntos destacados
        for(var i =0 ; i<3; i++){
            //Añadir elementos por fila
            for(var j=0; j<count; j++){
                $("#row"+(i+1)).append(element.replace("idHigh", increment));
                console.log(count);
                $("#"+increment).css("width", 100/count+"%");
                increment++;
            }
            //Cambiar num elemetos de la fila
            if(i==0 && rest!=0){
                //FILA 2
                count=rowCount; 
            }else if(i==1 && rest!=0){
                //FILA 3
                if(rest%2==0){
                    count = parseInt(rest/2);
                }else{
                    count = (parseInt(rest/2)+1);
                }
            }
        }
        
    </script>
@endsection