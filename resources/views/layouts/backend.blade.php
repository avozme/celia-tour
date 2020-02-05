{{-- LAYOUT PARA EL BACKEND GENERAL DEL SISTEMA --}}
<html>
    <head>
        <link rel="stylesheet" href="{{url('css/global.css')}}" />
        <link rel="stylesheet" href="{{url('css/backend.css')}}" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700&display=swap" rel="stylesheet">
        @yield('headExtension')
        <!-- Por defecto title Celia Tour -->
        <title>
            @yield('title', 'Celia Tour') 
        </title>
    </head>

    <body>
        <!-- MENU NAVEGACION LATERAL -->
        <nav class="col16 row100">
            <!-- LOGO -->    
            <div class="col100 logo centerH">  
                <a href="{{url('')}}">
                    <img class="width80" src="{{ url('/img/logo.png')}}"/>
                </a>
            </div>
           
            <!-- MENU -->
            <div class="col100 menu">
                <ul>
                    <div class="line"></div>
                        <a href="{{route('zone.index')}}">
                            <li>
                                <svg id="map" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.258 32.266">
                                    <path  d="M.067,5.416V35.55l9.511-1.722V3.505Z" transform="translate(-0.067 -3.284)"/>
                                    <path  d="M190.462,25.3V4.78L180.99,3.151V33.474L190.462,35V27.283C190.466,27.265,190.462,25.3,190.462,25.3Z" transform="translate(-169.588 -2.952)"/>
                                    <path  d="M361.293,1.807V32.023l9.493-1.785V0Z" transform="translate(-338.529)"/>
                                    </svg>                                                                    
                                ZONAS
                            </li>
                        </a>
                    <div class="line"></div>
                    <a href="{{route('resources.index')}}">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 32.258 28.62">
                                <g>
                                    <path  d="M31.278,4.021H11.984L10.9.677A.979.979,0,0,0,9.966,0H.979A.98.98,0,0,0,0,.98V27.64a.98.98,0,0,0,.98.98h30.3a.98.98,0,0,0,.98-.98V5a.98.98,0,0,0-.98-.98Z"/>
                                </g>
                            </svg>                                  
                            RECURSOS
                        </li>
                    </a>
                    <div class="line"></div>
                    <a href="{{route('gallery.index')}}">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.821 20">
                                <g transform="translate(0 -31.331)">
                                    <path d="M22.459,33.331H.362A.362.362,0,0,0,0,33.693v1.142s21.126,0,21.137,0c.251,0,.337.191.324.454.025.025,0,15.681,0,15.681h1.358c-.008.037,0-17.277,0-17.277A.361.361,0,0,0,22.459,33.331Z" transform="translate(2 -2)"/>
                                    <path d="M22.459,33.331H.362A.362.362,0,0,0,0,33.693V50.969a.362.362,0,0,0,.362.362h22.1a.361.361,0,0,0,.362-.362V33.693A.361.361,0,0,0,22.459,33.331ZM20.651,48.448,15.678,43.3a.148.148,0,0,0-.2-.008l-3.449,3.036L7.617,40.9a.145.145,0,0,0-.118-.055.148.148,0,0,0-.115.059l-5.214,7V35.5H20.651Z"/>
                                    <path d="M187.3,90.039a1.774,1.774,0,1,0-1.774-1.774A1.774,1.774,0,0,0,187.3,90.039Z" transform="translate(-172.115 -49.316)"/>
                                </g>
                            </svg>
                            GALERIAS
                        </li>
                    </a>
                    <div class="line"></div>
                    <a href="{{route('guidedVisit.index')}}">
                        <li>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 496.016 496.016" xml:space="preserve">
                                   <path d="M248.016,0C111.264,0,0.008,111.256,0.008,248.008s111.256,248.008,248.008,248.008
                                       c136.744,0,247.992-111.256,247.992-248.008S384.76,0,248.016,0z M370.6,141.28l-78.544,145.948c-1.076,2-2.716,3.648-4.724,4.728
                                       l-145.94,78.532c-1.736,0.932-3.624,1.384-5.504,1.384c-3.012,0-5.988-1.164-8.224-3.404c-3.632-3.628-4.452-9.212-2.02-13.732
                                       L204.172,208.8c1.08-2.004,2.724-3.652,4.728-4.728l145.956-78.536c4.52-2.436,10.096-1.612,13.732,2.016
                                       C372.212,131.184,373.04,136.76,370.6,141.28z"/>
                                   <path d="M248.248,220.984c-14.96,0-27.084,12.112-27.084,27.072c0,14.956,12.128,27.088,27.084,27.088
                                       c14.944,0,27.072-12.132,27.072-27.088C275.32,233.096,263.192,220.984,248.248,220.984z"/>
                           </svg>
                            VISITAS GUIADAS
                        </li>
                    </a>
                   
                    <div class="line"></div>
                    <a href="{{route('user.index')}}">
                        <li>
                            <svg id="user" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.258 36.866">
                                <path d="M144.625,2.7a9.216,9.216,0,1,1-13.034,0,9.216,9.216,0,0,1,13.034,0" transform="translate(-121.979 0)"/>
                                <path d="M62.489,295.384a25.6,25.6,0,0,0-28.275,0,4.57,4.57,0,0,0-1.991,3.8v7.986H64.481v-7.986A4.57,4.57,0,0,0,62.489,295.384Z" transform="translate(-32.223 -270.308)"/>
                            </svg>
                            USUARIOS
                        </li>
                    </a>
                    
                    <div class="line"></div>
                    <a href="{{route('backup.index')}}">
                        <li>
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 95.103 95.103" xml:space="preserve">
                                <path d="M47.561,0C25.928,0,8.39,6.393,8.39,14.283v11.72c0,7.891,17.538,14.282,39.171,14.282
                                        c21.632,0,39.17-6.392,39.17-14.282v-11.72C86.731,6.393,69.193,0,47.561,0z"/>
                                <path d="M47.561,47.115c-20.654,0-37.682-5.832-39.171-13.227c-0.071,0.353,0,19.355,0,19.355
                                        c0,7.892,17.538,14.283,39.171,14.283c21.632,0,39.17-6.393,39.17-14.283c0,0,0.044-19.003-0.026-19.355
                                        C85.214,41.284,68.214,47.115,47.561,47.115z"/>
                                <path d="M86.694,61.464c-1.488,7.391-18.479,13.226-39.133,13.226S9.875,68.854,8.386,61.464L8.39,80.82
                                    c0,7.891,17.538,14.282,39.171,14.282c21.632,0,39.17-6.393,39.17-14.282L86.694,61.464z"/>
                           </svg>
                            BACKUP
                        </li>
                    </a>

                    <div class="line"></div>
                    <a href="{{route('options.edit')}}">
                        <li>
                            <svg id="black-settings-button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.123 35.123">
                                <path d="M35.123,17.562a3.483,3.483,0,0,0-2.1-3.11,4.826,4.826,0,0,1-2.612-2.21A4.853,4.853,0,0,1,30.7,8.828a3.488,3.488,0,0,0-.716-3.686,3.488,3.488,0,0,0-3.686-.715,4.847,4.847,0,0,1-3.41.288A4.844,4.844,0,0,1,20.675,2.1,3.49,3.49,0,0,0,17.562,0a3.49,3.49,0,0,0-3.113,2.1,4.847,4.847,0,0,1-2.21,2.614,4.849,4.849,0,0,1-3.411-.288,3.488,3.488,0,0,0-3.686.715,3.488,3.488,0,0,0-.715,3.686,4.844,4.844,0,0,1,.284,3.413A4.83,4.83,0,0,1,2.1,14.452,3.482,3.482,0,0,0,0,17.562a3.49,3.49,0,0,0,2.1,3.113,4.846,4.846,0,0,1,2.612,2.211A4.835,4.835,0,0,1,4.427,26.3a3.488,3.488,0,0,0,.715,3.686,3.489,3.489,0,0,0,3.686.715,4.844,4.844,0,0,1,3.411-.287,4.858,4.858,0,0,1,2.21,2.615,3.491,3.491,0,0,0,3.113,2.1,3.491,3.491,0,0,0,3.113-2.1,4.862,4.862,0,0,1,2.208-2.615,4.838,4.838,0,0,1,3.411.287,3.356,3.356,0,0,0,4.4-4.4,4.85,4.85,0,0,1-.289-3.411,4.846,4.846,0,0,1,2.615-2.21A3.492,3.492,0,0,0,35.123,17.562ZM17.562,24.006A6.44,6.44,0,1,1,24,17.569,6.437,6.437,0,0,1,17.562,24.006Z"/>
                            </svg>
                            OPCIONES
                        </li>
                    </a>
                    <div class="line"></div>
                </ul>
            </div>

             <!-- CERRAR SESION -->    
             <div class="col100 logout mMarginBottom centerH">  
                <a href="{{url('')}}">
                    <button>Cerrar Sesión</button>
                </a>
            </div>
        </nav>
        
        <!-- CONTENIDO PRINCIPAL -->
        <main class="col84 row100">
			<div id="contentMain">
				@yield('content')
			</div>

			<!-- PIE DE PAGINA -->
			<footer class="col84">
				<center>
					<span>Creado por IES Celia Viñas 2DAW 19/20</span>
				</center>
			</footer>

        </main>

        <!-- VENTANA MODAL -->
        <div id="modalWindow" class="col100">
            @yield('modal')
        </div>

    </body>
</html>