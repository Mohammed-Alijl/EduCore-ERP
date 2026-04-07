@extends('admin.layouts.master')

@section('title', __('admin.Finance.fee_categories.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Academic/grade/grade-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Finance/finance-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.finance') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.Finance.fee_categories.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_fees')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addFeeCategoryModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ __('admin.Finance.fee_categories.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card glass-card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover" id="fee_categories_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-30p border-bottom-0">{{ __('admin.Finance.fee_categories.fields.title') }}</th>
                                <th class="wd-40p border-bottom-0">{{ __('admin.Finance.fee_categories.fields.description') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
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

    @include('admin.Finance.fee_categories.add_modal')
    @include('admin.Finance.fee_categories.edit_modal')

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            var table = $('#fee_categories_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: "{{ route('admin.Finance.fee_categories.datatable') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'title',       name: 'title'},
                    {data: 'description', name: 'description',  orderable: false, searchable: false, defaultContent: '-',
                        render: function(data) { return data ? data : '<span class="text-muted">—</span>'; }
                    },
                    {data: 'actions',     name: 'actions', orderable: false, searchable: false, className: 'text-center'},
                ],
            });

            // ─── Populate Edit Modal ───
            $(document).on('click', '.edit-btn', function() {
                var modal = $('#editFeeCategoryModal');
                modal.find('form').attr('action', $(this).data('url'));
                modal.find('input[name="title[ar]"]').val($(this).data('title_ar'));
                modal.find('input[name="title[en]"]').val($(this).data('title_en'));
                modal.find('textarea[name="description"]').val($(this).data('description'));
            });
        });
    </script>
    @stack('scripts')
@endsection
