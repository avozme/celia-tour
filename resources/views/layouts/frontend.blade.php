<html>
    <head>
        <link rel="stylesheet" href="{{url('css/global.css')}}" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <title>
            <!-- Por defecto title Celia Tour -->
            @yield('title', 'Celia Tour') 
        </title>
    </head>

    <body>       
        <!-- CONTENIDO PRINCIPAL -->
        <main class="col100">
            @yield('content')
        </main>
    </body>
</html>