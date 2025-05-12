<?php
// Start the session
session_start();

    // Collect form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lastname = $_POST['lastname'] ?? '';
        $firstname = $_POST['firstname'] ?? '';
        $middlename = $_POST['middlename'] ?? '';
        $suffix = $_POST['suffix'] ?? '';
        $email = $_POST['email'] ?? '';
        $age = $_POST['age'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $street = $_POST['street'] ?? '';
        $region = $_POST['region'] ?? '';
        $province = $_POST['province'] ?? '';
        $city = $_POST['city'] ?? '';
        $barangay = $_POST['barangay'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $emergencyName = $_POST['emergencyName'] ?? '';
        $relationship = $_POST['relationship'] ?? '';
        $emergencyNumber = $_POST['emergencyNumber'] ?? '';


    // Default image path in case no image is uploaded
    $imagePath = 'img/noprofil.jpg';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageError = $_FILES['image']['error'];

        // Define allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExt, ['jpg', 'jpeg', 'png', 'gif'])) {
            if ($imageSize <= 2 * 1024 * 1024) {
                $newImageName = uniqid('', true) . '.' . $imageExt;
                $uploadPath = 'uploads/' . $newImageName;
                

                // Move this after registration success — do NOT move the file yet
            $imageTempData = [
                'tmp_name' => $imageTmpName,
                'upload_path' => $uploadPath
            ];
            $imagePath = $uploadPath; // Save intended path

            } else {
                echo "Image size is too large. Maximum size is 2MB. Using default image.";
            }
        } else {
            echo "Invalid image type. Only JPG, PNG, and GIF are allowed. Using default image.";
        }
    }
    // Create connection
    $conn = new mysqli("localhost", "root", "", "user_registration");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user already exists
    $checkStmt = $conn->prepare("SELECT * FROM users_info WHERE email = ? OR username = ?");
    $checkStmt->bind_param("ss", $email, $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: registration.html?error=user_exists"); // Redirect to the registration form
        exit(); 

    }else{
        $stmt = $conn->prepare("INSERT INTO users_info (lastname, firstname, middlename, suffix, email, age, gender, phone, street, region, province, city, barangay, username, password, emergencyName, relationship, emergencyNumber, image_path) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisisssssssssis",  $lastname, $firstname, $middlename, $suffix, $email, $age, $gender, $phone, $street, $region, $province, $city, $barangay, $username, $password, $emergencyName, $relationship, $emergencyNumber, $imagePath);
        $stmt->execute();
        echo "    
            <div style='display:flex;justify-content:center;align-items:center;height:100vh;background:#f9f9f9'>
                <div style='text-align:center;padding:50px 80px;#000;border-radius:12px;background:#fff;box-shadow:0 4px 12px rgba(0,0,0,0.1)'>
                    <div style='font-size:80px;color:#0c0'>&#10003;</div>
                    <div style='font:700 24px \"Source Serif Pro\",serif;color:#333'>Registration successful.</div>
                </div>
            </div>
            ";

        //Upload the image only if the registration is successful
        if (!empty($imageTempData)) {
            if (!move_uploaded_file($imageTempData['tmp_name'], $imageTempData['upload_path'])) {
                // Fallback if upload failed
                $imagePath = 'img/BG.png';
                echo " Image upload failed, using default image.";
            }
        }

        $stmt->close();
        $conn->close();
    }}

?>


 
