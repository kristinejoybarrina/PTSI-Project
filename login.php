<?php
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';



// Connect to the database
$conn = new mysqli("localhost", "root", "", "user_registration");

// Connection failed
if ($conn->connect_error){
    die("Connection failed". $conn->connect_error);
}

$query = "SELECT * FROM users WHERE username = $username AND password = $password";
$stmt = $conn->prepare($query);

// Bind the parameters
$stmt->bind_param("ss", $username, $password);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();


$result = $conn->query($query);

if ($result->num_rows > 0) {
    // User found, set session variables
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];

    // Redirect to the welcome page
    echo "Login successful";
} else {
    // Invalid credentials
    echo "Invalid username or password";

}
    // Close the connection
    $conn->close();

}
?>