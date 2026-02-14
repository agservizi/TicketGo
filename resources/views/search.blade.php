@extends('layouts.auth')
@section('page-title')
    {{ __('Search Your Ticket') }}
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
                    <a href="{{ route('search', $code) }}" tabindex="0"
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
                    <div class=" text-center">
                        <h2 class="mb-2 h3">{{ __('Search Ticket') }}</h2>
                        <div class="text-border-bottom"></div>
                        <p>{{ __('Enter your ticket number and email to search.') }}</p>
                    </div>
                    <div class="login-form">
                        <form action="{{ route('ticket.search') }}" method="POST" class="needs-validation create-form mb-3"
                            novalidate>
                            @csrf
                            @if (session()->has('info'))
                                <div class="alert alert-success">
                                    {{ session()->get('info') }}
                                </div>
                            @endif
                            @if (session()->has('status'))
                                <div class="alert alert-info">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <div class="text-start row">
                                <div class="col-12 form-group mb-3">
                                    <label for="ticket_id" class="form-label">{{ __('Ticket Number') }}</label>
                                    <x-required></x-required>
                                    <input type="text"
                                        class="form-control {{ $errors->has('ticket_id') ? 'is-invalid' : '' }}"
                                        min="0" id="ticket_id" name="ticket_id"
                                        placeholder="{{ __('Enter Ticket Number') }}" required=""
                                        value="{{ old('ticket_id') }}" autofocus>
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('ticket_id') }}
                                    </div>
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <x-required></x-required>
                                    <input type="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                        name="email" placeholder="{{ __('Email address') }}" required
                                        value="{{ old('email') }}">
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('email') }}
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-1">
                                    <button class="btn btn-primary login-do-btn w-100"
                                        id="login_button">{{ __('Search Ticket') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
@endsection
