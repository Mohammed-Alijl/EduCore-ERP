<!-- Show Role Modal -->
<div class="modal fade" id="roleShowModal">
    <div class="modal-dialog modal-xl text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}" role="document">
        <div class="modal-content modal-content-demo border-0 rounded-lg">
            <div class="modal-header d-flex justify-content-between border-bottom-0 pb-0">
                <h6 class="modal-title font-weight-bold" style="font-size: 1.1rem;">
                    <i class="fas fa-user-shield text-primary mx-1"></i>
                    {{ __('admin.global.view') }} {{ __('admin.System.roles.title') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 pt-3">
                <!-- Hero Header Card -->
                <div class="card role-hero-card shadow-sm mb-4 border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 16px;">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="icon-circle bg-white shadow-sm" style="width: 70px; height: 70px; font-size: 32px; border-radius: 50%; display: flex; align-items:center; justify-content: center; margin: 0 1rem; color: #4361ee;">
                            <i class="las la-user-tag"></i>
                        </div>
                        <div>
                            <h4 id="rshow_name" class="mb-1 font-weight-bold text-dark"></h4>
                            <span id="rshow_permissions_count" class="badge badge-pill mt-1 px-3 py-1" style="background: rgba(67,97,238,0.15); color: #4361ee; font-weight: 600; font-size: 0.8rem;"></span>
                        </div>
                    </div>
                </div>

                <!-- Permissions Grid -->
                <div class="row" id="rshow_permissions_container">
                    @foreach($groupedPermissions as $model => $permissions)
                        <div class="col-md-4 mb-4 rshow-model-col">
                            <div class="permission-group-card shadow-sm h-100 border-0" data-model="{{ $model }}" style="background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #f0f2f8;">
                                <div class="permission-group-header" style="background: linear-gradient(135deg, #f8f9ff 0%, #eef0ff 100%); padding: 0.75rem 1rem; border-bottom: 1.5px solid #e9ecef;">
                                    <span class="permission-group-title" style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #3d4a70; display:flex; gap:0.4rem; align-items:center;">
                                        <i class="las la-cube text-primary" style="font-size: 1.1rem;"></i> {{ str_replace('_', ' ', $model) }}
                                    </span>
                                </div>
                                <div class="card-body p-3">
                                    @foreach($permissions as $permission)
                                        <div class="permission-item-show mb-2" data-permission="{{ $permission->name }}" style="display:none; align-items:center; gap:0.5rem;">
                                            <i class="las la-check-circle text-success" style="font-size: 1.35rem;"></i>
                                                {{ \App\Helpers\PermissionHelper::translate($permission->name, $model) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div><!-- /modal-body -->

            <div class="modal-footer pb-4 px-4 border-top-0">
                <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal" style="border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-times mx-1"></i> {{ trans('admin.global.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.btn-role-view', function() {
        let btn = $(this);
        $('#rshow_name').text(btn.data('name'));
        
        let permissionsCount = btn.data('count');
        $('#rshow_permissions_count').text(permissionsCount + ' {{ __("admin.System.roles.fields.permissions_count") }}');

        let rawPerms = btn.data('permissions');
        let rolePermissions = [];
        if (typeof rawPerms === 'string') {
            try { rolePermissions = JSON.parse(rawPerms); } catch (e) { rolePermissions = []; }
        } else {
            rolePermissions = rawPerms || [];
        }

        $('.rshow-model-col').each(function() {
            let col = $(this);
            let hasAny = false;
            
            col.find('.permission-item-show').each(function() {
                let pName = $(this).data('permission');
                if (rolePermissions.includes(pName)) {
                    $(this).css('display', 'flex');
                    hasAny = true;
                } else {
                    $(this).css('display', 'none');
                }
            });
            
            if (hasAny) {
                col.show();
            } else {
                col.hide();
            }
        });
    });
</script>
@endpush
