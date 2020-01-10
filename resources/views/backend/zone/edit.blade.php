@extends('layouts.backend')

@section('content')
    <div id="title" class="col80"></div>
    <div id="contentbutton" col20></div>
    <div id="content" class="col100">
        <form action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col20"><label for="name">Name</label></div>
            <div class="col20"><label for="file_image">File Image</label></div>
            <div class="col20"><label for="file_miniature">File miniature</label></div>
            <div class="col20"><label for="position">Position</label></div>

            <div style="clear:both"></div>

            <div class="col20"><input type="text" name="name" value="{{ $zone->name }}"><br><br></div>
            <div class="col20"><img src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image' height="100" width="150" onclick="$('#inputFileImage').trigger('click')"></div>
            <div class="col20"><img src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature' height="100" width="150" onclick="$('#inputFileMiniature').trigger('click')"></div>
            <div class="col20"><input type="number" name="position" value="{{ $zone->position }}"></div>
            <div style="display: none">
                <input type="file" name="file_image" accept=".png, .jpg, .jpeg" id="inputFileImage">
                <input type="file" name="file_miniature" accept=".png, .jpg, .jpeg" id="inputFileMiniature">
            </div>

            <input type="submit" name="Save Changes">
        </form>
        
    </div>
@endsection