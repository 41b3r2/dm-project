<?php
session_start();
require 'connection.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the posted form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if inputs are empty
    if (empty($email) || empty($password)) {
        echo "Email and Password are required.";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT Userid, Password FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $hashed_password);
        $stmt->fetch();

        // Verify the password
        // Replace the password comparison with a simple string comparison
        if ($password === $hashed_password) {
            // Password is correct, start a session
            $_SESSION['userid'] = $userid;
            $_SESSION['email'] = $email;
            echo "Login successful!";
            // Redirect to the dashboard or home page
            header("Location: index.php");
            exit;
        } else {
            echo "Invalid password.";
        }

    } else {
        echo "No user found with this email.";
    }

    $stmt->close();
}

$conn->close();
?>
