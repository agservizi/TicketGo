@extends('layouts.auth')

@section('page-title')
    {{ __('Verify Email Address') }}
@endsection

@section('content')
    <div class="auth-wrapper login-page">
        <div class="login-bg-img"></div>
        <div class="auth-content ticket-form-wrapper">
            @include('layouts.navbar')

            <div class="login-row">
                <div class="login-form-wrp">
                    <div class="border-top"></div>
                    <div class="border-bottom"></div>

                    <div class="text-center">
                        <h2 class="mb-2 h3">{{ __('Verify Email Address') }}</h2>
                        <div class="text-border-bottom"></div>
                        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="d-flex align-items-center justify-content-between gap-2 mt-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>

                @include('layouts.footer')
            </div>
        </div>
    </div>
@endsection
