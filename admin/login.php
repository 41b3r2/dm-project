<?php 
session_start();
include "../connection.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to validate input data
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form data is set
if (isset($_POST['Email']) && isset($_POST['Password'])) {

    // Validate the email and password
    $email = validate($_POST['Email']);
    $password = validate($_POST['Password']);

    // Check for empty fields
    if (empty($email)) {
        header("Location: index.php?error=Email is required");
        exit();
    } else if (empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
    }

    // Prepare the SQL query
    $sql = "SELECT * FROM admin WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Check if the password is hashed and verify using password_verify
        if (password_verify($password, $row['Password'])) {
            // User is authenticated with hashed password
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['Fname'] = $row['Fname'];
            $_SESSION['AdminId'] = $row['AdminId'];
            header("Location: home.php?success=Logged In Successfully!");
            exit();
        } 
        // Check for plain text password match if password_verify fails
        else if ($password === $row['Password']) {
            // User is authenticated with plain text password
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['Fname'] = $row['Fname'];
            $_SESSION['AdminId'] = $row['AdminId'];
            header("Location: home.php?success=Logged In Successfully!");
            exit();
        } 
        else {
            // Incorrect password
            header("Location: index.php?error=Incorrect credentials");
            exit();
        }
    } else {
        // No matching user found
        header("Location: index.php?error=User not found");
        exit();
    }
}
?>
