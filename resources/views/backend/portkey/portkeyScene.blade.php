@extends('layouts.backend')

@section('headExtension')
    <script src="{{url('js/portkey/index.js')}}"></script>
    <!-- Recursos de zonas -->
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>

    <!-- MDN para usar sortable -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

@endsection
@section('content')
	<div>
	<h2>Selección de escenas</h2>
	
        <button id="newportkey"> Añadir </button>
        <button onclick="window.location.href='{{ route('portkey.index')}}'"> Volver </button>  
        
		<table id="tableContent">
            
		@foreach($portkeySceneList as $prk)
            <tr id={{$prk->id}}>
                <td>{{ $portkey->name }}</td>
                <td>{{ $prk->name }}</td> 
				<td><button class="prueba"> Previsualizar </button></td>
				<td><button class="deleteScene delete"> Eliminar </button></td>
			</tr>

		@endforeach
	</table>
    </div>
    <div style="width: 500%; height: 50%; position: relative; border: 2px solid black;">
        <div id="pano" style="width: 100%: position: absolute"></div>
    </div>
    <style>
        
    </style>

    <script>
        
        function sceneInfo($id){
        var route = "{{ route('scene.show', 'id') }}".replace('id', $id);
        return $.ajax({
            url: route,
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        });
    }

        var view = null;
    function loadScene(sceneDestination){
        view = null;
        'use strict';
        console.log("{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}".replace('dn', sceneDestination.directory_name));

        //1. VISOR DE IMAGENES
        var  panoElement = document.getElementById('pano');
        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

        //2. RECURSO
        var source = Marzipano.ImageUrlSource.fromString(
        "{{url('/marzipano/tiles/dn/{z}/{f}/{y}/{x}.jpg')}}".replace('dn', sceneDestination.directory_name),
        
        //Establecer imagen de previsualizacion para optimizar su carga 
        //(bdflru para establecer el orden de la capas de la imagen de preview)
        {cubeMapPreviewUrl: "{{url('/marzipano/tiles/dn/preview.jpg')}}".replace('dn', sceneDestination.directory_name), 
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
        var view = new Marzipano.RectilinearView({yaw: sceneDestination.yaw, pitch: sceneDestination.pitch, roll: 0, fov: Math.PI}, limiter);

        //5. ESCENA SOBRE EL VISOR
        var scene = viewer.createScene({
        source: source,
        geometry: geometry,
        view: view,
        pinFirstLevel: true
        });

        //6.MOSTAR
        scene.switchTo({ transitionDuration: 1000 });
    }

    sceneInfo(4).done(function(result){
            loadScene(result);
            //console.log(result);
        });
    </script>
@endsection
@section('modal')
    <!-- Form añadir portkey -->
    <div id="modalportkey" class="window" style="display:none">
        <span class="titleModal col100">Nueva escena</span>
        <button id="closeModalWindowButton" class="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
        </svg>
        </button>
        <div>
			@include('backend.zone.map.zonemap')
        </div>

        <!-- form para guardar la escena -->
        <form id="addsgv" style="clear:both;" action="{{ route('portkey.guardar', $portkey->id) }}" method="post">
            @csrf
            <input id="sceneValue" type="text" name="scene" value="" hidden>
        </form>

        <!-- Botones de control -->
        <div id="actionbutton">
            <div id="acept" class="col20"> <button class="btn-acept">Guardar</button> </div>
        </div>
	</div>
@endsection
