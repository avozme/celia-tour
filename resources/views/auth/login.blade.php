@extends('layouts.app')

@section('content')

<div id="title" class="col80"><h1>Login</h1></div>

<div id="content" class="col100">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="col100">
            <label for="email" class="">{{ __('Email') }}</label>

            <div class="">
                <input id="email" type="text" class="" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col100">
            <label for="password" class="">{{ __('Contraseña') }}</label>

            <div class="">
                <input id="password" type="password" class="" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col100">
            <div class="">
                <button type="submit" class="" >
                    {{ __('Login') }}
                </button>
            </div>
        </div>
    </form>
</div>
            
@endsection
