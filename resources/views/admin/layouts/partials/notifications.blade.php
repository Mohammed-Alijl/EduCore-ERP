<div class="dropdown nav-item main-header-notification" id="notification-dropdown">
    <a class="new nav-link" href="#" data-toggle="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        <span class="pulse notification-pulse" id="notification-pulse" style="display: none;"></span>
        <span class="badge badge-danger notification-badge" id="notification-badge"
            style="display: none; position: absolute; top: 5px; right: 5px; font-size: 10px; padding: 3px 6px; border-radius: 10px; min-width: 18px; text-align: center;">0</span>
    </a>
    <div class="dropdown-menu" style="width: 360px; max-width: 90vw;">
        <div class="menu-header-content text-right"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1rem 1.25rem;">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="dropdown-title mb-0 tx-15 text-white font-weight-bold" style="font-size: 16px;">
                    <i class="las la-bell mr-1"></i>
                    {{ __('admin.header.notifications') }}
                </h6>
                <button type="button" class="btn btn-sm text-white p-0 d-flex align-items-center"
                    id="mark-all-read-btn" style="font-size: 12px; opacity: 0.9; transition: opacity 0.2s;"
                    onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                    <i class="las la-check-double mr-1"></i>
                    {{ __('admin.header.mark_read') }}
                </button>
            </div>
            <p class="dropdown-title-text mb-0 text-white tx-12 mt-2" style="opacity: 0.85;">
                <span id="unread-count-text" class="font-weight-semibold">0</span> {{ __('admin.header.unread') }}
            </p>
        </div>
        <div class="main-notification-list Notification-scroll" id="notification-list"
            style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
            <div class="p-4 text-center text-muted" id="notification-empty">
                <i class="las la-bell-slash" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mb-0 mt-3" style="font-size: 14px; color: #94a3b8;">{{ __('admin.notifications.empty') }}</p>
            </div>
        </div>
        <div class="dropdown-footer text-center"
            style="padding: 0.75rem; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
            <a href="javascript:void(0);" id="view-all-notifications"
                style="color: #667eea; font-weight: 600; font-size: 13px; text-decoration: none; transition: color 0.2s;"
                onmouseover="this.style.color='#764ba2'" onmouseout="this.style.color='#667eea'">
                {{ __('admin.header.view_all') }}
            </a>
        </div>
    </div>
</div>

<template id="notification-item-template">
    <a class="d-flex p-3 border-bottom notification-item align-items-start" href="#" data-notification-id=""
        data-download-url=""
        style="transition: all 0.2s ease; border-left: 3px solid transparent; background-color: #fff;">
        <div class="notifyimg __ICON_BG__ d-flex align-items-center justify-content-center"
            style="width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;">
            <i class="__ICON__ text-white" style="font-size: 20px;"></i>
        </div>
        <div class="flex-grow-1 mr-2" style="min-width: 0;">
            <h5 class="notification-label mb-1 font-weight-semibold"
                style="font-size: 14px; color: #1e293b; line-height: 1.4;">__TITLE__</h5>
            <div class="notification-subtext"
                style="white-space: normal; line-height: 1.5; font-size: 13px; color: #64748b;">
                __MESSAGE__
            </div>
            <span class="text-muted mt-1 d-inline-block" style="font-size: 11px; color: #94a3b8;">
                <i class="las la-clock mr-1"></i>__TIME__
            </span>
        </div>
        <div class="ml-auto" style="flex-shrink: 0;">
            <button type="button" class="btn btn-sm delete-notification"
                style="padding: 4px 8px; opacity: 0.5; transition: all 0.2s; background: transparent; border: none; border-radius: 6px;"
                onmouseover="this.style.opacity='1'; this.style.backgroundColor='#fee2e2';"
                onmouseout="this.style.opacity='0.5'; this.style.backgroundColor='transparent';"
                title="{{ __('admin.global.delete') }}">
                <i class="las la-times text-danger" style="font-size: 18px;"></i>
            </button>
        </div>
    </a>
</template>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationList = document.getElementById('notification-list');
            const notificationBadge = document.getElementById('notification-badge');
            const notificationPulse = document.getElementById('notification-pulse');
            const unreadCountText = document.getElementById('unread-count-text');
            const notificationEmpty = document.getElementById('notification-empty');
            const markAllReadBtn = document.getElementById('mark-all-read-btn');
            const notificationTemplate = document.getElementById('notification-item-template');

            function updateNotificationBadge(count) {
                if (count > 0) {
                    notificationBadge.textContent = count > 99 ? '99+' : count;
                    notificationBadge.style.display = 'inline-block';
                    notificationPulse.style.display = 'inline-block';
                } else {
                    notificationBadge.style.display = 'none';
                    notificationPulse.style.display = 'none';
                }
                unreadCountText.textContent = count;
            }

            function renderNotifications(notifications) {
                notificationList.innerHTML = '';

                if (notifications.length === 0) {
                    notificationEmpty.style.display = 'block';
                    notificationList.appendChild(notificationEmpty);
                    return;
                }

                notificationEmpty.style.display = 'none';

                notifications.forEach(function(notification, index) {
                    const data = notification.data;
                    let html = notificationTemplate.innerHTML
                        .replace('__ICON_BG__', data.icon_bg || 'bg-primary')
                        .replace('__ICON__', data.icon || 'las la-bell')
                        .replace('__TITLE__', data.title)
                        .replace('__MESSAGE__', data.message)
                        .replace('__TIME__', notification.created_at);

                    const div = document.createElement('div');
                    div.innerHTML = html;
                    const item = div.firstElementChild;

                    item.setAttribute('data-notification-id', notification.id);

                    if (data.download_url) {
                        item.setAttribute('data-download-url', data.download_url);
                    }

                    // Enhanced styling for unread notifications
                    if (!notification.read_at) {
                        item.style.backgroundColor = '#f8fafc';
                        item.style.borderLeftColor = '#667eea';
                        item.style.borderLeftWidth = '3px';
                    }

                    // Add hover effect
                    item.addEventListener('mouseenter', function() {
                        this.style.backgroundColor = notification.read_at ? '#f8fafc' : '#f1f5f9';
                        this.style.transform = 'translateX(2px)';
                        this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.08)';
                    });

                    item.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = notification.read_at ? '#ffffff' : '#f8fafc';
                        this.style.transform = 'translateX(0)';
                        this.style.boxShadow = 'none';
                    });

                    // Add fade-in animation
                    item.style.opacity = '0';
                    item.style.animation = `fadeInNotification 0.3s ease forwards ${index * 0.05}s`;

                    notificationList.appendChild(item);
                });

                // Add animation keyframes if not already added
                if (!document.getElementById('notification-animations')) {
                    const style = document.createElement('style');
                    style.id = 'notification-animations';
                    style.textContent = `
                        @keyframes fadeInNotification {
                            from {
                                opacity: 0;
                                transform: translateY(-10px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                    `;
                    document.head.appendChild(style);
                }
            }

            function fetchNotifications() {
                fetch('{{ route('admin.notifications.index') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        renderNotifications(data.notifications);
                        updateNotificationBadge(data.unread_count);
                    })
                    .catch(error => console.error('Failed to fetch notifications:', error));
            }

            notificationList.addEventListener('click', function(e) {
                const item = e.target.closest('.notification-item');
                if (!item) return;

                const notificationId = item.getAttribute('data-notification-id');
                const downloadUrl = item.getAttribute('data-download-url');
                const deleteBtn = e.target.closest('.delete-notification');

                if (deleteBtn) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Add delete animation
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-100%)';

                    setTimeout(() => {
                        fetch('{{ url('admin/notifications') }}/' + notificationId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(() => fetchNotifications())
                            .catch(error => console.error('Failed to delete notification:', error));
                    }, 300);
                    return;
                }

                e.preventDefault();

                if (downloadUrl) {
                    window.location.href = downloadUrl + '&notification_id=' + notificationId;
                    setTimeout(fetchNotifications, 1000);
                } else {
                    fetch('{{ url('admin/notifications') }}/' + notificationId + '/mark-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(() => fetchNotifications())
                        .catch(error => console.error('Failed to mark notification as read:', error));
                }
            });

            markAllReadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Add loading state
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="las la-spinner la-spin"></i>';
                this.style.pointerEvents = 'none';

                fetch('{{ route('admin.notifications.mark-all-read') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(() => {
                        this.innerHTML = originalHtml;
                        this.style.pointerEvents = 'auto';
                        fetchNotifications();
                    })
                    .catch(error => {
                        console.error('Failed to mark all notifications as read:', error);
                        this.innerHTML = originalHtml;
                        this.style.pointerEvents = 'auto';
                    });
            });

            fetchNotifications();

            setInterval(fetchNotifications, 30000);
        });
    </script>
@endpush
