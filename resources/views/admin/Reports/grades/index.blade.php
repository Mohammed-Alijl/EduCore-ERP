@extends('admin.layouts.master')

@section('title', trans('admin.Reports.reports.grades.title'))

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Reports/grades-report.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="grades-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb grades-breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="las la-chart-bar mr-1 ml-1"></i>
                            {{ trans('admin.Reports.reports.title') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ trans('admin.Reports.reports.grades.title') }}
                        </li>
                    </ol>
                </nav>
                <h2 class="mb-0 mt-2 grades-page-title">
                    {{ trans('admin.Reports.reports.grades.title') }}
                </h2>
                <p class="mb-0 mt-1 grades-page-subtitle">
                    {{ trans('admin.Reports.reports.grades.subtitle') }}
                </p>
            </div>
        </div>
    </div>

@endsection

@section('content')
    @include('admin.Reports.grades.partials.filters')
    @include('admin.Reports.grades.partials.kpis')
    @include('admin.Reports.grades.partials.charts')
    @include('admin.Reports.grades.partials.table')
    @include('admin.Reports.grades.partials.export-modal')
    @include('admin.Reports.grades.partials.export-pdf-modal')
@endsection
@section('js')
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.Reports.grades.partials.scripts')
@endsection
