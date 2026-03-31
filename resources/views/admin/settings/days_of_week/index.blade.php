@extends('admin.layouts.master')

@section('title', __('admin.days_of_week.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/css/settings/days-of-week.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.days_of_week.title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card days-glass-card">
                {{-- Header --}}
                <div class="days-header">
                    <h2 class="days-header-title">
                        <i class="las la-calendar-week"></i>
                        {{ __('admin.days_of_week.title') }}
                    </h2>
                    <p class="days-header-subtitle">{{ __('admin.days_of_week.subtitle') }}</p>
                </div>

                {{-- Days Grid --}}
                <div class="days-grid-wrapper">
                    <div class="days-grid">
                        @foreach ($days as $day)
                            <div class="day-card {{ $day->is_active ? 'is-active' : 'is-inactive' }} {{ $day->is_weekend ? 'is-weekend' : '' }}"
                                data-id="{{ $day->id }}"
                                data-url="{{ route('admin.settings.days_of_week.update', $day) }}">

                                @if ($day->is_weekend)
                                    <span class="weekend-badge">
                                        <i class="las la-moon"></i> {{ __('admin.days_of_week.weekend') }}
                                    </span>
                                @endif

                                <div class="day-icon-container">
                                    <i class="las {{ $day->is_active ? 'la-check-circle' : 'la-times-circle' }}"></i>
                                </div>

                                <h3 class="day-name">{{ $day->name }}</h3>
                                <p class="day-name-en">{{ $day->getTranslation('name', 'en') }}</p>

                                <div class="day-status-badge">
                                    @if ($day->is_active)
                                        <i class="las la-check"></i>
                                        {{ __('admin.days_of_week.active') }}
                                    @else
                                        <i class="las la-ban"></i>
                                        {{ __('admin.days_of_week.inactive') }}
                                    @endif
                                </div>

                                @can('edit_daysOfWeek')
                                    <div class="day-toggle-wrapper d-flex align-items-center justify-content-between">
                                        <span class="toggle-label">{{ __('admin.days_of_week.toggle_status') }}</span>
                                        <label class="toggle-switch">
                                            <input type="checkbox" class="day-toggle" {{ $day->is_active ? 'checked' : '' }}
                                                data-id="{{ $day->id }}">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                @endcan

                                <span class="day-number">{{ $day->day_number }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actions Bar --}}
                <div class="days-actions-bar">
                    <div class="days-stats">
                        <div class="stat-item">
                            <div class="stat-icon active">
                                <i class="las la-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value"
                                    id="active-count">{{ $days->where('is_active', true)->count() }}</span>
                                <span class="stat-label">{{ __('admin.days_of_week.stats.active') }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon inactive">
                                <i class="las la-times-circle"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value"
                                    id="inactive-count">{{ $days->where('is_active', false)->count() }}</span>
                                <span class="stat-label">{{ __('admin.days_of_week.stats.inactive') }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon weekend">
                                <i class="las la-moon"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-value">{{ $days->where('is_weekend', true)->count() }}</span>
                                <span class="stat-label">{{ __('admin.days_of_week.stats.weekend') }}</span>
                            </div>
                        </div>
                    </div>

                    @can('edit_daysOfWeek')
                        <div class="days-quick-actions">
                            <button type="button" class="btn-action btn-activate-all" id="activate-all">
                                <i class="las la-check-double"></i>
                                {{ __('admin.days_of_week.activate_all') }}
                            </button>
                            <button type="button" class="btn-action btn-deactivate-all" id="deactivate-all">
                                <i class="las la-ban"></i>
                                {{ __('admin.days_of_week.deactivate_all') }}
                            </button>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Toggle individual day
            $('.day-toggle').on('change', function() {
                const $toggle = $(this);
                const $card = $toggle.closest('.day-card');
                const dayId = $toggle.data('id');
                const isActive = $toggle.is(':checked');
                const url = $card.data('url');

                $card.addClass('is-loading');

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: isActive ? 1 : 0
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Update card classes
                            $card.removeClass('is-active is-inactive');
                            $card.addClass(isActive ? 'is-active' : 'is-inactive');

                            // Update icon
                            $card.find('.day-icon-container i')
                                .removeClass('la-check-circle la-times-circle')
                                .addClass(isActive ? 'la-check-circle' : 'la-times-circle');

                            // Update badge
                            const badgeHtml = isActive ?
                                '<i class="las la-check"></i> {{ __('admin.days_of_week.active') }}' :
                                '<i class="las la-ban"></i> {{ __('admin.days_of_week.inactive') }}';
                            $card.find('.day-status-badge').html(badgeHtml);

                            // Update stats
                            updateStats();

                            // Show success notification
                            showNotification('success', response.message);
                        }
                    },
                    error: function(xhr) {
                        // Revert toggle
                        $toggle.prop('checked', !isActive);
                        showNotification('error', xhr.responseJSON?.message ||
                            '{{ __('admin.global.error') }}');
                    },
                    complete: function() {
                        $card.removeClass('is-loading');
                    }
                });
            });

            // Activate all days
            $('#activate-all').on('click', function() {
                toggleAllDays(true);
            });

            // Deactivate all days
            $('#deactivate-all').on('click', function() {
                toggleAllDays(false);
            });

            function toggleAllDays(isActive) {
                $('.day-card').addClass('is-loading');

                $.ajax({
                    url: '{{ route('admin.settings.days_of_week.toggle_all') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: isActive ? 1 : 0
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Update all cards
                            $('.day-card').each(function() {
                                const $card = $(this);
                                $card.removeClass('is-active is-inactive');
                                $card.addClass(isActive ? 'is-active' : 'is-inactive');

                                $card.find('.day-toggle').prop('checked', isActive);

                                $card.find('.day-icon-container i')
                                    .removeClass('la-check-circle la-times-circle')
                                    .addClass(isActive ? 'la-check-circle' : 'la-times-circle');

                                const badgeHtml = isActive ?
                                    '<i class="las la-check"></i> {{ __('admin.days_of_week.active') }}' :
                                    '<i class="las la-ban"></i> {{ __('admin.days_of_week.inactive') }}';
                                $card.find('.day-status-badge').html(badgeHtml);
                            });

                            updateStats();
                            showNotification('success', response.message);
                        }
                    },
                    error: function(xhr) {
                        showNotification('error', xhr.responseJSON?.message ||
                            '{{ __('admin.global.error') }}');
                    },
                    complete: function() {
                        $('.day-card').removeClass('is-loading');
                    }
                });
            }

            function updateStats() {
                const activeCount = $('.day-card.is-active').length;
                const inactiveCount = $('.day-card.is-inactive').length;
                $('#active-count').text(activeCount);
                $('#inactive-count').text(inactiveCount);
            }

            function showNotification(type, message) {
                if (typeof toastr !== 'undefined') {
                    toastr[type](message);
                } else {
                    alert(message);
                }
            }
        });
    </script>
@endsection
