@extends('admin.layouts.master')

@section('title', trans('admin.activity_logs.show_title'))

@section('css')
    <style>
        .log-detail-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .log-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
        }

        .event-badge {
            font-size: 0.8rem;
            padding: 0.5em 1em;
            border-radius: 20px;
            font-weight: 600;
        }

        .event-badge-created {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .event-badge-updated {
            background: rgba(255, 193, 7, 0.2);
            color: #d39e00;
        }

        .event-badge-deleted {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .detail-section {
            padding: 1.25rem;
            border-bottom: 1px solid #eee;
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 0.95rem;
            color: inherit;
        }

        .detail-value strong {
            color: inherit;
        }

        .properties-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .property-diff {
            display: flex;
            align-items: flex-start;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .property-diff:last-child {
            border-bottom: none;
        }

        .property-name {
            font-weight: 600;
            min-width: 150px;
            color: inherit;
        }

        .property-old {
            background: #ffeef0;
            color: #dc3545;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            margin-right: 0.5rem;
            text-decoration: line-through;
        }

        .property-new {
            background: #e6ffed;
            color: #28a745;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .property-value {
            background: #e7f1ff;
            color: #0d6efd;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            margin-left: 1rem;
        }

        .timeline-connector {
            position: relative;
            padding-right: 2rem;
        }

        .timeline-connector::after {
            content: '';
            position: absolute;
            right: 14px;
            top: 50%;
            height: 100%;
            width: 2px;
            background: #e9ecef;
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.logs') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.activity_logs.show_title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            <a href="{{ route('admin.activity_logs.index') }}" class="btn btn-outline-primary">
                <i class="las la-arrow-right ml-1"></i>
                {{ trans('admin.global.back') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card log-detail-card mb-4">
                <div class="log-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="mb-2">{{ $log->description }}</h4>
                            <span class="badge log-name-badge">{{ $log->log_name }}</span>
                        </div>
                        <span class="event-badge event-badge-{{ $log->event }}">
                            {{ ucfirst($log->event) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-0">
                    {{-- Subject Information --}}
                    <div class="detail-section">
                        <div class="d-flex align-items-start">
                            <div class="info-icon">
                                <i class="las la-cube"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="detail-label">{{ trans('admin.activity_logs.fields.subject') }}</div>
                                @if ($log->subject)
                                    <div class="detail-value">
                                        <strong>{{ class_basename($log->subject_type) }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $log->subject_id }}</small>
                                    </div>
                                @else
                                    <div class="detail-value text-muted">
                                        {{ trans('admin.activity_logs.no_subject') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Causer Information --}}
                    <div class="detail-section">
                        <div class="d-flex align-items-start">
                            <div class="info-icon">
                                <i class="las la-user"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="detail-label">{{ trans('admin.activity_logs.fields.causer') }}</div>
                                @if ($log->causer)
                                    <div class="detail-value">
                                        <strong>{{ $log->causer->name ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ class_basename($log->causer_type) }}
                                            #{{ $log->causer_id }}</small>
                                    </div>
                                @else
                                    <div class="detail-value text-muted">
                                        {{ trans('admin.activity_logs.system_action') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Timestamp --}}
                    <div class="detail-section">
                        <div class="d-flex align-items-start">
                            <div class="info-icon">
                                <i class="las la-clock"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="detail-label">{{ trans('admin.activity_logs.fields.created_at') }}</div>
                                <div class="detail-value">
                                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                                    <br>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Batch UUID --}}
                    @if ($log->batch_uuid)
                        <div class="detail-section">
                            <div class="d-flex align-items-start">
                                <div class="info-icon">
                                    <i class="las la-layer-group"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="detail-label">{{ trans('admin.activity_logs.fields.batch_uuid') }}</div>
                                    <div class="detail-value">
                                        <code>{{ $log->batch_uuid }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Properties Changes --}}
            <div class="card log-detail-card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="las la-exchange-alt mr-2"></i>
                        {{ trans('admin.activity_logs.properties_title') }}
                    </h5>
                </div>
                <div class="card-body">
                    @if ($log->properties && $log->properties->count())
                        <div class="properties-card">
                            @if ($log->event === 'updated' && isset($log->properties['old']) && isset($log->properties['attributes']))
                                {{-- Show diff for updates --}}
                                @foreach ($log->properties['attributes'] as $key => $newValue)
                                    <div class="property-diff">
                                        <span class="property-name">{{ $key }}</span>
                                        <div class="d-flex flex-wrap align-items-center">
                                            @if (isset($log->properties['old'][$key]))
                                                <span
                                                    class="property-old">{{ is_array($log->properties['old'][$key]) ? json_encode($log->properties['old'][$key]) : $log->properties['old'][$key] }}</span>
                                                <i class="las la-arrow-left mx-2 text-muted"></i>
                                            @endif
                                            <span
                                                class="property-new">{{ is_array($newValue) ? json_encode($newValue) : $newValue }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($log->properties['attributes']))
                                {{-- Show attributes for create/delete --}}
                                @foreach ($log->properties['attributes'] as $key => $value)
                                    <div class="property-diff">
                                        <span class="property-name">{{ $key }}</span>
                                        <span
                                            class="property-value">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                    </div>
                                @endforeach
                            @else
                                {{-- Raw properties --}}
                                <pre class="mb-0"><code>{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            @endif
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="las la-inbox tx-40 d-block mb-2"></i>
                            {{ trans('admin.activity_logs.no_properties') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
