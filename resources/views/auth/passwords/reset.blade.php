@extends('layouts.auth')

@section('page-title')
    {{ __('Set a New Password') }}
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
                    <div class=" text-center">
                        <h2 class="mb-2 h3">{{ __('Set a New Password') }}</h2>
                        <div class="text-border-bottom"></div>
                        <p>{{ __('Choose a new password to secure your account.') }}</p>
                    </div>


                    <form method="POST" class="needs-validation create-form mb-0" novalidate
                        action="{{ route('password.update') }}">
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label d-flex">{{ __('Enter Email address') }}</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="email" name="email" placeholder="{{ __('Enter your email') }}" required=""
                                    value="{{ old('email') }}">
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label d-flex">{{ __('Enter Password') }}</label>
                                <input type="password"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password"
                                    name="password" placeholder="{{ __('Enter Password') }}" required=""
                                    value="{{ old('password') }}">
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('password') }}
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label d-flex">{{ __('Enter Confirm Password') }}</label>
                                <input type="password"
                                    class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="{{ __('Enter Confirm Password') }}" required="">
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            </div>

                            <div class="form-group mb-3 text-center">
                                <button
                                    class="btn btn-primary btn-submit btn-block w-100">{{ __('Reset Password') }}</button>

                            </div>
                            <p class="text-center mb-0">
                                {{ __('Click here to') }}
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
@endsection
