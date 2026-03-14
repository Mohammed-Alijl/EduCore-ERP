@extends('admin.layouts.master')

@section('title', trans('admin.finance.invoices.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/invoices/invoice-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.finance') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.finance.invoices.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_invoices')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm" data-effect="effect-scale" data-toggle="modal"
                        href="#addInvoiceModal">
                        <i class="las la-file-invoice-dollar tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.finance.invoices.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-12">
            <div class="card glass-card overflow-hidden">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1 font-weight-bold">{{ trans('admin.finance.invoices.title') }}</h5>
                            <p class="mb-0 text-muted tx-13">
                                {{ trans('admin.finance.invoices.fields.fee_details') }} •
                                {{ trans('admin.finance.invoices.fields.student') }} •
                                {{ trans('admin.finance.invoices.fields.amount') }}
                            </p>
                        </div>
                    </div>

                    {{-- ─── Advanced Filter Section ─── --}}
                    <div class="filter-section mt-4 mb-2">
                        <div class="row align-items-end p-3">
                            {{-- Grade --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-layer-group mr-1"></i> {{ trans('admin.students.fields.grade') }}
                                </label>
                                <select class="form-control form-control-modern" id="filter_grade">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Classroom --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-chalkboard mr-1"></i> {{ trans('admin.students.fields.classroom') }}
                                </label>
                                <select class="form-control form-control-modern" id="filter_classroom" disabled>
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            {{-- Academic Year --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-calendar mr-1"></i>
                                    {{ trans('admin.finance.invoices.fields.academic_year') }}
                                </label>
                                <select class="form-control form-control-modern select2-filter" id="filter_academic_year">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($academicYears as $academicYear)
                                        <option value="{{ $academicYear->id }}">{{ $academicYear->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Student --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-user-graduate mr-1"></i>
                                    {{ trans('admin.finance.invoices.fields.student') }}
                                </label>
                                <select class="form-control form-control-modern" id="filter_student"
                                    data-placeholder="{{ trans('admin.global.all') }}">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            {{-- Fee --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-file-invoice-dollar mr-1"></i>
                                    {{ trans('admin.finance.invoices.fields.fee_details') }}
                                </label>
                                <select class="form-control form-control-modern select2-filter" id="filter_fee">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($fees as $fee)
                                        <option value="{{ $fee->id }}">{{ $fee->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Reset Button --}}
                            <div class="col-md-2 text-right">
                                <button class="btn btn-modern w-100 btn-outline-primary" id="reset_filters">
                                    <i class="las la-sync-alt mr-1 ml-1"></i>
                                    {{ trans('admin.global.reset_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover mb-0" id="invoices_table" width="100%">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.finance.invoices.fields.student') }}
                                    </th>
                                    <th class="wd-25p border-bottom-0">
                                        {{ trans('admin.finance.invoices.fields.fee_details') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.finance.invoices.fields.amount') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.finance.invoices.fields.date') }}
                                    </th>
                                    <th class="wd-10p border-bottom-0 text-center">{{ trans('admin.global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    @include('admin.finance.invoices.add_modal')
    @include('admin.finance.invoices.show_modal')
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(function() {
            var studentSearchUrl = '{{ route('admin.students.search') }}';
            var classroomsByGradeUrl = '{{ route('admin.classrooms.by-grade') }}';
            var invoiceTableUrl = '{{ route('admin.invoices.datatable') }}';

            var elements = {
                addInvoiceModal: $('#addInvoiceModal'),
                filterGrade: $('#filter_grade'),
                filterClassroom: $('#filter_classroom'),
                filterAcademicYear: $('#filter_academic_year'),
                filterStudent: $('#filter_student'),
                filterFee: $('#filter_fee'),
                resetFilters: $('#reset_filters'),
                feeSelect: $('select[name="fee_id"]'),
                modalStudentSelect: $('.select2-student-modal'),
                amountDisplay: $('#fee-amount-display')
            };

            initializeStaticSelects();
            initializeStudentSelect(elements.filterStudent, {
                placeholder: '{{ trans('admin.global.all') }}',
                includeFilterContext: true
            });
            initializeStudentSelect(elements.modalStudentSelect, {
                placeholder: '{{ trans('admin.global.select') }}',
                dropdownParent: elements.addInvoiceModal
            });

            elements.feeSelect.on('change', updateFeeAmountPreview);
            elements.addInvoiceModal.on('hidden.bs.modal', resetAddInvoiceModal);

            var table = $('#invoices_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: invoiceTableUrl,
                    data: function(d) {
                        $.extend(d, getTableFilters());
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student',
                        name: 'student',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fee_details',
                        name: 'fee_details',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'date',
                        name: 'invoice_date'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            elements.filterGrade.on('change', function() {
                resetStudentFilter();
                resetClassroomFilter();

                loadClassroomsByGrade($(this).val())
                    .always(function() {
                        table.draw();
                    });
            });

            elements.filterClassroom.on('change', function() {
                resetStudentFilter();
                table.draw();
            });

            elements.filterStudent.add(elements.filterFee).on('change', function() {
                drawTable();
            });

            elements.filterAcademicYear.on('change', function() {
                drawTable();
            });

            elements.resetFilters.on('click', resetFilters);

            function initializeStaticSelects() {
                $('.select2-modal').select2({
                    placeholder: '{{ trans('admin.global.select') }}',
                    width: '100%',
                    dropdownParent: elements.addInvoiceModal
                });

                $('.select2-filter').select2({
                    width: '100%',
                    allowClear: true
                });
            }

            function initializeStudentSelect($element, options) {
                var settings = options || {};
                var includeFilterContext = settings.includeFilterContext === true;
                var config = $.extend(true, {
                    width: '100%',
                    allowClear: true,
                    placeholder: $element.data('placeholder') || '{{ trans('admin.global.select') }}',
                    minimumInputLength: 0,
                    ajax: {
                        url: studentSearchUrl,
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            return buildStudentSearchParams(params, includeFilterContext);
                        },
                        processResults: function(response, params) {
                            params.page = params.page || 1;

                            return {
                                results: response.results || [],
                                pagination: {
                                    more: response.pagination && response.pagination.more === true
                                }
                            };
                        }
                    }
                }, settings);

                if ($element.hasClass('select2-hidden-accessible')) {
                    $element.select2('destroy');
                }

                $element.select2(config);
            }

            function buildStudentSearchParams(params, includeFilterContext) {
                var request = {
                    q: params.term || '',
                    page: params.page || 1
                };

                if (includeFilterContext) {
                    request.grade_id = elements.filterGrade.val();
                    request.classroom_id = elements.filterClassroom.val();
                }

                return request;
            }

            function getTableFilters() {
                return {
                    grade_id: elements.filterGrade.val(),
                    classroom_id: elements.filterClassroom.val(),
                    academic_year_id: elements.filterAcademicYear.val(),
                    student_id: elements.filterStudent.val(),
                    fee_id: elements.filterFee.val()
                };
            }

            function updateFeeAmountPreview() {
                var amount = elements.feeSelect.find(':selected').data('amount') || '0.00';
                elements.amountDisplay.text(amount);
            }

            function drawTable() {
                table.draw();
            }

            function resetAddInvoiceModal() {
                var form = this.querySelector('form');

                if (form) {
                    form.reset();
                }

                elements.modalStudentSelect.val(null).trigger('change.select2');
                elements.feeSelect.val(null).trigger('change.select2');
                elements.amountDisplay.text('0.00');
                elements.addInvoiceModal.find('.error-text').text('');
            }

            function resetStudentFilter() {
                elements.filterStudent.val(null).trigger('change.select2');
            }

            function resetClassroomFilter() {
                elements.filterClassroom
                    .empty()
                    .append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true)
                    .trigger('change.select2');
            }

            function loadClassroomsByGrade(gradeId) {
                if (!gradeId) {
                    return $.Deferred().resolve().promise();
                }

                return $.ajax({
                    url: classroomsByGradeUrl,
                    data: {
                        grade_id: gradeId
                    }
                }).done(function(response) {
                    if (!(response.success && response.data)) {
                        return;
                    }

                    $.each(response.data, function(_, classroom) {
                        elements.filterClassroom.append(
                            $('<option>', {
                                value: classroom.id,
                                text: classroom.name
                            })
                        );
                    });

                    elements.filterClassroom.prop('disabled', false).trigger('change.select2');
                });
            }

            function resetFilters() {
                elements.filterGrade.val('').trigger('change.select2');
                resetClassroomFilter();
                resetStudentFilter();
                elements.filterAcademicYear.val('').trigger('change.select2');
                elements.filterFee.val('').trigger('change.select2');
                drawTable();
            }

        });
    </script>
    @stack('scripts')
@endsection
