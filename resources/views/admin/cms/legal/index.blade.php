@extends('admin.layouts.master')

@section('title', __('admin.cms.legal_title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/css/CMS/cms.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.website') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.cms.legal_title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card cms-glass-card">
                <div class="cms-header">
                    <div class="cms-header-content">
                        <h2 class="cms-header-title">
                            <i class="las la-file-contract"></i>
                            {{ __('admin.cms.legal_title') }}
                        </h2>
                        <p class="cms-header-subtitle">{{ __('admin.cms.legal_subtitle') }}</p>
                    </div>
                </div>

                <div class="cms-body">
                    @if($pages->isEmpty())
                        <div class="text-center py-5">
                            <i class="las la-inbox" style="font-size: 48px; color: #ccc;"></i>
                            <p class="mt-3 text-muted">{{ __('admin.cms.no_legal_pages') }}</p>
                        </div>
                    @else
                        <div class="cms-legal-grid">
                            @foreach($pages as $page)
                                <div class="cms-legal-card">
                                    <div class="cms-legal-icon">
                                        @switch($page->slug)
                                            @case('privacy-policy')
                                                <i class="las la-shield-alt"></i>
                                                @break
                                            @case('terms-of-service')
                                                <i class="las la-file-contract"></i>
                                                @break
                                            @case('cookie-policy')
                                                <i class="las la-cookie-bite"></i>
                                                @break
                                            @default
                                                <i class="las la-file-alt"></i>
                                        @endswitch
                                    </div>
                                    <div class="cms-legal-info">
                                        <h5>{{ $page->title }}</h5>
                                        <span class="badge badge-{{ $page->is_published ? 'success' : 'secondary' }}">
                                            {{ $page->is_published ? __('admin.cms.published') : __('admin.cms.draft') }}
                                        </span>
                                    </div>
                                    <div class="cms-legal-actions">
                                        @can('edit_cms')
                                            <a href="{{ route('admin.cms.legal.edit', $page) }}"
                                               class="btn btn-sm btn-primary-gradient cms-edit-btn">
                                                <i class="las la-edit"></i>
                                                {{ __('admin.global.edit') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
