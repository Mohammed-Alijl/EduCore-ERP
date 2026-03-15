@extends('admin.layouts.master')

@section('title', trans('admin.finance.receipts.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/receipts/receipts-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.finance') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.finance.receipts.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_receipts')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-success btn-modern shadow-sm" data-effect="effect-scale" data-toggle="modal"
                        href="#addReceiptModal">
                        <i class="las la-receipt tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.finance.receipts.add') }}
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
                            <h5 class="mb-1 font-weight-bold">{{ trans('admin.finance.receipts.title') }}</h5>
                            <p class="mb-0 text-muted tx-13">
                                {{ trans('admin.finance.receipts.fields.receipt_number') }} •
                                {{ trans('admin.finance.receipts.fields.student') }} •
                                {{ trans('admin.finance.receipts.fields.amount') }}
                            </p>
                        </div>
                    </div>

                    {{-- ─── Advanced Filter Section ─── --}}
                    <div class="filter-section mt-4 mb-2">
                        <div class="row align-items-end p-2">
                            {{-- Grade --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label">
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
                                <label class="form-label">
                                    <i class="las la-chalkboard mr-1"></i> {{ trans('admin.students.fields.classroom') }}
                                </label>
                                <select class="form-control form-control-modern" id="filter_classroom" disabled>
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            {{-- Academic Year --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label">
                                    <i class="las la-calendar mr-1"></i>
                                    {{ trans('admin.finance.receipts.fields.academic_year') }}
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
                                <label class="form-label">
                                    <i class="las la-user-graduate mr-1"></i>
                                    {{ trans('admin.finance.receipts.fields.student') }}
                                </label>
                                <select class="form-control form-control-modern" id="filter_student"
                                    data-placeholder="{{ trans('admin.global.all') }}">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            {{-- Payment Method --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label">
                                    <i class="las la-credit-card mr-1"></i>
                                    {{ trans('admin.finance.receipts.fields.payment_method') }}
                                </label>
                                <select class="form-control form-control-modern select2-filter" id="filter_payment_method">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    <option value="cash">{{ trans('admin.finance.receipts.payment_methods.cash') }}</option>
                                    <option value="bank_transfer">{{ trans('admin.finance.receipts.payment_methods.bank_transfer') }}</option>
                                    <option value="cheque">{{ trans('admin.finance.receipts.payment_methods.cheque') }}</option>
                                    <option value="online">{{ trans('admin.finance.receipts.payment_methods.online') }}</option>
                                </select>
                            </div>

                            {{-- Reset Button --}}
                            <div class="col-md-2 text-right">
                                <button class="btn w-100 btn-outline-success" id="reset_filters">
                                    <i class="las la-sync-alt mr-1 ml-1"></i>
                                    {{ trans('admin.global.reset_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover mb-0" id="receipts_table" width="100%">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.finance.receipts.fields.receipt_number') }}</th>
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.finance.receipts.fields.student') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.finance.receipts.fields.invoice') }}</th>
                                    <th class="wd-12p border-bottom-0">{{ trans('admin.finance.receipts.fields.amount') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.finance.receipts.fields.payment_method') }}</th>
                                    <th class="wd-12p border-bottom-0">{{ trans('admin.finance.receipts.fields.date') }}</th>
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

    @include('admin.finance.receipts.add_modal')
    @include('admin.finance.receipts.show_modal')
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
        $(function () {

            var studentSearchUrl    = '{{ route('admin.students.search') }}';
            var classroomsByGradeUrl = '{{ route('admin.classrooms.by-grade') }}';
            var receiptTableUrl     = '{{ route('admin.receipts.datatable') }}';

            var elements = {
                addReceiptModal:      $('#addReceiptModal'),
                filterGrade:          $('#filter_grade'),
                filterClassroom:      $('#filter_classroom'),
                filterAcademicYear:   $('#filter_academic_year'),
                filterStudent:        $('#filter_student'),
                filterPaymentMethod:  $('#filter_payment_method'),
                resetFilters:         $('#reset_filters'),
                invoiceSelect:        $('select[name="invoice_id"]'),
                modalStudentSelect:   $('.select2-student-modal'),
                amountDisplay:        $('#receipt-amount-display'),
            };

            initializeStaticSelects();
            initializeStudentSelect(elements.filterStudent, {
                placeholder: '{{ trans('admin.global.all') }}',
                includeFilterContext: true,
            });

            elements.invoiceSelect.on('change', updateInvoiceAmountPreview);
            elements.addReceiptModal.on('hidden.bs.modal', resetAddReceiptModal);

            var table = $('#receipts_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: receiptTableUrl,
                    data: function (d) {
                        $.extend(d, getTableFilters());
                    },
                },
                columns: [
                    { data: 'DT_RowIndex',    name: 'DT_RowIndex',    orderable: false, searchable: false },
                    { data: 'receipt_number', name: 'receipt_number' },
                    { data: 'student',        name: 'student',        orderable: false, searchable: false },
                    { data: 'invoice_ref',    name: 'invoice_ref',    orderable: false, searchable: false },
                    { data: 'amount',         name: 'amount' },
                    { data: 'payment_method', name: 'payment_method', orderable: false },
                    { data: 'date',           name: 'receipt_date' },
                    { data: 'actions',        name: 'actions',        orderable: false, searchable: false, className: 'text-center' },
                ],
            });

            // ─── Filter Events ──────────────────────────────────────────────
            elements.filterGrade.on('change', function () {
                resetStudentFilter();
                resetClassroomFilter();
                loadClassroomsByGrade($(this).val()).always(function () { table.draw(); });
            });

            elements.filterClassroom.on('change', function () {
                resetStudentFilter();
                table.draw();
            });

            elements.filterStudent
                .add(elements.filterPaymentMethod)
                .add(elements.filterAcademicYear)
                .on('change', function () { table.draw(); });

            elements.resetFilters.on('click', resetFilters);

            // ─── Helpers ────────────────────────────────────────────────────
            function initializeStaticSelects() {
                $('.select2-modal').select2({
                    placeholder: '{{ trans('admin.global.select') }}',
                    width: '100%',
                    dropdownParent: elements.addReceiptModal,
                });

                $('.select2-filter').select2({
                    width: '100%',
                    allowClear: true,
                });
            }

            function initializeStudentSelect($el, options) {
                var settings = options || {};
                var includeFilter = settings.includeFilterContext === true;
                var config = $.extend(true, {
                    width: '100%',
                    allowClear: true,
                    placeholder: $el.data('placeholder') || '{{ trans('admin.global.select') }}',
                    minimumInputLength: 0,
                    ajax: {
                        url: studentSearchUrl,
                        dataType: 'json',
                        delay: 250,
                        cache: !includeFilter,
                        data: function (params) {
                            var req = { q: params.term || '', page: params.page || 1 };
                            if (includeFilter) {
                                req.grade_id     = elements.filterGrade.val();
                                req.classroom_id = elements.filterClassroom.val();
                            }
                            return req;
                        },
                        processResults: function (response, params) {
                            params.page = params.page || 1;
                            return {
                                results: response.results || [],
                                pagination: { more: response.pagination && response.pagination.more === true },
                            };
                        },
                    },
                }, settings);

                if ($el.hasClass('select2-hidden-accessible')) { $el.select2('destroy'); }
                $el.select2(config);
            }

            function getTableFilters() {
                return {
                    grade_id:         elements.filterGrade.val(),
                    classroom_id:     elements.filterClassroom.val(),
                    academic_year_id: elements.filterAcademicYear.val(),
                    student_id:       elements.filterStudent.val(),
                    payment_method:   elements.filterPaymentMethod.val(),
                };
            }

            function updateInvoiceAmountPreview() {
                var amount = elements.invoiceSelect.find(':selected').data('amount') || '0.00';
                elements.amountDisplay.text(amount);
            }

            function resetAddReceiptModal() {
                var form = this.querySelector('form');
                if (form) { form.reset(); }
                elements.invoiceSelect.val(null).trigger('change.select2');
                elements.amountDisplay.text('0.00');
                elements.addReceiptModal.find('.error-text').text('');
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
                if (!gradeId) { return $.Deferred().resolve().promise(); }
                return $.ajax({
                    url: classroomsByGradeUrl,
                    data: { grade_id: gradeId },
                }).done(function (response) {
                    if (!(response.success && response.data)) { return; }
                    $.each(response.data, function (_, classroom) {
                        elements.filterClassroom.append($('<option>', { value: classroom.id, text: classroom.name }));
                    });
                    elements.filterClassroom.prop('disabled', false).trigger('change.select2');
                });
            }

            function resetFilters() {
                elements.filterGrade.val('').trigger('change.select2');
                resetClassroomFilter();
                resetStudentFilter();
                elements.filterAcademicYear.val('').trigger('change.select2');
                elements.filterPaymentMethod.val('').trigger('change.select2');
                table.draw();
            }

        });
    </script>
    @stack('scripts')
@endsection
