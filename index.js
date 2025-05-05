function showSignup() {
    document.getElementById("loginContainer").style.display = "none";
    document.getElementById("signupContainer").style.display = "block";
}

function showLogin() {
    document.getElementById("signupContainer").style.display = "none";
    document.getElementById("loginContainer").style.display = "block";
}

  // Get the password and confirm password fields
  const password = document.getElementById('password');
  const confirmPassword = document.getElementById('confirmPassword');
  const form = document.querySelector('form');

  form.addEventListener('submit', function(event)) {
    // Check if the passwords match
    if (password.value !== confirmPassword.value) {
      alert('Passwords do not match!');
      event.preventDefault(); // Prevent form submission
    }
}