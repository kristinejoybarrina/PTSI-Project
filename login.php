<?php
session_start();
header('Content-Type: application/json');

// Check request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $conn = new mysqli("localhost", "root", "", "user_registration");

    if ($conn->connect_error) {
        echo json_encode([
            'success' => false,
            'message' => 'Database connection failed: ' . $conn->connect_error
        ]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users_info WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // THIS IS CRUCIAL
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            echo json_encode([
                'success' => true,
                'message' => 'Login successful.',
                'redirect' => './client/dashboard.html'
            ]);
            exit;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid password.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'User not found.'
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>

