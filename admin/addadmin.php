<?php
session_start();
include "../connection.php";
$host = 'localhost';
$dbname = 'sql_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}
if (isset($_SESSION['AdminId'])) {
    $AdminId = $_SESSION['AdminId'];
    $query = "SELECT Profilepic FROM admin WHERE AdminId = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$AdminId]);
    $admin = $stmt->fetch();
    $Profilepic = $admin['Profilepic'] ? $admin['Profilepic'] : 'img/default-user.jpg';
}

// Check if the user is logged in
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate form fields
    $fname = trim($_POST['fname'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        // Hash the password for secure storage
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle profile picture upload
        $profilepic = '';
        if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
            $profilepic = 'ad_image/' . basename($_FILES['profilepic']['name']);
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $profilepic);
        }
        $stmt = $conn->prepare("INSERT INTO admin (Fname, Mname, Lname, Birthday, Address, Email, Contact, Password, Profilepic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $fname, $mname, $lname, $birthday, $address, $email, $contact, $hashed_password, $profilepic);

        if ($stmt->execute()) {
            echo "<script>
            alert('New admin added successfully');
            window.location.href = 'administrators.php';
            </script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Query to select all admin data
$sql = "SELECT Fname, Mname, Lname, Email, Contact FROM admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../admin/css/administrators.css" />
    <link rel="stylesheet" href="../admin/css/prof1.css" />
    <title>ADMIN PORTAL</title>
    <link rel="icon" href="../img/logo.png">
  </head>
  <body>
    <div class="container">
      <div class="navigation">
        <ul>
        <li style="display: flex; justify-content: center; align-items: center; text-align: center; padding: 10px; list-style-type: none;">
                <a href="#" style="display: flex; align-items: center; text-decoration: none; color: #333;">
                <img src="../img/logo.png" alt="Admin Logo" style="margin-left: -15px; display: block; width: 75px; height: 75px; border-radius: 50%; filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 5));">
                    <span style="font-size: 18px; font-weight: bold; color: #fff; text-transform: uppercase;">ItsSamarTime</span>
                </a>
            </li>

            <li><a href="home.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="title">Dashboard</span></a></li>

            <li><a href="package.php"><span class="icon"><ion-icon name="briefcase-outline"></ion-icon></span><span class="title">Package Spots</span></a></li>

            <li><a href="customers.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Customers</span></a></li>

            <li><a href="message.php"><span class="icon"><ion-icon name="mail-outline"></ion-icon></span><span class="title">Messages</span></a></li>

            <li><a href="booking.php"><span class="icon"><ion-icon name="calendar-outline"></ion-icon></span><span class="title">Bookings</span></a></li>
            
            <li><a href="settings.php"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="title">Settings</span></a></li>

            <li><a href="administrators.php" class="nav-link" aria-label="Go to Profile"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Administrators</span></a></li>
            
            <li><a href="profile.php" class="nav-link" aria-label="Go to Profile">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="user-icon">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span><span class="title">Profile</span>
                </a>
            </li>

            <li><a href="signout.php"><span class="icon"><ion-icon name="log-out-outline"></ion-icon></span><span class="title">Sign Out</span></a> </li>
            </ul>
        </div>

      <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        <!-- Search -->
        <div class="cardHeader">
            <h2>SETTINGS</h2>
        </div>
        <!-- UserImg -->
        <div class="user">
        <img src="<?php echo htmlspecialchars($Profilepic); ?>" alt="User Image">
        </div>
    </div>

    <!-- Cards -->
    <!-- Orders details List -->
    <div class="recentOrders">
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Administrator</h2>
                    <a href="administrators.php" style="
                      display: inline-block; 
                      padding: 5px 15px; 
                      background-color: #2C6975; 
                      color: #fff; 
                      text-decoration: none; 
                      border-radius: 10px; 
                      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); 
                      transition: background-color 0.3s, box-shadow 0.3s;"
                      onmouseover="this.style.backgroundColor='#68B2A0'; this.style.boxShadow='4px 4px 10px rgba(0, 0, 0, 0.5)';"
                      onmouseout="this.style.backgroundColor='#2C6975'; this.style.boxShadow='2px 2px 5px rgba(0, 0, 0, 0.3)';">
                      View Admins
                    </a>
                </div>
                <div class="form-container">
                    <form method="POST" action="addadmin.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="name-row">
                        <div>
                            <label for="fname">First Name:</label>
                            <input type="text" id="fname" name="fname" required>
                        </div>
                        <div>
                            <label for="mname">Middle Name:</label>
                            <input type="text" id="mname" name="mname" required>
                        </div>
                        <div>
                            <label for="lname">Last Name:</label>
                            <input type="text" id="lname" name="lname" required>
                        </div>
                    </div>

                    <div class="details-row">
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}" title="Please enter a valid email address (e.g., example@domain.com)" onblur="validateEmail()">
                            <span id="email-error" style="color: red; display: none;">Invalid email format! Please enter a valid email with '@' and '.com'</span>
                        </div>
                        <div>
                            <label for="contact">Contact No.:</label>
                            <input type="tel" id="contact" name="contact" required maxlength="11" oninput="validateContact()" pattern="^09\d{9}$">
                            <span id="contact-error" style="color: red; display: none;">Invalid contact number</span>
                        </div>
                        <div>
                            <label for="birthday">Birthday:</label>
                            <input type="date" id="birthday" name="birthday" required maxlength="11" oninput="validateContact()"
                                max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                        </div>
                    </div>

                    <div>
                      <label for="address">Complete Address:</label>
                      <input type="text" id="address" name="address" required>
                    </div>

                    <div class="details-row">
                      <div>
                          <label for="password">Password:</label>
                          <input type="password" id="password" name="password" required>
                      </div>
                      <div>
                          <label for="confirm_password">Confirm Password:</label>
                          <input type="password" id="confirm_password" name="confirm_password" required>
                      </div>
                      <div>
                          <label for="profilepic">Insert Image:</label>
                          <input type="file" id="profilepic" name="profilepic" accept="image/*">
                      </div>
                    </div>
                    
                    <div class="add-button">
                        <button type="submit">Add Admin</button>
                    </div>
                    </form>
                </div>
            </div>

<script>
    function validateEmail() {
        var email = document.getElementById('email').value;
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        var errorMessage = document.getElementById('email-error');

        if (!regex.test(email)) {
        errorMessage.style.display = 'inline';
        } else {
        errorMessage.style.display = 'none'; 
        }
    }
    function validateContact() {
        var contact = document.getElementById('contact').value;
        var errorMessage = document.getElementById('contact-error');

        if (contact.length > 11) {
        contact = contact.slice(0, 11);
        document.getElementById('contact').value = contact;
        }

        var regex = /^09\d{9}$/;
        if (!regex.test(contact)) {
        errorMessage.style.display = 'inline';
        } else {
        errorMessage.style.display = 'none';   
        }
    }
    function validateForm() {
        const password = document.getElementById("password").value;
        const confirm_password = document.getElementById("confirm_password").value;
        if (password !== confirm_password) {
            alert("Passwords do not match!");
            return false;
        }
        return true;
    }
</script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="main.js"></script>
</body>
</html>
