@extends('admin.layouts.master')

@section('title', __('admin.academic_years.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Academic/academic_year/academic-year-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.academic_structure') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.academic_years.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_years')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm" data-effect="effect-scale" data-toggle="modal"
                        href="#addModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ __('admin.academic_years.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card year-hero-card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h5 class="mb-1">{{ __('admin.academic_years.subtitle') }}</h5>
                            <p class="mb-0 text-muted">{{ __('admin.academic_years.description') }}</p>
                        </div>
                        <span class="badge badge-pill badge-primary year-count-badge">
                            {{ __('admin.academic_years.count', ['count' => $academicYears->count()]) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card year-glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="academic_years_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-25p border-bottom-0">{{ __('admin.academic_years.fields.name') }}</th>
                                    <th class="wd-20p border-bottom-0">{{ __('admin.academic_years.fields.starts_at') }}
                                    </th>
                                    <th class="wd-20p border-bottom-0">{{ __('admin.academic_years.fields.ends_at') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">
                                        {{ __('admin.academic_years.fields.is_current') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('admin.global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academicYears as $index => $year)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="font-weight-bold">{{ $year->name }}</td>
                                        <td>{{ $year->starts_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ $year->ends_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td class="text-center">
                                            @if ($year->is_current)
                                                <span
                                                    class="badge badge-success year-current-badge">{{ __('admin.academic_years.current') }}</span>
                                            @else
                                                <span
                                                    class="badge badge-secondary year-inactive-badge">{{ __('admin.academic_years.not_current') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @include('admin.academic_years.partials.index_actions', [
                                                'year' => $year,
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @include('admin.academic_years.add_modal')
    @include('admin.academic_years.edit_modal')
    @include('admin.academic_years.show_modal')
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function() {
            $('#academic_years_table').DataTable({
                ...globalTableConfig,
                language: $.extend({}, datatable_lang)
            });

            $(document).on('click', '.show-academic-year-btn', function() {
                let btn = $(this);
                $('#show_year_name').text(btn.data('name') || '-');
                $('#show_year_starts_at').text(btn.data('starts_at') || '-');
                $('#show_year_ends_at').text(btn.data('ends_at') || '-');
                $('#show_year_current').text(btn.data('is_current') == 1 ?
                    '{{ __('admin.academic_years.current') }}' :
                    '{{ __('admin.academic_years.not_current') }}');
                $('#showModal').modal('show');
            });

            $(document).on('click', '.academic-year-edit-btn', function() {
                let btn = $(this);
                let form = $('#editModal').find('form');

                form.attr('action', btn.data('url'));
                form.find('[name="name"]').val(btn.data('name'));
                form.find('[name="starts_at"]').val(btn.data('starts_at_raw'));
                form.find('[name="ends_at"]').val(btn.data('ends_at_raw'));
                form.find('[name="is_current"]').val(btn.data('is_current')).trigger('change');
            });
        });
    </script>
    @stack('scripts')
@endsection
