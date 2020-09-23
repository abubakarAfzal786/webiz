@extends('layouts.app_new')
@section('content')
    <div class="login-page">
        <div class="container flex wrap">
            <div class="login-form">
                <div class="logo">
                    <a href="javascript:void(0)"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="title">
                        <h1>{{ __('Login WeBiz Dashboard') }}</h1>
                    </div>
                    <label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="{{ __('E-Mail Address') }}">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </label>
                    <label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password"
                               placeholder="{{ __('Password') }}">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </label>
                    <div class="btn">
                        <button type="submit">{{ __('Login') }}</button>
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>{{ __('Remember password') }}</span>
                        </label>
                        {{--TODO forgot you password--}}
                    </div>
                </form>
                <div class="text">
                    <p>2020 Development</p>
                </div>
            </div>
            <div class="login-bg">
                <div class="bg-wrap">
                    <img src="{{ asset('images/login-bg.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection