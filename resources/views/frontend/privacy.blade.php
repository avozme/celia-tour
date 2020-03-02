@extends('layouts.frontend')
@section('content')
<div class="content-whois content-center">
    <div id="whois" class="contentCard">
        <h3>Politica de Privacidad</h3>
        <p>
           {{$privacidad[0]->value}}
        </p>
    </div>
</div>
@endsection