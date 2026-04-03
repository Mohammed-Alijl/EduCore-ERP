@extends('admin.layouts.master')

@section('title', __('admin.cms.sections_title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/cms.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.website') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.cms.sections_title') }}</span>
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
                            <i class="las la-layer-group"></i>
                            {{ __('admin.cms.sections_title') }}
                        </h2>
                        <p class="cms-header-subtitle">{{ __('admin.cms.sections_subtitle') }}</p>
                    </div>
                    <a href="{{ route('landing-page') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="las la-external-link-alt"></i> {{ __('admin.global.view') }}
                    </a>
                </div>

                {{-- Sections Grid --}}
                <div class="cms-body">
                    @if($sections->isEmpty())
                        <div class="text-center py-5">
                            <i class="las la-inbox" style="font-size: 48px; color: #ccc;"></i>
                            <p class="mt-3 text-muted">{{ __('admin.cms.no_sections') }}</p>
                        </div>
                    @else
                        <div class="cms-sections-grid" id="sections-sortable">
                            @foreach($sections as $section)
                                <div class="cms-section-card {{ !$section->is_visible ? 'cms-section-hidden' : '' }}"
                                     data-id="{{ $section->id }}">
                                    <div class="cms-section-drag-handle">
                                        <i class="las la-grip-vertical"></i>
                                    </div>
                                    <div class="cms-section-icon">
                                        @switch($section->section_key)
                                            @case('hero')
                                                <i class="las la-rocket"></i>
                                                @break
                                            @case('features')
                                                <i class="las la-star"></i>
                                                @break
                                            @case('about')
                                                <i class="las la-info-circle"></i>
                                                @break
                                            @case('stats')
                                                <i class="las la-chart-bar"></i>
                                                @break
                                            @case('programs')
                                                <i class="las la-graduation-cap"></i>
                                                @break
                                            @case('testimonials')
                                                <i class="las la-quote-right"></i>
                                                @break
                                            @case('faq')
                                                <i class="las la-question-circle"></i>
                                                @break
                                            @case('newsletter')
                                                <i class="las la-envelope-open"></i>
                                                @break
                                            @case('contact')
                                                <i class="las la-phone"></i>
                                                @break
                                            @case('footer')
                                                <i class="las la-columns"></i>
                                                @break
                                            @default
                                                <i class="las la-puzzle-piece"></i>
                                        @endswitch
                                    </div>
                                    <div class="cms-section-info">
                                        <h5 class="cms-section-name">
                                            {{ __('admin.cms.sections.' . $section->section_key) }}
                                        </h5>
                                        <p class="cms-section-desc">
                                            {{ __('admin.cms.section_descriptions.' . $section->section_key) }}
                                        </p>
                                    </div>
                                    <div class="cms-section-actions">
                                        <div class="cms-visibility-toggle">
                                            <label class="cms-switch" title="{{ $section->is_visible ? __('admin.cms.visible') : __('admin.cms.hidden') }}">
                                                <input type="checkbox"
                                                       class="toggle-visibility"
                                                       data-id="{{ $section->id }}"
                                                       {{ $section->is_visible ? 'checked' : '' }}>
                                                <span class="cms-switch-slider"></span>
                                            </label>
                                        </div>
                                        @can('edit_cms')
                                            <a href="{{ route('admin.cms.sections.edit', $section) }}"
                                               class="btn btn-sm btn-primary cms-edit-btn">
                                                <i class="las la-edit"></i>
                                                {{ __('admin.global.edit') }}
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="cms-section-order-badge">
                                        #{{ $section->sort_order }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            // Sortable
            const sortable = new Sortable(document.getElementById('sections-sortable'), {
                handle: '.cms-section-drag-handle',
                animation: 300,
                ghostClass: 'cms-sortable-ghost',
                chosenClass: 'cms-sortable-chosen',
                onEnd: function() {
                    const order = [];
                    document.querySelectorAll('.cms-section-card').forEach(function(el) {
                        order.push(parseInt(el.dataset.id));
                    });

                    $.ajax({
                        url: "{{ route('admin.cms.reorder') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order: order
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Update order badges
                                document.querySelectorAll('.cms-section-card').forEach(function(el, index) {
                                    el.querySelector('.cms-section-order-badge').textContent = '#' + (index + 1);
                                });
                                swal({
                                    title: "{{ __('admin.global.success') }}",
                                    text: response.message,
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function() {
                            swal("{{ __('admin.global.error') }}", "{{ __('admin.cms.messages.failed.reorder') }}", "error");
                        }
                    });
                }
            });

            // Toggle visibility
            $(document).on('change', '.toggle-visibility', function() {
                const $toggle = $(this);
                const sectionId = $toggle.data('id');
                const $card = $toggle.closest('.cms-section-card');

                $.ajax({
                    url: "{{ url('admin/cms/sections') }}/" + sectionId + "/toggle",
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $card.toggleClass('cms-section-hidden', !response.is_visible);
                            swal({
                                title: "{{ __('admin.global.success') }}",
                                text: response.message,
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        $toggle.prop('checked', !$toggle.prop('checked'));
                        swal("{{ __('admin.global.error') }}", "{{ __('admin.cms.messages.failed.toggle') }}", "error");
                    }
                });
            });
        });
    </script>
@endsection
