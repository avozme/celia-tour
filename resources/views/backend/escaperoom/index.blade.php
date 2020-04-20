@extends('layouts.backend')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zonemap/zonemap.css')}}" />
    <link rel="stylesheet" href="{{url('css/escaperoom/index.css')}}" />
    <script src="{{url('js/zone/zonemap.js')}}"></script>
    <script src="{{url('js/marzipano/es5-shim.js')}}"></script>
    <script src="{{url('js/marzipano/eventShim.js')}}"></script>
    <script src="{{url('js/marzipano/requestAnimationFrame.js')}}"></script>
    <script src="{{url('js/marzipano/marzipano.js')}}"></script>
@endsection

@section('content')
    <div id="title" class="col100 mMarginBottom">
        <span>ESCAPE ROOM</span>
    </div>

    {{-- <nav id="menuHorizontal" class="col100"> --}}
        <div id="menuEscapeRoom" class="col100 mMarginBototom">
            <ul>
                <div id="menuList">
                    <li>Escenas</li>
                    <li>Preguntas</li>
                    <li id="liBorder">Llaves</li>
                </div>
            </ul>
        </div>
        <div id="borderDiv" class="col100"></div>
    {{-- </nav> --}}

    {{------------ MAPA -------------}}
    <div id="map" class="col60">
        @include('backend.zone.map.zonemap')
    </div>

    {{------------ MENÚ ------------}}
    <div id="menu" class="col30 lPaddingLeft lMarginTop" style="border: 1px solid black; margin-left: 8%">
        <div id="pano" class="col100 relative"></div>
    </div>


    <style>
        #changeZone {
            top: 70%;
            left: 66%;
            width: 5%;
        }
    </style>
@endsection