@extends('admin.layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{URL::asset('assets/admin/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
    <style>
        .login-right-panel {
            background-color: #ffffff;
            transition: background-color 0.3s ease;
        }

        /* ─── DARK THEME OVERRIDES ─── */
        .dark-theme .login-right-panel {
            background-color: #1e212b !important;
            color: #f1f5f9;
        }

        .dark-theme .main-signup-header h2,
        .dark-theme .main-signup-header h5 {
            color: #f1f5f9 !important;
        }

        .dark-theme .main-logo1 {
            color: #f1f5f9 !important;
        }

        .dark-theme .form-group label {
            color: #cbd5e1 !important;
            font-weight: 500;
        }

        .dark-theme .form-control {
            background-color: #14161f !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        .dark-theme .form-control:focus {
            background-color: #1a1d27 !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.05) !important;
        }

        .dark-theme .form-control::placeholder {
            color: #94a3b8 !important;
        }

        .dark-theme .bg-primary-transparent {
            background-color: #14161f !important;
        }
        
        .dark-theme .main-signin-footer p,
        .dark-theme .main-signin-footer a {
            color: #94a3b8 !important;
        }
        
        .dark-theme .main-signin-footer a:hover {
            color: #f1f5f9 !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{URL::asset('assets/admin/img/media/login.avif')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 login-right-panel">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex"> <a href="#"><img src="{{URL::asset('assets/admin/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">
                                        {{__('admin.global.brand')}}</h1></div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>{{__('admin.login.welcome')}}</h2>
                                            <h5 class="font-weight-semibold mb-4">{{__('admin.login.subtitle')}}</h5>
                                            <form action="{{route('admin.login.store')}}" id="loginForm" method="post" data-parsley-validate="">
                                                @csrf
                                                <div class="form-group">
                                                    <label id="email">{{__('admin.global.email')}}</label>
                                                    <input class="form-control" id="email" required placeholder="{{__('admin.global.email_placeholder')}}" type="email" name="email" autocomplete="off" maxlength="30">
                                                    <small class="text-danger" id="error-message"></small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">{{__('admin.global.password')}}</label>
                                                    <input class="form-control" id="password" required placeholder="{{__('admin.global.password_placeholder')}}" type="password" name="password" minlength="8" maxlength="30">
                                                </div><button type="submit" id="loginBtn" class="btn btn-main-primary btn-block">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="btnSpinner"></span>
                                                    <span id="btnText">{{__('admin.login.submit')}}</span>
                                                </button>
                                            </form>
                                            <div class="main-signin-footer mt-5">
                                                <p><a href="{{route('admin.password.request')}}">{{__('admin.login.forgot_password')}}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
@section('js')
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>

    <script src="{{URL::asset('assets/admin/js/form-validation.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                if ($(this).parsley().isValid()) {

                    var formData = $(this).serialize();
                    var url = $(this).attr('action');

                    $('#error-message').hide().text('');
                    $('#loginBtn').attr('disabled', true);
                    $('#btnText').text('Signing in...');
                    $('#btnSpinner').show();

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.status === true) {
                                window.location.href = response.redirect;
                            } else {
                                $('#error-message').text(response.message).show();
                                resetButton();
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON;
                            var errorMsg = "{{__('auth.failed')}}";

                            if (xhr.status === 422) {
                                $.each(errors.errors, function(key, value) {
                                    errorMsg = value[0];
                                    return false;
                                });
                            } else if (xhr.status === 401 || xhr.status === 403) {
                                errorMsg = errors.message || 'Do Not Match Our credentials';
                            }

                            $('#error-message').text(errorMsg).show();

                            $('#email, #password').removeClass('parsley-success').addClass('parsley-error');

                            $('#email, #password').closest('.form-group').addClass('has-danger');

                            resetButton();
                        }
                    });
                }
            });

            function resetButton() {
                $('#loginBtn').attr('disabled', false);
                $('#btnText').text('Sign In');
                $('#btnSpinner').hide();
            }
        });

        $('#loginForm #email, #loginForm #password').on('input',function(){
            $("#error-message").hide();
        })
    </script>
@endsection
