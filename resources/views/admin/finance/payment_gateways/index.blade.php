@extends('admin.layouts.master')

@section('title', trans('admin.finance.payment_gateways.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/finance/payment-gateways.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.finance.payment_gateways.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            <div class="pg-gateway-count">
                <i class="las la-credit-card"></i>
                {{ $gateways->where('is_activated', true)->count() }} / {{ $gateways->count() }}
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Page Title --}}
    <div class="pg-page-header">
        <h2 class="pg-page-title">
            <i class="las la-credit-card mr-2"></i>{{ trans('admin.finance.payment_gateways.title') }}
        </h2>
        <p class="pg-page-subtitle">{{ trans('admin.finance.payment_gateways.subtitle') }}</p>
    </div>

    {{-- Gateway Cards Grid --}}
    <div class="pg-grid">
        @foreach ($gateways as $gw)
            <div class="pg-card {{ !$gw['is_activated'] ? 'pg-card--not-activated' : (!$gw['status'] ? 'pg-card--inactive' : '') }}"
                id="gateway-card-{{ $gw['code'] }}">

                {{-- Card Header --}}
                <div class="pg-card__header">
                    <div class="pg-card__icon"
                         style="--pg-color-from: {{ $gw['colors']['from'] ?? '#8b5cf6' }}; --pg-color-to: {{ $gw['colors']['to'] ?? '#7c3aed' }};">
                        <i class="{{ $gw['icon'] }}"></i>
                    </div>
                    <div class="pg-card__info">
                        <div class="pg-card__name">{{ $gw['name'] }}</div>
                        <div class="pg-card__code">{{ $gw['code'] }}</div>
                    </div>
                    <span
                        class="pg-card__type-badge {{ $gw['is_online'] ? 'pg-card__type-badge--online' : 'pg-card__type-badge--offline' }}">
                        {{ $gw['is_online'] ? trans('admin.finance.payment_gateways.type_online') : trans('admin.finance.payment_gateways.type_offline') }}
                    </span>
                </div>

                @if ($gw['is_activated'])
                    {{-- Card Body — Activated Gateway --}}
                    <div class="pg-card__body">
                        <div class="pg-card__meta">
                            <div class="pg-card__meta-item">
                                <span
                                    class="pg-card__meta-label">{{ trans('admin.finance.payment_gateways.fields.surcharge_percentage') }}</span>
                                <span
                                    class="pg-card__meta-value {{ $gw['surcharge'] > 0 ? 'pg-card__meta-value--accent' : '' }}">
                                    {{ $gw['surcharge'] }}%
                                </span>
                            </div>
                            <div class="pg-card__meta-item">
                                <span
                                    class="pg-card__meta-label">{{ trans('admin.finance.payment_gateways.fields.status') }}</span>
                                <span
                                    class="pg-status-badge {{ $gw['status'] ? 'pg-status-badge--active' : 'pg-status-badge--inactive' }}">
                                    <span class="pg-status-badge__dot"></span>
                                    {{ $gw['status'] ? trans('admin.global.active') : trans('admin.global.disabled') }}
                                </span>
                            </div>
                        </div>
                        @if ($gw['has_settings'])
                            <div class="pg-card__settings-hint">
                                <i class="las la-cog"></i>
                                {{ trans('admin.finance.payment_gateways.fields.settings') }}
                            </div>
                        @else
                            <div class="pg-card__settings-hint">
                                <i class="las la-check-circle"></i>
                                {{ trans('admin.finance.payment_gateways.no_settings') }}
                            </div>
                        @endif
                    </div>

                    {{-- Card Footer — Activated Gateway --}}
                    <div class="pg-card__footer">
                        @can('edit_payment_gateways')
                            <label class="pg-toggle">
                                <input type="checkbox" class="pg-toggle__input toggle-status"
                                    data-id="{{ $gw['gateway']->id }}"
                                    data-url="{{ route('admin.payment_gateways.toggle-status', $gw['gateway']->id) }}"
                                    {{ $gw['status'] ? 'checked' : '' }}>
                                <span class="pg-toggle__slider"></span>
                            </label>
                        @endcan

                        @can('edit_payment_gateways')
                            <button class="pg-btn pg-btn--configure edit-btn"
                                data-url="{{ route('admin.payment_gateways.update', $gw['gateway']->id) }}"
                                data-code="{{ $gw['code'] }}"
                                data-name_ar="{{ $gw['gateway']->getTranslation('name', 'ar') }}"
                                data-name_en="{{ $gw['gateway']->getTranslation('name', 'en') }}"
                                data-surcharge_percentage="{{ $gw['surcharge'] }}"
                                data-status="{{ (int) $gw['status'] }}"
                                data-settings="{{ json_encode($gw['settings']) }}">
                                <i class="las la-cog"></i>
                                {{ trans('admin.finance.payment_gateways.configure') }}
                            </button>
                        @endcan
                    </div>
                @else
                    {{-- Card Body — Not Activated --}}
                    <div class="pg-card__not-activated">
                        <p class="pg-card__not-activated-text">
                            {{ trans('admin.finance.payment_gateways.not_activated') }}
                        </p>
                        @can('create_payment_gateways')
                            <button class="pg-btn pg-btn--activate activate-btn" data-code="{{ $gw['code'] }}"
                                data-default-name="{{ $gw['name'] }}">
                                <i class="las la-plus-circle"></i>
                                {{ trans('admin.finance.payment_gateways.activate') }}
                            </button>
                        @endcan
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    </div>
    </div>

    {{-- Edit Modal --}}
    @include('admin.finance.payment_gateways.edit_modal')

    {{-- Activate Modal --}}
    @include('admin.finance.payment_gateways.activate_modal')
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // ─── Settings Schema Loader ──────────────────────────────────────────
            var settingsSchemaUrl = "{{ route('admin.payment_gateways.settings-schema') }}";

            function loadSettingsSchema(code, containerId, fieldsId, existingSettings) {
                var $container = $(containerId);
                var $fields = $(fieldsId);

                $fields.html('');
                $container.addClass('d-none');

                if (!code) return;

                $.ajax({
                    url: settingsSchemaUrl,
                    type: 'GET',
                    data: {
                        code: code
                    },
                    success: function(response) {
                        var schema = response.schema;
                        if (!schema || Object.keys(schema).length === 0) {
                            return;
                        }

                        $.each(schema, function(key, config) {
                            var value = (existingSettings && existingSettings[key]) ?
                                existingSettings[key] : '';
                            var requiredMark = config.required ?
                                '<span class="text-danger">*</span>' : '';
                            var requiredAttr = config.required ? 'required' : '';

                            var html = '<div class="col-md-6">' +
                                '<div class="form-group finance-form-group">' +
                                '<label class="finance-form-label">' + $('<span>').text(
                                    config.label).html() + ' ' + requiredMark +
                                '</label>' +
                                '<input type="text" name="settings[' + key +
                                ']" class="form-control form-control-modern" ' +
                                'value="' + $('<span>').text(value).html() + '" ' +
                                requiredAttr +
                                ' maxlength="500" autocomplete="off">' +
                                '<span class="text-danger error-text settings_' + key +
                                '_error"></span>' +
                                '</div></div>';

                            $fields.append(html);
                        });

                        $container.removeClass('d-none');
                    }
                });
            }

            // ─── Edit Gateway ───────────────────────────────────────────────────
            $(document).on('click', '.edit-btn', function() {
                var btn = $(this);
                var modal = $('#editPaymentGatewayModal');

                modal.find('form').attr('action', btn.data('url'));
                modal.find('input[name="name[ar]"]').val(btn.data('name_ar'));
                modal.find('input[name="name[en]"]').val(btn.data('name_en'));
                modal.find('input[name="surcharge_percentage"]').val(btn.data(
                    'surcharge_percentage'));

                modal.find('input[name="status"]').val(btn.data('status') ? '1' : '0');
                modal.find('input[id="edit_status"]').prop('checked', btn.data('status') == 1);

                var code = btn.data('code');
                var settingsData = btn.data('settings') || {};
                modal.find('.gateway-code-display').text(code);
                loadSettingsSchema(code, '#edit_settings_container', '#edit_settings_fields',
                    settingsData);

                modal.modal('show');
            });

            // ─── Activate Gateway ───────────────────────────────────────────────
            $(document).on('click', '.activate-btn', function() {
                var btn = $(this);
                var modal = $('#activateGatewayModal');
                var code = btn.data('code');
                var defaultName = btn.data('default-name');

                modal.find('input[name="code"]').val(code);
                modal.find('.gateway-code-display').text(code);
                modal.find('input[name="name[ar]"]').val('');
                modal.find('input[name="name[en]"]').val(defaultName);
                modal.find('input[name="surcharge_percentage"]').val('0.00');

                loadSettingsSchema(code, '#activate_settings_container',
                    '#activate_settings_fields', {});

                modal.modal('show');
            });

            // ─── Toggle Status ──────────────────────────────────────────────────
            $(document).on('change', '.toggle-status', function() {
                var checkbox = $(this);
                var url = checkbox.data('url');

                $.ajax({
                    url: url,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            swal({
                                title: response.message,
                                icon: 'success',
                                timer: 1500,
                                buttons: false,
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON ? xhr.responseJSON.message :
                            'Error';
                        swal({
                            title: msg,
                            icon: 'error',
                        });
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                });
            });

            // ─── Sync hidden inputs with checkboxes ─────────────────────────────
            $('#edit_status').on('change', function() {
                $(this).closest('form').find('input[name="status"]').val(this.checked ? '1' :
                    '0');
            });

            // ─── Clear settings on modal close ──────────────────────────────────
            $('#editPaymentGatewayModal').on('hidden.bs.modal', function() {
                $('#edit_settings_fields').html('');
                $('#edit_settings_container').addClass('d-none');
            });
            $('#activateGatewayModal').on('hidden.bs.modal', function() {
                $('#activate_settings_fields').html('');
                $('#activate_settings_container').addClass('d-none');
            });
        });
    </script>
@endsection
