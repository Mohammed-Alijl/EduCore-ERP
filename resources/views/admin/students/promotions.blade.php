@extends('admin.layouts.master')

@section('title', trans('admin.promotions.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.promotions.title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="card-title mb-0">{{ trans('admin.promotions.filters') }}</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.students.promotions.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.promotions.fields.from_grade') }} <span class="text-danger">*</span></label>
                                    <select name="from_grade_id" id="from_grade_id" class="form-control select2" required>
                                        <option value="" disabled {{ request('from_grade_id') ? '' : 'selected' }}>-- {{ trans('admin.global.select') }} --</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}" {{ request('from_grade_id') == $grade->id ? 'selected' : '' }}>
                                                {{ $grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.promotions.fields.from_classroom') }} <span class="text-danger">*</span></label>
                                    <select name="from_classroom_id" id="from_classroom_id" class="form-control select2"
                                            data-selected="{{ request('from_classroom_id') }}" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.promotions.fields.from_section') }} <span class="text-danger">*</span></label>
                                    <select name="from_section_id" id="from_section_id" class="form-control select2"
                                            data-selected="{{ request('from_section_id') }}" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ trans('admin.promotions.fields.from_academic_year') }} <span class="text-danger">*</span></label>
                                    <select name="from_academic_year_id" id="from_academic_year_id" class="form-control select2" required>
                                        <option value="" disabled {{ request('from_academic_year_id') ? '' : 'selected' }}>-- {{ trans('admin.global.select') }} --</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ request('from_academic_year_id') == $year->id ? 'selected' : '' }}>
                                                {{ $year->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">{{ trans('admin.promotions.load_students') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($students !== null)
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="card-title mb-0">{{ trans('admin.promotions.promote') }}</h6>
                    </div>
                    <div class="card-body">
                        @if($students->count())
                            {{-- No method="POST", JS handles submission --}}
                            <form id="promotion-form" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="from_grade_id" value="{{ request('from_grade_id') }}">
                                <input type="hidden" name="from_classroom_id" value="{{ request('from_classroom_id') }}">
                                <input type="hidden" name="from_section_id" value="{{ request('from_section_id') }}">
                                <input type="hidden" name="from_academic_year_id" value="{{ request('from_academic_year_id') }}">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.promotions.fields.to_grade') }} <span class="text-danger">*</span></label>
                                            <select name="to_grade_id" id="to_grade_id" class="form-control select2" required>
                                                <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text to_grade_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.promotions.fields.to_classroom') }} <span class="text-danger">*</span></label>
                                            <select name="to_classroom_id" id="to_classroom_id" class="form-control select2" required>
                                                <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                            </select>
                                            <span class="text-danger error-text to_classroom_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.promotions.fields.to_section') }} <span class="text-danger">*</span></label>
                                            <select name="to_section_id" id="to_section_id" class="form-control select2" required>
                                                <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                            </select>
                                            <span class="text-danger error-text to_section_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('admin.promotions.fields.to_academic_year') }} <span class="text-danger">*</span></label>
                                            <select name="to_academic_year_id" id="to_academic_year_id" class="form-control select2" required>
                                                <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                                @foreach($academicYears as $year)
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
                                                <span class="ml-1">{{ trans('admin.promotions.fields.promote') }}</span>
                                            </th>
                                            @can('graduate_students')
                                                <th class="wd-5p border-bottom-0">{{ trans('admin.promotions.fields.graduate') }}</th>
                                            @endcan
                                            <th class="wd-5p border-bottom-0">#</th>
                                            <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.student_code') }}</th>
                                            <th class="wd-20p border-bottom-0">{{ trans('admin.students.fields.name') }}</th>
                                            <th class="wd-20p border-bottom-0">{{ trans('admin.students.fields.guardian') }}</th>
                                            <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.grade') }}</th>
                                            <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.classroom') }}</th>
                                            <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.section') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="promote_student_ids[]" value="{{ $student->id }}" class="student-checkbox promote-checkbox">
                                                </td>
                                                @can('graduate_students')
                                                    <td>
                                                        <input type="checkbox" name="graduate_student_ids[]" value="{{ $student->id }}" class="graduate-checkbox">
                                                    </td>
                                                @endcan
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

                                <div class="mt-2">
                                    <span class="text-muted">{{ trans('admin.promotions.repeat_hint') }}</span>
                                </div>

                                <span class="text-danger error-text promote_student_ids_error"></span>
                                <span class="text-danger error-text graduate_student_ids_error"></span>

                                <div class="d-flex justify-content-end">
                                    <button type="button" id="submit-promotion" class="btn btn-success">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" id="submit-spinner"></span>
                                        {{ trans('admin.promotions.promote') }}
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">{{ trans('admin.promotions.no_students') }}</div>
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
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function () {

            // ─── Select2 Init ────────────────────────────────────────────────
            $('.select2').select2({
                placeholder: '{{ trans("admin.global.select") }}',
                width: '100%'
            });

            // ─── DataTable Init ───────────────────────────────────────────────
            if ($('#promotions_table').length) {
                $('#promotions_table').DataTable(globalTableConfig);
            }

            // ─── Cascade Dropdowns ────────────────────────────────────────────
            setupCascade('#from_grade_id', '#from_classroom_id', '#from_section_id');
            setupCascade('#to_grade_id',   '#to_classroom_id',   '#to_section_id');

            // ─── Select All / Promote / Graduate Logic ────────────────────────
            $('#select_all_students').on('change', function () {
                $('.promote-checkbox').prop('checked', $(this).prop('checked'));
                if ($(this).prop('checked')) {
                    $('.graduate-checkbox').prop('checked', false);
                }
            });

            $(document).on('change', '.promote-checkbox', function () {
                if ($(this).prop('checked')) {
                    $(this).closest('tr').find('.graduate-checkbox').prop('checked', false);
                }
                var total   = $('.promote-checkbox').length;
                var checked = $('.promote-checkbox:checked').length;
                $('#select_all_students').prop('checked', total > 0 && total === checked);
            });

            $(document).on('change', '.graduate-checkbox', function () {
                if ($(this).prop('checked')) {
                    $(this).closest('tr').find('.promote-checkbox').prop('checked', false);
                    $('#select_all_students').prop('checked', false);
                }
            });

            // ─── AJAX Submission ──────────────────────────────────────────────
            $('#submit-promotion').on('click', function () {

                var form = $('#promotion-form');
                if (!form.parsley().validate()) {
                    return;
                }

                var promotedCount  = $('.promote-checkbox:checked').length;
                var graduatedCount = $('.graduate-checkbox:checked').length;

                var summaryLines = [];
                if (promotedCount > 0) {
                    summaryLines.push('<strong>{{ trans("admin.promotions.fields.promote") }}:</strong> ' + promotedCount + ' {{ trans("admin.promotions.students") }}');
                }
                if (graduatedCount > 0) {
                    summaryLines.push('<strong>{{ trans("admin.promotions.fields.graduate") }}:</strong> ' + graduatedCount + ' {{ trans("admin.promotions.students") }}');
                }

                @if($students)
                var repeatCount = {{ $students->count() }} - promotedCount - graduatedCount;
                if (repeatCount > 0) {
                    summaryLines.push('<strong>{{ trans("admin.promotions.repeat_hint") }}:</strong> ' + repeatCount + ' {{ trans("admin.promotions.students") }}');
                }
                @endif
                Swal.fire({
                    title: '{{ trans("admin.promotions.confirm_title") }}',
                    html: summaryLines.length
                        ? summaryLines.join('<br>')
                        : '{{ trans("admin.promotions.confirm_body") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor:  '#6c757d',
                    confirmButtonText: '{{ trans("admin.promotions.promote") }}',
                    cancelButtonText:  '{{ trans("admin.global.cancel") }}',
                }).then(function (result) {
                    if (!result.isConfirmed) return;

                    submitPromotion(form);
                });
            });
        });

        // ─── Submit via AJAX ──────────────────────────────────────────────────
        function submitPromotion(form) {
            var $btn     = $('#submit-promotion');
            var $spinner = $('#submit-spinner');

            // Clear previous inline errors
            $('.error-text').text('');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url:         '{{ route("admin.students.promotions.store") }}',
                type:        'POST',
                data:        form.serialize(),
                dataType:    'json',

                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title:             '{{ trans("admin.global.success") }}',
                            text:              response.message,
                            icon:              'success',
                            confirmButtonColor: '#28a745',
                        }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        showErrorAlert(response.message);
                    }
                },

                error: function (xhr) {
                    var response = xhr.responseJSON;

                    if (xhr.status === 422 && response && response.errors) {
                        handleValidationErrors(response.errors);

                        Swal.fire({
                            title:             '{{ trans("admin.global.validation_error") }}',
                            text:              '{{ trans("admin.global.fix_errors") }}',
                            icon:              'warning',
                            confirmButtonColor: '#d33',
                        });
                    } else {
                        var msg = (response && response.message)
                            ? response.message
                            : '{{ trans("admin.promotions.messages.failed.promote") }}';
                        showErrorAlert(msg);
                    }
                },

                complete: function () {
                    $btn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        }

        // ─── Helpers ─────────────────────────────────────────────────────────
        function showErrorAlert(message) {
            Swal.fire({
                title:             '{{ trans("admin.global.error") }}',
                text:              message,
                icon:              'error',
                confirmButtonColor: '#d33',
            });
        }

        function handleValidationErrors(errors) {
            $.each(errors, function (field, messages) {
                var $el = $('.' + field + '_error');
                if ($el.length) {
                    $el.text(messages[0]);
                }
            });
        }

        // ─── Cascade Dropdown Helpers ─────────────────────────────────────────
        function setupCascade(gradeSelector, classroomSelector, sectionSelector) {
            $(gradeSelector).on('change', function () {
                loadClassrooms(gradeSelector, classroomSelector, sectionSelector);
            });

            $(classroomSelector).on('change', function () {
                loadSections(classroomSelector, sectionSelector);
            });

            if ($(gradeSelector).val()) {
                loadClassrooms(gradeSelector, classroomSelector, sectionSelector, true);
            }
        }

        function loadClassrooms(gradeSelector, classroomSelector, sectionSelector, init = false) {
            var gradeId = $(gradeSelector).val();
            resetDropdown(classroomSelector);
            resetDropdown(sectionSelector);
            if (!gradeId) return;

            $.ajax({
                url:  '{{ route("admin.classrooms.by-grade") }}',
                type: 'GET',
                data: { grade_id: gradeId },
                success: function (response) {
                    if (response.success) {
                        $.each(response.data, function (key, classroom) {
                            $(classroomSelector).append(`<option value="${key}">${classroom}</option>`);
                        });
                        applySelectedOption(classroomSelector, init);
                    }
                }
            });
        }

        function loadSections(classroomSelector, sectionSelector) {
            var classroomId = $(classroomSelector).val();
            resetDropdown(sectionSelector);
            if (!classroomId) return;

            $.ajax({
                url:  '{{ route("admin.sections.by-classroom") }}',
                type: 'GET',
                data: { classroom_id: classroomId },
                success: function (response) {
                    if (response.success) {
                        $.each(response.data, function (key, section) {
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
            var selected = $(selector).data('selected');
            if (selected) {
                $(selector).val(selected).trigger('change');
                $(selector).data('selected', '');
            }
        }
    </script>
@endsection
