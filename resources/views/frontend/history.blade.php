@extends('layouts.frontend')
@section('content')
<link rel="stylesheet" href="{{url('css/info.css')}}" />
<div class="content-whois content-center">
    <div id="whois" class="contentCard">
        <h3>Historia</h3>
        <div id="contenido"></div>
        <script>
         $(document).ready(function() {
             var data = @JSON($history[0]->value);
            $("#contenido").html(data);
         });
        </script>
    </div>
</div>
@endsection