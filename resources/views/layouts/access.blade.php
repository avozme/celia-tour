{{-- LAYOUT PARA EL BACKEND GENERAL DEL SISTEMA --}}
<html>
    <head>
        <link rel="stylesheet" href="{{url('css/global.css')}}" />
        <link rel="stylesheet" href="{{url('css/backend.css')}}" />
        <link rel="icon" type="image/png" href="{{url('img/faviconbackend.png')}}">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700&display=swap" rel="stylesheet">
        @yield('headExtension')
        <!-- Por defecto title Celia Tour -->
        <title>
            @yield('title', 'Celia Tour') 
        </title>
    </head>

    <body class="row100">
        
        <!-- CONTENIDO PRINCIPAL -->
        <div class="col100 row100">
            @yield('content')
	
			<!-- PIE DE PAGINA -->
			<footer class="col100">
				<center>
					<span>Creado por IES Celia Viñas 2DAW 19/20</span>
				</center>
			</footer>

        </div>

        <!-- VENTANA MODAL -->
        <div id="modalWindow">
            <div id="containerModal">
                @yield('modal')
            </div>
        </div>
    </body>
</html>