// Function to toggle between login and registration forms
function toggleForms() {
    const loginContainer = document.getElementById('loginContainer');
    const signupContainer = document.getElementById('signupContainer');
    
    if (loginContainer.style.display === 'none') {
        loginContainer.style.display = 'block';
        signupContainer.style.display = 'none';
    } else {
        loginContainer.style.display = 'none';
        signupContainer.style.display = 'block';
    }
}

// Function to validate login form
function validateLoginForm(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('Please fill in all fields');
        event.preventDefault();
        return false;
    }
    return true;
}

// Function to validate registration form
function validateRegistrationForm(event) {
    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;
    const regPassword = document.getElementById('regPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Check if required fields are filled
    if (!firstname || !lastname || !email || !address || !regPassword || !confirmPassword) {
        alert('Please fill in all required fields');
        event.preventDefault();
        return false;
    }

    // Validate email format
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address');
        event.preventDefault();
        return false;
    }

    // Check if passwords match
    if (regPassword !== confirmPassword) {
        alert('Passwords do not match!');
        event.preventDefault();
        return false;
    }

    // Check password strength (at least 8 characters, containing numbers and letters)
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordPattern.test(regPassword)) {
        alert('Password must be at least 8 characters long and contain both letters and numbers');
        event.preventDefault();
        return false;
    }

    return true;
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const loginForm = document.querySelector('#loginContainer form');
    const registrationForm = document.querySelector('#signupContainer form');

    // Add submit event listeners to forms
    if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
    }
    if (registrationForm) {
        registrationForm.addEventListener('submit', validateRegistrationForm);
    }

    // Show login form by default
    const loginContainer = document.getElementById('loginContainer');
    if (loginContainer) {
        loginContainer.style.display = 'block';
    }
});