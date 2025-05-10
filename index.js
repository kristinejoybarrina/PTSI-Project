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

  
 //Profile Upload Script
    const fileInput = document.getElementById('fileInput');
    const profileImage = document.getElementById('profileImage');
    const updateBtn = document.getElementById('updateBtn');
    const removeBtn = document.getElementById('removeBtn');
    const defaultImage = 'img/noprofil.jpg';
  
    // Show file preview on file change
    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          profileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  
    // Trigger file input when update button is clicked
    updateBtn.addEventListener('click', function () {
      fileInput.click();
    });
  
    // Reset to default image
    removeBtn.addEventListener('click', function () {
      fileInput.value = '';
      profileImage.src = defaultImage;
    });