@extends('admin.layouts.master')

@section('title', __('admin.cms.edit_section') . ' - ' . __('admin.cms.sections.' . $section->section_key))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/CMS/cms.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.website') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('admin.cms.index') }}">{{ __('admin.cms.sections_title') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.cms.sections.' . $section->section_key) }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card cms-glass-card">
                {{-- Header --}}
                <div class="cms-header">
                    <div class="cms-header-content">
                        <h2 class="cms-header-title">
                            <i class="las la-edit"></i>
                            {{ __('admin.cms.edit_section') }}: {{ __('admin.cms.sections.' . $section->section_key) }}
                        </h2>
                        <p class="cms-header-subtitle">{{ __('admin.cms.section_descriptions.' . $section->section_key) }}</p>
                    </div>
                    <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="las la-arrow-left"></i> {{ __('admin.cms.back_to_sections') }}
                    </a>
                </div>

                {{-- Form --}}
                <form id="section-form" method="POST" action="{{ route('admin.cms.sections.update', $section) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="cms-body">
                        {{-- Title Fields --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-heading"></i>
                                {{ __('admin.cms.fields.title_en') }} / {{ __('admin.cms.fields.title_ar') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.title_en') }}</label>
                                        <input type="text" name="title[en]" class="form-control"
                                               value="{{ $section->getTranslation('title', 'en', false) }}"
                                               placeholder="Section title in English">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.title_ar') }}</label>
                                        <input type="text" name="title[ar]" class="form-control" dir="rtl"
                                               value="{{ $section->getTranslation('title', 'ar', false) }}"
                                               placeholder="عنوان القسم بالعربية">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.subtitle_en') }}</label>
                                        <textarea name="subtitle[en]" class="form-control" rows="2"
                                                  placeholder="Section subtitle in English">{{ $section->getTranslation('subtitle', 'en', false) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.subtitle_ar') }}</label>
                                        <textarea name="subtitle[ar]" class="form-control" rows="2" dir="rtl"
                                                  placeholder="وصف القسم بالعربية">{{ $section->getTranslation('subtitle', 'ar', false) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section-specific content --}}
                        @if(in_array($section->section_key, ['features', 'faq', 'testimonials']))
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="las la-list"></i>
                                    {{ __('admin.cms.content') }} — {{ __('admin.cms.sections.' . $section->section_key) }}
                                </h3>
                                <div id="repeater-container">
                                    @php
                                        $items = $section->content['items'] ?? [];
                                    @endphp
                                    @if(!empty($items))
                                        @foreach($items as $index => $item)
                                            <div class="repeater-item card p-3 mb-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <strong>{{ __('admin.cms.content') }} #{{ $index + 1 }}</strong>
                                                    <button type="button" class="btn btn-sm btn-danger remove-item">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </div>
                                                @if($section->section_key === 'features')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][title_en]"
                                                                   class="form-control mb-2" placeholder="Title (EN)"
                                                                   value="{{ $item['title_en'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][title_ar]"
                                                                   class="form-control mb-2" placeholder="العنوان (AR)" dir="rtl"
                                                                   value="{{ $item['title_ar'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="content[items][{{ $index }}][desc_en]"
                                                                      class="form-control mb-2" rows="2" placeholder="Description (EN)">{{ $item['desc_en'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="content[items][{{ $index }}][desc_ar]"
                                                                      class="form-control mb-2" rows="2" placeholder="الوصف (AR)" dir="rtl">{{ $item['desc_ar'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][icon]"
                                                                   class="form-control mb-2" placeholder="Icon class (e.g. las la-book)"
                                                                   value="{{ $item['icon'] ?? '' }}">
                                                        </div>
                                                    </div>
                                                @elseif($section->section_key === 'faq')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][question_en]"
                                                                   class="form-control mb-2" placeholder="Question (EN)"
                                                                   value="{{ $item['question_en'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][question_ar]"
                                                                   class="form-control mb-2" placeholder="السؤال (AR)" dir="rtl"
                                                                   value="{{ $item['question_ar'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="content[items][{{ $index }}][answer_en]"
                                                                      class="form-control mb-2" rows="2" placeholder="Answer (EN)">{{ $item['answer_en'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="content[items][{{ $index }}][answer_ar]"
                                                                      class="form-control mb-2" rows="2" placeholder="الإجابة (AR)" dir="rtl">{{ $item['answer_ar'] ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                @elseif($section->section_key === 'testimonials')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][name]"
                                                                   class="form-control mb-2" placeholder="Name"
                                                                   value="{{ $item['name'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="content[items][{{ $index }}][role_en]"
                                                                   class="form-control mb-2" placeholder="Role (EN)"
                                                                   value="{{ $item['role_en'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="content[items][{{ $index }}][content_en]"
                                                                      class="form-control mb-2" rows="2" placeholder="Testimonial (EN)">{{ $item['content_en'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="content[items][{{ $index }}][content_ar]"
                                                                      class="form-control mb-2" rows="2" placeholder="التقييم (AR)" dir="rtl">{{ $item['content_ar'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="number" name="content[items][{{ $index }}][rating]"
                                                                   class="form-control mb-2" placeholder="Rating (1-5)" min="1" max="5"
                                                                   value="{{ $item['rating'] ?? 5 }}">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-item">
                                    <i class="las la-plus"></i> {{ __('admin.global.add') }}
                                </button>
                            </div>
                        @endif

                        {{-- Image Uploads --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-image"></i>
                                {{ __('admin.cms.images') }}
                            </h3>
                            <div class="row">
                                @php
                                    $imageKeys = match($section->section_key) {
                                        'hero' => ['background' => 'Background Image'],
                                        'about' => ['main' => 'Main Image', 'secondary_1' => 'Secondary Image 1', 'secondary_2' => 'Secondary Image 2'],
                                        default => [],
                                    };
                                @endphp
                                @forelse($imageKeys as $key => $label)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ $label }}</label>
                                            @if(isset($section->images[$key]) && $section->images[$key])
                                                <div class="cms-image-preview mb-2">
                                                    <img src="{{ Storage::disk('public')->url($section->images[$key]) }}" alt="{{ $label }}" class="img-fluid rounded">
                                                </div>
                                            @endif
                                            <input type="file" name="image_uploads[{{ $key }}]" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">{{ __('admin.cms.sections.' . $section->section_key) }} {{ __('admin.cms.content') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Settings --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="las la-cog"></i>
                                {{ __('admin.cms.section_settings') }}
                            </h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.cms.fields.is_visible') }}</label>
                                        <select name="is_visible" class="form-control">
                                            <option value="1" {{ $section->is_visible ? 'selected' : '' }}>{{ __('admin.cms.visible') }}</option>
                                            <option value="0" {{ !$section->is_visible ? 'selected' : '' }}>{{ __('admin.cms.hidden') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
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
            let itemIndex = {{ count($section->content['items'] ?? []) }};

            // Add repeater item
            $('#add-item').on('click', function() {
                const sectionKey = "{{ $section->section_key }}";
                let html = '<div class="repeater-item card p-3 mb-3">' +
                    '<div class="d-flex justify-content-between mb-2">' +
                    '<strong>{{ __("admin.cms.content") }} #' + (itemIndex + 1) + '</strong>' +
                    '<button type="button" class="btn btn-sm btn-danger remove-item"><i class="las la-trash"></i></button></div>';

                if (sectionKey === 'features') {
                    html += '<div class="row">' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][title_en]" class="form-control mb-2" placeholder="Title (EN)"></div>' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][title_ar]" class="form-control mb-2" placeholder="العنوان (AR)" dir="rtl"></div>' +
                        '<div class="col-md-6"><textarea name="content[items][' + itemIndex + '][desc_en]" class="form-control mb-2" rows="2" placeholder="Description (EN)"></textarea></div>' +
                        '<div class="col-md-6"><textarea name="content[items][' + itemIndex + '][desc_ar]" class="form-control mb-2" rows="2" placeholder="الوصف (AR)" dir="rtl"></textarea></div>' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][icon]" class="form-control mb-2" placeholder="Icon class (e.g. las la-book)"></div></div>';
                } else if (sectionKey === 'faq') {
                    html += '<div class="row">' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][question_en]" class="form-control mb-2" placeholder="Question (EN)"></div>' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][question_ar]" class="form-control mb-2" placeholder="السؤال (AR)" dir="rtl"></div>' +
                        '<div class="col-md-6"><textarea name="content[items][' + itemIndex + '][answer_en]" class="form-control mb-2" rows="2" placeholder="Answer (EN)"></textarea></div>' +
                        '<div class="col-md-6"><textarea name="content[items][' + itemIndex + '][answer_ar]" class="form-control mb-2" rows="2" placeholder="الإجابة (AR)" dir="rtl"></textarea></div></div>';
                } else if (sectionKey === 'testimonials') {
                    html += '<div class="row">' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][name]" class="form-control mb-2" placeholder="Name"></div>' +
                        '<div class="col-md-6"><input type="text" name="content[items][' + itemIndex + '][role_en]" class="form-control mb-2" placeholder="Role (EN)"></div>' +
                        '<div class="col-md-6"><textarea name="content[items][' + itemIndex + '][content_en]" class="form-control mb-2" rows="2" placeholder="Testimonial (EN)"></textarea></div>' +
                        '<div class="col-md-6"><textarea name="content[items][' + itemIndex + '][content_ar]" class="form-control mb-2" rows="2" placeholder="التقييم (AR)" dir="rtl"></textarea></div>' +
                        '<div class="col-md-3"><input type="number" name="content[items][' + itemIndex + '][rating]" class="form-control mb-2" placeholder="Rating (1-5)" min="1" max="5" value="5"></div></div>';
                }

                html += '</div>';
                $('#repeater-container').append(html);
                itemIndex++;
            });

            // Remove repeater item
            $(document).on('click', '.remove-item', function() {
                $(this).closest('.repeater-item').remove();
            });

            // Form submission
            $('#section-form').on('submit', function(e) {
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
                        $submitBtn.prop('disabled', false).html('<i class="las la-save"></i> {{ __("admin.global.save") }}');
                    }
                });
            });
        });
    </script>
@endsection
