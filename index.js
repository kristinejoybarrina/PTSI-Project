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

// Function to validate phone number format (Philippine format)
function validatePhoneNumber(phone) {
    const phoneRegex = /^(09|\+639)\d{9}$/;
    return phoneRegex.test(phone);
}

// Function to validate age (18 years or older)
function validateAge(age) {
    const ageNum = parseInt(age);
    return ageNum >= 18 && ageNum <= 100;
}

// Function to validate postal code (4 digits)
function validatePostalCode(postal) {
    return /^\d{4}$/.test(postal);
}

// Enhanced registration form validation
function validateRegistrationForm(event) {
    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;
    const regPassword = document.getElementById('regPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const phone = document.getElementById('phone').value;
    const age = document.getElementById('age').value;
    const postal = document.getElementById('postal').value;
    const emergencyNumber = document.getElementById('emergencyNumber').value;

    // Check if required fields are filled
    if (!firstname || !lastname || !email || !address || !regPassword || !confirmPassword || !phone || !age || !postal || !emergencyNumber) {
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

    // Validate phone number
    if (!validatePhoneNumber(phone)) {
        alert('Please enter a valid Philippine phone number (e.g., 09123456789 or +639123456789)');
        event.preventDefault();
        return false;
    }

    // Validate emergency contact number
    if (!validatePhoneNumber(emergencyNumber)) {
        alert('Please enter a valid emergency contact number');
        event.preventDefault();
        return false;
    }

    // Validate age
    if (!validateAge(age)) {
        alert('Age must be between 18 and 100 years old');
        event.preventDefault();
        return false;
    }

    // Validate postal code
    if (!validatePostalCode(postal)) {
        alert('Please enter a valid 4-digit postal code');
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

    // Real-time phone number validation
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            if (!validatePhoneNumber(this.value) && this.value.length > 0) {
                this.setCustomValidity('Please enter a valid Philippine phone number');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Real-time emergency number validation
    const emergencyNumberInput = document.getElementById('emergencyNumber');
    if (emergencyNumberInput) {
        emergencyNumberInput.addEventListener('input', function() {
            if (!validatePhoneNumber(this.value) && this.value.length > 0) {
                this.setCustomValidity('Please enter a valid phone number');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Real-time age validation
    const ageInput = document.getElementById('age');
    if (ageInput) {
        ageInput.addEventListener('input', function() {
            if (!validateAge(this.value) && this.value.length > 0) {
                this.setCustomValidity('Age must be between 18 and 100');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Real-time postal code validation
    const postalInput = document.getElementById('postal');
    if (postalInput) {
        postalInput.addEventListener('input', function() {
            if (!validatePostalCode(this.value) && this.value.length > 0) {
                this.setCustomValidity('Please enter a valid 4-digit postal code');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Prevent form submission if any field is invalid
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                // Show validation messages
                const invalidInputs = this.querySelectorAll(':invalid');
                if (invalidInputs.length > 0) {
                    invalidInputs[0].focus();
                }
            }
        });
    }
});

const data = {
    "Manila": {
      cities: ["Manila"],
      districts: ["Tondo", "Sampaloc", "Ermita", "Malate"],
      barangays: ["Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4"]
    },
    "Albay": {
      cities: ["Legazpi", "Daraga", "Tabaco"],
      districts: ["Legazpi Central", "Daraga North"],
      barangays: ["Bagumbayan", "Camalig", "Barangay Tinago", "San Jose"]
    },
    "Iloilo": {
      cities: ["Iloilo City", "Passi"],
      districts: ["Jaro", "Lapuz"],
      barangays: ["Lapaz", "Barangay Taculing", "Barangay Abucay", "Balintawak"]
    },
    "Cagayan": {
      cities: ["Tuguegarao", "Aparri"],
      districts: ["Centro 1", "Pengue Ruyu"],
      barangays: ["Barangay Carig", "Barangay Ugac", "San Gabriel", "Cataggaman"]
    },
    "Negros Oriental": {
      cities: ["Dumaguete", "Bais", "Bayawan"],
      districts: ["North District", "West District"],
      barangays: ["Barangay Calindagan", "Barangay Daro", "Barangay Banilad", "Barangay Tinago"]
    },
    "Davao": {
      cities: ["Davao City", "Panabo"],
      districts: ["Talomo", "Buhangin"],
      barangays: ["Barangay 5-A", "Barangay 9-A", "Barangay Mintal", "Barangay Ma-a"]
    },
    "Roxas": {
      cities: ["Roxas City"],
      districts: ["Pueblo", "Lawa-an"],
      barangays: ["Barangay Lawaan", "Barangay Inzo", "Barangay Tiza", "Barangay Tanque"]
    },
    "Eastern Visayas": {
      cities: ["Tacloban", "Ormoc"],
      districts: ["Downtown", "San Jose"],
      barangays: ["Barangay Abucay", "Barangay Basper", "Barangay 88", "Barangay 75"]
    }
  };

  document.getElementById("province").addEventListener("change", function () {
    const province = this.value;
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const barangaySelect = document.getElementById("barangay");
  
    // Clear previous options
    citySelect.innerHTML = "<option value=''>-- Select City / Municipality --</option>";
    districtSelect.innerHTML = "<option value=''>-- Select District --</option>";
    barangaySelect.innerHTML = "<option value=''>-- Select Barangay --</option>";
  
    if (data[province]) {
      data[province].cities.forEach(city => {
        citySelect.innerHTML += `<option value="${city}">${city}</option>`;
      });
  
      data[province].districts.forEach(district => {
        districtSelect.innerHTML += `<option value="${district}">${district}</option>`;
      });
  
      data[province].barangays.forEach(barangay => {
        barangaySelect.innerHTML += `<option value="${barangay}">${barangay}</option>`;
      });
    }
  });