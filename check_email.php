<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "sql_db";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email from the AJAX request
$email = $_POST['Email'];

// Prepare and execute the query to check for the email
$sql = "SELECT * FROM user WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the email exists in the database
if ($result->num_rows > 0) {
    echo 'exists';
} else {
    echo 'not_exists';
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
