@extends('layouts.frontend')
<style>

    body {
        background-color: white !important;
    }

    .content-center {
        display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .content-whois {
        width: 100%;
        height: 200px;
        border: 1px solid red;
    }

    .content-collaborator {
        width: 80%;
        padding: 2em;
        border: 1px solid red;
    }

    #whois {
        width: 80%;
    }

    .collaborator {
        width: 30%;
    }

    .contentCard {
        padding-left: 2em;
        padding-right: 2em;
        padding: 1em 2em 1em 2em;
        border-radius: 100px;
        border: 1px solid black;
        box-shadow: 3px 3px grey;
        color: black;
    }
</style>
@section('content')
<div class="content-whois content-center">
    <div id="whois" class="contentCard">
        <h3>¿Qué es CeliaTour?</h3>
        <p>
            Es una aplicación web para la creación de recorridos virtuales a partir de fotografías
            360 desarrollada por el alumnado de 2º curso del Ciclo Formativo de Desarrollo 
            de Aplicaciones Web en IES Celia Viñas de Almería (España) durante el curso 2017/2018.
        </p>
    </div>
</div>
<div class="content-collaborator content-center">

    <!-- <div class="contentCard collaborator">
        <div>
        </div>
        <p>
            blabla
        </p>
    </div> -->
</div>

@endsection