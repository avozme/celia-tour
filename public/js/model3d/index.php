<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Cargando modelo IES Celia Viñas 3D</title>
    </head>
    <body>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r119/three.min.js"></script>
        <script src="js/GLTFLoader.js"></script>
        <script src="js/OrbitControls.js"></script>

        <script>

            /**
            * Función que extrae el id de la url
            */
            function getParameterByName(name, url = window.location.href) {
                name = name.replace(/[\[\]]/g, '\\$&');
                var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }

            var scene, camera, renderer, controls;

            scene = new THREE.Scene();
            //Cambia el color de fondo de la escena
            scene.background = new THREE.Color(0x999999);

            camera = new THREE.PerspectiveCamera(50,window.innerWidth/window.innerHeight);
            camera.position.set(0,0,2);
            scene.add(camera);

            renderer = new THREE.WebGLRenderer();
            renderer.setSize(window.innerWidth,window.innerHeight);
            document.body.appendChild(renderer.domElement);

            //ROTAMOS EL MARTILLO
            controls = new THREE.OrbitControls(camera, renderer.domElement);

            controls.minDistance = 3;
            controls.maxDistance = 10;

            controls.enableDamping = true;
            controls.dampingFactor = 0.5;

            controls.maxPolarAngle = Math.PI;

            controls.screenSpacePanning = true;


            //Cargamos el martillo
            const loader = new THREE.GLTFLoader();
            var name = getParameterByName('name');          
            
            loader.load('../../img/resources/'+name, function (glb) {

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


            //Añadimos luz a la escena
            const dirLight1 = new THREE.DirectionalLight( 0xffffff );
            dirLight1.position.set( 0, 3, 2 );
            scene.add( dirLight1 );

            const dirLight2 = new THREE.DirectionalLight( 0xffffff );
            dirLight2.position.set( - 1, - 1, - 1 );
            scene.add( dirLight2 );

            const ambientLight = new THREE.AmbientLight( 0x222222 );
            scene.add( ambientLight );

            function animate () {
                requestAnimationFrame(animate);
                renderer.render(scene,camera);
            }

            animate()
        </script>
    </body>
</html>