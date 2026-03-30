<div class="dropdown nav-item main-header-notification" id="notification-dropdown"
    data-csrf="{{ csrf_token() }}"
    data-index-url="{{ route('admin.notifications.index') }}"
    data-base-url="{{ url('admin/notifications') }}"
    data-mark-all-read-url="{{ route('admin.notifications.mark-all-read') }}"
    data-delete-text="{{ __('admin.global.delete') }}">
    <a class="new nav-link" href="#" data-toggle="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        <span class="pulse-danger" id="notification-pulse"></span>
    </a>
    <div class="dropdown-menu">
        <div class="menu-header-content bg-primary text-right">
            <div class="d-flex">
                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">
                    {{ __('admin.header.notifications') }}
                </h6>
                <span class="badge badge-pill badge-warning mr-auto my-auto float-left" id="mark-all-read-btn"
                    style="cursor: pointer;">
                    {{ __('admin.header.mark_read') }}
                </span>
            </div>
            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12">
                <span id="unread-count-text">0</span> {{ __('admin.header.unread') }}
            </p>
        </div>
        <div class="main-notification-list Notification-scroll" id="notification-list">
            <div class="p-4 text-center text-muted" id="notification-empty">
                <i class="las la-bell-slash" style="font-size: 2.5rem; opacity: 0.4;"></i>
                <p class="mb-0 mt-2">{{ __('admin.notifications.empty') }}</p>
            </div>
        </div>
        <div class="text-center dropdown-footer">
            <a href="javascript:void(0);" id="view-all-notifications">{{ __('admin.header.view_all') }}</a>
        </div>
    </div>
</div>
