<div class="footer-row">
    <p class="text-center mb-0 f-w-600">
        @if (isset($settings['footer_text']))
        {{ $settings['footer_text'] }}
        @else
        {{ __('Copyright') }} &copy; {{ config('app.name') }}
        @endif
    </p>
</div>
