<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href='{{url('css/model3d/model3d.css')}}'>
        <title>Cargando modelo {{$name}}</title>
    </head>
    <body>

        <div id="info">
            <p>Modelo 3D: {{$name}}</p>
        </div>

        <div id="leyenda">
            <p>Girar Modelo: </p><img src="{{url('/img/RatonIzquierdo.png')}}">
            <p>Zoom: </p><img src="{{url('/img/RatonRuleta.png')}}">
            <p>Desplazar pantalla: </p><img src="{{url('/img/RatonDerecho.png')}}">
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r119/three.min.js"></script>
        <script src="{{url('/js/model3d/GLTFLoader.js')}}"></script>
        <script src="{{url('/js/model3d/OrbitControls.js')}}"></script>

        <script>

            var scene, camera, renderer, controls;

            scene = new THREE.Scene();
            //CAMBIA EL COLOR DE FONDO DE LA ESCENA
            scene.background = new THREE.Color(0xbfe3dd);

            //POSICIÓN DE LA CÁMARA
            camera = new THREE.PerspectiveCamera(50,window.innerWidth/window.innerHeight);
            camera.position.set(0,0,2);
            scene.add(camera);

            //SE RENDERIZA EL MODELO 3D
            renderer = new THREE.WebGLRenderer();
            renderer.setSize(window.innerWidth,window.innerHeight);
            document.body.appendChild(renderer.domElement);

            //ROTAMOS EL MODELO 3D
            controls = new THREE.OrbitControls(camera, renderer.domElement);

            controls.minDistance = 0;
            controls.maxDistance = 10;

            controls.enableDamping = true;
            controls.dampingFactor = 0.5;

            controls.maxPolarAngle = Math.PI;

            controls.screenSpacePanning = true;


            //CARGAMOS EL MODELO 3D
            const loader = new THREE.GLTFLoader();
            var name = "{{$name}}";
            var url = "{{url('/img/resources/')}}";

            loader.load(url+'/'+name, function (glb) {

                console.log(glb.scene.children.material);
                const root = glb.scene;

                //Le da tamaño al modelado
                root.scale.set(0.019, 0.019, 0.019);

                //Lo rotamos ligeramente
                root.rotation.set(0.04,5,0.5);

                //Lo añadimos
                scene.add(root);

            }, function (xhr){
                console.log((xhr.loaded/xhr.total * 100) + "% loaded")
            }, function (error){
                console.log('Ha ocurrido un error.')
            })


            //AÑADIMOS LUZ A LA ESCENA
            const dirLight1 = new THREE.DirectionalLight(0xffffff);
            dirLight1.position.set(0, 3, 2);
            scene.add(dirLight1);

            const dirLight2 = new THREE.DirectionalLight(0xffffff);
            dirLight2.position.set(- 1, - 1, - 1);
            scene.add(dirLight2);

            const ambientLight = new THREE.AmbientLight(0x222222);
            scene.add(ambientLight);

            ambientLight.intensity = 1.35;
            dirLight2.intensity = 1.1;
            dirLight1.intensity = 1.1;
            
            /**
             * MÉTODO QUE MUESTRA FINALMENTE EL MODELO 3D CON LA COMPOSICIÓN
             * DE ESCENA Y CÁMARA PROGRAMADAS MÁS ARRIBA
             */
            function animate () {
                requestAnimationFrame(animate);
                renderer.render(scene,camera);
            }

            animate();
        </script>
    </body>
</html>