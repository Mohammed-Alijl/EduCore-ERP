@extends('admin.layouts.master')

@section('title', trans('admin.reports.attendance.title'))

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Reports/attendance-report.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="att-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb att-breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="las la-chart-bar mr-1 ml-1"></i>
                            {{ trans('admin.reports.title') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ trans('admin.reports.attendance.title') }}
                        </li>
                    </ol>
                </nav>
                <h2 class="mb-0 mt-2 att-page-title">
                    {{ trans('admin.reports.attendance.title') }}
                </h2>
                <p class="mb-0 mt-1 att-page-subtitle">
                    {{ trans('admin.reports.attendance.subtitle') }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('admin.reports.attendance.partials.filters')
    @include('admin.reports.attendance.partials.kpis')
    @include('admin.reports.attendance.partials.charts')
    @include('admin.reports.attendance.partials.table')

    @can('export_attendance-reports')
        @include('admin.reports.attendance.partials.export-modal')
        @include('admin.reports.attendance.partials.export-pdf-modal')
    @endcan
@endsection

@section('js')
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.reports.attendance.partials.scripts')
@endsection
