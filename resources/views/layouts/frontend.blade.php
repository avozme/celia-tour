<html>
    <head>
        <link rel="stylesheet" href="{{url('css/global.css')}}" />
        <link rel="stylesheet" href="{{url('css/marzipano.css')}}" />
        <link rel="stylesheet" href="{{url('css/frontend.css')}}" />
        <link rel="icon" type="image/png" href="{{url('img/options/'.$favicon)}}">
        <meta name="description" content="{{$metadescription}}"/>
        <meta name="title" content="{{$metatitle}}"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family={{$fontLink}}:400, 500, 700&display=swap" rel="stylesheet">
        <!-- Por defecto title Celia Tour -->
        <title>
            @yield('title', 'Celia Tour') 
        </title>
        <style>
            body{
                font-family:{{$font}}, Arial!important;
            }
            button{font-family:{{$font}}, Arial!important;}
            
            /*COLORES*/
            #titleIndex, #buttonsIndex button, #footerIndex, #txtOption, #sTextEscape, #bTextEscape{
                color:{{$color}}!important;
            }
            #buttonsIndex button{
                border-color: {{$color}}!important;
            }
            #padOpen, #padClose{
                fill: {{$color}}!important;
            }
            #buttonsIndex button:hover{
                background-color:{{$color}}!important;
                color:{{$reverseColor}}!important;
            }
            
        </style>
    </head>

    <body>       
        <!-- CONTENIDO PRINCIPAL -->
        <main class="col100">
            @yield('content')
        </main>
        <!-- VENTANA MODAL -->
        <div id="modalWindow" class="col100">
            @yield('modal')
        </div>
    </body>
</html>