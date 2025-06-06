<?php
// Start the session
session_start();

// Set the response type to JSON
header('Content-Type: application/json');

// Collect form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = $_POST['lastname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $middlename = $_POST['middlename'] ?? '';
    $suffix = $_POST['suffix'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = (int) ($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $street = $_POST['street'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $emergencyName = $_POST['emergencyName'] ?? '';
    $relationship = $_POST['relationship'] ?? '';
    $emergencyNumber = $_POST['emergencyNumber'] ?? '';

    // Default image path
    $imagePath = 'img/BG.png';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image']['name'];
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedExtensions)) {
            echo json_encode([
                "success" => false,
                "message" => "Only JPG, JPEG, PNG, and GIF files are allowed."
            ]);
            exit();
        }

        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            echo json_encode([
                "success" => false,
                "message" => "Image size is too large. Maximum is 2MB."
            ]);
            exit();
        }

        $newImageName = uniqid('', true) . '.' . $imageFileType;
        $target = "uploads/" . $newImageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to upload the image."
            ]);
            exit();
        }

        // Image upload successful
        $imagePath = $target;
    }

    // Create connection
    $conn = new mysqli("localhost", "root", "", "user_registration");

    // Check connection
    if ($conn->connect_error) {
        echo json_encode([
            'success' => false,
            'message' => 'Connection failed: ' . $conn->connect_error
        ]);
        exit;
    }

    // Check if the user already exists
    $checkStmt = $conn->prepare("SELECT * FROM users_info WHERE email = ? OR username = ?");
    $checkStmt->bind_param("ss", $email, $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User already exists.'
        ]);
        $checkStmt->close();
        $conn->close();
        exit();
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users_info (
        lastname, firstname, middlename, suffix, email, age, gender, phone, 
        street, region, province, city, barangay, username, password, 
        emergencyName, relationship, emergencyNumber, image_path
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssisisssssssssss",  
        $lastname, $firstname, $middlename, $suffix, $email, $age, $gender, $phone,
        $street, $region, $province, $city, $barangay, $username, $password,
        $emergencyName, $relationship, $emergencyNumber, $imagePath
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'User registered successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registration failed. Please try again.'
        ]);
    }

    $stmt->close();
    $checkStmt->close();
    $conn->close();
}
?>
