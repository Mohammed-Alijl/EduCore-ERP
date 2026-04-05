/**
 * Notification System
 * Handles real-time notifications display and management
 * Follows Valex Dashboard conventions
 */
(function() {
    'use strict';

    class NotificationManager {
        constructor(config) {
            this.config = config;
            this.els = {
                dropdown: document.getElementById('notification-dropdown'),
                list: document.getElementById('notification-list'),
                pulse: document.getElementById('notification-pulse'),
                unreadCount: document.getElementById('unread-count-text'),
                empty: document.getElementById('notification-empty'),
                markAllReadBtn: document.getElementById('mark-all-read-btn'),
            };

            this.init();
        }

        init() {
            if (!this.els.dropdown) {
                console.warn('Notification dropdown not found');
                return;
            }

            this.attachEventListeners();
            this.loadNotifications();

            // Auto-refresh every 30 seconds
            setInterval(() => this.loadNotifications(), 30000);
        }

        attachEventListeners() {
            if (this.els.list) {
                this.els.list.addEventListener('click', (e) => this.handleNotificationClick(e));
            }

            if (this.els.markAllReadBtn) {
                this.els.markAllReadBtn.addEventListener('click', (e) => this.markAllAsRead(e));
            }
        }

        updateBadge(count) {
            const hasUnread = count > 0;

            if (this.els.pulse) {
                this.els.pulse.style.display = hasUnread ? '' : 'none';
            }

            if (this.els.unreadCount) {
                this.els.unreadCount.textContent = count;
            }
        }

        createNotificationItem(notification, index) {
            const data = notification.data || {};
            const iconBg = data.icon_bg || 'bg-primary';
            const icon = data.icon || 'las la-bell';
            const isRead = !!notification.read_at;
            const statusClass = isRead ? 'read' : 'unread';

            const a = document.createElement('a');
            a.className = `notification-item ${statusClass}`;
            a.href = '#';
            a.dataset.id = notification.id;
            if (data.download_url) {
                a.dataset.downloadUrl = data.download_url;
            }

            // Animation
            a.style.opacity = '0';
            a.style.animation = `fadeInNotification 0.3s ease forwards ${index * 0.05}s`;

            const title = this.escapeHtml(data.title || 'Notification');
            const message = this.escapeHtml(data.message || '');
            const time = this.escapeHtml(notification.created_at || '');
            const deleteTitle = this.config.deleteText || 'Delete';

            a.innerHTML = `
                <div class="notifyimg ${iconBg}">
                    <i class="${icon}"></i>
                </div>
                <div class="notification-content">
                    <h5 class="notification-label">${title}</h5>
                    <p class="notification-subtext mb-0">${message}</p>
                    <span class="notification-time">
                        <i class="las la-clock"></i>${time}
                    </span>
                </div>
                <button type="button" class="btn btn-sm delete-notification" title="${deleteTitle}">
                    <i class="las la-times"></i>
                </button>
            `;

            return a;
        }

        render(notifications) {
            if (!this.els.list) return;

            this.els.list.innerHTML = '';

            if (notifications.length === 0) {
                if (this.els.empty) {
                    this.els.empty.style.display = 'block';
                    this.els.list.appendChild(this.els.empty);
                }
            } else {
                if (this.els.empty) {
                    this.els.empty.style.display = 'none';
                }

                notifications.forEach((notification, index) => {
                    this.els.list.appendChild(this.createNotificationItem(notification, index));
                });
            }
        }

        async fetchApi(url, method = 'GET') {
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': this.config.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return await response.json();
            } catch (error) {
                console.error('API request failed:', error);
                throw error;
            }
        }

        async loadNotifications() {
            try {
                const data = await this.fetchApi(this.config.indexUrl);
                this.render(data.notifications || []);
                this.updateBadge(data.unread_count || 0);
            } catch (error) {
                console.error('Failed to load notifications:', error);
            }
        }

        async handleNotificationClick(e) {
            const item = e.target.closest('.notification-item');
            if (!item) return;

            const id = item.dataset.id;
            const downloadUrl = item.dataset.downloadUrl;

            if (e.target.closest('.delete-notification')) {
                e.preventDefault();
                e.stopPropagation();
                await this.deleteNotification(item, id);
                return;
            }

            e.preventDefault();

            if (downloadUrl) {
                window.location.href = `${downloadUrl}&notification_id=${id}`;
                setTimeout(() => this.loadNotifications(), 1000);
            } else {
                await this.markAsRead(id);
            }
        }

        async deleteNotification(item, id) {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-100%)';

            setTimeout(async () => {
                try {
                    await this.fetchApi(`${this.config.baseUrl}/${id}`, 'DELETE');
                    await this.loadNotifications();
                } catch (error) {
                    console.error('Failed to delete notification:', error);
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }
            }, 300);
        }

        async markAsRead(id) {
            try {
                await this.fetchApi(`${this.config.baseUrl}/${id}/mark-read`, 'POST');
                await this.loadNotifications();
            } catch (error) {
                console.error('Failed to mark notification as read:', error);
            }
        }

        async markAllAsRead(e) {
            e.preventDefault();

            const btn = this.els.markAllReadBtn;
            if (btn.style.pointerEvents === 'none') return;

            const oldHtml = btn.innerHTML;
            btn.innerHTML = '<i class="las la-spinner la-spin"></i>';
            btn.style.pointerEvents = 'none';

            try {
                await this.fetchApi(this.config.markAllReadUrl, 'POST');
                await this.loadNotifications();
            } catch (error) {
                console.error('Failed to mark all as read:', error);
            } finally {
                btn.innerHTML = oldHtml;
                btn.style.pointerEvents = 'auto';
            }
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('notification-dropdown');
        if (!dropdown) return;

        const config = {
            csrfToken: dropdown.dataset.csrf || '',
            indexUrl: dropdown.dataset.indexUrl || '',
            baseUrl: dropdown.dataset.baseUrl || '',
            markAllReadUrl: dropdown.dataset.markAllReadUrl || '',
            deleteText: dropdown.dataset.deleteText || 'Delete'
        };

        new NotificationManager(config);
    });
})();
