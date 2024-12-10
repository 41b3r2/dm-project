<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Email']) && isset($_POST['Password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['Email']);
        $password = mysqli_real_escape_string($conn, $_POST['Password']);
        
        $query = "SELECT * FROM user WHERE Email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Compare the plain text password with the stored password
            if ($password == $user['Password']) {
                // Password is correct, start the session
                $_SESSION['Userid'] = $user['Userid'];
                $_SESSION['Email'] = $user['Email'];
                $_SESSION['Fname'] = $user['Fname'];

                echo '<script type="text/javascript">alert("You are successfully logged in!"); window.location = "index.php";</script>';
                exit();
            } else {
                // Incorrect password
                echo '<script type="text/javascript">alert("Invalid credentials!"); window.location = "index.php";</script>';
            }
        } else {
            // Email not found
            echo '<script type="text/javascript">alert("Invalid credentials!"); window.location = "index.php";</script>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '<script type="text/javascript">alert("Please fill in both email and password."); window.location = "index.php";</script>';
    }
}

mysqli_close($conn);
?>
