@extends('layouts.backend')

@section('title', 'Admin Zones')

@section('headExtension')
    <link rel="stylesheet" href="{{url('css/zone/zone.css')}}" />
@endsection

@section('content')

    <div id="title" class="col80">
        <h3>Administración de Zonas</h3>
    </div>
    <div id="contentbutton" class="col20">
        <input type="button" value="New" onclick="window.location.href='{{ route('zone.create') }}'">
    </div>
    <div id="content" class="col100">
        <div id="table" class="col80">
            <div class="col5">Id</div>
            <div class="col20">Name</div>
            <div class="col15">File Image</div>
            <div class="col15">File Miniature</div>
            <div class="col10">Position</div>
            <div class="col10">Edit</div>
            <div class="col10">Delete</div>
            @php
                $count = 1;
            @endphp
            @foreach ($zones as $zone)
                <div style="clear:both"></div>
                <div class="col5 row15">{{ $zone->id }}
                    @if ($zone->initial_zone)
                        <span style="color: red;">*</span>
                    @endif
                </div>
                <div class="col20 row15">{{ $zone->name }}</div>
                <div class="col15 row15"> <img class="col70 row25" src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image'> </div>
                <div class="col15 row15"> <img class="col70 row25" src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature'> </div>
                <div class="col10 row15">{{ $zone->position }}</div>
                <div class="col10 row15"> <input type="button" value="Edit" onclick="window.location.href='{{ route('zone.edit', $zone->id) }}'"> </div>
                <div class="col10 row15"> <input type="button" value="Delete" onclick="window.location.href='{{ route('zone.delete', $zone->id) }}'"> </div>
                @if($count == 1)
                    <div class="col5 row15"> <img id="d{{ $zone->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'd'.$zone->id]) }}'"> </div>
                @else
                    @if($count == $rows)
                        <div class="col5 row15"> <img id="u{{ $zone->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'u'.$zone->id]) }}'"> </div>
                    @else
                        <div class="col5 row15"> <img id="u{{ $zone->position }}" src="{{ url('img/icons/up.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'u'.$zone->id]) }}'"> </div>
                        <div class="col5 row15"> <img id="d{{ $zone->position }}" src="{{ url('img/icons/down.png') }}" width="18px" onclick="window.location.href='{{ route('zone.updatePosition', ['opc' => 'd'.$zone->id]) }}'"> </div>
                    @endif
                @endif
                @php
                    $count++;
                @endphp
            @endforeach
        </div>
        
    </div>
{{-- <button onclick="window.location.href='{{ route('zone.pruebas') }}'">Pruebas</button> --}}
@endsection

