@extends('layouts.backend')

@section('title', 'Admin Zones')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
@endsection

@section('modal')
    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ZONAS -->
<div class="window" id="confirmDelete">
    <span class="titleModal col100">¿Eliminar Zona?</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
        <button id="aceptDelete" class="deleteButton">Aceptar</button>
        <button id="cancelDelete" >Cancelar</button>
    </div>
</div>
@endsection

@section('content')
    <!-- TITULO -->
    <div id="title" class="col80 xlMarginBottom">
            <span>ZONAS</span>
    </div>

    <!-- BOTON AGREGAR -->   
    <div id="contentbutton" class="col20 xlMarginBottom">   
        <button class="right round col45" onclick="window.location.href='{{ route('zone.create') }}'">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
                <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                        8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
            </svg>                                        
        </button>
    </div>

    <div id="content" class="col100 centerH">
        <div id="table" class="col90">
            <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
                <div class="col30"><strong>Nombre</strong></div>
                <div class="col15"><strong>Imagen</strong></div>
                <div class="col15"><strong>Posición</strong></div>
            </div>

            @php
                $count = 1;
            @endphp
            @foreach ($zones as $zone)
                <div id="zone{{ $zone->id }}" class="col100 mPadding">
                    <div class="col30 row15">{{ $zone->name }}</div>
                    {{--<div class="col15 row15"> <img class="col70 row25" src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image'> </div>--}}
                    <div class="col15 row15"> <img class="col70 row25" src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature'> </div>
                    <div class="col15 row15">{{ $zone->position }}</div>
                    <div class="col15 row15"> <input type="button" value="Editar" class="col80" onclick="window.location.href='{{ route('zone.edit', $zone->id) }}'"> </div>
                    <div class="col15 row15"> <input id="{{ $zone->id }}" type="button" value="Eliminar" class="col80 delete"> </div>
                    @if($count == 1)
                        <div class="pointer col5 row15"> <img id="d{{ $zone->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'd'.$zone->id]) }}'"> </div>
                    @else
                        @if($count == $rows)
                            <div class="pointer col5 row15"> <img id="u{{ $zone->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'u'.$zone->id]) }}'"> </div>
                        @else
                            <div class="pointer col5 row15"> <img id="u{{ $zone->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'u'.$zone->id]) }}'"> </div>
                            <div class="pointer col5 row15"> <img id="d{{ $zone->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'd'.$zone->id]) }}'"> </div>
                        @endif
                    @endif
                    @php
                        $count++;
                    @endphp
                </div>
            @endforeach
        </div>
        
    </div>
    <script>
        $().ready(function(){
            $('.delete').click(function(){
                var zoneId = $(this).attr('id');
                $('#confirmDelete').css('width', '20%');
                $('#modalWindow').show();
                $('#aceptDelete').click(function(){
                    $('#modalWindow').hide();
                    var route = "{{ route('zone.delete', 'req_id') }}".replace('req_id', zoneId);
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success:function(result){
                            if(result['status']){
                                $('#zone' + zoneId).remove();
                            }
                        }
                    });
                });
            });
        });
    </script>
{{-- <button onclick="window.location.href='{{ route('zone.pruebas') }}'">Pruebas</button> --}}
@endsection

