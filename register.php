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

<<<<<<< HEAD
    // Default image path
    $imagePath = 'img/BG.png';
=======
    // Default image path in case no image is uploaded
    $imagePath = 'img/BG.png';

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
    } else {
        echo "No image uploaded or there was an upload error. Using default image.";
    }


    // Create connection
    $conn = new mysqli("sql202.infinityfree.com", "if0_39135099", "Wmsregistration", "if0_39135099_user_registration");

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
<<<<<<< HEAD
        echo json_encode([
            'success' => false,
            'message' => 'User already exists.'
        ]);
        $checkStmt->close();
=======
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
>>>>>>> 663d2714626619377fa081da0d602c548fb18399
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
