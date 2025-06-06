// MENU BUTTONS CLICKED
document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu li');

    // Restore active from localStorage
    const activeId = localStorage.getItem('activeMenuId');
    if (activeId) {
        document.getElementById(activeId)?.classList.add('active');
    }

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const menuId = item.id;

            menuItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            localStorage.setItem('activeMenuId', menuId);

            if (menuId === 'dashboard') {
                window.location.href = 'dashboard.html';
            } else if (menuId === 'lab-result') {
                window.location.href = 'labresult-login.html';
            } else if (menuId === 'appointment') {
                window.location.href = 'appointment.html';
            }
        });
    });

    //Logout
    const logoutBtn = document.getElementById('logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            // Clear any stored login data
            localStorage.removeItem('activeMenuId');
            localStorage.removeItem('user'); 

            // Redirect to login page
            window.location.href = 'index.html'; 
        });
    }
});