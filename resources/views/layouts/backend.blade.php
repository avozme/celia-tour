{{-- LAYOUT PARA EL BACKEND GENERAL DEL SISTEMA --}}
<html>
    <head>
        <link rel="stylesheet" href="{{url('css/global.css')}}" />
        <link rel="stylesheet" href="{{url('css/backend.css')}}" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <!-- Por defecto title Celia Tour -->
        <title>
            @yield('title', 'Celia Tour') 
        </title>
    </head>

    <body>
        <!-- MENU NAVEGACION LATERAL -->
        <nav class="col15 row100">
            <center  style="margin-top:40px"><strong>SECCION DE MENU</strong></center>
            <a href="{{route('guidedVisit.index')}}">Visitas guiadas</a><br>
            <a href="{{route('resources.index')}}">Recursos</a><br>
            <a href="{{route('zone.index')}}">Zonas</a><br>
            <a href="{{route('user.index')}}">Usuarios</a><br>
        </nav>
        
        <!-- CONTENIDO PRINCIPAL -->
        <main class="col85 row100">
			<div id="contentMain">
				@yield('content')
			</div>

			<!-- PIE DE PAGINA -->
			<footer class="col85">
				<center>
					<span>Creado por IES Celia Viñas 2DAW 19/20</span>
				</center>
			</footer>

        </main>
    </body>
</html>