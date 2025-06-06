document.addEventListener('DOMContentLoaded', function () {
    const notifications = [
        { id: 1, type: 'success', message: 'Appointment Confirmed', time: '1 hour ago' },
        { id: 2, type: 'info', message: 'New Lab Results Available', time: '3 hours ago' },
        { id: 3, type: 'warning', message: 'Reminder: Follow-up Checkup Tomorrow', time: 'Yesterday' }
    ];

    function getNotificationIcon(type) {
        switch (type) {
            case 'success':
                return `
                    <svg class="text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                `;
            case 'info':
                return `
                    <svg class="text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                `;
            case 'warning':
                return `
                    <svg class="text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                `;
            default:
                return '';
        }
    }

    const notificationBell = document.getElementById('notificationBell');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationItemsContainer = document.getElementById('notificationItems');

    if (notificationBell && notificationDropdown && notificationItemsContainer) {
        notificationBell.addEventListener('click', function (event) {
            event.stopPropagation();
            notificationDropdown.classList.toggle('active');
        });

        notificationItemsContainer.innerHTML = '';
        notifications.forEach(notification => {
            const notificationItem = document.createElement('div');
            notificationItem.classList.add('notification-item');
            notificationItem.innerHTML = `
                ${getNotificationIcon(notification.type)}
                <div>
                    <p class="title">${notification.message}</p>
                    <p class="time">${notification.time}</p>
                </div>
            `;
            notificationItemsContainer.appendChild(notificationItem);
        });

        window.addEventListener('click', function (event) {
            if (!notificationBell.contains(event.target) && !notificationDropdown.contains(event.target)) {
                if (notificationDropdown.classList.contains('active')) {
                    notificationDropdown.classList.remove('active');
                }
            }
        });
    }
});