@extends('admin.layouts.master')

@section('title', trans('admin.reports.financial.title'))

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/reports/financial-report.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/student/finance.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern">
                        <li class="breadcrumb-item">
                            <i class="las la-chart-bar mr-1 ml-1"></i>
                            {{ trans('admin.reports.title') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ trans('admin.reports.financial.title') }}
                        </li>
                    </ol>
                </nav>
                <h2 class="mb-0 mt-2 page-title">
                    {{ trans('admin.reports.financial.outstanding_balances') }}
                </h2>
                <p class="mb-0 mt-1 page-subtitle">
                    {{ trans('admin.reports.financial.subtitle') }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('admin.reports.finance.partials.outstanding_balances.kpis')
    @include('admin.reports.finance.partials.outstanding_balances.charts')
    @include('admin.reports.finance.partials.outstanding_balances.payment_timeline')
    @include('admin.reports.finance.partials.outstanding_balances.table')
    @include('admin.reports.finance.partials.outstanding_balances.modal')
@endsection

@section('js')
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.reports.finance.partials.outstanding_balances.scripts')
@endsection
