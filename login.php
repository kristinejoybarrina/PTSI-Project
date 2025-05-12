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

$query = "SELECT * FROM users_info WHERE username = ? AND password = ?";
$stmt = $conn->prepare($query);

// Bind the parameters
$stmt->bind_param("ss", $username, $password);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if theuser exists
if ($result->num_rows > 0) {
    // User found, set session variables
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];

    // Redirect to the welcome page
    echo "
    <div style='display:flex;justify-content:center;align-items:center;height:100vh;background:#f9f9f9'>
      <div style='text-align:center;padding:50px 80px;#000;border-radius:12px;background:#fff;box-shadow:0 4px 12px rgba(0,0,0,0.1)'>
        <div style='font-size:80px;color:#0c0'>&#10003;</div>
        <div style='font:700 24px \"Source Serif Pro\",serif;color:#333'>Logged in successfully.</div>
      </div>
    </div>
    ";

} else {
    // Invalid credentials
    header("Location:login.html?error=invalid");
    exit();

}
    // Close the connection
    $stmt->close();
    $conn->close();

}
?>