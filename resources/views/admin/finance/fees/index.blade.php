@extends('admin.layouts.master')

@section('title', __('admin.finance.fees.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Academic/grade/grade-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Finance/finance-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.finance') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.finance.fees.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_fees')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addFeeModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ __('admin.finance.fees.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            {{-- Filter Section --}}
            <div class="filter-section shadow-sm mb-4">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-tags mr-1"></i> {{ __('admin.finance.fees.fields.category') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_category">
                            <option value="">{{ __('admin.global.all') }}</option>
                            @foreach($lookups['feeCategories'] as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-calendar mr-1"></i> {{ __('admin.finance.fees.fields.academic_year') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_academic_year">
                            <option value="">{{ __('admin.global.all') }}</option>
                            @foreach($lookups['academicYears'] as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-layer-group mr-1"></i> {{ __('admin.finance.fees.fields.grade') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_grade">
                            <option value="">{{ __('admin.global.all') }}</option>
                            @foreach($lookups['grades'] as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-right mt-3 mt-md-0">
                        <button class="btn btn-modern w-100" id="reset_filters">
                            <i class="las la-sync-alt mr-1 ml-1"></i>
                            {{ __('admin.global.reset_filters') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="card glass-card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover" id="fees_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.finance.fees.fields.title') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.finance.fees.fields.amount') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.finance.fees.fields.category') }}</th>
                                <th class="wd-25p border-bottom-0">{{ __('admin.finance.fees.fields.academic_target') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.global.actions') }}</th>
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

    @include('admin.finance.fees.add_modal')
    @include('admin.finance.fees.edit_modal')
    @include('admin.finance.fees.show_modal')

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                placeholder: '{{ __("admin.global.select") }}',
                width: '100%'
            });

            var table = $('#fees_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: "{{ route('admin.fees.datatable') }}",
                    data: function(d) {
                        d.fee_category_id  = $('#filter_category').val();
                        d.academic_year_id = $('#filter_academic_year').val();
                        d.grade_id         = $('#filter_grade').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex',     name: 'DT_RowIndex',     orderable: false, searchable: false},
                    {data: 'title',           name: 'title'},
                    {data: 'amount',          name: 'amount'},
                    {data: 'category',        name: 'category',        orderable: false, searchable: false},
                    {data: 'academic_target', name: 'academic_target', orderable: false, searchable: false},
                    {data: 'actions',         name: 'actions',         orderable: false, searchable: false, className: 'text-center'},
                ],
            });

            // ─── Filter changes ───
            $('#filter_category, #filter_academic_year, #filter_grade').on('change', function () {
                table.draw();
            });

            // ─── Reset ───
            $('#reset_filters').on('click', function () {
                $('#filter_category, #filter_academic_year, #filter_grade').val('');
                table.draw();
            });

            // ─── Fetch Classrooms ───
            $('select[name="grade_id"]').on('change', function() {
                var grade_id = $(this).val();
                var modal = $(this).closest('.modal');
                var classroomSelect = modal.find('select[name="classroom_id"]');
                
                if (grade_id) {
                    $.ajax({
                        url: "{{ route('admin.get_classrooms') }}",
                        type: "GET",
                        data: { grade_id: grade_id },
                        success: function(response) {
                            if (response.success) {
                                classroomSelect.empty();
                                classroomSelect.append('<option value="">{{ __("admin.global.select") }}</option>');
                                $.each(response.data, function(key, value) {
                                    classroomSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                                
                                // Set selected value if pre-populated (from edit form)
                                var selectedClassroom = classroomSelect.data('selected');
                                if(selectedClassroom) {
                                    classroomSelect.val(selectedClassroom).trigger('change');
                                    classroomSelect.removeData('selected');
                                }
                            }
                        }
                    });
                } else {
                    classroomSelect.empty();
                    classroomSelect.append('<option value="">{{ __("admin.global.select") }}</option>');
                }
            });

            // ─── Populate Edit Modal ───
            $(document).on('click', '.edit-btn', function() {
                var modal = $('#editFeeModal');
                modal.find('form').attr('action', $(this).data('url'));
                modal.find('input[name="title[ar]"]').val($(this).data('title_ar'));
                modal.find('input[name="title[en]"]').val($(this).data('title_en'));
                modal.find('input[name="amount"]').val($(this).data('amount'));
                modal.find('textarea[name="description"]').val($(this).data('description'));
                modal.find('select[name="fee_category_id"]').val($(this).data('fee_category_id')).trigger('change');
                modal.find('select[name="academic_year_id"]').val($(this).data('academic_year_id')).trigger('change');
                
                modal.find('select[name="classroom_id"]').data('selected', $(this).data('classroom_id'));
                modal.find('select[name="grade_id"]').val($(this).data('grade_id')).trigger('change');
            });
        });
    </script>
    @stack('scripts')
@endsection
