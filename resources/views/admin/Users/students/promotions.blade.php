@extends('admin.layouts.master')

@section('title', trans('admin.Students.promotions.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Users/student/promotion.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.Students.promotions.title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="card-title mb-0">{{ trans('admin.Students.promotions.filters') }}</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.Users.students.promotions.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.Students.promotions.fields.from_grade') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="from_grade_id" id="from_grade_id" class="form-control select2" required>
                                        <option value="" disabled {{ request('from_grade_id') ? '' : 'selected' }}>--
                                            {{ trans('admin.global.select') }} --</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}"
                                                {{ request('from_grade_id') == $grade->id ? 'selected' : '' }}>
                                                {{ $grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.Students.promotions.fields.from_classroom') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="from_classroom_id" id="from_classroom_id" class="form-control select2"
                                        data-selected="{{ request('from_classroom_id') }}" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.Students.promotions.fields.from_section') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="from_section_id" id="from_section_id" class="form-control select2"
                                        data-selected="{{ request('from_section_id') }}" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.Students.promotions.fields.from_academic_year') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="from_academic_year_id" id="from_academic_year_id"
                                        class="form-control select2" required>
                                        <option value="" disabled
                                            {{ request('from_academic_year_id') ? '' : 'selected' }}>--
                                            {{ trans('admin.global.select') }} --</option>
                                        @foreach ($academicYears as $year)
                                            <option value="{{ $year->id }}"
                                                {{ request('from_academic_year_id') == $year->id ? 'selected' : '' }}>
                                                {{ $year->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter mr-1"></i>
                                {{ trans('admin.Students.promotions.load_students') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($students !== null)
        <div class="row row-sm">
            <!-- Summary Card -->
            @if ($students->count())
                <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                    <div class="summary-card">
                        <div class="summary-item">
                            <div class="summary-icon">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                            <div>
                                <div class="text-white-50" style="font-size: 12px;">
                                    {{ trans('admin.Students.promotions.fields.promote') }}</div>
                                <div class="summary-count" id="promote-count">0</div>
                            </div>
                        </div>
                        @can('graduate_students')
                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <div class="text-white-50" style="font-size: 12px;">
                                        {{ trans('admin.Students.promotions.fields.graduate') }}</div>
                                    <div class="summary-count" id="graduate-count">0</div>
                                </div>
                            </div>
                        @endcan
                        <div class="summary-item">
                            <div class="summary-icon">
                                <i class="fas fa-redo"></i>
                            </div>
                            <div>
                                <div class="text-white-50" style="font-size: 12px;">
                                    {{ trans('admin.Students.promotions.repeat_hint') }}</div>
                                <div class="summary-count" id="repeat-count">{{ $students->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-xl-{{ $students->count() ? '9' : '12' }}">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">{{ trans('admin.Students.promotions.promote') }}</h6>
                        @can('graduate_students')
                            <div class="mode-selector">
                                <button type="button" class="mode-btn active" data-mode="promote">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>{{ trans('admin.Students.promotions.fields.promote') }}</span>
                                </button>
                                <button type="button" class="mode-btn graduate" data-mode="graduate">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span>{{ trans('admin.Students.promotions.fields.graduate') }}</span>
                                </button>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        @if ($students->count())
                            <div class="graduate-mode-info">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="fas fa-info-circle"
                                        style="font-size: 20px; color: #f5576c; margin-top: 2px;"></i>
                                    <div>
                                        <strong>{{ trans('admin.Students.promotions.graduation_mode') }}</strong>
                                        <p class="mb-0 mt-1">{{ trans('admin.Students.promotions.graduation_mode_hint') }}</p>
                                    </div>
                                </div>
                            </div>

                            <form id="promotion-form" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="from_grade_id" value="{{ request('from_grade_id') }}">
                                <input type="hidden" name="from_classroom_id"
                                    value="{{ request('from_classroom_id') }}">
                                <input type="hidden" name="from_section_id" value="{{ request('from_section_id') }}">
                                <input type="hidden" name="from_academic_year_id"
                                    value="{{ request('from_academic_year_id') }}">

                                <div class="row destination-fields">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.Students.promotions.fields.to_grade') }} <span
                                                    class="text-danger destination-required">*</span></label>
                                            <select name="to_grade_id" id="to_grade_id" class="form-control select2">
                                                <option value="" disabled selected>--
                                                    {{ trans('admin.global.select') }} --</option>
                                                @foreach ($grades as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text to_grade_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.Students.promotions.fields.to_classroom') }} <span
                                                    class="text-danger destination-required">*</span></label>
                                            <select name="to_classroom_id" id="to_classroom_id"
                                                class="form-control select2">
                                                <option value="" disabled selected>--
                                                    {{ trans('admin.global.select') }} --</option>
                                            </select>
                                            <span class="text-danger error-text to_classroom_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.Students.promotions.fields.to_section') }} <span
                                                    class="text-danger destination-required">*</span></label>
                                            <select name="to_section_id" id="to_section_id" class="form-control select2">
                                                <option value="" disabled selected>--
                                                    {{ trans('admin.global.select') }} --</option>
                                            </select>
                                            <span class="text-danger error-text to_section_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.Students.promotions.fields.to_academic_year') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="to_academic_year_id" id="to_academic_year_id"
                                                class="form-control select2" required>
                                                <option value="" disabled selected>--
                                                    {{ trans('admin.global.select') }} --</option>
                                                @foreach ($academicYears as $year)
                                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text to_academic_year_id_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="promotions_table">
                                        <thead>
                                            <tr>
                                                <th class="wd-5p border-bottom-0">
                                                    <input type="checkbox" id="select_all_students">
                                                    <span class="ml-1">{{ trans('admin.global.select_all') }}</span>
                                                </th>
                                                <th class="wd-5p border-bottom-0">#</th>
                                                <th class="wd-10p border-bottom-0">
                                                    {{ trans('admin.Users.students.fields.student_code') }}</th>
                                                <th class="wd-20p border-bottom-0">
                                                    {{ trans('admin.Users.students.fields.name') }}</th>
                                                <th class="wd-20p border-bottom-0">
                                                    {{ trans('admin.Users.students.fields.guardian') }}</th>
                                                <th class="wd-10p border-bottom-0">
                                                    {{ trans('admin.Users.students.fields.grade') }}</th>
                                                <th class="wd-10p border-bottom-0">
                                                    {{ trans('admin.Users.students.fields.classroom') }}</th>
                                                <th class="wd-10p border-bottom-0">
                                                    {{ trans('admin.Users.students.fields.section') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="promote_student_ids[]"
                                                            value="{{ $student->id }}"
                                                            class="student-checkbox promote-checkbox"
                                                            style="display: none;">
                                                        @can('graduate_students')
                                                            <input type="checkbox" name="graduate_student_ids[]"
                                                                value="{{ $student->id }}"
                                                                class="student-checkbox graduate-checkbox"
                                                                style="display: none;">
                                                        @endcan
                                                    </td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student->student_code }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->guardian->name_father }}</td>
                                                    <td>{{ $student->grade->name }}</td>
                                                    <td>{{ $student->classroom->name }}</td>
                                                    <td>{{ $student->section->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <span class="text-danger error-text promote_student_ids_error"></span>
                                <span class="text-danger error-text graduate_student_ids_error"></span>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" id="submit-promotion" class="btn btn-success btn-lg">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            id="submit-spinner"></span>
                                        <i class="fas fa-check mr-1"></i>
                                        <span id="submit-btn-text">{{ trans('admin.Students.promotions.promote') }}</span>
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ trans('admin.Students.promotions.no_students') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function() {
            let currentMode = 'promote';

            // ─── Select2 Init ────────────────────────────────────────────────
            $('.select2').select2({
                placeholder: '{{ trans('admin.global.select') }}',
                width: '100%'
            });

            // ─── DataTable Init ───────────────────────────────────────────────
            if ($('#promotions_table').length) {
                $('#promotions_table').DataTable(globalTableConfig);
            }

            // ─── Cascade Dropdowns ────────────────────────────────────────────
            setupCascade('#from_grade_id', '#from_classroom_id', '#from_section_id');
            setupCascade('#to_grade_id', '#to_classroom_id', '#to_section_id');

            // ─── Mode Switcher ────────────────────────────────────────────────
            $('.mode-btn').on('click', function() {
                const mode = $(this).data('mode');
                if (mode === currentMode) return;

                currentMode = mode;

                // Update button states
                $('.mode-btn').removeClass('active');
                $(this).addClass('active');

                // Show/hide appropriate checkboxes
                if (mode === 'promote') {
                    $('.promote-checkbox').show();
                    $('.graduate-checkbox').hide().prop('checked', false);
                    $('.destination-fields').removeClass('disabled');
                    $('.graduate-mode-info').removeClass('show');
                    $('#to_grade_id, #to_classroom_id, #to_section_id').prop('required', true);
                    $('.destination-required').show();
                    $('#submit-btn-text').text('{{ trans('admin.Students.promotions.promote') }}');
                } else {
                    $('.promote-checkbox').hide().prop('checked', false);
                    $('.graduate-checkbox').show();
                    $('.destination-fields').addClass('disabled');
                    $('.graduate-mode-info').addClass('show');
                    $('#to_grade_id, #to_classroom_id, #to_section_id').prop('required', false);
                    $('.destination-required').hide();
                    $('#submit-btn-text').text('{{ trans('admin.Students.promotions.fields.graduate') }}');
                }

                // Reset select all
                $('#select_all_students').prop('checked', false);
                updateCounts();
            });

            // Initialize with promote mode
            $('.promote-checkbox').show();
            @can('graduate_students')
                $('.graduate-checkbox').hide();
            @endcan

            // ─── Select All Logic ─────────────────────────────────────────────
            $('#select_all_students').on('change', function() {
                const isChecked = $(this).prop('checked');
                if (currentMode === 'promote') {
                    $('.promote-checkbox:visible').prop('checked', isChecked);
                } else {
                    $('.graduate-checkbox:visible').prop('checked', isChecked);
                }
                updateCounts();
            });

            $(document).on('change', '.student-checkbox', function() {
                const visibleCheckboxes = currentMode === 'promote' ? '.promote-checkbox:visible' :
                    '.graduate-checkbox:visible';
                const total = $(visibleCheckboxes).length;
                const checked = $(visibleCheckboxes + ':checked').length;
                $('#select_all_students').prop('checked', total > 0 && total === checked);
                updateCounts();
            });

            // ─── Update Counts ────────────────────────────────────────────────
            function updateCounts() {
                const promotedCount = $('.promote-checkbox:checked').length;
                const graduatedCount = $('.graduate-checkbox:checked').length;
                @if ($students)
                    const repeatCount = {{ $students->count() }} - promotedCount - graduatedCount;
                @else
                    const repeatCount = 0;
                @endif

                $('#promote-count').text(promotedCount);
                $('#graduate-count').text(graduatedCount);
                $('#repeat-count').text(repeatCount);
            }

            // ─── AJAX Submission ──────────────────────────────────────────────
            $('#submit-promotion').on('click', function() {
                // Check destination fields only in promote mode
                if (currentMode === 'promote') {
                    if (!$('#to_grade_id').val() || !$('#to_classroom_id').val() ||
                        !$('#to_section_id').val() || !$('#to_academic_year_id').val()) {
                        Swal.fire({
                            title: '{{ trans('admin.global.validation_error') }}',
                            text: '{{ trans('admin.Students.promotions.select_destination') }}',
                            icon: 'warning',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }
                }

                const promotedCount = $('.promote-checkbox:checked').length;
                const graduatedCount = $('.graduate-checkbox:checked').length;

                if (promotedCount === 0 && graduatedCount === 0) {
                    Swal.fire({
                        title: '{{ trans('admin.global.validation_error') }}',
                        text: '{{ trans('admin.Students.promotions.select_students') }}',
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                    });
                    return;
                }

                const summaryLines = [];
                if (promotedCount > 0) {
                    summaryLines.push(
                        `<div class="d-flex align-items-center gap-2 mb-2"><i class="fas fa-arrow-up text-primary"></i> <strong>{{ trans('admin.Students.promotions.fields.promote') }}:</strong> ${promotedCount} {{ trans('admin.Students.promotions.students') }}</div>`
                        );
                }
                if (graduatedCount > 0) {
                    summaryLines.push(
                        `<div class="d-flex align-items-center gap-2 mb-2"><i class="fas fa-graduation-cap text-danger"></i> <strong>{{ trans('admin.Students.promotions.fields.graduate') }}:</strong> ${graduatedCount} {{ trans('admin.Students.promotions.students') }}</div>`
                        );
                }

                @if ($students)
                    const repeatCount = {{ $students->count() }} - promotedCount - graduatedCount;
                    if (repeatCount > 0) {
                        summaryLines.push(
                            `<div class="d-flex align-items-center gap-2"><i class="fas fa-redo text-warning"></i> <strong>{{ trans('admin.Students.promotions.repeat_hint') }}:</strong> ${repeatCount} {{ trans('admin.Students.promotions.students') }}</div>`
                            );
                    }
                @endif

                Swal.fire({
                    title: '{{ trans('admin.Students.promotions.confirm_title') }}',
                    html: summaryLines.join(''),
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-check mr-1"></i> {{ trans('admin.global.confirm') }}',
                    cancelButtonText: '<i class="fas fa-times mr-1"></i> {{ trans('admin.global.cancel') }}',
                }).then(function(result) {
                    if (!result.isConfirmed) return;
                    submitPromotion($('#promotion-form'));
                });
            });
        });

        // ─── Submit via AJAX ──────────────────────────────────────────────────
        function submitPromotion(form) {
            const $btn = $('#submit-promotion');
            const $spinner = $('#submit-spinner');

            $('.error-text').text('');
            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: '{{ route("admin.Users.students.promotions.store") }}',
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',

                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '{{ trans('admin.global.success') }}',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#28a745',
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        showErrorAlert(response.message);
                    }
                },

                error: function(xhr) {
                    const response = xhr.responseJSON;

                    if (xhr.status === 422 && response && response.errors) {
                        handleValidationErrors(response.errors);
                        Swal.fire({
                            title: '{{ trans('admin.global.validation_error') }}',
                            text: '{{ trans('admin.global.fix_errors') }}',
                            icon: 'warning',
                            confirmButtonColor: '#d33',
                        });
                    } else {
                        const msg = (response && response.message) ?
                            response.message :
                            '{{ trans('admin.Students.promotions.messages.failed.promote') }}';
                        showErrorAlert(msg);
                    }
                },

                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        }

        // ─── Helpers ─────────────────────────────────────────────────────────
        function showErrorAlert(message) {
            Swal.fire({
                title: '{{ trans('admin.global.error') }}',
                text: message,
                icon: 'error',
                confirmButtonColor: '#d33',
            });
        }

        function handleValidationErrors(errors) {
            $.each(errors, function(field, messages) {
                const $el = $('.' + field + '_error');
                if ($el.length) {
                    $el.text(messages[0]);
                }
            });
        }

        // ─── Cascade Dropdown Helpers ─────────────────────────────────────────
        function setupCascade(gradeSelector, classroomSelector, sectionSelector) {
            $(gradeSelector).on('change', function() {
                loadClassrooms(gradeSelector, classroomSelector, sectionSelector);
            });

            $(classroomSelector).on('change', function() {
                loadSections(classroomSelector, sectionSelector);
            });

            if ($(gradeSelector).val()) {
                loadClassrooms(gradeSelector, classroomSelector, sectionSelector, true);
            }
        }

        function loadClassrooms(gradeSelector, classroomSelector, sectionSelector, init = false) {
            const gradeId = $(gradeSelector).val();
            resetDropdown(classroomSelector);
            resetDropdown(sectionSelector);
            if (!gradeId) return;

            $.ajax({
                url: '{{ route('admin.Academic.classrooms.by-grade') }}',
                type: 'GET',
                data: {
                    grade_id: gradeId
                },
                success: function(response) {
                    if (response.success) {
                        $.each(response.data, function(key, classroom) {
                            $(classroomSelector).append(`<option value="${key}">${classroom}</option>`);
                        });
                        applySelectedOption(classroomSelector, init);
                    }
                }
            });
        }

        function loadSections(classroomSelector, sectionSelector) {
            const classroomId = $(classroomSelector).val();
            resetDropdown(sectionSelector);
            if (!classroomId) return;

            $.ajax({
                url: '{{ route('admin.Academic.sections.by-classroom') }}',
                type: 'GET',
                data: {
                    classroom_id: classroomId
                },
                success: function(response) {
                    if (response.success) {
                        $.each(response.data, function(key, section) {
                            $(sectionSelector).append(`<option value="${key}">${section}</option>`);
                        });
                        applySelectedOption(sectionSelector, true);
                    }
                }
            });
        }

        function resetDropdown(selector) {
            $(selector).html(`<option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>`);
        }

        function applySelectedOption(selector, shouldApply) {
            if (!shouldApply) return;
            const selected = $(selector).data('selected');
            if (selected) {
                $(selector).val(selected).trigger('change');
                $(selector).data('selected', '');
            }
        }
    </script>
@endsection
