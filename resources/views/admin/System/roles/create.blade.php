@extends('admin.layouts.master')
@section('title', __('admin.System.roles.add'))
@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    {{-- Roles Dedicated CSS --}}
    <link href="{{ URL::asset('assets/admin/css/System/role/role.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.sidebar.roles') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card role-glass-card">
                <div class="role-form-header">
                    <div class="role-form-title">
                        <i class="las la-plus-circle"></i>
                        {{ __('admin.System.roles.add') }}
                    </div>
                    <a href="{{ route('admin.System.roles.index') }}" class="btn btn-sm btn-light" style="border-radius: 8px; font-weight: 600;">
                        <i class="las la-arrow-left mr-1"></i> {{ __('admin.global.back') }}
                    </a>
                </div>
                <div class="role-form-body">
                    <form id="addForm" action="{{ route('admin.System.roles.store') }}" method="POST" data-parsley-validate="">
                        @csrf

                        <div class="form-group mb-4">
                            <label>{{ __('admin.System.roles.fields.name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="{{ __('admin.System.roles.fields.name_placeholder') }}"
                                   autocomplete="off" minlength="3" maxlength="30" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        {{-- Select All Bar --}}
                        <div class="select-all-bar mb-3">
                            <label class="ckbox mb-0">
                                <input type="checkbox" id="selectAllGlobal">
                                <span>{{ __('admin.System.roles.select_all') }}</span>
                            </label>
                        </div>
                        <div class="text-danger error-text permissions_error mb-3"></div>

                        <div class="row">
                            @foreach($groupedPermissions as $model => $permissions)
                                <div class="col-md-4 mb-4">
                                    <div class="permission-group-card" data-model="{{ $model }}">
                                        <div class="permission-group-header">
                                            <span class="permission-group-title">{{ str_replace('_', ' ', $model) }}</span>
                                            <label class="ckbox mb-0">
                                                <input type="checkbox" class="select-all-model" data-model="{{ $model }}">
                                                <small>{{ __('admin.global.all') }}</small>
                                            </label>
                                        </div>
                                        <div class="card-body p-3">
                                            @foreach($permissions as $permission)
                                                <div class="permission-item mb-1">
                                                    <label class="ckbox">
                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                               class="{{ $model }}-checkbox">
                                                        <span>
                                                            {{ \App\Helpers\PermissionHelper::translate($permission->name, $model) }}
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary px-4" id="submit-btn">
                            <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                            <span id="btn-text">{{ __('admin.global.send') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>

    @include('admin.layouts.scripts.roles_permissions')

    <script>
        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var parsleyInstance = form.parsley();
            parsleyInstance.validate();
            if (!parsleyInstance.isValid()) { return; }

            var btn     = $('#submit-btn');
            var spinner = $('#spinner');
            var btnText = $('#btn-text');

            btn.attr('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{ __("admin.global.loading") }}...');

            $('span.error-text').text('');
            $('input').removeClass('is-invalid');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    if (response.status === 'success') {
                        swal({
                            title: "{{ __('admin.global.success') }}",
                            text: response.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.System.roles.index') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    btn.attr('disabled', false);
                    spinner.addClass('d-none');
                    btnText.text('{{ __("admin.global.send") }}');

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, val) {
                            $('input[name="' + key + '"]').addClass('is-invalid');
                            $('.' + key + '_error').text(val[0]);
                        });
                    } else {
                        swal("{{ __('admin.global.failed') }}", "{{ __('admin.System.roles.messages.failed.add') }}", "error");
                    }
                }
            });
        });
    </script>
@endsection
