@extends('layouts.frontend')

{{-- VENTANA MODAL --}}
@section('modal')
    {{--<div id="map" style="display: none">
        @include('backend.zone.map.zonemap') 
    </div>--}}
    
    <div id="containerModal">
        {{-- GALERIA DE IMAGENES --}}
        <div id="showAllImages" class="window" style="display: none" >
            <div id="galleryResources" class="col100">
                <button class="closeModal closeModalWindowButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                </button>
                
            </div>
            <div class="col100 centerV xlMarginTop">
                <div class="col5 leftArrow">
                    <img id="backResource" class="col100" src="{{ url('/img/icons/left.svg') }}" alt="leftArrow">
                </div>
                
                <div id="imageMiniature" class="col90"></div>

                <div class="col5 rightArrow">
                    <img id="nextResource" class="col100" src="{{ url('/img/icons/right.svg') }}" alt="rightArrow">
                </div>
            </div>
            <input type="hidden" name="numImages" id="numImages">
            <input type="hidden" name="actualResource" id="actualResource">
        </div>

        {{-- ESCAPE ROOM RANKING --}}
        <div id="modalRanking" class="window" style="display: none">
            <div class="col100">
                <button class="closeModal closeModalWindowButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                </button>
            </div>
            <div class="col100 mlMarginTop">
                <span class="titleModal col100 sMarginBottom">Ranking</span>
                <span class="col100 lMarginBottom">Los mejores tiempos:</span>
                <div class="col100">
                    <div class="col33 lMarginTop centerT">
                        <svg class="width40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510.77 512" fill="#999">
                            <path d="M351,482V392H161v90H126v30H386V482Z" transform="translate(-0.61 0)"/>
                            <path d="M191,474.89" transform="translate(-0.61 0)"/>
                            <path d="M435.66,45.84q1.38-14,1.4-28a928.36,928.36,0,0,0-362.12,0q0,14,1.4,28H.61L2.69,62.68C9,113.49,25.36,162.87,51.42,209.45c1.89,3.37,3.85,6.76,5.82,10.08a75.18,75.18,0,0,0,64.32,36.38H183a272.13,272.13,0,0,0,43,31.52V362h60V287.43a272.13,272.13,0,0,0,43-31.52h61.45a75.15,75.15,0,0,0,64.31-36.38c2-3.31,3.94-6.7,5.83-10.07,26.06-46.58,42.46-96,48.73-146.77l2.08-16.85ZM121.56,225.9A45,45,0,0,1,83,204.16c-1.83-3.08-3.65-6.23-5.41-9.36-21.25-38-35.56-77.93-42.64-119H80.83A336.53,336.53,0,0,0,153.74,225.9Zm312.83-31.1c-1.75,3.13-3.57,6.28-5.41,9.36a45,45,0,0,1-38.54,21.74H358.26a336.48,336.48,0,0,0,72.91-150H477C470,116.87,455.65,156.81,434.39,194.8Z" transform="translate(-0.61 0)"/>
                            <path fill="#fff" d="M254,60.87c26.75,0,55.78,10.89,55.78,42.6,0,34-25.6,40.49-53.67,40.49-11.08,0-29,2.87-29,17.38V172.8h83.09v23.49H201.85V161.15c0-30.75,27.89-39.92,54.25-39.92,10.12,0,28.65-1.72,28.65-17.19,0-14.52-13.18-21.39-30.37-21.39-13.18,0-26.74,6.68-26.93,18.72h-25C202.62,73.1,229.36,60.87,254,60.87Z" transform="translate(-0.61 0)"/>
                        </svg>
                        <div id="rPosition2" class="col100 mMarginTop"></div>
                    </div>
                    
                    <div class="col33 centerT">
                        
                        <svg class="width40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510.77 512" fill="#dba705">
                            <path d="M351,482V392H161v90H126v30H386V482Z" transform="translate(-0.61 0)"/>
                            <path d="M191,474.89" transform="translate(-0.61 0)"/>
                            <path d="M435.66,45.84q1.38-14,1.4-28a928.36,928.36,0,0,0-362.12,0q0,14,1.4,28H.61L2.69,62.68C9,113.49,25.36,162.87,51.42,209.45c1.89,3.37,3.85,6.76,5.82,10.08a75.18,75.18,0,0,0,64.32,36.38H183a272.13,272.13,0,0,0,43,31.52V362h60V287.43a272.13,272.13,0,0,0,43-31.52h61.45a75.15,75.15,0,0,0,64.31-36.38c2-3.31,3.94-6.7,5.83-10.07,26.06-46.58,42.46-96,48.73-146.77l2.08-16.85ZM121.56,225.9A45,45,0,0,1,83,204.16c-1.83-3.08-3.65-6.23-5.41-9.36-21.25-38-35.56-77.93-42.64-119H80.83A336.53,336.53,0,0,0,153.74,225.9Zm312.83-31.1c-1.75,3.13-3.57,6.28-5.41,9.36a45,45,0,0,1-38.54,21.74H358.26a336.48,336.48,0,0,0,72.91-150H477C470,116.87,455.65,156.81,434.39,194.8Z" transform="translate(-0.61 0)"/>
                            <path fill="#fff" d="M244.49,174.63V84.09H223.4V60.87h46.43V174.63H288.6v21.66H224.18V174.63Z" transform="translate(-0.61 0)"/>
                        </svg>
                        
                        <div id="rPosition1" class="col100 mMarginTop"></div>
                    </div>
                    <div class="col33 xlMarginTop centerT">
                        <svg class="width40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510.77 512" fill="#7f2d2d">
                            <path d="M351,482V392H161v90H126v30H386V482Z" transform="translate(-0.61 0)"/>
                            <path d="M191,474.89" transform="translate(-0.61 0)"/>
                            <path d="M435.66,45.84q1.38-14,1.4-28a928.36,928.36,0,0,0-362.12,0q0,14,1.4,28H.61L2.69,62.68C9,113.49,25.36,162.87,51.42,209.45c1.89,3.37,3.85,6.76,5.82,10.08a75.18,75.18,0,0,0,64.32,36.38H183a272.13,272.13,0,0,0,43,31.52V362h60V287.43a272.13,272.13,0,0,0,43-31.52h61.45a75.15,75.15,0,0,0,64.31-36.38c2-3.31,3.94-6.7,5.83-10.07,26.06-46.58,42.46-96,48.73-146.77l2.08-16.85ZM121.56,225.9A45,45,0,0,1,83,204.16c-1.83-3.08-3.65-6.23-5.41-9.36-21.25-38-35.56-77.93-42.64-119H80.83A336.53,336.53,0,0,0,153.74,225.9Zm312.83-31.1c-1.75,3.13-3.57,6.28-5.41,9.36a45,45,0,0,1-38.54,21.74H358.26a336.48,336.48,0,0,0,72.91-150H477C470,116.87,455.65,156.81,434.39,194.8Z" transform="translate(-0.61 0)"/>
                            <path fill="#fff" d="M235.72,137.19V116.53H255c13.59,0,27.93-3.63,28.12-16.07,0-7.65-6.12-17.79-27.54-17.79-11.86,0-27.93,4.21-27.93,16.46H202.44c0-28.89,28.69-39.41,53.37-39.41,25.25,0,52.41,12.24,52.61,40.74,0,10.53-6.89,22.77-18.56,26.4,12.82,4.21,21.81,16.84,21.81,28.12,0,32.72-30.8,42.47-56.63,42.47-25.44,0-54.52-10.71-54.71-41.13h25.44c0,13.78,18.56,18.56,29.46,18.56,12.82,0,29.85-5.36,29.85-19.7,0-8-4.4-18-28.51-18Z" transform="translate(-0.61 0)"/>
                        </svg>
                        <div id="rPosition3" class="col100 mMarginTop"></div>
                    </div>
                </div>

                <div id="separatorRanking" class="col100 lMarginTop"></div>

                {{--Columnas para el resto de elementos del ranking --}}
                <div class="col100 xlMarginTop">
                    <div id="rColum1" class="col50 containerRankingPosition sPaddingRight"></div>
                    <div id="rColum2" class="col50 containerRankingPosition sPaddingLeft"></div>
                </div>
            </div>
            <div id="containerReturnRanking"class="col100 centerT lMarginTop" style="display:none">
                <button id="returnStartRanking" class="buttonCustom">Volver</button>
            </div>
        </div>


        {{-- ESCAPE ROOM FINISH --}}
        <div id="modalFinishGame" class="window" style="display: none">
            <div class="col100">
                <button class="closeModal closeModalWindowButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                </button>
            </div>
            <div class="col100 mlMarginTop">
                <span class="titleModal col100 lMarginBottom">Juego Completado!</span>

                <div class="col100">
                    <span class="col0">Enhorabuena! Has consegido completar el misterio y escapar a tiempo.</span><br>
                    <span class="col0">Tiempo empleado:</span>
                    <div id="finishTime" class="lMarginTop xlMarginBottom col100 centerT">
                        <svg width="35px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 535.5 535.5">
                            <path d="M344.25,0h-153v51h153V0z M242.25,331.5h51v-153h-51V331.5z M446.25,163.2l38.25-35.7c-12.75-12.75-25.5-25.5-38.25-35.7
                                    l-35.7,35.7c-38.25-30.6-89.25-51-142.8-51c-127.5,0-229.5,102-229.5,229.5s102,229.5,229.5,229.5s229.5-102,229.5-229.5
                                    C497.25,252.45,479.4,201.45,446.25,163.2z M267.75,484.5c-99.45,0-178.5-79.05-178.5-178.5s79.05-178.5,178.5-178.5
                                    s178.5,79.05,178.5,178.5S367.2,484.5,267.75,484.5z"/>
                        </svg>
                        <span></span>
                        <svg width="35px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 535.5 535.5">
                            <path d="M344.25,0h-153v51h153V0z M242.25,331.5h51v-153h-51V331.5z M446.25,163.2l38.25-35.7c-12.75-12.75-25.5-25.5-38.25-35.7
                                    l-35.7,35.7c-38.25-30.6-89.25-51-142.8-51c-127.5,0-229.5,102-229.5,229.5s102,229.5,229.5,229.5s229.5-102,229.5-229.5
                                    C497.25,252.45,479.4,201.45,446.25,163.2z M267.75,484.5c-99.45,0-178.5-79.05-178.5-178.5s79.05-178.5,178.5-178.5
                                    s178.5,79.05,178.5,178.5S367.2,484.5,267.75,484.5z"/>
                        </svg>
                    </div>

                    <div id="noRankingTime" class="col100">
                        <span class="col0">Vaya... Parece que tu tiempo no se encuentra entre los 10 mejores, pero no te preocupes completar el misterio es todo un logro!</span>
                        <div class="col100 centerT lMarginTop">
                            <button id="bShowRankingComplete" class="buttonCustom">Ver ranking</button>
                        </div>
                    </div>

                    <div id="rankingTime" class="col100">
                        <span class="col0">Que velocidad! Has conseguido unos de los mejores tiempos, ¡El numero <strong id="currentPositionRanking"></strong> del ranking!</span>
                        <span class="col0">Introduce el nombre con el que quieres aparecer en la clasificación</span>
                        <div class="col100 centerT lMarginTop">
                            <form id="formSaveTime">
                                <input id="nickToRanking" class="width50 inputCustom" type="text" placeholder="Nombre" maxlength="10" required>
                                <button type="submit" id="bAddRanking" class="sMarginTop buttonCustom">Aceptar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ESCAPE ROOM OPENROOM --}}
        <div id="modalOpenRoom" class="window sizeWindow40" style="display: none">
            <div class="col100">
                <button class="closeModal closeModalWindowButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                </button>
            </div>
            <div class="col100 mlMarginTop">
                <span class="titleModal col100 lMarginBottom">Habitación desbloqueada!</span>

                <div class="col100">
                    <span>Acabas de encontrar la llave de <strong id="nameRoomOpen"></strong>, es hora de inspeccionar la nueva estancia...</span>
                </div>
                <div class="col100 centerT mMarginTop">
                    <svg class="width20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 557.45">
                        <path d="M325.11,192.25,94.64,192V114.55A96,96,0,0,1,281,82.23l63.13-12.78c-19.53-66.34-81-114.9-153.53-114.9-88.22,0-160,71.78-160,160v87.16A63.78,63.78,0,0,0,0,256V448a64.06,64.06,0,0,0,64,64H320a64.06,64.06,0,0,0,64-64V256C384,232.41,372.74,192.25,325.11,192.25ZM227.78,367.76a48.15,48.15,0,0,1-3.78,3.78V416H160V371.54a48,48,0,1,1,67.78-3.78Z" transform="translate(0 45.45)"/>
                    </svg>
                </div>
                <div class="col100 centerT lMarginTop">
                    <button class="closeModalOpenRoom closeModalWindowButton buttonCustom">Aceptar</button>
                </div>
            </div>
        </div>

         {{-- ESCAPE ROOM INITIAL TEXT --}}
         <div id="modalStartEscape" class="window sizeWindow60" style="display: block">
            <div id="startModalClose" class="col100" style="display: none">
                <button class="closeModal closeModalWindowButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                        </svg>
                </button>
            </div>

            <div id="instructionsStart" class="col100 mlMarginTop">
                <span class="titleModal col100 xlMarginBottom centerT">ESCAPE ROOM VIRTUAL</span>
                <div class="col100">
                    <div id="introText" class="col100 sMarginBottom">
                        Bienvenid@ al escape room virtual <strong id="nameTour"></strong>. ¿Serás capaz de seguir las pistas ocultas y resolver los enigmas del recorrido virtual para conseguir la llave de salida?
                    </div>
                    <div class="xlMarginTop col100 paragraphEscape">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 473.99 469.84"><rect x="183.93" width="30.15" height="67.22"/><rect y="183.93" width="67.22" height="30.15"/><rect x="70.62" y="47.58" width="30.15" height="73.11" transform="translate(-35.95 85.24) rotate(-45)"/><rect x="49.14" y="298.81" width="73.11" height="30.15" transform="translate(-198.4 152.53) rotate(-45)"/><rect x="278.88" y="69.06" width="73.11" height="30.15" transform="translate(31.34 247.69) rotate(-45)"/><polyline points="473.99 407.07 406.16 469.84 304.44 363.5 241.01 421.33 170.62 166.06 433.06 243.94 372.41 300.65"/></svg>
                        <div>                            
                            Explora las diferentes estancias en busca de elementos que puedan proporcionarte nuevas pistas para conseguir escapar, debes <strong>pulsar</strong> sobre ellos para inspeccionarlos.
                        </div>
                    </div>

                    <div class="xlMarginTop col100 paragraphEscape">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 470.33 470.33"><rect fill="transparent" x="-106.67" y="-0.09" width="469.33" height="469.33" transform="translate(363.17 469.74) rotate(180)"/><path d="M175,200.44a137.72,137.72,0,1,0-64.92,64.91L180.7,336l-64.92,64.93L180.7,465.8l64.92-64.92,32.46,32.45L343,368.41ZM18.41,173.66a45.91,45.91,0,1,1,64.92,0h0a45.89,45.89,0,0,1-64.9,0Z" transform="translate(107.17 0.59)"/></svg>
                        <div>                            
                            En tu exploración podrás toparte con enigmas y preguntas que resolver. Gracias a estas podrás <strong>obtener llaves</strong> de acceso a las habitaciones que se encuentran bloqueadas, para poder continuar así con la investigación.
                        </div>
                    </div>

                    <div class="xlMarginTop col100 paragraphEscape">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 535.5 535.5"  xml:space="preserve"><path d="M344.25,0h-153v51h153V0z M242.25,331.5h51v-153h-51V331.5z M446.25,163.2l38.25-35.7c-12.75-12.75-25.5-25.5-38.25-35.7l-35.7,35.7c-38.25-30.6-89.25-51-142.8-51c-127.5,0-229.5,102-229.5,229.5s102,229.5,229.5,229.5s229.5-102,229.5-229.5C497.25,252.45,479.4,201.45,446.25,163.2z M267.75,484.5c-99.45,0-178.5-79.05-178.5-178.5s79.05-178.5,178.5-178.5s178.5,79.05,178.5,178.5S367.2,484.5,267.75,484.5z"/></svg>  
                        <div>                            
                            Hay que darse prisa, el <strong>marcador de tiempo</strong> no se detendrá hasta completar la misión, consigue uno de los mejores tiempos para entrar en el ranking de los mejores escapistas.
                        </div>
                    </div>
                    
                </div>
                <div class="col100 centerT lMarginTop">
                    <div class="col50 mPaddingRight">
                        <button id="rankingStart" class="right buttonCustom">Ranking</button>
                    </div>
                    <div class="col50 mPaddingLeft">
                        <button id="continueStartButton" class="col0 buttonCustom">Jugar</button>
                    </div>
                </div>
            </div>

            <div id="initialHistory" class="col100 mlMarginTop" style="display:none">
                <span class="titleModal col100 xlMarginBottom centerT">ESCAPE ROOM VIRTUAL</span>
                <div id="textHistoryInitial"class="col100"></div>
                <div class="col100 centerT lMarginTop">
                    <button id="startGameButton" class=" buttonCustom">Comenzar</button>
                </div>
            </div>
        </div>

        {{-- ESCAPE ROOM PISTAS --}}
        @include('frontend.escaperoom.modalclue')
        {{-- ESCAPE ROOM PREGUNTAS --}}
        @include('frontend.escaperoom.modalquestion')

        <script>
            $('.closeModalWindowButton').click(function(){
                $('#modalWindow').hide();
                $('#showAllImages').hide();
                $('.window').hide();
                $('#galleryResources').empty();
                //Detener narración
                document.getElementById('narrationSound').pause();
                document.getElementById('narrationSound').currentTime = 0; // Resetear tiempo
            });
        </script>
    </div>
@endsection

{{-- CONTENIDO --}}
@section('content')
    <link rel='stylesheet' href='{{url('css/hotspot/textInfo.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/audio.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/video.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/jump.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/portkey.css')}}'>
    <link rel='stylesheet' href='{{url('css/hotspot/imageGallery.css')}}'>
   
    {{-- MUSICA DE FONDO --}}
    <audio id="backgroundSound" class="notStopChangeScene" src="{{url('/img/options/'.$backgroundSound)}}" preload="auto" style="display:none" controls loop></audio>
    {{-- NARRACIONES --}}
    <audio id="narrationSound" style="display:none" preload="auto" controls></audio>

    <!-- PANEL SUPERIO CON TITULO DE LA ESCENA -->
    <div id="titlePanel" class="absolute l3">
        <span></span><br>
        <div class="lineSub"></div>
    </div>

    <!-- PANEL SUPERIO MARCADOR + SONIDO -->
    <div id="topRightPanel" class="absolute l3" style="display: none">
        <div id="soundEscapeControl" class="col0">
            <svg id="soundEscapeOn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384" xml:space="preserve">
                <g>
                    <path d="M288,192c0-37.653-21.76-70.187-53.333-85.867v171.84C266.24,262.187,288,229.653,288,192z"/>
                    <polygon points="0,128 0,256 85.333,256 192,362.667 192,21.333 85.333,128"/>
                    <path d="M234.667,4.907V48.96C296.32,67.307,341.333,124.373,341.333,192S296.32,316.693,234.667,335.04v44.053C320.107,359.68,384,283.413,384,192S320.107,24.32,234.667,4.907z"/>
                </g>
           </svg>
           

           <svg id="soundEscapeOff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384" style="display:none">
                <g>
                    <path d="M288,192c0-37.653-21.76-70.187-53.333-85.867v47.147l52.373,52.373C287.68,201.173,288,196.587,288,192z"/>
                    <path d="M341.333,192c0,20.053-4.373,38.933-11.52,56.32l32.32,32.32C376,254.08,384,224,384,192c0-91.307-63.893-167.68-149.333-187.093V48.96C296.32,67.307,341.333,124.373,341.333,192z"/>
                    <polygon points="192,21.333 147.413,65.92 192,110.507 "/>
                    <path d="M27.2,0L0,27.2L100.8,128H0v128h85.333L192,362.667V219.2l90.773,90.773c-14.293,10.987-30.4,19.84-48.107,25.173V379.2 c29.333-6.72,56.107-20.16,78.613-38.613L356.8,384l27.2-27.2l-192-192L27.2,0z"/>
                </g>
            </svg>
        </div>
        <div id="timerCount" class="col0">
            <span>00:00</span>
        </div>
    </div>
    
    {{-- PANEL LATERAL DERECHO PARA MOSTRAR LAS LLAVES --}}
    <div id="keyPanel" class="absolute l3" style="display: none">
        
    </div>


    <!-- PANEL LATERAL DE OPCIONES -->
    <div id="leftPanel" class="col40 absolute l2" style="display:none">
        <div id="actionButton" class="col10">
            <!-- BOTON DESPLAZAR PLANTAS  -->
            <div id="buttonsFloorCont" class="col100 xlMarginBottom" style="display:none">
                <div id="floorUp">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                        <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#fff"/>
                    </svg>                          
                </div>
                <div id="floorDown">
                    <svg class="col100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32" style="transform: rotate(180deg)">
                        <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#fff"/>
                    </svg>                          
                </div>
            </div>

            <!-- BOTON MAPA -->
            <div id="buttonMap">
                <svg id="mapIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.258 32.266">
                    <path  d="M.067,5.416V35.55l9.511-1.722V3.505Z" transform="translate(-0.067 -3.284)"/>
                    <path  d="M190.462,25.3V4.78L180.99,3.151V33.474L190.462,35V27.283C190.466,27.265,190.462,25.3,190.462,25.3Z" transform="translate(-169.588 -2.952)"/>
                    <path  d="M361.293,1.807V32.023l9.493-1.785V0Z" transform="translate(-338.529)"/>
                </svg>          
                
                <svg id="closeMapIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" style="display:none">
                    <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
                </svg>    
            </div>

            {{-- BOTON VER HISTORIA --}}
            <div id="buttonHistory">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 348.16 422.91">
                    <title>Ver historia 📕</title>
                    <path d="M86.53,0A49.15,49.15,0,0,0,37.38,49.15V373.76a49.14,49.14,0,0,0,49.15,49.15h299V67.58h-41V0M170.25,194l-44.81,36.87V98.3h90.11V230.91M313.86,67.58H86.53a18.43,18.43,0,0,1,0-36.86H313.86V67.58Z" transform="translate(-37.38 0)"/>
                </svg>
            </div>

            {{-- BOTON VER RANKING --}}
            <div id="buttonRanking">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510.77 480.46">
                    <title>Ver ranking 🏆</title>
                    <path d="M351,482V392H161v90H126v30H386V482Z" transform="translate(-0.61 -31.54)"/>
                    <path d="M435.66,77.38q1.38-14,1.4-28a928.36,928.36,0,0,0-362.12,0q0,14,1.4,28H.61L2.69,94.23C9,145,25.36,194.42,51.42,241c1.89,3.37,3.85,6.76,5.83,10.08a75.15,75.15,0,0,0,64.31,36.38H183A272.13,272.13,0,0,0,226,319v74.52h60V319a272.13,272.13,0,0,0,43-31.52h61.45a75.15,75.15,0,0,0,64.31-36.38c2-3.31,3.94-6.7,5.83-10.07,26.06-46.58,42.46-96,48.73-146.77l2.08-16.85ZM121.56,257.44A45,45,0,0,1,83,235.7c-1.83-3.08-3.65-6.23-5.4-9.36-21.26-38-35.57-77.92-42.65-118.95H80.83a336.53,336.53,0,0,0,72.91,150.05Zm312.83-31.1c-1.75,3.13-3.57,6.28-5.41,9.36a45,45,0,0,1-38.54,21.74H358.26a336.43,336.43,0,0,0,72.91-150H477C470,148.41,455.65,188.35,434.39,226.34Z" transform="translate(-0.61 -31.54)"/>
                </svg>
            </div>

             <!-- BOTON PANTALLA COMPLETA -->
            <div id="buttonFullScreen">
                {{--Abrir pantalla completa--}}
                <svg id="openFull" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357">
                    <path d="M51,229.5H0V357h127.5v-51H51V229.5z M0,127.5h51V51h76.5V0H0V127.5z M306,306h-76.5v51H357V229.5h-51V306z M229.5,0v51
                        H306v76.5h51V0H229.5z"/>
                </svg>
                {{--Cerrar pantalla completa--}}
                <svg id="exitFull" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357 357" style="display:none">
                    <path d="M0,280.5h76.5V357h51V229.5H0V280.5z M76.5,76.5H0v51h127.5V0h-51V76.5z M229.5,357h51v-76.5H357v-51H229.5V357z
                        M280.5,76.5V0h-51v127.5H357v-51H280.5z"/>
                </svg>
            </div>
        </div>

        {{-- MAPAS PLANTAS --}}
        <div id="mapContent" class="col90">
            @foreach ($allZones as $key => $zone)
                <div id="map{{ $key }}" class="map" value="{{$zone->id}}">
                    {{-- Mapa --}}
                    <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}">
                    {{-- Dibujar puntos de zonas --}}
                    @foreach ($data as $scene)
                        @if($scene->id_zone == $zone->id)
                            <div id="point{{$scene->id}}" class="pointMap" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%;">
                                <div class="pointMapInside"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!-- IMAGEN 360 -->
    <div id="pano" class="l1 col100"></div>

    <!-- HOTSPOTS -->
    <div id="contentHotSpot"></div>

    <!-- AGREGAR SCRIPTS -->
    <script src="{{url('/js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('/js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('/js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('/js/marzipano/marzipano.js')}}"></script>

    <script src="{{url('/js/marzipano/easing.js')}}" ></script>
    <script src="{{url('/js/marzipano/transitionFunctions.js')}}" ></script>

    <script src="{{url('/js/frontend/textInfo.js')}}"></script>
    <script src="{{url('/js/frontend/audio.js')}}"></script>
    <script src="{{url('/js/frontend/video.js')}}"></script>
    <script src="{{url('/js/frontend/jump.js')}}"></script>
    <script src="{{url('/js/frontend/portkey.js')}}"></script>
    <script src="{{url('/js/frontend/fullScreen.js')}}"></script>
    <script src="{{url('/js/frontend/imageGallery.js')}}"></script>
    <script src="{{url('/js/frontend/hide.js')}}"></script>

    <script>      
        var token = "{{ csrf_token() }}";  
        var indexUrl = "{{ url('img/resources/') }}";
        var url = "{{url('')}}";
        var data = @json($data);
        var subt = @json($subtitle);
        var indexSubt = "{{url('img/resources/subtitles')}}";
        
        /////// Variables especificas para el escape room

        var keys = @json($keys);
        var lockScenes=[]; //Listado de escenas bloqueadas
        var lockJumps=[];//Listado con todos los saltos bloqueados

        var padlockIcon=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="hotspotPadlock">
                            <path d="M416,200.9V160C416,71.78,344.22,0,256,0S96,71.78,96,160v40.9A63.77,63.77,0,0,0,64,256V448a64.06,64.06,0,0,0,64,64H384a64.06,64.06,0,0,0,64-64V256a63.77,63.77,0,0,0-32-55.1ZM256,64a96.1,96.1,0,0,1,96,96v32H160V160A96.1,96.1,0,0,1,256,64Zm32,307.54V416H224V371.54a48,48,0,1,1,64,0Z" transform="translate(-64 0)"/>
                         </svg>`;
        var posRanking=null;
        
        var clues = @json($clues); //Obtener todas las pistas de la base de datos
        var questions = @json($questions); //Otener preguntas con sus respuestas
        var startGame = false;
        var backgroundSound = @json($backgroundSound);
        var audios = @json($audios);
        var enabledSoundEscape=true;
        var initNarration = @json($initNarration);
        var principalScene = @json($principalScene);
        
        /////////////////////////////////////////////////

        //Relaciones entre los diferentes tipos y el hotspot
        var hotsRel = @json($hotspotsRel); 
        var typePortkey = @json($typePortkey);
        //Rutas necesarias por scripts externos
        var getScenesPortkey = "{{ route('portkey.getScenes', 'id') }}";
        
        /* RUTA PARA SACAR EL ID DE LA GALERÍA A TRAVÉS DEL ID DEL HOTSPOT */
        var getIdGalleryRoute = "{{ route('htypes.getIdGallery', 'hotspotid') }}";
        /* RUTA PARA SACAR LAS IMÁGENES DE UNA GALERÍA */
        var getImagesGalleryRoute = "{{ route('gallery.resources', 'id') }}";
        /* URL PARA LAS IMÁGENES DE LA GALERÍA */
        var urlImagesGallery = "{{ url('img/resources/image') }}";
        //URL PARA LA IMAGEN DE UN PUNTO
        var ScenePointUrl = "{{ url('img/zones/icon-zone.png') }}";
        // URL PARA LAS IMAGENES DE PORTKEYS
        var urlImagesPortkey = "{{ url('img/portkeys') }}";
        // URL PARA OBTENER LOS DATOS DE UN PORTKEY
        var getPortkey = "{{ route('portkey.openUpdate', 'insertIdHere') }}";
        
        //Confirmación para cerrar ventana
        var unloadEvent = function (e) {
            var confirmationMessage = "¿Desea cerrar la ventana? El progreso se perderá...";
            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage; //Webkit, Safari, Chrome etc.
        };
        window.addEventListener("beforeunload", unloadEvent);

        $( document ).ready(function() {
                       
            //Mostrar la escena inicial
            var escenaIni=false;
            for(var j=0; j<data.length; j++){
                if(data[j].id==principalScene){
                    changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                    escenaIni=true;
                }
            }
            //Si no se encuentra escena inicial, establecemos la primera
            if(!escenaIni){
                changeScene(data[0].id, data[0].pitch, data[0].yaw, false);
            }
            
            //EVENTOS
            /*
            * Aplicar funcionalidad a los puntos del mapa para cambiar de escena al presionarlos
            */
            $(".pointMap").on("click", function(){
                var idPulse = $(this).attr("id");
                idPulse = idPulse.replace("point", "");
                for(var j=0; j<data.length; j++){
                    if(data[j].id==idPulse){
                        changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                    }
                }
            });       

            /*
            * Boton para subir de planta
            */
            $("#floorUp").on("click", function(){
                //Obtener el id del elemento visible
                if($('.map.showMap').length>=1){
                    var map = parseInt($('.map.showMap').attr("id").replace("map", ""));
                    //Comprobar que no queremos subir mas de las plantas existentes
                    if((map+1)<=$(".map").length-1){
                        $("#map"+map).removeClass('showMap'); //Ocultar actual
                        $("#map"+map).on('transitionend', function(e) {
                            $("#map"+map).off('transitionend');
                            $("#map"+(map+1)).addClass('showMap');//Mostrar siguiente
                        });
                        
                    }
                }
            });

            /*
            * Boton para bajar de planta
            */
            $("#floorDown").on("click", function(){
                //Obtener el id del elemento visible
                if($('.map.showMap').length>=1){
                    var map = parseInt($('.map.showMap').attr("id").replace("map", ""));
                    //Comprobar que no queremos subir mas de las plantas existentes
                    if((map-1)>=0){
                        $("#map"+map).removeClass('showMap'); //Ocultar actual
                        $("#map"+map).on('transitionend', function(e) {
                            $("#map"+map).off('transitionend');
                            $("#map"+(map-1)).addClass('showMap');//Mostrar siguiente
                        });
                        
                    }
                }
            });
            /*
            * Boton para mostrar y ocultar el mapa
            */
            $("#buttonMap").on("click", function(){
                $("#closeMapIcon, #mapIcon").hide();
                if($("#mapContent").hasClass("showContentMap")){
                    //Ocultar
                    $("#mapContent").removeClass("showContentMap");
                    $("#mapIcon").show();
                    $("#buttonsFloorCont").hide();
                }else{
                    //Mostrar
                    $("#mapContent").addClass("showContentMap");
                    $("#closeMapIcon").show();
                    $("#buttonsFloorCont").show();
                }
            });

            //------------------------------------------------------------------------

            /*
             * ACCION PARA ATENUAR LOS HOTSPOT MIENTRAS NO SE MUEVE EN LA VISTA
             */
            var clickDown = false;
            var drag = false;
            $(".hotspotElement").addClass("hotsLowOpacity");

            $("#pano")
            .mousedown(function() {
                clickDown = true;
            })
            .mousemove(function() {
                if(clickDown){
                    drag="true";
                    //Al arrastrar la vista que mostrar los hotspot
                    $(".hotspotElement").removeClass("hotsLowOpacity");
                }
            })
            /*
            .mouseup(function() {
                clickDown=false;
                if(drag){
                    //Desvanecer puntos al dejar de arrastrar
                    $(".hotspotElement").addClass("hotsLowOpacity");
                    drag=false;
                }
            });*/

            //------------------------------------------------------------------------
            // ESCAPE ROOM
            //------------------------------------------------------------------------
            getRanking();//Al iniciar, obtener el ranking
            $("#nameTour").text(@json($nameTour)[0].value);//Establecer titulo en texto inicial
            $("#modalWindow").show(); //Inicialmente mostrar la ventana modal de explicacion incial
            //Establecer texto de historia inicial del escape room
            $("#textHistoryInitial").html(@json($initialHistory)[0].value); 
            //Bloquear las abitaciones con llave inicialmente
            lockPoints();

            //Al pulsar el boton de ranking
            $("#buttonRanking").on("click", function(){
                //Llamada al metodo para refrescar los datos del ranking
                getRanking();
                //Mostrar la ventana modal correspondiente
                $(".window").hide();
                $('.closeModalWindowButton').show();
                $('#modalRanking').show();
                $('#modalWindow').show();
            });

            //--------------------------------------------------------------------

            //Funcionalidad al hacer click en aceptar del formulario 
            //para almacenar entrada en el ranking
            $("#formSaveTime").on("submit", function(e){
                e.preventDefault();
                //Almacenar valor en la base de datos
                var nickInput = $("#nickToRanking").val();
                var urlStoreRanking = "{{ route('ranking.store') }}";
                $.ajax({
                    url: urlStoreRanking,
                    type: 'POST',
                    data: {
                        "_token": token,
                        nick: nickInput,
                        time: time
                    },

                    success:function(data){
                        //Si se guarda correctamente, recuperamos y mostramos el ranking
                        if(data.status){
                            getRanking().done(function(){
                                $(".window").hide();
                                $('#modalRanking').show();
                            });
                        }
                    }
                });
            });

            //---------------------------------------------------------------------

            //Funcionalidad del boton inicial "continuar"
            $("#continueStartButton").on("click", function(){
                $("#instructionsStart").hide();
                $("#initialHistory").show();
                //Reproducir audio ambiente
                document.getElementById('backgroundSound').play();
                //Narracion inicial
                $("#narrationSound").attr("src", url+"/img/options/"+initNarration);
                document.getElementById('narrationSound').play();
            });

            //---------------------------------------------------------------------

            //Funcionalidad para el botón de iniciar la partida
            $("#startGameButton").on("click",function(){
                $(".window").hide();
                $('#modalWindow').hide();
                //Mostrar elementos UI
                $("#leftPanel, #keyPanel, #topRightPanel").show();
                //Iniciar contador de tiempo si no esta iniciado
                if(!startGame){
                    startGame=true;
                    timerStart();
                }
                //Detener narracion inicial
                document.getElementById('narrationSound').pause();
                document.getElementById('narrationSound').currentTime = 0; // Resetear tiempo
            });

            //---------------------------------------------------------------------

            //Funcionalidad para el boton de ver ranking
            $("#buttonHistory").on("click", function(){
                $(".window").hide();
                $("#startModalClose").show();
                $("#modalStartEscape").show();
                $('#modalWindow').show();
                $("#startGameButton").text("Aceptar");
                //Narracion inicial
                $("#narrationSound").attr("src", url+"/img/options/"+initNarration);
                document.getElementById('narrationSound').play();
            });        

            //---------------------------------------------------------------------

            // Al finalizar la narracion de sonido subir volumen del audio de fondo
            $('#narrationSound').on('ended pause', function() {
                $('#backgroundSound').animate({volume: 0.5}, 2000);
            });

            //---------------------------------------------------------------------

            //Al reproducirse una narracion de sonido bajar el volumen de la musica de fondo
            $('#narrationSound').on('playing', function() {
                $('#backgroundSound').animate({volume: 0.05}, 2000);
            });

            //---------------------------------------------------------------------

            //Funcionalidad al hacer click sobre el control de sonido del escape
            $('#soundEscapeControl').on('click', function(){
                if(enabledSoundEscape){
                    //Desactivar sonido
                    $("#soundEscapeOff").show();
                    $("#soundEscapeOn").hide();
                    enabledSoundEscape=false;
                    document.getElementById('backgroundSound').pause();
                    $('#backgroundSound').volume = 0.5;
                }else{
                    //Activar sonido
                    $("#soundEscapeOff").hide();
                    $("#soundEscapeOn").show();
                    enabledSoundEscape=true;
                    document.getElementById('backgroundSound').play();
                    $('#backgroundSound').volume = 0.5;
                }
            });

            //---------------------------------------------------------------------

            //Mostrar ranking al pulsar el boton inicial
            $('#rankingStart').on('click', function(){
                //Llamada al metodo para refrescar los datos del ranking
                getRanking();
                //Mostrar boton de volver
                $("#containerReturnRanking").show();
                //Ocultar boton de cerrar
                $('.closeModalWindowButton').hide();
                //Mostrar la ventana modal correspondiente
                $(".window").hide();
                $('#modalRanking').show();
                $('#modalWindow').show();
            });

            //---------------------------------------------------------------------

            //Accion al pulsar el boton de volver de la ventana ranking
            $("#returnStartRanking").on("click", function(){
                $("#containerReturnRanking").hide();
                $('#modalRanking').hide();
                $('#modalStartEscape').show();
            });
        });

        //--------------------------------------------------------------------------------------------
        // ESCAPE ROOM
        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA INICIAR EL MARCADOR DE TIEMPO
        */
        var time=0;
        var counter;
        function timerStart(){
            //Contador de tiempo
            counter=window.setInterval(function(){
                time++;
                var min = Math.trunc(time/60).toString();
                var sec = (time%60).toString();
                $("#timerCount span").text(min.padStart(2, 0)+":"+sec.padStart(2, 0));
            },1000);
        }

        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA APLICAR ANIMACION A LAS ETIQUETAS DE LAS LLAVES
        */
        function animateLabelKey(){
            //Animación para las etiquetas de las llaves
            $( ".keyContainer svg" ).hover(
                function() {
                    //Mostrar etiqueta
                    var hoverKey =  $(this).parent().find(".labelKey div").addClass("animateShowLabelKey");
                    hoverKey.removeClass("animateHideLabelKey");
                    hoverKey.addClass("animateShowLabelKey");
                }, function() {
                    //Ocultar etiqueta
                    var hoverKey =  $(this).parent().find(".labelKey div").addClass("animateShowLabelKey");
                    hoverKey.addClass("animateHideLabelKey");
                    hoverKey.removeClass("animateShowLabelKey");
                }
            );
        }

        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA BLOQUEAR LAS ESCENAS CON LLAVE
        */
        function lockPoints(){
            //Cada una de las llaves
            for(var i=0; i<keys.length; i++){
                var scenesToLock = keys[i].scenes_id.split(",");

                //Cada una de las escenas de una llave
                for(var j=0; j<scenesToLock.length; j++){
                    //Editar punto
                    $("#point"+scenesToLock[j]+" .pointMapInside").remove();
                    $("#point"+scenesToLock[j]).append(`
                        <div class="pointPadlock">
                            `+padlockIcon+`
                        </div>
                    `);
                    $("#point"+scenesToLock[j]).off("click");
                    //Agregar al listado
                    lockScenes.push(scenesToLock[j]);
                }

                //Agregar icono de llave
                $("#keyPanel").append(`
                    <div id="key`+keys[i].id+`" class="keyContainer centerV">
                        <div class="labelKey col82">
                            <div>`+keys[i].name+`</div> 
                        </div>
                        <svg class="col18 keyClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256.08 469.51">
                            <path d="M170.66,248.53a128,128,0,1,0-85.33,0V371.8A18.45,18.45,0,0,1,88.39,374a18.72,18.72,0,0,1,4.14,5.31,17.06,17.06,0,0,1,5.88,27,16.94,16.94,0,0,1-1.34,1.34v15.8H85.33v45.86h85.33V426.67H256V341.33H170.66ZM128,170.67h0A42.67,42.67,0,1,1,170.66,128h0A42.66,42.66,0,0,1,128,170.67Z" transform="translate(0.04 0.18)"/>
                            <path fill="#fff" d="M138.93,334.9V318.75a63.27,63.27,0,0,0-53.6-62.44,64.26,64.26,0,0,0-9.57-.72h-.41A63.21,63.21,0,0,0,12.6,318.75V334.9A25.18,25.18,0,0,0,0,356.66v75.78a25.29,25.29,0,0,0,25.27,25.27H126.28a25.29,25.29,0,0,0,25.28-25.27V356.66A25.23,25.23,0,0,0,138.93,334.9Zm-75.8,84.91V402.26a18.93,18.93,0,0,1,12.22-33.05,18.73,18.73,0,0,1,10,2.59A18.45,18.45,0,0,1,88.39,374a18.72,18.72,0,0,1,4.14,5.31,18.93,18.93,0,0,1-2.65,21.44,20.94,20.94,0,0,1-1.49,1.49v17.55Zm50.52-88.43H37.86V318.75a37.93,37.93,0,0,1,37.49-37.89h.41a37.9,37.9,0,0,1,37.89,37.89Z" transform="translate(0.04 0.18)"/>
                        </svg>

                        <svg class="col18 keyOpen" style="display:none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 469.33">
                            <path fill="#fff" d="M192,248.53a128,128,0,1,1,85.33,0v92.8h85.34v85.34H277.33v42.66H192ZM277.33,128a42.67,42.67,0,1,0-42.66,42.67A42.66,42.66,0,0,0,277.33,128Z" transform="translate(-106.67 0)"/>
                        </svg>
                    </div>
                `);
            }
            //Llamada al metodo para cargar los hotspots
            callLoadHotspots();
            //Lamada al metodo para aplicar animacion a las etiquetas de las llaves
            animateLabelKey();
        }

        //--------------------------------------------------------------------------------------------

        /**
        * METODO PARA DESBLOQUEAR UNA ESCENA PASANDO EL ID DE LA LLAVE
        */
        function unlockPoints(id, idQuest){
            //Cada una de las llaves
            for(var i=0; i<keys.length; i++){
                //Buscar la llave pasada por parametro
                if(keys[i].id==id){
                    var scenesToUnlock = keys[i].scenes_id.split(",");

                    //Cada una de las escenas de la llave
                    for(var j=0; j<scenesToUnlock.length; j++){
                        //Comprobar si la escena esta bloqueada por si ya se ha ejecutao el metodo
                        if(lockScenes.includes(scenesToUnlock[j])){

                            //1. Eliminar las escenas bloqueadas del listado
                            for(var k=lockScenes.length-1; k>=0; k--){
                                if(scenesToUnlock[j]==lockScenes[k]){
                                    lockScenes.splice( k, 1 );
                                }
                            }

                            //2. Reestablecer puntos en el mapa
                            $("#point"+scenesToUnlock[j]+" .pointPadlock").remove();
                            $("#point"+scenesToUnlock[j]).append(` <div class="pointMapInside"></div> `);

                            //3. Reestablecer funcionalidad del punto
                            $("#point"+scenesToUnlock[j]).on("click", function(){
                                var idPulse = $(this).attr("id");
                                idPulse = idPulse.replace("point", "");
                                for(var j=0; j<data.length; j++){
                                    if(data[j].id==idPulse){
                                        changeScene(data[j].id, data[j].pitch, data[j].yaw, false);
                                    }
                                }
                            });

                            //4. Reestablecer saltos
                            for(var k=0; k<lockJumps.length; k++){
                                if(scenesToUnlock[j]==lockJumps[k].idScene){
                                    //4.1 Eliminamos el hotspot de tipo candado
                                    lockJumps[k].scene.hotspotContainer().destroyHotspot(lockJumps[k].oldHots);
                                    //4.2 Establecemos el nuevo punto de tipo salto
                                    loadHotspot(lockJumps[k].scene, lockJumps[k].hotspot);
                                }
                            }

                            //5. Eliminar los saltos bloqueados del listado
                            for(var k=lockJumps.length-1; k>=0; k--){
                                if(scenesToUnlock[j]==lockJumps[k].idScene){
                                    lockJumps.splice( k, 1 );
                                }
                            }
                        }
                        
                    }

                    //Comprobar si se ha habierto la habitación final
                    if(keys[i].finish){
                        //Mostrar mensaje final del juego
                        completeGame();
                    }else{
                        //Mostrar ventana habitacion abierta + pista al finalizar
                        $("#nameRoomOpen").text(keys[i].name);
                        $(".window").hide();
                        $('#modalOpenRoom').show();
                        $('#modalWindow').show();

                        //Comprobar si tras el mensaje de apertura se debe mostrar una pista
                        if(idQuest!=-1){
                            $(".closeModalOpenRoom").on("click", function(){
                                //Mostrar pista
                                openClueAssociated(idQuest);
                                $(".closeModalOpenRoom").off();
                            });                            
                        }
                    }

                    //Cambiar icono de la llave
                    $("#key"+id+" .keyClose").hide();
                    $("#key"+id+" .keyOpen").show();
                    $("#key"+id+" .labelKey").addClass("unlockKey");

                }          
            }
        }

        //-----------------------------------------------------------------------------

        /**
        * METODO PARA RELLENAR LA VENTANA MODAL CON LOS DATOS DEL RANKING 
        */
        function getRanking(){
            //Obtener los registros del ranking
            var routeRanking = "{{ route('ranking.index') }}";
            
            return $.get(routeRanking, function(data){
                //Eliminar contenido previo
                $("#rColum1, #rColum2").empty();
                
                //Recorrer todos los elementos del ranking
                for(var i=0;i<data.length;i++){
                    var min = Math.trunc(data[i].time/60).toString();
                    var sec = (data[i].time%60).toString();
                    //Si es mi propia posicion obtenida marcamos el elemento
                    if(posRanking!=null && posRanking == (i+1)){
                        var element = "<span class='myPositionRanking'><strong>"+(i+1)+"º </strong><span class='elemRanking'>"+data[i].nick+"</span> ("+min+"m "+sec+"s)</span>";
                    }else{
                        var element = "<strong>"+(i+1)+"º </strong><span class='elemRanking'>"+data[i].nick+"</span> ("+min+"m "+sec+"s)";
                    }
                    
                    
                    //Agregar el tiempo de ranking segun la posicion
                    switch (i+1){
                        case 1: $("#rPosition1").html(element); break;
                        case 2: $("#rPosition2").html(element); break;
                        case 3: $("#rPosition3").html(element); break;
                        
                        //En otro caso
                        default:
                            var colum;
                            if((i+1)<=7){
                                //Introducir en la columna izquierda
                                colum = $("#rColum1");
                            }else{
                                //Introducir en la columna derecha
                                colum = $("#rColum2");
                            }
                            colum.append(`
                                <div class="col100">
                                    `+element+`
                                </div>
                            `);
                        break;

                    }                    
                }
            });
        }

        //-----------------------------------------------------------------------------

        /**
         * METODO QUE SE EJECUTARÁ AL FINALIZAR LA PARTIDA PARA 
         */
        function completeGame(){
            //1. Detener el contador de tiempo
            clearInterval(counter);

            //2. Establecer el tiempo empleado en la ventana
            var min = Math.trunc(time/60).toString();
            var sec = (time%60).toString();
            $("#finishTime span").text(min.padStart(2, 0)+"m "+sec.padStart(2, 0)+"s");
            
            //3. Obtener los registros del ranking
            var routeRanking = "{{ route('ranking.index') }}";
            $.get(routeRanking, function(data){
                //Comprobar si su tiempo entra en el ranking
                
                //ENTRA EN EL RANKING
                if(data.length<10 || time<data[data.length-1].time){
                    $("#noRankingTime").remove();

                    //Obtener posicion dentro del ranking
                    var pos=1;
                    for(var i=0; i<data.length; i++){
                        if(time>=data[0].time && time>=data[i].time){
                            pos=i+2;
                        }
                    }
                    //Indicar la posicion
                    posRanking = pos;
                    $("#currentPositionRanking").text(pos);

                //NO ENTRA EN EL RANKING
                }else{    
                    $("#rankingTime").remove();
                    //Al hacer clic en el boton de ver ranking de la ventana modal
                    $("#bShowRankingComplete").on("click", function(){
                        $(".window").hide();
                        $('#modalRanking').show();
                    });
                }

                //Mostrar ventana
                $(".window").hide();
                $('#modalFinishGame').show();
                $('#modalWindow').show();
            });
        }
        
        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////   MARZIPANO   /////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////
        'use strict';
        //1. VISOR DE IMAGENES
        var panoElement = document.getElementById('pano');
        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 
        var currentScene=null;
        var currentPrincipalId;
        var scenes= new Array;
        //2. RECORRER TODAS LAS ESCENAS
        for(var i=0;i<data.length;i++){
            var source = Marzipano.ImageUrlSource.fromString(
                "{{url('/marzipano/tiles/dirName/{z}/{f}/{y}/{x}.jpg')}}".replace("dirName", data[i].directory_name),
            
            //Establecer imagen de previsualizacion para optimizar su carga 
            //(bdflru para establecer el orden de la capas de la imagen de preview)
            {cubeMapPreviewUrl: "{{url('/marzipano/tiles/dirName/preview.jpg')}}".replace("dirName", data[i].directory_name), 
            cubeMapPreviewFaceOrder: 'lfrbud'});
            //GEOMETRIA 
            var geometry = new Marzipano.CubeGeometry([
            { tileSize: 256, size: 256, fallbackOnly: true  },
            { tileSize: 512, size: 512 },
            { tileSize: 512, size: 1024 },
            { tileSize: 512, size: 2048},
            ]);
            //CREAR VISOR (Con parametros de posicion, zoom, etc)
            //Limitadores de zoom min y max para vista vertical y horizontal
            var limiter = Marzipano.util.compose(
                Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
                Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
            );
            //Crear el objeto vista
            var dataView = {pitch: data[i].pitch, yaw: data[i].yaw, roll: 0, fov: Math.PI}
            var view = new Marzipano.RectilinearView(dataView, limiter);
            //CREAR LA ESCENA Y ALMACENARLA EN EL ARRAY 
            var scene = viewer.createScene({
                source: source,
                geometry: geometry,
                view: view,
                pinFirstLevel: true
            });
            //ALMACENAR OBJETO EN ARRAY
            scenes.push({scene:scene, id:data[i].id, zone:data[i].id_zone});
        }
        
        //--------------------------------------------------------------------------------------------------
               
        /*
        * FUNCION PARA RECORRER TODAS LAS ESCENAS Y ASIGNAR LOS HOTSPOTS
        */
        function callLoadHotspots(){
            for(var h=0; h<scenes.length;h++){
                var allHots = @json($allHots);
                var hotspots = new Array();
                //Obtener todos los hotspot relacionados con esta escena
                for(var i=0; i<allHots.length;i++){
                    if(allHots[i].scene_id == scenes[h].id){
                        hotspots.push(allHots[i]); //Agregar el hotspot si esta asociado a la escena
                    }
                }
                //Acceder a los datos de las relaciones entre hotspot y los diferentes recursos
                for(var i=0; i<hotspots.length;i++){
                    for(var j = 0; j<hotsRel.length;j++){
                        if(hotspots[i].id == hotsRel[j].id_hotspot){
                            //Almacenar el tipo de hotspot para pasarlo al metodo de instanciacion de hotspot
                            hotspots[i].type = hotsRel[j].type;
                            //Almacenar el id del recurso referenciado
                            hotspots[i].idType = hotsRel[j].id_type;
                        }
                    }
                }
                //Recorrer todos los datos de los hotspot existentes e instanciarlos en pantalla
                for(var i=0; i<hotspots.length;i++){
                    loadHotspot(scenes[h].scene, hotspots[i]);
                }
            }
        }

        //-----------------------------------------------------------------------------------------
        /*
        * METODO INSTANCIAR EN PANTALLA UN HOTSPOT PASADO POR PARAMETRO
        */
        function loadHotspot(scene, hotspot){
            //Insertar el código en funcion del tipo de hotspot
            switch(hotspot.type){
                case 0:
                /*
                    textInfo(hotspot.id, hotspot.title, hotspot.description);
                    //Crear el hotspot
                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                */
                    break;    

                case 1:
                    //Obtener los datos del salto como id de destino y posicion de vista
                    var getRoute = "{{ route('jump.getdestination', 'req_id') }}".replace('req_id', hotspot.idType);
                   
                    
                    $.get(getRoute, function(dest){
                        //Comprobar si la escena de destino del salto esta bloqueada
                        var lock=false;
                        for(var i=0; i<=lockScenes.length; i++){
                            if(dest.destination == lockScenes[i]){
                                lock=true
                            }
                        }

                        //Si no esta bloqueado lo agregamos
                        if(!lock){
                            jump(hotspot.id, dest.destination, dest.pitch, dest.yaw);
                            //Crear el hotspot al obtener la informacion
                            scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                        }else{
                            //Crear el hotspot al obtener la informacion
                            $("#contentHotSpot").append(
                                `<div id='hintspot' class='hotspotElement hotsLowOpacity hots`+hotspot.id+`'>
                                    `+padlockIcon+`
                                </div>`
                            );     
                            var padlockHots = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                            //Almacenar informacion para el posterior desbloqueo
                            var j={'idScene':dest.destination, 'scene':scene, 'hotspot':hotspot, 'oldHots':padlockHots};
                            lockJumps.push(j);
                        }
                    });
                    break;

                case 2:
                /*
                    //Obtener la URL del recurso asociado a traves de ajax
                    var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', hotspot.idType);
                    
                    $.get(getRoute, function(src){
                        video(hotspot.id, src);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });
                    */
                    break;

                case 3:
                /*
                    //Obtener la URL del recurso asociado a traves de ajax
                    var getRoute = "{{ route('resource.getroute', 'req_id') }}".replace('req_id', hotspot.idType);
                    
                    $.get(getRoute, function(src){
                        audio(hotspot.id, src, hotspot.idType);
                         //Crear el hotspot al obtener la informacion
                        scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                    });
                */
                    break;

                case 4:  
                /*               
                    imageGallery(hotspot.id);
                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                */
                    break;

                case 5:
                
                    var address = getPortkey.replace('insertIdHere', hotspot.idType);
                    $.get(address, function(data){
                        if(typeof data.id != "undefined") { // Controla que el portkey contiene datos
                            // Filtra los portkeys segun el tipo de portkey seleccionado en opciones.
                            if(typePortkey == "Mapa"){
                                if(data.image != null){ // Si tiene imagen significa que es de tipo mapas
                                    portkey(hotspot.id, hotspot.idType);
                                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                                }
                            } else {
                                if(data.image == null){ // Si no tiene imagen es de tipo ascensor
                                    portkey(hotspot.id, hotspot.idType);
                                    scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch });
                                }
                            }
                        }
                    });
                
                    break;

                case 6:
                    //HOTSPOT HIDE (ESCAPE ROOM)
                    loadHide(hotspot.id); //Crear elemento html

                    //Crear el hotspot
                    var hotspot = scene.hotspotContainer().createHotspot(document.querySelector(".hots"+hotspot.id), { "yaw": hotspot.yaw, "pitch": hotspot.pitch },
                    { perspective: { radius: 1640, extraTransforms: "rotateX(5deg)" }})
                    console.log(hotspot);
                    break;
            }
        };

        

        //-----------------------------------------------------------------------------
        /*
         * METODO PARA CAMBIAR DE ESCENA CON TRANSICION
         */
         function changeScene(id, pitch, yaw, tunnel){
            //Efectos de transicion
            if(tunnel){
                var fun = transitionFunctions["opacityRT"];
                var easeOpacity = easing["easeInOutCubic"]; //https://hsto.org/getpro/habr/post_images/f7b/65e/8e7/f7b65e8e7024fcdeecb308e97d4621fe.png
            }else{
                var fun = transitionFunctions["opacity"];
                var easeOpacity = easing["easeInOutCubic"];
            }
            //Buscar escena correspondiente con el id en el array
            for(var i=0; i<scenes.length;i++){
                if(scenes[i].id == id){
                    var s = scenes[i].scene;
                    
                    //Cambiar
                    s.switchTo({
                        transitionDuration: 800,
                        transitionUpdate: fun(easeOpacity, currentScene)
                    });
                    
                    s.view().setYaw(yaw);
                    s.view().setPitch(pitch);
                    
                    currentScene=s;
                    currentPrincipalId=id;
                    
                    //Mostrar el mapa correspondiente
                    $(".map").removeClass("showMap");
                    $(".map").each(function( index ) {
                        if($(this).attr("value")==scenes[i].zone){
                            $(this).addClass("showMap");
                        }
                    });

                    //Marcar el punto activo
                    $(".pointMap").removeClass("activePoint");
                    $("#point"+id).addClass("activePoint");
                    //Obtener infor de la escena
                    var dir="";
                    var pitchOriginal = 0;
                    var yawOriginal =0;
                    for(i =0; i<data.length;i++){
                        if(data[i].id==id){
                            $("#titlePanel span").text(data[i].name);
                            dir = data[i].directory_name;
                            pitchOriginal = data[i].pitch;
                            yawOriginal = data[i].yaw;
                        }
                    } 
                    
                    //Detener todos los audios de los hotspots
                    $('audio').each(function(){
                        if(this.getAttribute("id") != "backgroundSound"){
                            this.pause(); // Stop playing
                            this.currentTime = 0; // Reset time
                        }
                    }); 
                    $(".contentAudio").hide();
                    
                    //Argucia para detener los videos de los hotspot
                    $('iframe').each(function(){
                        var url = $(this).attr('src');
                        $(this).attr('src','');
                        $(this).attr('src',url);
                    }); 
                }
            }
        }

        //-----------------------------------------------------------------------------------

        /**
         * METODO PARA OBTENER POR AJAX LA INFORMACION DE LOS HOTSPOT DE TIPO HIDE
         */
        function getHideInfo(idHotspot){
            var route = "{{ route('hide.getHide', 'req_id')}}".replace('req_id', idHotspot);
            return $.ajax({
                url: route,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            });
        }
    </script>
@endsection