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
    {{ __('Create Ticket') }}
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/floating_chat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
    @if(moduleIsActive('OfficeHours'))
        @stack('add_homepage')
    @else
        <div class="auth-wrapper login-page">
            <div class="login-bg-img"></div>
            <div class="auth-content ticket-form-wrapper">
                {{-- Navbar --}}
                @include('layouts.navbar')
                <div class="login-row create-ticket-row">
                        <div class="login-form-wrp">
                            <div class="border-top"></div>
                            <div class="border-bottom"></div>
                            <div class="text-center">
                                <h2 class="mb-2 h3 text-center">{{ __('Create a Ticket') }}</h2>
                                <div class="text-border-bottom"></div>
                                <p>{{ __('Enter the details below to submit your support ticket.') }}</p>
                            </div>

                            @if (Session::has('create_ticket'))
                                <div class="alert alert-success text-center">
                                    {!! session('create_ticket') !!}
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {!! session('error') !!}
                                </div>
                            @endif

                            <div class="login-form">
                                <form method="post" action="{{ route('home.store') }}" class="create-form mb-0 needs-validation"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf

                                    <div class="text-start row">
                                        @if (!$customFields->isEmpty())
                                            @include('admin.customFields.formBuilder')
                                        @endif

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
                                            <input type="hidden" name="status" value="New Ticket" />
                                            <input type="hidden" name="type" value="Ticket" />
                                            <button class="btn btn-primary btn-block " id="ticket_button">
                                                {{ __('Create Ticket') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    {{-- </div> --}}
                    @include('layouts.footer')
                </div>
            </div>
        </div>

    @endif

    <div class="row w-100">
        <div class="col-sm-12 col-md-2 col-lg-2">
            @if (isset($settings['CHAT_MODULE']) && $settings['CHAT_MODULE'] == 'yes')
                <div class="fabs">
                    <div class="chat d-none">
                        <div class="chat_header">
                            <div class="chat_option btn-primary bg-primary">
                                <div class="header_img">
                                    {{-- img src="{{ $logos . 'logo-dark.png' . '?' . time() }}" /> --}}
                                    <img src="{{ getFile(getSidebarLogo()) }}{{ '?' . time() }}" alt="">
                                </div>
                                <span id="chat_head" class="">{{ __('Ticket') }}</span>
                            </div>
                        </div>
                        <div class="msg_chat">
                            <div id="chat_fullscreen" class="chat_conversion chat_converse">
                                <h3 class="text-center mt-5 pt-5">{{ __('No Message Found.!') }}</h3>
                            </div>
                            <div class="fab_field">
                                <textarea rows="1" id="chatSend" name="chat_message" placeholder="{{ __('Send a message') }}"
                                    class="chat_field chat_message"></textarea>
                                <button type="button" class="btn" id="Send">
                                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_2514)">
                                            <path
                                                d="M19.3386 9.2414L2.40878 0.98294C2.26318 0.911916 2.1033 0.875 1.94129 0.875C1.3524 0.875 0.875 1.3524 0.875 1.94129V1.97207C0.875 2.11515 0.892544 2.25769 0.927246 2.3965L2.55122 8.89236C2.59557 9.06981 2.74559 9.20089 2.92735 9.2211L10.0652 10.0142C10.3128 10.0417 10.5 10.2509 10.5 10.5C10.5 10.7491 10.3128 10.9583 10.0652 10.9858L2.92735 11.7789C2.74559 11.7991 2.59557 11.9302 2.55122 12.1076L0.927246 18.6035C0.892544 18.7423 0.875 18.8849 0.875 19.0279V19.0587C0.875 19.6476 1.3524 20.125 1.94129 20.125C2.1033 20.125 2.26318 20.0881 2.40878 20.017L19.3386 11.7586C19.8197 11.5239 20.125 11.0354 20.125 10.5C20.125 9.96459 19.8197 9.47608 19.3386 9.2414Z"
                                                fill="white"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2514">
                                                <rect width="21" height="21" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>

                            </div>

                        </div>
                        <div class="msg_form">
                            <div id="chat_fullscreen" class="chat_conversion chat_converse">
                                <form class="pt-4" name="chat_form" id="chat_form">
                                    <div class="form-group row mb-3 ml-md-2">
                                        <div class="col-sm-12 col-md-12">

                                            <div class="">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="chat_name" name="name"
                                                        placeholder="{{ __('Enter You Name') }}" autofocus>
                                                </div>
                                                <div class="input-group form-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="email" class="form-control" id="chat_email" name="email"
                                                        placeholder="{{ __('Enter You Email') }}" autofocus>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="chat_subject" name="subject"
                                                        placeholder="{{ __('Enter subject') }}" autofocus>
                                                </div>



                                                <div class="form-group">
                                                    <textarea name="description" id="chat_description" class="form-control"
                                                        cols="3" rows="1"
                                                        placeholder="{{ __('Enter Description') }}"></textarea>
                                                </div>



                                            </div>
                                            <div class="invalid-feedback d-block e_error">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4 ml-md-2">
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn-submit btn btn-primary  btn-block" id="chat_frm_submit"
                                                type="button"><span>{{ __('Start Chat') }}</span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a id="prime" class="fab btn-primary bg-primary">
                        <svg width="61" height="55" viewBox="0 0 61 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M53.6909 0H6.54767C4.81175 0.00204477 3.14751 0.692544 1.92003 1.92003C0.692544 3.14751 0.00204477 4.81175 0 6.54768V35.3574C0.00204477 37.0934 0.692544 38.7576 1.92003 39.9851C3.14751 41.2126 4.81175 41.9031 6.54767 41.9051H9.16674V52.3226C9.16187 52.8564 9.3177 53.3793 9.61397 53.8234C9.91024 54.2674 10.3333 54.6121 10.828 54.8125C11.307 55.0058 11.833 55.0502 12.3376 54.94C12.8422 54.8298 13.3018 54.5702 13.6566 54.1948L25.4401 41.9051H53.6909C55.4268 41.9031 57.0911 41.2126 58.3186 39.9851C59.5461 38.7576 60.2366 37.0934 60.2386 35.3574V6.54768C60.2366 4.81175 59.5461 3.14751 58.3186 1.92003C57.0911 0.692544 55.4268 0.00204477 53.6909 0ZM14.4049 11.7858H27.5002C27.8475 11.7858 28.1806 11.9238 28.4262 12.1694C28.6718 12.415 28.8098 12.748 28.8098 13.0954C28.8098 13.4427 28.6718 13.7757 28.4262 14.0213C28.1806 14.2669 27.8475 14.4049 27.5002 14.4049H14.4049C14.0576 14.4049 13.7245 14.2669 13.4789 14.0213C13.2333 13.7757 13.0953 13.4427 13.0953 13.0954C13.0953 12.748 13.2333 12.415 13.4789 12.1694C13.7245 11.9238 14.0576 11.7858 14.4049 11.7858ZM40.5956 30.1193H14.4049C14.0576 30.1193 13.7245 29.9813 13.4789 29.7358C13.2333 29.4902 13.0953 29.1571 13.0953 28.8098C13.0953 28.4625 13.2333 28.1294 13.4789 27.8838C13.7245 27.6382 14.0576 27.5002 14.4049 27.5002H40.5956C40.9429 27.5002 41.276 27.6382 41.5216 27.8838C41.7671 28.1294 41.9051 28.4625 41.9051 28.8098C41.9051 29.1571 41.7671 29.4902 41.5216 29.7358C41.276 29.9813 40.9429 30.1193 40.5956 30.1193ZM45.8337 22.2621H14.4049C14.0576 22.2621 13.7245 22.1241 13.4789 21.8785C13.2333 21.633 13.0953 21.2999 13.0953 20.9526C13.0953 20.6052 13.2333 20.2722 13.4789 20.0266C13.7245 19.781 14.0576 19.643 14.4049 19.643H45.8337C46.181 19.643 46.5141 19.781 46.7597 20.0266C47.0053 20.2722 47.1433 20.6052 47.1433 20.9526C47.1433 21.2999 47.0053 21.633 46.7597 21.8785C46.5141 22.1241 46.181 22.2621 45.8337 22.2621Z"
                                fill="white" />
                        </svg>

                    </a>
                </div>
            @endif
            {{-- WhatsappChatbot Addon --}}
            @stack('whatsappchatbot')
            {{-- end --}}
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('css/summernote/summernote-bs4.js') }}"></script>
    {{-- TicketWidget Addon --}}
    @if(moduleIsActive('TicketWidget'))
    <script>
        window.TicketGoWidgetConfig = {
            baseUrl: "{{ config('app.url') }}"
        };
    </script>
    <script src="{{ asset('packages/workdo/TicketWidget/src/Resources/assets/js/ticket-widget.js') }}"></script>
    @endif
    {{-- end --}}
    <script>
        $(document).ready(function () {
            $("#chat_frm_submit").click(function (e) {
                var form = $("#chat_form");
                if (form[0].checkValidity()) {
                    $(this).prop("disabled", true);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $(".form_data").submit(function (e) {
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
                        grecaptcha.execute('{{ $settings['NOCAPTCHA_SITEKEY'] }}', {
                            action: 'submit'
                        }).then(function (token) {
                            $('#g-recaptcha-response').val(token);
                        });
                    });
                });
            </script>
        @endif
    @endif

    <script>
        if ($(".select2").length) {
            $('.select2').select2({
                "language": {
                    "noResults": function () {
                        return "{{ __('No result found') }}";
                    }
                },
            });
        }

        // for Choose file
        $(document).on('change', 'input[type=file]', function () {
            var names = '';
            var files = $('input[type=file]')[0].files;

            for (var i = 0; i < files.length; i++) {
                names += files[i].name + '<br>';
            }
            $('.' + $(this).attr('data-filename')).html(names);
        });
    </script>


    @if (isset($settings['CHAT_MODULE']) && $settings['CHAT_MODULE'] == 'yes')
        <script>
            //Toggle chat and links
            function toggleFab() {
                $('.chat').toggleClass('is-visible');
                $('.fab').toggleClass('is-visible');
                $('.chat').toggleClass('d-none');
            }

            $('#prime').click(function () {
                var old_ticket_user = getCookie('ticket_user');
                if (old_ticket_user != '') {
                    // has cookie
                    $('.msg_chat').removeClass('d-none');
                    $('.msg_form').removeClass('d-block');
                    $('.msg_chat').addClass('d-block');
                    $('.msg_form').addClass('d-none');

                    getMessage();
                } else {
                    // no cookie
                    $('.msg_chat').removeClass('d-block');
                    $('.msg_form').removeClass('d-none');
                    $('.msg_chat').addClass('d-none');
                    $('.msg_form').addClass('d-block');
                    $("form[name='chat_form']")[0].reset();
                }
                toggleFab();
            });

            $('#chat_frm_submit').on('click', function () {
                var name = $('#chat_name').val();
                var email = $('#chat_email').val();
                var subject = $('#chat_subject').val();
                var description = $('#chat_description').val();


                $.ajax({
                    type: 'POST',
                    url: "{{ route('home.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: name,
                        email: email,
                        subject: subject,
                        description: description,
                    },

                    success: function (data) {
                        // Clear previous errors
                        $('.e_error').html('');

                        if (data.status === 'error') {
                            // Display validation error message
                            $('.e_error').html(data
                                .message); // You can update this to display multiple errors if needed
                        } else {
                            setCookie('ticket_user', JSON.stringify(data), 3);
                            $('.msg_chat').removeClass('d-none').addClass('d-block');
                            $('.msg_form').removeClass('d-block').addClass('d-none');
                            getMessage();
                        }

                    },
                    error: function (xhr, status, error) {
                        // Handle any general error, for example, server errors
                        console.log('Request failed: ' + error);
                    }

                });

            });

            // Live chat Send Btn
            $(document).on('click', '#Send', function (e) {
                var message = $('#chatSend').val();
                if (message != '') {
                    $('#chatSend').val('');
                    $.ajax({
                        type: "post",
                        url: "ticket_floating_message",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            message: message,
                        },
                        cache: false,
                        success: function (data) { },
                        error: function (jqXHR, status, err) { },
                        complete: function () {
                            getMessage();
                            // For Establishing the Pusher Connection Called this function Here.
                            getMessageViaPusher();
                        }
                    });
                }
            });

            // make a function to scroll down auto
            function scrollToBottomFunc() {
                $('#chat_fullscreen').animate({
                    scrollTop: $('#chat_fullscreen').get(0).scrollHeight
                }, 10);
            }

            // get Message when page is load or when msg successfully send
            function getMessage() {
                $.ajax({
                    type: "get",
                    url: "{{ route('get_ticket_message') }}",
                    cache: false,
                    success: function (data) {
                        $('.msg_chat').removeClass('d-none').addClass('d-block');
                        $('.msg_form').removeClass('d-block').addClass('d-none');
                        $('#chat_fullscreen').html(data);

                        scrollToBottomFunc();
                    }
                });
            }

            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            // This function is for getting the Live message from admin or agent side.
            function getMessageViaPusher() {
                var ticketdata = getCookie('ticket_user');
                if (ticketdata != '') {
                    Pusher.logToConsole = false;

                    var pusher = new Pusher(
                        '{{ isset($settings["PUSHER_APP_KEY"]) ? $settings["PUSHER_APP_KEY"] : "" }}', {
                        cluster: '{{ isset($settings["PUSHER_APP_CLUSTER"]) ? $settings["PUSHER_APP_CLUSTER"] : "" }}',
                        forceTLS: true
                    });

                    var ticketdata = getCookie('ticket_user');
                    if (ticketdata) {
                        ticketdata = JSON.parse(ticketdata);
                        var ticket_id = ticketdata.tikcet_id;
                    } else {
                        console.log('No ticket user data found in cookie');
                    }
                    var ticket_id = ticketdata.tikcet_id

                    var channel = pusher.subscribe('ticket-reply-send-' + ticket_id);

                    channel.bind('ticket-reply-send-event-' + ticket_id, function (data) {
                        if (getCookie('ticket_user') != '') {
                            var k = JSON.parse(getCookie('ticket_user'));

                            var receiver_id = k.id;
                            var my_id = '1';

                            /*alert(JSON.stringify(data));*/
                            if (ticket_id == data.ticket_number) {
                                getMessage();
                                scrollToBottomFunc();
                            }
                        }
                    });
                }
            }
            // Get the Messages Via Pusher Channel & Event
            $(document).ready(function () {
                getMessageViaPusher();
            });
            // end

            // $(document).ready(function() {
            //     $("#form-data").submit(function(e) {
            //         $("#ticket_button").attr("disabled", true);
            //         return true;
            //     });
            // });
        </script>
    @endif
@endpush
