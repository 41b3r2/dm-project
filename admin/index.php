
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="icon" src="../img/logo.png" type="image/x-icon">
    <link href="../admin/logincss.css" rel="stylesheet">
    <script>
        window.onload = function() {
            // Check if there's a 'success' or 'error' message in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const successMessage = urlParams.get('success');
            const errorMessage = urlParams.get('error');
            
            if(successMessage) {
                alert(successMessage); // Display success message
            }
            if(errorMessage) {
                alert(errorMessage); // Display error message
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>ADMIN PORTAL</h1>
    </div>

    <div class="main-container">
        <div class="login-container">
            <div class="login-logo">
                <img src="../img/logo.png" alt="Admin Logo">
            </div>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="Email">Email</label>
                    <input type="Email" id="Email" name="Email" placeholder="Enter your email" required>
                </div>
            
                <div class="input-group">
                    <label for="Password">Password</label>
                    <input type="Password" id="Password" name="Password" placeholder="Enter your password" required>
                </div>
            
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <button type="submit" class="login-button" name="login">LOGIN</button>
                
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
            
            <div class="footer">
                © 2024 Admin Portal. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
