@extends('layouts.access')

@section('content')

<div id="content" class="col100 centerV row100">

    <div class="col100" style="margin-top:-5%">
        <div class="col100 centerH">
            <img class="col25" src="{{ url('/img/logo.png')}}"/>
        </div>

        <form method="POST" action="{{ route('login') }}" class="col100 centerH xlMarginTop">
            @csrf
            <div class="col30">
                <div class="col100">
                    <div class="">
                        <input id="email" type="text" class="col100" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>                       
                    </div>
                </div>

                <div class="col100">
                    <div class="">
                        <input id="password" type="password" class="col100 sMarginTop" name="password" placeholder="Contraseña" required autocomplete="current-password">

                        @error('password')
                            <span class="msmError sMarginTop col100" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                        @error('email')
                            <span class="msmError sMarginTop col100" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col100">
                    <div class="">
                        <button type="submit" class="col100 lMarginTop" >
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
            
@endsection
