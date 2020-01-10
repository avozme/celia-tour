@extends('layouts/backend')

@section('title', 'Admin Zones')

@section('content')
<style>
</style>
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
            <div class="col20">File Image</div>
            <div class="col20">File Miniature</div>
            <div class="col10">Position</div>
            <div class="col10">Edit</div>
            <div class="col10">Delete</div>
            @foreach ($zones as $zone)
                <div style="clear:both"></div>
                <div class="col5 row15">{{ $zone->id }}</div>
                <div class="col20 row15">{{ $zone->name }}</div>
                <div class="col20 row15"> <img class="col45 row25" src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image'> </div>
                <div class="col20 row15"> <img class="col45 row25" src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature'> </div>
                <div class="col10 row15">{{ $zone->position }}</div>
                <div class="col10 row15"> <input type="button" value="Edit" onclick="window.location.href='{{ route('zone.edit', $zone->id) }}'"> </div>
                <div class="col10 row15"> <input type="button" value="Delete" onclick="window.location.href='{{ route('zone.delete', $zone->id) }}'"> </div>
            @endforeach
        </div>
        
    </div>
@endsection

