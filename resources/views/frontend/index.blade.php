@extends('layouts.frontend')

@section('content')
    
    <!-- CONTENIDO -->
    <div class="l2 col100 row100 absolute">
        <div id="coverCenter" class="col100 centerVH">
            <div id="titleIndex" class="col100 centerH">I.E.S Celia Viñas</div>
            <div id="buttonsIndex" class="col100 centerH">
                <button>Visita Libre</button>
                <button>Visita Guiada</button>
                <button>Puntos Destacados</button>
            </div>
        </div>
        <div id="footerIndex" class="absolute col100">
            <a href="http://www.google.es" target="blank">CeliaTour ®</a> | 
            <a href="http://www.google.es" target="blank">Créditos</a> | 
            <a href="http://www.google.es" target="blank">Privacidad | 
            <a href="http://www.google.es" target="blank">Cookies</a>
        </div>
    </div>

    <!-- IMAGEN 360 -->
    <div id="pano" class="l1 col100" style="filter: brightness(75%);"></div>

    <!-- AGREGAR SCRIPTS -->
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
        var source = Marzipano.ImageUrlSource.fromString(
        "{{url('/marzipano/tiles/'.$data[0]->directory_name.'/{z}/{f}/{y}/{x}.jpg')}}",
        
        //Establecer imagen de previsualizacion para optimizar su carga 
        //(bdflru para establecer el orden de la capas de la imagen de preview)
        {cubeMapPreviewUrl: "{{url('/marzipano/tiles/'.$data[0]->directory_name.'/preview.jpg')}}", 
        cubeMapPreviewFaceOrder: 'lfrbud'});

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
        var view = new Marzipano.RectilinearView({yaw: "{{$data[0]->yaw}}", pitch: "{{$data[0]->pitch}}", roll: 0, fov: Math.PI}, limiter);

        //5. ESCENA SOBRE EL VISOR
        var scene = viewer.createScene({
            source: source,
            geometry: geometry,
            view: view,
            pinFirstLevel: true
        });

        //6.MOSTAR
        scene.switchTo({ transitionDuration: 1000 });

        //7. AUTOROTACION
        var autorotate = Marzipano.autorotate({
            yawSpeed: 0.03,         // Yaw rotation speed
            targetPitch: 0,        // Pitch value to converge to
            targetFov: Math.PI/2   // Fov value to converge to
        });
        // Movimiento infinito
        viewer.setIdleMovement(Infinity);
        // Empezar rotacion
        viewer.startMovement(autorotate); 
    </script>
@endsection