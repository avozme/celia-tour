@extends('layouts/backendScene')

@section('title', 'Agregar escena')

@section('content')
<html>
    <input id="titleScene" type="text" value="{{$scene->name}}" class="l2">
    <button id="setViewDefault" onclick="setViewDefault" class="l2">Establecer vista</button>

    <div id="pano" class="l1 col80"></div>
    <div id="menuScenes" class="l2 width20 row100 right">
        <span>Menu<span>
    </div>
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>
    <script>
        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////   MARZIPANO   /////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
        'use strict';
        //1. VISOR DE IMAGENES
        var panoElement = document.getElementById('pano');
        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

        //2. RECURSO
        console.log("{{$scene->directory_name}}");  
        var source = Marzipano.ImageUrlSource.fromString(
        "{{url('/marzipano/tiles/'.$scene->directory_name.'/{z}/{f}/{y}/{x}.jpg')}}",
        
        //Establecer imagen de previsualizacion para optimizar su carga 
        //(bdflru para establecer el orden de la capas de la imagen de preview)
        {cubeMapPreviewUrl: "{{url('/marzipano/tiles/'.$scene->directory_name.'/preview.jpg')}}"}, 
        {cubeMapPreviewFaceOrder: 'bdflru'},);

        //3. GEOMETRIA 
        var geometry = new Marzipano.CubeGeometry([
        { tileSize: 256, size: 256, fallbackOnly: true  },
        { tileSize: 512, size: 512 },
        { tileSize: 512, size: 1024 },
        { tileSize: 512, size: 2048},
        ]);

        //4. VISTA
        //Limitadores de zoom min y max para vista vertical y horizontal
        var limiter = Marzipano.util.compose(
        Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
        Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
        );
        //Establecer estado inicial de la vista con el primer parametro
        var view = new Marzipano.RectilinearView({yaw: "{{$scene->yaw}}", pitch: "{{$scene->pitch}}"0, roll: 0, fov: Math.PI}, limiter);

        //5. ESCENA SOBRE EL VISOR
        var scene = viewer.createScene({
        source: source,
        geometry: geometry,
        view: view,
        pinFirstLevel: true
        });

        //6.MOSTAR
        scene.switchTo({ transitionDuration: 1000 });


        ///////////////////////////////////////////////////////////////////////////
        ////////////////////////////   JQUERY   ///////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
        $(document).ready(function(){  
            //Cambiar pitch y yaw de la vista por defecto
            function setViewDefault(){
                viewer.view().yaw();
                viewer.view().pitch();

                //Solicitud para almacenar por aja
                var rute = "{{ route('person.destroy', 'req_id') }}".replace('req_id', id)
                $.ajax({
                    url: rute,
                    type: 'delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(result){                   
                        //Obtener el resultado de la accion
                        if(result['status']){                        
                            $("#per"+result['id']).remove();
                        }else{
                            modalWindow(result['error'], 0, null);
                        }
                    }
                });
            };





            





        });  
    </script>
</body>

</html>
@endsection