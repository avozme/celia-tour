{{-- LAYOUT PARA EL BACKEND DE LAS ESCENAS DEL SISTEMA --}}
<html>
    <head>
        <link rel="stylesheet" href="{{url('css/global.css')}}" />
        <link rel="stylesheet" href="{{url('css/backend.css')}}" />
        <link rel="stylesheet" href="{{url('css/marzipano.css')}}" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <!-- Por defecto title Celia Tour -->
        <title>
            @yield('title', 'Celia Tour') 
        </title>
    </head>

    <body>
        <!-- CONTENIDO PRINCIPAL -->
        <main id="mainScene" class="col100">
            @yield('content')
        </main>
        <!-- VENTANA MODAL -->
        <div id="modalWindow" class="col100">
            @yield('modal')
        </div>
    </body>
</html>