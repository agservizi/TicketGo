@php
$settings = getCompanyAllSettings();
@endphp
@extends('layouts.auth')

@section('page-title')
{{ __('Authentication') }}
@endsection

@section('content')
{{-- Navbar --}}

<div class="auth-wrapper login-page">
     <div class="login-bg-img"></div>
    <div class="auth-content ticket-form-wrapper">
        <header class="custom-header">
            <a class="logo-col mx-auto" href="{{ route('home') }}">
                <img src="{{ getFile(getSidebarLogo()) }}{{ '?' . time() }}" alt="logo">
            </a>
        </header>
        <div class="login-row">
                <div class="login-form-wrp">
                    <div class="border-top"></div>
                    <div class="border-bottom"></div>
                    <div class="text-center">
                        <h2 class="mb-2 h3">{{ __('Log in to your account') }}</h2>
                        <div class="text-border-bottom"></div>
                    </div>
                    <form method="POST" class="needs-validation create-form mb-3" novalidate
                        action="{{ route('2faVerify') }}" id="form_data">
                        @csrf
                        <input type="hidden" name="2fa_referrer"
                            value="{{ request()->get('2fa_referrer') ?? URL()->current() }}">
                        <div class="row">
                            <div class="form-group col-12">
                                <p>{{ __('Please enter the') }} <strong>{{ __(' OTP') }}</strong>
                                    {{ __(' generated on your Authenticator App') }}. <br>
                                    {{ __('Ensure you submit the current one because it refreshes every 30 seconds') }}.
                                </p>
                                <label for="one_time_password"
                                    class="col-md-12 form-label">{{ __('One Time Password') }}</label>
                                <input id="one_time_password" type="password"
                                    class="form-control @if ($errors->any()) is-invalid @endif" name="one_time_password"
                                    required="required" autofocus>
                                @if ($errors->any())
                                <span class="error invalid-email text-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                    <small>{{ $error }}</small>
                                    @endforeach
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12 mb-0">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        <a href="{{ route('logout') }}" class="btn btn-danger text-white"
                                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection