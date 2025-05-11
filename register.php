<?php
    // Create connection
    $conn = new mysqli("localhost", "root", "", "user_registration");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $suffix = $_POST['suffix'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $age = $_POST['age'];
        $phone = $_POST['phome'];
        $street = $_POST['street'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $barangay = $_POST['barangay'];
        $postal = $_POST['postal'];
        $password = $POST['regPassword'];
        //$confirmPassword = $_POST['confirmPassword'];
        $emergencyName = $POST['emergencyName']
        $emergencyNumber = $POST['emergencyNumber'];


        // Validate input (basic validation)
        if (!empty($name) && !empty($email) && !empty($address)) {
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO users (lastname, firstname, middlename, suffix, email, username, age, phone, street, provice, city, district, barangay, postal, regPassword, emergencyName, emergencyNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssss", $lastname, $firstname, $middlename, $suffix, $email, $username, $age, $phone, $street, $province, $city, $district, $barangay, $postal $password, $emergencyName, $emergencyNumber);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "All fields are required!";
        }
    }

    // Close the connection
    $conn->close();
    ?>

?>


 
