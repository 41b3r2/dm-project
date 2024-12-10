<?php
session_start();
include "connection.php";

// Database connection settings
$host = 'localhost';
$dbname = 'sql_db';
$username = 'root';
$password = '';

// Connect to the database using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form fields
    $Fname = trim($_POST['Fname'] ?? '');
    $Mname = trim($_POST['Mname'] ?? '');
    $Lname = trim($_POST['Lname'] ?? '');
    $Birthday = trim($_POST['Birthday'] ?? '');
    $Gender = trim($_POST['Gender'] ?? '');
    $Address = trim($_POST['Address'] ?? '');
    $Email = trim($_POST['Email'] ?? '');
    $ContactNo = trim($_POST['ContactNo'] ?? '');
    $Password = $_POST['Password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check if passwords match
    if ($Password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
        exit;
    }

    // Validate and format the Birthday
    if (empty($Birthday)) {
        echo "<script>alert('Birthday cannot be empty');</script>";
        exit;
    }
    // Convert Birthday to the correct format if needed
    $formattedBirthday = date('Y-m-d', strtotime($Birthday)); // Ensures date is in 'YYYY-MM-DD' format

    // Check for duplicate email
    try {
        $emailCheckStmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE Email = ?");
        $emailCheckStmt->execute([$Email]);
        $emailCount = $emailCheckStmt->fetchColumn();

        if ($emailCount > 0) {
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    // Handle profile picture upload securely
    $profilepic = 'img/default-user.jpg'; // Default image
    if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            $upload_dir = 'img/users/';
            $profilepic = $upload_dir . uniqid() . '.' . $file_extension;
            if (!move_uploaded_file($_FILES['profilepic']['tmp_name'], $profilepic)) {
                echo "<script>alert('Failed to upload profile picture');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed');</script>";
            exit;
        }
    }

    // Prepare and execute the SQL statement using PDO
    try {
        $stmt = $pdo->prepare("INSERT INTO user (Fname, Mname, Lname, Gender, Birthday, Address, Email, ContactNo, Password, Profilepic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$Fname, $Mname, $Lname, $Gender, $formattedBirthday, $Address, $Email, $ContactNo, $Password, $profilepic]);

        echo "<script>
                alert('New user added successfully');
                window.location.href = 'index.php';
              </script>";
        exit;
    } catch (PDOException $e) {
        echo "Error during insertion: " . $e->getMessage();
    }
}
?>
