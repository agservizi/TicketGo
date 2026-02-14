@php
    config([
        'captcha.secret' => isset($settings['NOCAPTCHA_SECRET']) ? $settings['NOCAPTCHA_SECRET'] : '',
        'captcha.sitekey' => isset($settings['NOCAPTCHA_SITEKEY']) ? $settings['NOCAPTCHA_SITEKEY'] : '',
        'options' => [
            'timeout' => 30,
        ],
    ]);
@endphp
@extends('layouts.auth')

@section('page-title')
    {{ __('Login') }}
@endsection
@section('language-bar')
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
             <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe h-4 w-4"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
                <span class="drp-text"> {{ ucfirst($language->fullName) }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach (languages() as $code => $language)
                    <a href="{{ route('login', $code) }}" tabindex="0"
                        class="dropdown-item dropdown-item {{ $lang == $code ? 'active' : '' }}">
                        <span>{{ ucFirst($language) }}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection

@section('content')

    <div class="auth-wrapper login-page">
        <div class="login-bg-img"></div>
        <div class="auth-content ticket-form-wrapper">
            {{-- Navbar --}}
            @include('layouts.navbar')

            <div class="login-row">
                    <div class="login-form-wrp">
                        <div class="border-top"></div>
                        <div class="border-bottom"></div>
                        <div class="text-center">
                            <h2 class="mb-2 h3">{{ __('Log in to your account') }}</h2>
                            <div class="text-border-bottom"></div>
                            <p>{{ __('Enter your email and password below to log in') }}</p>
                        </div>
                        @if (session()->has('create_user'))
                            <div class="alert alert-success w-100 mx-auto">
                                <span> {{ session()->get('create_user') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger w-100 mx-auto">
                                <span> {{ session('error') }}</span>
                            </div>
                        @endif
                        @if (session()->has('info'))
                            <div class="alert alert-success w-100 mx-auto">
                                <span> {{ session()->get('info') }}</span>
                            </div>
                        @endif
                        @if (session()->has('status'))
                            <div class="alert alert-info w-100 mx-auto">
                                <span> {{ session()->get('status') }}</span>
                            </div>
                        @endif
                        <div class="login-form">

                            <form method="POST" class="needs-validation create-form" novalidate
                                action="{{ route('login') }}" id="form_data">
                                @csrf
                                <div class="row">
                                    <div class="form-group mb-3 col-12">
                                        <label for="email" class="form-label d-flex">{{ __('Email') }}</label>
                                        <input type="email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                            name="email" placeholder="{{ __('Enter your email') }}" required=""
                                            value="{{ old('email') }}">
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('email') }}
                                        </div>
                                    </div>

                                    <div class="form-group mb-3 col-12">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <label class="form-label mb-0 d-flex">{{ __('Password') }}</label>
                                            <a href="{{ route('password.request', $lang) }}"
                                                        tabindex="0">{{ __('Forgot your password?') }}</a>
                                        </div>
                                        <input type="password"
                                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            id="password" name="password" placeholder="{{ __('Enter Password') }}"
                                            required="" value="{{ old('password') }}">
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('password') }}
                                        </div>
                                    </div>

                                    @if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes')
                                                                    @if (
                                                                        isset($settings['google_recaptcha_version']) &&
                                                                        $settings['google_recaptcha_version'] == 'v2-checkbox'
                                                                    )
                                                                                                    <div class="form-group mb-4">
                                                                                                        {!! NoCaptcha::display() !!}
                                                                                                        @error('g-recaptcha-response')
                                                                                                            <span class="small text-danger" role="alert">
                                                                                                                <strong>{{ $message }}</strong>
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                    @else
                                                                        <div class="form-group mb-4">
                                                                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"
                                                                                class="form-control">
                                                                            @error('g-recaptcha-response')
                                                                                <span class="error small text-danger" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    @endif
                                    @endif
                                </div>
                                <div class="text-center ticket-btn-wrapper">
                                    <div class="d-block ">
                                        <button class="btn btn-primary login-do-btn w-100"
                                            id="login_button">{{ __('Login') }}</button>
                                    </div>
                                </div>
                                @if (moduleIsActive('CustomerLogin'))

                                    <p class="my-4 text-center">{{ __('Don') }}'{{ __('t have an account? ') }}<a
                                            href="{{ route('register', $lang) }}"
                                            tabindex="0">{{ __('Customer Registration') }}</a>
                                    </p>

                                @endif
                            </form>
                        </div>
                    </div>
                {{-- </div> --}}
                @include('layouts.footer')
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#form_data").submit(function (e) {
                $(".login_button").attr("disabled", true);
                return true;
            });
        });
    </script>

    @if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes')
        @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2-checkbox')
            {!! NoCaptcha::renderJs() !!}
        @else
            <script src="https://www.google.com/recaptcha/api.js?render={{ $settings['NOCAPTCHA_SITEKEY'] }}"></script>
            <script>
                $(document).ready(function () {
                    grecaptcha.ready(function () {
                        grecaptcha.execute('{{ $settings['
                                    NOCAPTCHA_SITEKEY '] }}', {
                            action: 'submit'
                        }).then(function (token) {
                            $('#g-recaptcha-response').val(token);
                        });
                    });
                });
            </script>
        @endif
    @endif

@endpush
