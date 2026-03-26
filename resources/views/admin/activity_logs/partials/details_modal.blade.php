{{-- Log Details Modal --}}
<div class="modal fade" id="logDetailsModal" tabindex="-1" role="dialog" aria-labelledby="logDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title" id="logDetailsModalLabel">
                    <i class="las la-info-circle mr-2"></i>
                    {{ trans('admin.activity_logs.detail_title') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                {{-- Content will be loaded via AJAX --}}
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ trans('admin.global.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    #logDetailsModal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>
