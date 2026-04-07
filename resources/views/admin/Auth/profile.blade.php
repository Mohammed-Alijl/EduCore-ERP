@extends('admin.layouts.master')
@section('title', __('admin.profile.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <style>
        /* Custom UI Tweaks for a Cleaner ERP Look */
        .shadow-sm-card {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        /* Profile Cover and Avatar Aesthetics */
        .profile-cover {
            height: 120px;
            background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
        }
        .profile-avatar-container {
            margin-top: -55px;
            text-align: center;
            position: relative;
        }
        .profile-avatar-container img {
            width: 110px;
            height: 110px;
            border: 4px solid #fff;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            object-fit: cover;
            background: #fff;
        }

        /* Nav Tabs Styling for Right Column */
        .nav-tabs-custom {
            border-bottom: 1px solid #e9ecef;
            padding: 0 1rem;
            background: #fdfdfd;
        }
        .nav-tabs-custom .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 1.25rem 1.5rem;
            position: relative;
            background: transparent;
            transition: color 0.2s ease-in-out;
        }
        .nav-tabs-custom .nav-link:hover {
            color: #495057;
        }
        .nav-tabs-custom .nav-link.active {
            color: #007bff;
            background: transparent;
            font-weight: 600;
        }
        .nav-tabs-custom .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 3px;
            background: #007bff;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        /* Form styling adjustments */
        .form-control {
            background-color: #f8f9fa;
            border: 1px solid #e2e5e8;
            padding: 0.65rem 1rem;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        .tracking-wide {
            letter-spacing: 0.05em;
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between my-4">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto text-dark font-weight-bold">{{ __('admin.profile.title') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 ml-2 mb-0">/ {{ __('admin.profile.breadcrumb') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card shadow-sm-card mb-4 pb-4">
                <div class="profile-cover"></div>
                <div class="profile-avatar-container">
                    <img id="profile-avatar-preview" src="{{ auth('admin')->user()->image_url ?? asset('assets/admin/img/faces/admin.png') }}" alt="{{ __('admin.profile.title') }}">
                </div>

                <div class="card-body text-center mt-2 px-4">
                    <h5 class="mb-1 text-dark font-weight-bold" id="profile-name-display">{{ auth('admin')->user()->name }}</h5>
                    <p class="text-muted mb-3 font-weight-medium">
                        <i class="las la-user-shield text-primary mr-1"></i>
                        {{ auth('admin')->user()->roles()->first()->name ?? __('admin.profile.system_admin') }}
                    </p>

                    <div class="d-flex justify-content-center mb-4">
                    <span class="badge badge-success px-3 py-1 rounded-pill" style="background:#e6f8ef; color:#17a561;">
                        <i class="las la-check-circle mr-1"></i> {{ __('admin.profile.active_user') }}
                    </span>
                    </div>

                    <hr class="border-light opacity-50 mb-4">

                    <div class="d-flex flex-column text-left px-2">
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span><i class="las la-calendar text-primary mr-1"></i> {{ __('admin.profile.join_date') }}</span>
                            <span class="font-weight-medium text-dark">{{ auth('admin')->user()->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span><i class="las la-envelope text-primary mr-1"></i> {{ __('admin.profile.email') }}</span>
                            <span class="font-weight-medium text-dark" id="profile-email-display">{{ auth('admin')->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm-card mb-4">

                <div class="card-header p-0">
                    <ul class="nav nav-tabs nav-tabs-custom" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">
                                <i class="las la-user-circle mr-1 tx-18 align-middle"></i> {{ __('admin.profile.personal_details') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="las la-lock mr-1 tx-18 align-middle"></i> {{ __('admin.profile.change_password') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar" aria-selected="false">
                                <i class="las la-image mr-1 tx-18 align-middle"></i> {{ __('admin.profile.avatar_update') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-5">
                    <div class="tab-content" id="profileTabsContent">

                        <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                            <form id="updateProfileForm" action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h6 class="mb-4 text-uppercase text-primary font-weight-bold tracking-wide tx-12">{{ __('admin.profile.basic_info') }}</h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="name" class="font-weight-medium">{{ __('admin.profile.full_name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ auth('admin')->user()->name }}" placeholder="{{ __('admin.profile.name_placeholder') }}">
                                            <span class="text-danger error-text name_error text-sm mt-1 d-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="email" class="font-weight-medium">{{ __('admin.profile.email_address') }} <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ auth('admin')->user()->email }}" placeholder="{{ __('admin.profile.email_placeholder') }}">
                                            <span class="text-danger error-text email_error text-sm mt-1 d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-4">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" id="btn-save-profile">
                                        <i class="las la-save mr-1"></i> {{ __('admin.profile.save_changes') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form id="updatePasswordForm" action="{{ route('admin.profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h6 class="mb-4 text-uppercase text-primary font-weight-bold tracking-wide tx-12">{{ __('admin.profile.security_credentials') }}</h6>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-4">
                                            <label for="current_password" class="font-weight-medium">{{ __('admin.profile.current_password') }} <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="{{ __('admin.profile.current_password_placeholder') }}">
                                            <span class="text-danger error-text current_password_error text-sm mt-1 d-block"></span>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="new_password" class="font-weight-medium">{{ __('admin.profile.new_password') }} <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="{{ __('admin.profile.new_password_placeholder') }}">
                                            <span class="text-danger error-text new_password_error text-sm mt-1 d-block"></span>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="new_password_confirmation" class="font-weight-medium">{{ __('admin.profile.confirm_new_password') }} <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="{{ __('admin.profile.confirm_new_password_placeholder') }}">
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-4">
                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" id="btn-save-password">
                                        <i class="las la-key mr-1"></i> {{ __('admin.profile.update_password') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                            <form id="updateAvatarForm" action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h6 class="mb-4 text-uppercase text-primary font-weight-bold tracking-wide tx-12">{{ __('admin.profile.profile_photo') }}</h6>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-4">
                                            <div class="alert alert-light border shadow-sm mb-4 d-flex align-items-center" role="alert">
                                                <i class="las la-info-circle tx-24 text-primary mr-3"></i>
                                                <span class="text-muted tx-14">{!! __('admin.profile.avatar_hint') !!}</span>
                                            </div>
                                            <input type="file" class="dropify" name="image" data-default-file="{{ auth('admin')->user()->image_url ?? '' }}" data-height="220" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg"/>
                                            <span class="text-danger error-text image_error text-sm mt-2 d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-4">
                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" id="btn-save-avatar">
                                        <i class="las la-cloud-upload-alt mr-1"></i> {{ __('admin.profile.upload_avatar') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/sweet-alert/jquery.sweet-alert.js')}}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    'default': "{{ __('admin.global.dropify.drag_drop') }}",
                    'replace': "{{ __('admin.global.dropify.replace') }}",
                    'remove':  "{{ __('admin.global.delete') }}",
                    'error':   "{{ __('admin.global.dropify.error') }}"
                }
            });

            // Helper function to handle button loading state
            function toggleButtonState(button, isLoading) {
                if(isLoading) {
                    button.prop('disabled', true).addClass('btn-loading');
                } else {
                    button.prop('disabled', false).removeClass('btn-loading');
                }
            }

            // Handle Profile Update
            $('#updateProfileForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = $('#btn-save-profile');
                $('.error-text').text('');
                toggleButtonState(btn, true);

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        toggleButtonState(btn, false);
                        if(response.status === 'success') {
                            swal('{{ __("admin.global.success") }}', response.message, 'success');
                            $('#profile-name-display').text($('#name').val());
                            $('#profile-email-display').text($('#email').val());
                        }
                    },
                    error: function(response) {
                        toggleButtonState(btn, false);
                        if(response.status === 422) {
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                form.find('.' + key + '_error').text(val[0]);
                            });
                        } else {
                            swal({
                                title: '{{ __("admin.global.error_title") }}',
                                text: '{{ __("admin.global.failed") }}',
                                type: "error",
                                confirmButtonText: '{{ __("admin.global.ok") }}'
                            });
                        }
                    }
                });
            });

            // Handle Password Update
            $('#updatePasswordForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = $('#btn-save-password');
                $('.error-text').text('');
                toggleButtonState(btn, true);

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        toggleButtonState(btn, false);
                        if(response.status === 'success') {
                            swal('{{ __("admin.global.success") }}', response.message, 'success');
                            form[0].reset();
                        }
                    },
                    error: function(response) {
                        toggleButtonState(btn, false);
                        if(response.status === 422) {
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                form.find('.' + key + '_error').text(val[0]);
                            });
                        } else {
                            swal({
                                title: '{{ __("admin.global.error_title") }}',
                                text: '{{ __("admin.global.failed") }}',
                                type: "error",
                                confirmButtonText: '{{ __("admin.global.ok") }}'
                            });
                        }
                    }
                });
            });

            // Handle Avatar Update
            $('#updateAvatarForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = $('#btn-save-avatar');
                var formData = new FormData(this);
                $('.error-text').text('');
                toggleButtonState(btn, true);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toggleButtonState(btn, false);
                        if(response.status === 'success') {
                            swal({
                                title: '{{ __("admin.global.success") }}',
                                text: response.message,
                                type: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(function(){
                                window.location.reload();
                            }, 1500);
                        }
                    },
                    error: function(response) {
                        toggleButtonState(btn, false);
                        if(response.status === 422) {
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                form.find('.' + key + '_error').text(val[0]);
                            });
                        } else {
                            swal({
                                title: '{{ __("admin.global.error_title") }}',
                                text: '{{ __("admin.global.failed") }}',
                                type: "error",
                                confirmButtonText: '{{ __("admin.global.ok") }}'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
