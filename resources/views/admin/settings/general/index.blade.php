@extends('admin.layouts.master')

@section('title', __('admin.general_settings.title'))

@section('css')
    <!-- Sweet-Alert css -->
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/general-settings.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.general_settings.title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card settings-glass-card">
                {{-- Header --}}
                <div class="settings-header">
                    <h2 class="settings-header-title">
                        <i class="las la-cog"></i>
                        {{ __('admin.general_settings.title') }}
                    </h2>
                    <p class="settings-header-subtitle">{{ __('admin.general_settings.subtitle') }}</p>
                </div>

                {{-- Form --}}
                <form id="settings-form" method="POST" action="{{ route('admin.settings.general.update') }}"
                    enctype="multipart/form-data" class="ajax-form">
                    @csrf
                    @method('PUT')

                    <div class="settings-body">
                        {{-- School Identity Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-school"></i>
                                {{ __('admin.general_settings.sections.school_identity') }}
                            </h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.school_name_ar') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="school_name[ar]" class="form-control"
                                            value="{{ old('school_name.ar', $settings->getTranslation('school_name', 'ar')) }}"
                                            placeholder="{{ __('admin.general_settings.placeholders.school_name_ar') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.school_name_en') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="school_name[en]" class="form-control"
                                            value="{{ old('school_name.en', $settings->getTranslation('school_name', 'en')) }}"
                                            placeholder="{{ __('admin.general_settings.placeholders.school_name_en') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.logo') }}</label>
                                        <div class="logo-preview-container" id="logo-preview-container">
                                            @if ($settings->logo)
                                                <img src="{{ $settings->logo_url }}" alt="School Logo" id="logo-preview">
                                                <button type="button" class="remove-logo-btn" id="remove-logo-btn">
                                                    <i class="las la-times"></i>
                                                </button>
                                            @else
                                                <div class="logo-placeholder">
                                                    <i class="las la-image"></i>
                                                    <span>{{ __('admin.general_settings.fields.logo') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" name="logo" id="logo-input" class="d-none"
                                            accept="image/jpeg,image/png,image/jpg,image/svg+xml">
                                        <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Contact Information Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-address-book"></i>
                                {{ __('admin.general_settings.sections.contact_info') }}
                            </h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.email') }}</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $settings->email) }}"
                                            placeholder="{{ __('admin.general_settings.placeholders.email') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.phone') }}</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', $settings->phone) }}"
                                            placeholder="{{ __('admin.general_settings.placeholders.phone') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.fax') }}</label>
                                        <input type="text" name="fax" class="form-control"
                                            value="{{ old('fax', $settings->fax) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.general_settings.fields.website') }}</label>
                                        <input type="url" name="website" class="form-control"
                                            value="{{ old('website', $settings->website) }}"
                                            placeholder="{{ __('admin.general_settings.placeholders.website') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Address Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-map-marker"></i>
                                {{ __('admin.general_settings.sections.address') }}
                            </h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __('admin.general_settings.fields.address_ar') }}</label>
                                        <textarea name="address[ar]" class="form-control" rows="3">{{ old('address.ar', $settings->getTranslation('address', 'ar')) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __('admin.general_settings.fields.address_en') }}</label>
                                        <textarea name="address[en]" class="form-control" rows="3">{{ old('address.en', $settings->getTranslation('address', 'en')) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Academic Configuration Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-graduation-cap"></i>
                                {{ __('admin.general_settings.sections.academic_config') }}
                            </h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __('admin.general_settings.fields.current_academic_year') }}</label>
                                        <select name="current_academic_year_id" class="form-control select2">
                                            <option value="">{{ __('admin.global.select') }}</option>
                                            @foreach ($academicYears as $year)
                                                <option value="{{ $year->id }}"
                                                    {{ old('current_academic_year_id', $settings->current_academic_year_id) == $year->id ? 'selected' : '' }}>
                                                    {{ $year->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Social Media Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="lab la-facebook"></i>
                                {{ __('admin.general_settings.sections.social_media') }}
                            </h3>

                            <div class="social-media-section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="lab la-facebook text-primary"></i>
                                                {{ __('admin.general_settings.fields.facebook') }}
                                            </label>
                                            <input type="url" name="social_media[facebook]" class="form-control"
                                                value="{{ old('social_media.facebook', $settings->social_media['facebook'] ?? '') }}"
                                                placeholder="https://facebook.com/yourpage">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="lab la-twitter text-info"></i>
                                                {{ __('admin.general_settings.fields.twitter') }}
                                            </label>
                                            <input type="url" name="social_media[twitter]" class="form-control"
                                                value="{{ old('social_media.twitter', $settings->social_media['twitter'] ?? '') }}"
                                                placeholder="https://twitter.com/yourpage">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="lab la-instagram text-danger"></i>
                                                {{ __('admin.general_settings.fields.instagram') }}
                                            </label>
                                            <input type="url" name="social_media[instagram]" class="form-control"
                                                value="{{ old('social_media.instagram', $settings->social_media['instagram'] ?? '') }}"
                                                placeholder="https://instagram.com/yourpage">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="lab la-linkedin text-primary"></i>
                                                {{ __('admin.general_settings.fields.linkedin') }}
                                            </label>
                                            <input type="url" name="social_media[linkedin]" class="form-control"
                                                value="{{ old('social_media.linkedin', $settings->social_media['linkedin'] ?? '') }}"
                                                placeholder="https://linkedin.com/company/yourpage">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        @can('edit_generalSettings')
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-save-settings">
                                    <i class="las la-save"></i>
                                    {{ __('admin.global.save') }}
                                </button>
                            </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Sweet-Alert js -->
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Logo preview
            $('#logo-preview-container').on('click', function() {
                $('#logo-input').click();
            });

            $('#logo-input').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const container = $('#logo-preview-container');
                        container.html(
                            '<img src="' + e.target.result +
                            '" alt="Logo Preview" id="logo-preview">' +
                            '<button type="button" class="remove-logo-btn" id="remove-logo-btn"><i class="las la-times"></i></button>'
                        );
                        $('#remove_logo').val('0');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $(document).on('click', '#remove-logo-btn', function(e) {
                e.stopPropagation();
                $('#logo-preview-container').html(
                    '<div class="logo-placeholder"><i class="las la-image"></i><span>{{ __('admin.general_settings.fields.logo') }}</span></div>'
                );
                $('#logo-input').val('');
                $('#remove_logo').val('1');
            });

            // Form submission
            $('#settings-form').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const formData = new FormData(this);

                $submitBtn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin"></i> {{ __('admin.global.saving') }}...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            swal({
                                title: "{{ __('admin.global.success') }}",
                                text: response.message,
                                type: "success",
                                confirmButtonText: "{{ __('admin.global.ok') }}"
                            }, function() {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                            swal("{{ __('admin.global.error') }}", errorMessage, "error");
                        } else {
                            swal("{{ __('admin.global.error') }}", xhr.responseJSON?.message || "{{ __('admin.global.error') }}", "error");
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html('<i class="las la-save"></i> {{ __('admin.global.save') }}');
                    }
                });
            });
        });
    </script>
@endsection
