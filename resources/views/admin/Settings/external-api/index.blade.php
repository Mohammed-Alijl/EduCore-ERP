@extends('admin.layouts.master')

@section('title', __('admin.Settings.external_api.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Settings/external-api-settings.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.Settings.external_api.title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="api-settings-container">
        <div class="row">
            @foreach($apis as $api)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="api-card">
                        <div class="api-card-header">
                            <div class="d-flex align-items-center">
                                <div class="api-logo logo-{{ $api->slug }}">
                                    @if($api->slug == 'mailgun')
                                        <i class="las la-envelope"></i>
                                    @elseif($api->slug == 'zoom')
                                        <i class="las la-video"></i>
                                    @elseif($api->slug == 'firebase')
                                        <i class="las la-fire"></i>
                                    @elseif($api->slug == 'pusher')
                                        <i class="las la-broadcast-tower"></i>
                                    @else
                                        <i class="las la-plug"></i>
                                    @endif
                                </div>
                                <div class="api-info">
                                    <h3 class="api-name">{{ $api->name }}</h3>
                                    <span class="api-slug">{{ $api->slug }}</span>
                                </div>
                            </div>
                            <div class="api-action">
                                <label class="api-switch">
                                    <input type="checkbox" class="toggle-status" data-slug="{{ $api->slug }}" 
                                           {{ $api->is_active ? 'checked' : '' }}>
                                    <span class="api-slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="api-card-body">
                            <p class="api-description">
                                {{ $api->description ?: __('admin.global.no_description') }}
                            </p>
                            <div class="api-status">
                                <span class="api-status-badge {{ $api->is_active ? 'status-active' : 'status-inactive' }}" id="status-badge-{{ $api->slug }}">
                                    <i class="las {{ $api->is_active ? 'la-check-circle' : 'la-times-circle' }} mr-1"></i>
                                    {{ $api->is_active ? __('admin.global.active') : __('admin.global.disabled') }}
                                </span>
                            </div>
                        </div>
                        <div class="api-card-footer">
                            <button class="btn btn-primary btn-block btn-with-icon edit-api" 
                                    data-api="{{ json_encode($api) }}"
                                    data-toggle="modal" data-target="#editApiModal">
                                <i class="las la-edit"></i>
                                {{ __('admin.global.edit') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Edit API Modal -->
    <div class="modal fade premium-modal" id="editApiModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="las la-cog mr-2"></i>
                        <span>{{ __('admin.global.edit') }}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="api-settings-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="modalFields">
                        <!-- Dynamic fields will be injected here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.global.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="saveApiBtn">
                            <i class="las la-save mr-1"></i>
                            {{ __('admin.global.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Handle Edit Button
            $('.edit-api').on('click', function() {
                const api = $(this).data('api');
                const form = $('#api-settings-form');
                const fieldsContainer = $('#modalFields');
                
                // Set form action
                form.attr('action', `/admin/settings/external-api/${api.slug}`);
                $('#modalTitle span').text(`${api.name}`);
                
                // Clear and generate fields
                fieldsContainer.empty();
                
                // Use the translations from the backend or mapping
                const fieldLabels = {
                    'domain': "{{ __('admin.Settings.external_api.mailgun.domain') }}",
                    'secret': "{{ __('admin.Settings.external_api.mailgun.secret') }}",
                    'endpoint': "{{ __('admin.Settings.external_api.mailgun.endpoint') }}",
                    'client_id': "{{ __('admin.Settings.external_api.zoom.client_id') }}",
                    'client_secret': "{{ __('admin.Settings.external_api.zoom.client_secret') }}",
                    'account_id': "{{ __('admin.Settings.external_api.zoom.account_id') }}",
                    'api_key': "{{ __('admin.Settings.external_api.firebase.api_key') }}",
                    'project_id': "{{ __('admin.Settings.external_api.firebase.project_id') }}",
                    'messaging_sender_id': "{{ __('admin.Settings.external_api.firebase.messaging_sender_id') }}",
                    'app_id': "{{ __('admin.Settings.external_api.firebase.app_id') }}",
                };

                Object.keys(api.credentials).forEach(key => {
                    const label = fieldLabels[key] || key.replace('_', ' ').toUpperCase();
                    const inputType = (key.includes('secret') || key.includes('password') || key.includes('key')) ? 'password' : 'text';
                    
                    fieldsContainer.append(`
                        <div class="form-floating-custom">
                            <label for="field_${key}">${label}</label>
                            <div class="input-group">
                                <input type="${inputType}" name="credentials[${key}]" id="field_${key}" 
                                       class="form-control" value="${api.credentials[key]}" required>
                                ${inputType === 'password' ? `
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-light toggle-password" type="button">
                                            <i class="las la-eye"></i>
                                        </button>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `);
                });
            });

            // Toggle Password Visibility
            $(document).on('click', '.toggle-password', function() {
                const input = $(this).closest('.input-group').find('input');
                const icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('la-eye').addClass('la-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('la-eye-slash').addClass('la-eye');
                }
            });

            // Handle AJAX Form Submission
            $('#api-settings-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const btn = $('#saveApiBtn');
                const originalBtnHtml = btn.html();
                
                btn.prop('disabled', true).html('<i class="las la-spinner la-spin mr-1"></i> {{ __('admin.global.saving') }}');
                
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#editApiModal').modal('hide');
                        swal({
                            title: "{{ __('admin.global.success') }}",
                            text: response.message,
                            type: "success",
                            confirmButtonClass: "btn btn-success"
                        }, function() {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalBtnHtml);
                        let errorMsg = "{{ __('admin.global.failed') }}";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        swal({
                            title: "{{ __('admin.global.error_title') }}",
                            text: errorMsg,
                            type: "error",
                            confirmButtonClass: "btn btn-danger"
                        });
                    }
                });
            });

            // Handle Status Toggle
            $('.toggle-status').on('change', function() {
                const checkbox = $(this);
                const slug = checkbox.data('slug');
                const isActive = checkbox.is(':checked');
                const badge = $(`#status-badge-${slug}`);
                
                $.ajax({
                    url: `/admin/settings/external-api/${slug}/toggle-status`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (isActive) {
                            badge.removeClass('status-inactive').addClass('status-active');
                            badge.html(`<i class="las la-check-circle mr-1"></i> {{ __('admin.global.active') }}`);
                        } else {
                            badge.removeClass('status-active').addClass('status-inactive');
                            badge.html(`<i class="las la-times-circle mr-1"></i> {{ __('admin.global.disabled') }}`);
                        }
                        
                        $.toast({
                            heading: "{{ __('admin.global.success') }}",
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right'
                        });
                    },
                    error: function() {
                        checkbox.prop('checked', !isActive);
                        swal("{{ __('admin.global.error_title') }}", "{{ __('admin.global.failed') }}", "error");
                    }
                });
            });
        });
    </script>
@endsection
