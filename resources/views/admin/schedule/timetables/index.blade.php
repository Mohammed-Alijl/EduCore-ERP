@extends('admin.layouts.master')

@section('title', __('admin.timetables.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Schedule/timetable.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-table"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ __('admin.timetables.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ __('admin.timetables.subtitle') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="timetable-page">
        <div class="row row-sm">
            <div class="col-xl-12">

                {{-- Section Selector Card --}}
                <div class="glass-card mb-4">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-title-icon bg-gradient-primary">
                                <i class="las la-filter"></i>
                            </div>
                            <div class="card-title-text">
                                <h5>{{ __('admin.timetables.select_section') }}</h5>
                                <span>{{ __('admin.timetables.select_section_subtitle') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        <div class="row">
                            {{-- Grade Filter --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-layer-group"></i> {{ __('admin.grades.select') }}
                                </label>
                                <select class="form-select select2" id="grade_filter" name="grade_id">
                                    <option value="">{{ __('admin.global.select') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Classroom Filter --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-school"></i> {{ __('admin.classrooms.select') }}
                                </label>
                                <select class="form-select select2" id="classroom_filter" name="classroom_id" disabled>
                                    <option value="">{{ __('admin.global.select') }}</option>
                                </select>
                            </div>

                            {{-- Section Filter --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-users"></i> {{ __('admin.sections.select') }}
                                </label>
                                <select class="form-select select2" id="section_filter" name="section_id" disabled>
                                    <option value="">{{ __('admin.global.select') }}</option>
                                </select>
                            </div>

                            {{-- Load Button --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">&nbsp;</label>
                                <button id="load_timetable"
                                    class="btn btn-load-timetable w-100 d-flex align-items-center justify-content-center gap-2"
                                    disabled>
                                    <i class="las la-sync"></i>
                                    <span>{{ __('admin.timetables.load_timetable') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timetable Matrix Card --}}
                <div class="glass-card" id="timetable_card" style="display: none;">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <div class="d-flex align-items-center">
                                <div class="card-title-icon bg-gradient-success">
                                    <i class="las la-calendar-week"></i>
                                </div>
                                <div class="card-title-text">
                                    <h5 id="section_title">{{ __('admin.timetables.weekly_schedule') }}</h5>
                                    <span id="section_subtitle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        <div class="table-responsive">
                            <table class="table timetable-matrix">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.timetables.period') }}</th>
                                        <th colspan="100" id="days_header"></th>
                                    </tr>
                                </thead>
                                <tbody id="timetable_body">
                                    {{-- Populated via AJAX --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Empty State --}}
                <div class="timetable-empty-state" id="empty_state">
                    <i class="las la-calendar-times"></i>
                    <h4>{{ __('admin.timetables.no_timetable') }}</h4>
                    <p>{{ __('admin.timetables.select_section_to_view') }}</p>
                </div>

            </div>
        </div>
    </div>

    {{-- Assignment Modal --}}
    @include('admin.schedule.timetables.assign_modal')

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            'use strict';

            // Setup AJAX to include CSRF token in all requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize Select2
            $('.select2').select2({
                width: '100%',
                minimumResultsForSearch: -1
            });

            // Global Variables
            let currentSectionId = null;
            const currentAcademicYearId = {{ $currentAcademicYear->id ?? 'null' }};

            // Grade Change Event
            $('#grade_filter').on('change', function() {
                const gradeId = $(this).val();
                $('#classroom_filter').prop('disabled', !gradeId).val('').trigger('change');
                resetDropdown('#classroom_filter');
                $('#section_filter').prop('disabled', true).val('').trigger('change');
                resetDropdown('#section_filter');
                $('#load_timetable').prop('disabled', true);

                if (gradeId) {
                    loadClassrooms(gradeId);
                }
            });

            // Classroom Change Event
            $('#classroom_filter').on('change', function() {
                const classroomId = $(this).val();
                $('#section_filter').prop('disabled', !classroomId).val('').trigger('change');
                resetDropdown('#section_filter');
                $('#load_timetable').prop('disabled', true);

                if (classroomId) {
                    loadSections(classroomId);
                }
            });

            // Section Change Event
            $('#section_filter').on('change', function() {
                $('#load_timetable').prop('disabled', !$(this).val());
            });

            // Load Timetable Button
            $('#load_timetable').on('click', function() {
                currentSectionId = $('#section_filter').val();
                if (currentSectionId && currentAcademicYearId) {
                    window.loadTimetableMatrix(currentSectionId, currentAcademicYearId);
                }
            });

            // Load Classrooms
            function loadClassrooms(gradeId) {
                $.ajax({
                    url: '{{ route('admin.classrooms.by-grade') }}',
                    data: {
                        grade_id: gradeId
                    },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(key, classroom) {
                                $('#classroom_filter').append(
                                    `<option value="${key}">${classroom}</option>`);
                            });
                        }
                    }
                });
            }

            // Load Sections
            function loadSections(classroomId) {
                $.ajax({
                    url: '{{ route('admin.sections.by-classroom') }}',
                    data: {
                        classroom_id: classroomId
                    },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(key, section) {
                                $('#section_filter').append(
                                    `<option value="${key}">${section}</option>`);
                            });
                        }
                    }
                });
            }

            // Load Timetable Matrix
            window.loadTimetableMatrix = function(sectionId, academicYearId) {
                $('#timetable_card').hide();
                $('#empty_state').html(`
                    <div class="timetable-loading">
                        <div class="timetable-spinner"></div>
                        <p>{{ __('admin.global.loading') }}</p>
                    </div>
                `).show();

                $.ajax({
                    url: '{{ route('admin.schedule.timetables.matrix') }}',
                    data: {
                        section_id: sectionId,
                        academic_year_id: academicYearId
                    },
                    success: function(response) {
                        if (response.success) {
                            renderMatrix(response);
                            $('#empty_state').hide();
                            $('#timetable_card').fadeIn();
                        }
                    },
                    error: function() {
                        $('#empty_state').html(`
                            <i class="las la-exclamation-triangle text-danger"></i>
                            <h4 class="text-danger">{{ __('admin.timetables.errors.fetch_failed') }}</h4>
                        `);
                    }
                });
            }

            // Render Timetable Matrix
            function renderMatrix(data) {
                // Update section title
                $('#section_title').text(
                    `${data.section.grade} - ${data.section.classroom} - ${data.section.name}`);
                $('#section_subtitle').text('{{ __('admin.timetables.weekly_schedule') }}');

                // Render day headers
                let daysHtml = '';
                data.days.forEach(day => {
                    daysHtml += `<th>${day.name}</th>`;
                });
                $('#days_header').replaceWith(daysHtml);

                // Render matrix rows
                let bodyHtml = '';
                data.periods.forEach(period => {
                    bodyHtml += '<tr>';

                    // Period cell
                    if (period.is_break) {
                        bodyHtml += `<td class="period-cell break-period">
                            <strong><i class="las la-coffee"></i> ${period.name}</strong>
                            <small>${period.formatted_time_range}</small>
                        </td>`;
                        bodyHtml += `<td colspan="${data.days.length}" class="break-period text-center">
                            <em><i class="las la-coffee mr-2"></i>{{ __('admin.timetables.break_time') }}</em>
                        </td>`;
                    } else {
                        bodyHtml += `<td class="period-cell">
                            <strong>${period.name}</strong>
                            <small>${period.formatted_time_range}</small>
                        </td>`;

                        // Day cells
                        data.days.forEach(day => {
                            const slotKey = `${day.id}_${period.id}`;
                            const slot = data.slots[slotKey];

                            bodyHtml +=
                                `<td class="slot-cell" data-day="${day.id}" data-period="${period.id}" data-slot-id="${slot?.id || ''}">`;

                            if (slot) {
                                bodyHtml += `<div class="assigned-slot">
                                    <strong>${slot.subject_name}</strong>
                                    <small><i class="las la-user-tie"></i> ${slot.teacher_name}</small>
                                    <div class="slot-actions">
                                        @can('edit_timetables')
                                            <button class="slot-action-btn edit-btn edit-slot" title="{{ __('admin.global.edit') }}"
                                                data-subject-id="${slot.subject_id}" data-teacher-id="${slot.teacher_id}">
                                                <i class="las la-edit"></i>
                                            </button>
                                        @endcan
                                        @can('delete_timetables')
                                            <button class="slot-action-btn remove-btn remove-slot" title="{{ __('admin.global.delete') }}">
                                                <i class="las la-times"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </div>`;
                            } else {
                                @can('create_timetables')
                                    bodyHtml += `<button class="assign-slot">
                                        <i class="las la-plus"></i>
                                        <span>{{ __('admin.timetables.assign') }}</span>
                                    </button>`;
                                @else
                                    bodyHtml += `<div class="text-muted">-</div>`;
                                @endcan
                            }

                            bodyHtml += '</td>';
                        });
                    }

                    bodyHtml += '</tr>';
                });

                $('#timetable_body').html(bodyHtml);
            }

            // Handle Assign Slot Click
            $(document).on('click', '.assign-slot, .edit-slot', function() {
                const $cell = $(this).closest('.slot-cell');
                const dayId = $cell.data('day');
                const periodId = $cell.data('period');
                const slotId = $cell.data('slot-id');
                const subjectId = $(this).data('subject-id');
                const teacherId = $(this).data('teacher-id');

                openAssignModal(dayId, periodId, slotId, subjectId, teacherId);
            });

            // Handle Remove Slot Click
            $(document).on('click', '.remove-slot', function() {
                const $cell = $(this).closest('.slot-cell');
                const slotId = $cell.data('slot-id');

                if (slotId) {
                    deleteSlot(slotId);
                }
            });

            // Open Assign Modal - will be implemented in assign_modal.blade.php
            window.openAssignModal = function(dayId, periodId, slotId, subjectId, teacherId) {
                $('#assign_modal').data({
                    day_id: dayId,
                    period_id: periodId,
                    slot_id: slotId,
                    subject_id: subjectId,
                    teacher_id: teacherId,
                    section_id: currentSectionId,
                    academic_year_id: currentAcademicYearId
                });

                if (slotId) {
                    $('#assign_modal_title').text('{{ __('admin.timetables.edit_assignment') }}');
                    // Load existing slot data would go here
                } else {
                    $('#assign_modal_title').text('{{ __('admin.timetables.create_assignment') }}');
                    resetAssignForm();
                }

                $('#assign_modal').modal('show');
            };

            // Delete Slot
            function deleteSlot(slotId) {
                swal({
                    title: "{{ __('admin.global.warning_title') }}",
                    text: "{{ __('admin.timetables.delete_confirm') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ef4444",
                    confirmButtonText: "{{ __('admin.global.delete') }}",
                    cancelButtonText: "{{ __('admin.global.cancel') }}",
                    closeOnConfirm: false
                }, function() {
                    $.ajax({
                        url: `{{ route('admin.schedule.timetables.index') }}/${slotId}`,
                        type: 'DELETE',
                        success: function(response) {
                            swal("{{ __('admin.global.deleted') }}", response.message,
                                "success");
                            window.loadTimetableMatrix(currentSectionId, currentAcademicYearId);
                        },
                        error: function() {
                            swal("{{ __('admin.global.error_title') }}",
                                "{{ __('admin.timetables.errors.delete_failed') }}",
                                "error");
                        }
                    });
                });
            }

            // Reset Assign Form - implemented in assign_modal
            window.resetAssignForm = function() {
                $('#assign_form')[0].reset();
                $('#subject_id').val('').trigger('change');
                $('#teacher_id').html('<option value="">{{ __('admin.global.select') }}</option>').prop(
                    'disabled', true);
                // Re-enable the save button
                $('.btn-save').prop('disabled', false).html(
                    '<i class="las la-save mr-1"></i> {{ __('admin.global.save') }}'
                );
            };


            // Helpers
            function resetDropdown(selector) {
                $(selector).html(
                    `<option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>`);
            }
        });
    </script>
    @stack('scripts')
@endsection
