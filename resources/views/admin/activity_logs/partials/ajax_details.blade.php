{{-- AJAX Log Details Partial --}}
<div class="log-details-content">
    {{-- Header Info --}}
    <div class="d-flex align-items-start mb-4 pb-3 border-bottom">
        <div class="flex-grow-1">
            <h5 class="mb-2 font-weight-bold">{{ $log->description }}</h5>
            <div class="d-flex align-items-center flex-wrap">
                <span class="badge badge-pill mr-2 mb-1"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff;">
                    {{ $log->log_name }}
                </span>
                @php
                    $eventColors = [
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                    ];
                    $eventColor = $eventColors[$log->event] ?? 'secondary';
                @endphp
                <span class="badge badge-{{ $eventColor }} mr-2 mb-1">
                    {{ ucfirst($log->event) }}
                </span>
                <small class="text-muted mb-1">
                    <i class="las la-clock mr-1"></i>
                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                    ({{ $log->created_at->diffForHumans() }})
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Subject & Causer Info --}}
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded">
                <h6 class="text-uppercase tx-11 text-muted font-weight-bold mb-2">
                    <i class="las la-cube mr-1"></i>
                    {{ trans('admin.activity_logs.fields.subject') }}
                </h6>
                @if ($log->subject)
                    <p class="mb-0">
                        <strong>{{ class_basename($log->subject_type) }}</strong>
                        <br>
                        <small class="text-muted">ID: {{ $log->subject_id }}</small>
                    </p>
                @else
                    <p class="mb-0 text-muted">{{ trans('admin.activity_logs.no_subject') }}</p>
                @endif
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded">
                <h6 class="text-uppercase tx-11 text-muted font-weight-bold mb-2">
                    <i class="las la-user mr-1"></i>
                    {{ trans('admin.activity_logs.fields.causer') }}
                </h6>
                @if ($log->causer)
                    <p class="mb-0">
                        <strong>{{ $log->causer->name ?? 'N/A' }}</strong>
                        <br>
                        <small class="text-muted">{{ class_basename($log->causer_type) }}
                            #{{ $log->causer_id }}</small>
                    </p>
                @else
                    <p class="mb-0 text-muted">{{ trans('admin.activity_logs.system_action') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Batch UUID --}}
    @if ($log->batch_uuid)
        <div class="mb-3 p-3 bg-light rounded">
            <h6 class="text-uppercase tx-11 text-muted font-weight-bold mb-2">
                <i class="las la-layer-group mr-1"></i>
                {{ trans('admin.activity_logs.fields.batch_uuid') }}
            </h6>
            <code class="small">{{ $log->batch_uuid }}</code>
        </div>
    @endif

    {{-- Properties Changes --}}
    @if ($log->properties && $log->properties->count())
        <div class="mt-3">
            <h6 class="text-uppercase tx-11 text-muted font-weight-bold mb-3">
                <i class="las la-exchange-alt mr-1"></i>
                {{ trans('admin.activity_logs.properties_title') }}
            </h6>

            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="wd-25p">{{ trans('admin.activity_logs.fields.attribute') }}</th>
                            @if ($log->event === 'updated' && isset($log->properties['old']))
                                <th class="wd-35p">{{ trans('admin.activity_logs.fields.old_value') }}</th>
                                <th class="wd-35p">{{ trans('admin.activity_logs.fields.new_value') }}</th>
                            @else
                                <th>{{ trans('admin.activity_logs.fields.value') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if ($log->event === 'updated' && isset($log->properties['old']) && isset($log->properties['attributes']))
                            @foreach ($log->properties['attributes'] as $key => $newValue)
                                <tr>
                                    <td><strong>{{ $key }}</strong></td>
                                    <td class="text-danger">
                                        @if (isset($log->properties['old'][$key]))
                                            <del>{{ is_array($log->properties['old'][$key]) ? json_encode($log->properties['old'][$key]) : $log->properties['old'][$key] }}</del>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-success">
                                        {{ is_array($newValue) ? json_encode($newValue) : $newValue }}
                                    </td>
                                </tr>
                            @endforeach
                        @elseif(isset($log->properties['attributes']))
                            @foreach ($log->properties['attributes'] as $key => $value)
                                <tr>
                                    <td><strong>{{ $key }}</strong></td>
                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ $log->event === 'updated' ? 3 : 2 }}">
                                    <pre class="mb-0 small"><code>{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center text-muted py-3 bg-light rounded mt-3">
            <i class="las la-inbox tx-30 d-block mb-2"></i>
            {{ trans('admin.activity_logs.no_properties') }}
        </div>
    @endif

    {{-- View Full Details Link --}}
    <div class="mt-4 text-center">
        <a href="{{ route('admin.activity_logs.show', $log->id) }}" class="btn btn-outline-primary">
            <i class="las la-external-link-alt mr-1"></i>
            {{ trans('admin.activity_logs.view_full_details') }}
        </a>
    </div>
</div>
