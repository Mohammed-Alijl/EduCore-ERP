@extends('admin.layouts.master')
@section('title', __('admin.global.edit') . ' ' . __('admin.roles.title'))
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
                        <i class="las la-pen"></i>
                        {{ __('admin.global.edit') }} {{ __('admin.roles.title') }}
                    </div>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-light" style="border-radius: 8px; font-weight: 600;">
                        <i class="las la-arrow-left mr-1"></i> {{ __('admin.global.back') }}
                    </a>
                </div>
                <div class="role-form-body">
                    <form id="editForm" action="{{ route('admin.roles.update', $role->id) }}" method="POST" data-parsley-validate="">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-4">
                            <label>{{ __('admin.roles.fields.name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="{{ __('admin.roles.fields.name_placeholder') }}"
                                   required autocomplete="off" minlength="3" maxlength="30" value="{{ $role->name }}">
                        </div>

                        {{-- Select All Bar --}}
                        <div class="select-all-bar mb-3">
                            <label class="ckbox mb-0">
                                <input type="checkbox" id="selectAllGlobal">
                                <span>{{ __('admin.roles.select_all') }}</span>
                            </label>
                        </div>

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
                                                        <input type="checkbox" name="permissions[]"
                                                               {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
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
                        <button type="submit" class="btn btn-primary px-4" id="submit-btn" onclick="this.form.submit(); this.disabled=true; this.innerHTML='<span class=\'spinner-border spinner-border-sm\' role=\'status\' aria-hidden=\'true\'></span> {{ __('admin.global.loading') }}...';">
                            {{ __('admin.global.send') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    
    @include('admin.layouts.scripts.roles_permissions')
    
    <script>
        $(document).ready(function() {
            // Trigger change on load to sync the select-all states correctly
            if ($('input[name="permissions[]"]').length > 0) {
                // Initialize the group-level select-all checkboxes
                $('.permission-group-card').each(function() {
                    let modelName = $(this).data('model');
                    if (modelName) {
                        let total = $('.' + modelName + '-checkbox').length;
                        let checked = $('.' + modelName + '-checkbox:checked').length;
                        if (total > 0 && total === checked) {
                            $('.select-all-model[data-model="' + modelName + '"]').prop('checked', true);
                        }
                    }
                });

                // Initialize the global select-all checkbox
                let allChecked = $('input[name="permissions[]"]:not(:checked)').length === 0;
                $('#selectAllGlobal').prop('checked', allChecked);
            }
        });
    </script>
@endsection
