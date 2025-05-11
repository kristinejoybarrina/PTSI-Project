<?php
// Start the session
session_start();

    // Collect form data
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $emergencyName = $_POST['emergencyName'];
    $relationship = $_POST['relationship'];
    $emergencyNumber = $_POST['emergencyNumber'];
    
    // Create connection
    $conn = new mysqli("localhost", "root", "", "user_registration");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("insert into users (lastname, firstname, middlename, suffix, email, username, age, phone, street, province, city, district, barangay, postal, regPassword, emergencyName, emergencyNumber) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssiisssssissi",  $lastname, $firstname, $middlename, $suffix, $email, $username, $age, $phone, $street, $province, $city, $district, $barangay, $postal,  $password, $emergencyName, $emergencyNumber);
        $stmt->execute();
        echo "Registration successful";
        $stmt->close();
        $conn->close();
    }

?>


 
