@extends('admin.layouts.master')

@section('title', __('admin.CMS.cms.edit_page') . ' - ' . $page->title)

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/CMS/cms.css') }}" rel="stylesheet">
    <style>
        .ql-editor {
            min-height: 300px;
            font-size: 16px;
            line-height: 1.8;
        }

        .ql-container {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .ql-toolbar {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background: #f8fafc;
        }

        .editor-wrapper {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .editor-wrapper:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .editor-rtl .ql-editor {
            direction: rtl;
            text-align: right;
        }

        .content-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .content-tab {
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .content-tab:hover {
            background: #f1f5f9;
        }

        .content-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .content-panel {
            display: none;
        }

        .content-panel.active {
            display: block;
        }

        .info-alert {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            border: 1px solid #93c5fd;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .info-alert i {
            color: #3b82f6;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .info-alert p {
            margin: 0;
            color: #1e40af;
            font-size: 0.9rem;
            line-height: 1.5;
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.website') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a
                        href="{{ route('admin.CMS.cms.legal.index') }}">{{ __('admin.CMS.cms.legal_title') }}</a></span>
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
                            {{ __('admin.CMS.cms.edit_page') }}: {{ $page->title }}
                        </h2>
                        <p class="cms-header-subtitle">{{ __('admin.CMS.cms.legal_edit_desc') }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($page->slug) }}" target="_blank" class="btn btn-outline-light btn-sm">
                            <i class="las la-external-link-alt"></i> {{ __('admin.global.preview') }}
                        </a>
                        <a href="{{ route('admin.CMS.cms.legal.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="las la-arrow-left"></i> {{ __('admin.CMS.cms.back_to_legal') }}
                        </a>
                    </div>
                </div>

                <form id="legal-form" method="POST" action="{{ route('admin.CMS.cms.legal.update', $page) }}">
                    @csrf
                    @method('PUT')

                    <div class="cms-body">
                        {{-- Info Alert --}}
                        <div class="info-alert">
                            <i class="las la-info-circle"></i>
                            <p>
                                <strong>{{ __('admin.CMS.cms.info') }}:</strong>
                                {{ __('admin.CMS.cms.legal_content_info') }}
                            </p>
                        </div>

                        {{-- Title --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-heading"></i>
                                {{ __('admin.CMS.cms.fields.title_en') }} / {{ __('admin.CMS.cms.fields.title_ar') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.CMS.cms.fields.title_en') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title[en]" class="form-control" required
                                            value="{{ $page->getTranslation('title', 'en', false) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.CMS.cms.fields.title_ar') }} <span
                                                class="text-danger">*</span></label>
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
                                {{ __('admin.CMS.cms.content') }}
                            </h3>

                            {{-- Language Tabs --}}
                            <div class="content-tabs">
                                <button type="button" class="content-tab active" data-lang="en">
                                    <i class="flag-icon flag-icon-gb mr-1"></i> English
                                </button>
                                <button type="button" class="content-tab" data-lang="ar">
                                    <i class="flag-icon flag-icon-sa mr-1"></i> العربية
                                </button>
                            </div>

                            {{-- English Content --}}
                            <div class="content-panel active" id="content-en-panel">
                                <label class="form-label">{{ __('admin.CMS.cms.fields.content_en') }}</label>
                                <p class="text-muted small mb-2">{{ __('admin.CMS.cms.legal_content_hint') }}</p>
                                <div class="editor-wrapper">
                                    <div id="editor-en"></div>
                                </div>
                                <textarea name="content[en]" id="content-en" class="d-none">{{ $page->getTranslation('content', 'en', false) }}</textarea>
                            </div>

                            {{-- Arabic Content --}}
                            <div class="content-panel" id="content-ar-panel">
                                <label class="form-label">{{ __('admin.CMS.cms.fields.content_ar') }}</label>
                                <p class="text-muted small mb-2">{{ __('admin.CMS.cms.legal_content_hint') }}</p>
                                <div class="editor-wrapper">
                                    <div id="editor-ar" class="editor-rtl"></div>
                                </div>
                                <textarea name="content[ar]" id="content-ar" class="d-none" dir="rtl">{{ $page->getTranslation('content', 'ar', false) }}</textarea>
                            </div>
                        </div>

                        {{-- Meta & Settings --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-cog"></i>
                                {{ __('admin.CMS.cms.section_settings') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.CMS.cms.fields.meta_description') }}
                                            (EN)</label>
                                        <p class="text-muted small mb-2">{{ __('admin.CMS.cms.meta_desc_hint') }}</p>
                                        <textarea name="meta_description[en]" class="form-control" rows="2"
                                            placeholder="Short description for search engines...">{{ $page->getTranslation('meta_description', 'en', false) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.CMS.cms.fields.meta_description') }}
                                            (AR)</label>
                                        <p class="text-muted small mb-2">{{ __('admin.CMS.cms.meta_desc_hint') }}</p>
                                        <textarea name="meta_description[ar]" class="form-control" rows="2" dir="rtl"
                                            placeholder="وصف قصير لمحركات البحث...">{{ $page->getTranslation('meta_description', 'ar', false) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.CMS.cms.fields.is_published') }}</label>
                                        <select name="is_published" class="form-control">
                                            <option value="1" {{ $page->is_published ? 'selected' : '' }}>
                                                {{ __('admin.CMS.cms.published') }}</option>
                                            <option value="0" {{ !$page->is_published ? 'selected' : '' }}>
                                                {{ __('admin.CMS.cms.draft') }}</option>
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
    <script src="{{ URL::asset('assets/admin/plugins/quill/quill.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Quill toolbar options
            const toolbarOptions = [
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                [{
                    'align': []
                }],
                ['link'],
                ['blockquote', 'code-block'],
                ['clean']
            ];

            // Initialize English editor
            const quillEn = new Quill('#editor-en', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Enter your content here... Leave empty to use default content.'
            });

            // Initialize Arabic editor
            const quillAr = new Quill('#editor-ar', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'أدخل المحتوى هنا... اترك فارغًا لاستخدام المحتوى الافتراضي.'
            });

            // Load existing content
            const contentEn = document.getElementById('content-en').value;
            const contentAr = document.getElementById('content-ar').value;

            if (contentEn) {
                quillEn.root.innerHTML = contentEn;
            }
            if (contentAr) {
                quillAr.root.innerHTML = contentAr;
            }

            // Tab switching
            $('.content-tab').on('click', function() {
                const lang = $(this).data('lang');
                $('.content-tab').removeClass('active');
                $(this).addClass('active');
                $('.content-panel').removeClass('active');
                $(`#content-${lang}-panel`).addClass('active');
            });

            // Form submission
            $('#legal-form').on('submit', function(e) {
                e.preventDefault();

                // Sync Quill content to hidden textareas
                document.getElementById('content-en').value = quillEn.root.innerHTML === '<p><br></p>' ?
                    '' : quillEn.root.innerHTML;
                document.getElementById('content-ar').value = quillAr.root.innerHTML === '<p><br></p>' ?
                    '' : quillAr.root.innerHTML;

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const formData = new FormData(this);

                $submitBtn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin"></i> {{ __('admin.global.saving') }}');

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
                            swal("{{ __('admin.global.error') }}", xhr.responseJSON?.message ||
                                "{{ __('admin.global.error') }}", "error");
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html(
                            '<i class="las la-save"></i> {{ __('admin.global.save') }}');
                    }
                });
            });
        });
    </script>
@endsection
