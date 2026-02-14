@extends('layouts.auth')
@section('page-title')
    {{ __('Reset Password') }}
@endsection
@section('language-bar')
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-globe h-4 w-4">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                    <path d="M2 12h20"></path>
                </svg>
                <span class="drp-text"> {{ ucfirst($language->fullName) }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach (languages() as $code => $language)
                    <a href="{{ route('password.request', $code) }}" tabindex="0"
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
            {{-- navbar --}}
            @include('layouts.navbar')
            <div class="login-row">
                <div class="login-form-wrp">
                    <div class="border-top"></div>
                    <div class="border-bottom"></div>
                    <div class=" text-center">
                        <h2 class="mb-2 h3">{{ __('Forgot Password') }}</h2>
                        <div class="text-border-bottom"></div>
                        <p>{{ __('Enter your email to receive a password reset link') }}</p>
                    </div>
                    <form method="POST" class="needs-validation" novalidate action="{{ route('password.email') }}"
                        id="form_data">
                        @csrf
                        <div class="row">
                            @if (session()->has('info'))
                                <div class="alert alert-success">
                                    {{ session()->get('info') }}
                                </div>
                            @endif
                            @if (session()->has(key: 'status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif

                            @if (session('Error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('Error') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                                    {{ __('Email SMTP settings does not configured so please contact to your site admin.') }}
                                </div>
                            @endif
                            <div class="col-12 form-group mb-3">
                                <label for="email" class="form-label d-flex">{{ __('Email') }}</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="email" name="email" placeholder="{{ __('Email address') }}" required=""
                                    value="{{ old('email') }}">
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary login-do-btn mt-2 w-100"
                                    id="login_button">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-center">{{ __('Back to? ') }}
                            <a href="{{ route('login', $lang) }}" class="my-4 text-primary">{{ __('Login') }}</a>
                        </p>
                    </form>
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
@endsection
