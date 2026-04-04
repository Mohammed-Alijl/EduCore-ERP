@extends('admin.layouts.master')

@section('title', trans('admin.reports.grades.title'))

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
                            {{ trans('admin.reports.title') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ trans('admin.reports.grades.title') }}
                        </li>
                    </ol>
                </nav>
                <h2 class="mb-0 mt-2 grades-page-title">
                    {{ trans('admin.reports.grades.title') }}
                </h2>
                <p class="mb-0 mt-1 grades-page-subtitle">
                    {{ trans('admin.reports.grades.subtitle') }}
                </p>
            </div>
        </div>
    </div>

@endsection

@section('content')
    @include('admin.reports.grades.partials.filters')
    @include('admin.reports.grades.partials.kpis')
    @include('admin.reports.grades.partials.charts')
    @include('admin.reports.grades.partials.table')
    @include('admin.reports.grades.partials.export-modal')
    @include('admin.reports.grades.partials.export-pdf-modal')
@endsection
@section('js')
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.reports.grades.partials.scripts')
@endsection
