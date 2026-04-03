@extends('admin.layouts.master')

@section('title', __('admin.cms.edit_page') . ' - ' . $page->title)

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/cms.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.website') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('admin.cms.legal.index') }}">{{ __('admin.cms.legal_title') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $page->title }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card cms-glass-card">
                <div class="cms-header">
                    <div class="cms-header-content">
                        <h2 class="cms-header-title">
                            <i class="las la-file-alt"></i>
                            {{ __('admin.cms.edit_page') }}: {{ $page->title }}
                        </h2>
                    </div>
                    <a href="{{ route('admin.cms.legal.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="las la-arrow-left"></i> {{ __('admin.cms.back_to_legal') }}
                    </a>
                </div>

                <form id="legal-form" method="POST" action="{{ route('admin.cms.legal.update', $page) }}">
                    @csrf
                    @method('PUT')

                    <div class="cms-body">
                        {{-- Title --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-heading"></i>
                                {{ __('admin.cms.fields.title_en') }} / {{ __('admin.cms.fields.title_ar') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.title_en') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="title[en]" class="form-control" required
                                               value="{{ $page->getTranslation('title', 'en', false) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.title_ar') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="title[ar]" class="form-control" dir="rtl" required
                                               value="{{ $page->getTranslation('title', 'ar', false) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-align-left"></i>
                                {{ __('admin.cms.content') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">{{ __('admin.cms.fields.content_en') }} <span class="text-danger">*</span></label>
                                    <textarea name="content[en]" class="form-control" rows="12" required
                                              placeholder="Enter legal page content in English. You can use HTML.">{{ $page->getTranslation('content', 'en', false) }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">{{ __('admin.cms.fields.content_ar') }} <span class="text-danger">*</span></label>
                                    <textarea name="content[ar]" class="form-control" rows="12" dir="rtl" required
                                              placeholder="أدخل محتوى الصفحة القانونية بالعربية. يمكنك استخدام HTML.">{{ $page->getTranslation('content', 'ar', false) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Meta & Settings --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-cog"></i>
                                {{ __('admin.cms.section_settings') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.meta_description') }} (EN)</label>
                                        <textarea name="meta_description[en]" class="form-control" rows="2">{{ $page->getTranslation('meta_description', 'en', false) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.meta_description') }} (AR)</label>
                                        <textarea name="meta_description[ar]" class="form-control" rows="2" dir="rtl">{{ $page->getTranslation('meta_description', 'ar', false) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.is_published') }}</label>
                                        <select name="is_published" class="form-control">
                                            <option value="1" {{ $page->is_published ? 'selected' : '' }}>{{ __('admin.cms.published') }}</option>
                                            <option value="0" {{ !$page->is_published ? 'selected' : '' }}>{{ __('admin.cms.draft') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('edit_cms')
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
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#legal-form').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const formData = new FormData(this);

                $submitBtn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin"></i> {{ __("admin.global.saving") }}');

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
                        $submitBtn.prop('disabled', false).html('<i class="las la-save"></i> {{ __("admin.global.save") }}');
                    }
                });
            });
        });
    </script>
@endsection
