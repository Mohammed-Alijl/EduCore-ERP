@extends('admin.layouts.master')

@section('title', trans('admin.sidebar.attendance'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    {{-- Attendance CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/attendance/attendance-crud.css') }}" rel="stylesheet">
    <!-- Sweet Alert 2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between attendance-page">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-user-check"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.attendances.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ trans('admin.attendances.subtitle') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-info btn-sm" id="btn_print_section_attendance">
                <i class="las la-print mr-1"></i>
                {{ trans('admin.attendances.print_section') ?? 'Print Section' }}
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="attendance-page">
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="glass-card mb-4">
                    <div class="glass-card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-calendar"></i> {{ trans('admin.attendances.attendance_date') }}
                                </label>
                                <input type="date" class="form-control form-control-modern" id="attendance_date"
                                    name="attendance_date" value="{{ now()->toDateString() }}"
                                    max="{{ now()->toDateString() }}">
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-layer-group"></i> {{ trans('admin.attendances.filter_grade') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_grade" name="grade_id">
                                    <option value="">{{ trans('admin.attendances.select_grade') }}</option>
                                    @foreach ($lookups['grades'] ?? $grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-chalkboard"></i> {{ trans('admin.attendances.filter_classroom') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_classroom"
                                    name="classroom_id" disabled>
                                    <option value="">{{ trans('admin.attendances.select_classroom') }}</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-users"></i> {{ trans('admin.attendances.filter_section') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_section"
                                    name="section_id" disabled>
                                    <option value="">{{ trans('admin.attendances.select_section') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn load-students-btn" id="btn_load_students">
                                <span class="spinner-border spinner-border-sm d-none" id="load_students_spinner"></span>
                                <i class="las la-search mr-1 ml-1"></i>
                                {{ trans('admin.attendances.load_students') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div id="students_container"></div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <!-- SweetAlert2 js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            /**
             * Attendance Management Class
             * Handles all UI interactions, AJAX requests, and validation for the attendance page.
             */
            class AttendanceManager {
                constructor() {
                    this.initElements();
                    this.initAlerts();
                    this.bindEvents();
                    this.setupAjax();
                }

                initElements() {
                    // Filters
                    this.$grade = $('#filter_grade');
                    this.$classroom = $('#filter_classroom');
                    this.$section = $('#filter_section');
                    this.$date = $('#attendance_date');
                    
                    // Buttons
                    this.$loadBtn = $('#btn_load_students');
                    this.$printBtn = $('#btn_print_section_attendance');
                    
                    // Containers
                    this.$container = $('#students_container');
                    
                    // Translations & Routes (Passed from Blade)
                    this.routes = {
                        classrooms: "{{ route('admin.classrooms.by-grade') }}",
                        sections: "{{ route('admin.sections.by-classroom') }}",
                        students: "{{ route('admin.attendances.students') }}",
                        store: "{{ route('admin.attendances.store') }}",
                        print: "{{ route('admin.attendances.print-section') }}"
                    };

                    this.trans = {
                        select: "-- {{ trans('admin.global.select') }} --",
                        loading: '<i class="las la-spinner la-spin mr-1"></i> {{ trans("admin.attendances.loading") }}',
                        saving: '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trans("admin.attendances.saving") }}',
                        ok: "{{ trans('admin.global.ok') }}",
                        warning: "{{ trans('admin.attendances.messages.failed.warning') }}",
                        errorTitle: "{{ trans('admin.attendances.messages.failed.error') }}",
                        success: "{{ trans('admin.attendances.messages.success.add') }}",
                        warningSelect: "{{ trans('admin.attendances.messages.warning_select') }}",
                        errorFetch: "{{ trans('admin.attendances.messages.error_fetch') }}",
                        errorSave: "{{ trans('admin.attendances.messages.error_save') }}",
                        errorPrint: "{{ trans('admin.attendances.messages.error_print') }}"
                    };
                }

                initAlerts() {
                    const self = this;
                    this.alert = {
                        success: (text) => Swal.fire({
                            icon: 'success', title: self.trans.success, text: text, timer: 2000, showConfirmButton: false
                        }),
                        error: (text) => Swal.fire({
                            icon: 'error', title: self.trans.errorTitle, text: text, confirmButtonText: self.trans.ok
                        }),
                        warning: (text) => Swal.fire({
                            icon: 'warning', title: self.trans.warning, text: text, confirmButtonText: self.trans.ok
                        })
                    };
                }

                setupAjax() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                }

                bindEvents() {
                    this.$grade.on('change', () => this.handleGradeChange());
                    this.$classroom.on('change', () => this.handleClassroomChange());
                    this.$loadBtn.on('click', (e) => this.loadStudents(e));
                    this.$printBtn.on('click', (e) => this.printAttendance(e));
                    $('body').on('submit', '#attendanceForm', (e) => this.saveAttendance(e));
                }

                resetSelect($el) {
                    $el.empty().append(`<option value="" disabled selected>${this.trans.select}</option>`).prop('disabled', true);
                }

                populateSelect($el, data) {
                    $.each(data, (key, val) => {
                        $el.append(`<option value="${key}">${val}</option>`);
                    });
                    $el.prop('disabled', false);
                }

                handleGradeChange() {
                    const gradeId = this.$grade.val();
                    this.resetSelect(this.$classroom);
                    this.resetSelect(this.$section);

                    if (gradeId) {
                        $.get(this.routes.classrooms, { grade_id: gradeId }, (response) => {
                            if (response.success) this.populateSelect(this.$classroom, response.data);
                        });
                    }
                }

                handleClassroomChange() {
                    const classroomId = this.$classroom.val();
                    this.resetSelect(this.$section);

                    if (classroomId) {
                        $.get(this.routes.sections, { classroom_id: classroomId }, (response) => {
                            if (response.success) this.populateSelect(this.$section, response.data);
                        });
                    }
                }

                hasValidFilters() {
                    return this.$section.val() && this.$date.val();
                }

                toggleButton($btn, textHtml, disable) {
                    if (disable) {
                        $btn.data('original-text', $btn.html())
                            .prop('disabled', true)
                            .html(textHtml);
                    } else {
                        $btn.prop('disabled', false)
                            .html($btn.data('original-text'));
                    }
                }

                loadStudents(e) {
                    e.preventDefault();

                    if (!this.hasValidFilters()) {
                        return this.alert.warning(this.trans.warningSelect);
                    }

                    this.toggleButton(this.$loadBtn, this.trans.loading, true);

                    $.get(this.routes.students, {
                        section_id: this.$section.val(),
                        attendance_date: this.$date.val()
                    })
                    .done((response) => {
                        if (response.status === 'success') {
                            this.$container.html(response.html).hide().fadeIn('fast');
                        }
                    })
                    .fail(() => this.alert.error(this.trans.errorFetch))
                    .always(() => this.toggleButton(this.$loadBtn, null, false));
                }

                printAttendance(e) {
                    e.preventDefault();

                    if (!this.hasValidFilters()) {
                        return this.alert.warning(this.trans.warningSelect);
                    }

                    this.toggleButton(this.$printBtn, this.trans.loading, true);

                    $.post(this.routes.print, {
                        section_id: this.$section.val(),
                        attendance_date: this.$date.val()
                    })
                    .done((response) => {
                        if (response.status === 'success') {
                            const printWindow = window.open('', '_blank');
                            printWindow.document.write(response.html);
                            printWindow.document.close();
                            setTimeout(() => printWindow.print(), 500);
                        } else {
                            this.alert.error(response.message || this.trans.errorPrint);
                        }
                    })
                    .fail((xhr) => {
                        this.alert.error(xhr.responseJSON?.message || this.trans.errorPrint);
                    })
                    .always(() => this.toggleButton(this.$printBtn, null, false));
                }

                saveAttendance(e) {
                    e.preventDefault();
                    
                    const $form = $(e.target);
                    if ($form.parsley && !$form.parsley().isValid()) return;

                    const $btn = $('#saveAttendanceBtn');
                    this.toggleButton($btn, this.trans.saving, true);

                    // Clear previous errors
                    $form.find('.is-invalid').removeClass('is-invalid');
                    $form.find('.error-text').remove();

                    // Serialize and append dynamic filters
                    const formData = $form.serializeArray();
                    formData.push(
                        { name: 'grade_id', value: this.$grade.val() },
                        { name: 'classroom_id', value: this.$classroom.val() },
                        { name: 'section_id', value: this.$section.val() },
                        { name: 'attendance_date', value: this.$date.val() }
                    );

                    $.post(this.routes.store, $.param(formData))
                        .done((response) => {
                            if (response.status === 'success') {
                                this.alert.success(response.message);
                            }
                        })
                        .fail((xhr) => this.handleValidationErrors(xhr, $form))
                        .always(() => this.toggleButton($btn, null, false));
                }

                handleValidationErrors(xhr, $form) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, (key, value) => {
                            this.alert.error(value[0]);
                            
                            let $input = $form.find(`[name="${key}"]`);
                            if (!$input.length) $input = $form.find(`[name="${key}[]"]`);

                            if (!$input.length) {
                                let spatieName = key.replace('.', '[').replace(/(\.[^.]+)$/, ']') + ']';
                                const parts = key.split('.');
                                if (parts.length > 1) {
                                    spatieName = parts[0] + '[' + parts[1] + ']';
                                }
                                $input = $form.find(`[name="${spatieName}"]`);
                            }

                            $input.addClass('is-invalid');
                            const errorClass = key.replace(/\./g, '_') + '_error';
                            const $errorElement = $form.find('.' + errorClass);
                            
                            if ($errorElement.length) {
                                $errorElement.text(value[0]);
                            } else {
                                const errorHtml = `<div class="text-danger error-text mt-1 ${errorClass}">${value[0]}</div>`;
                                if ($input.closest('.status-pills').length) {
                                    $input.closest('.status-pills').after(errorHtml);
                                } else {
                                    $input.after(errorHtml);
                                }
                            }
                        });
                    } else {
                        this.alert.error(this.trans.errorSave);
                    }
                }
            }

            // Initialize the Attendance Manager
            new AttendanceManager();
        });
    </script>
@endsection
