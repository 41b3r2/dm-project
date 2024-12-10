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
    $LocationSpot = trim($_POST['LocationSpot'] ?? '');
    $Location = trim($_POST['Location'] ?? '');
    $Price = trim($_POST['Price'] ?? '');
    $Days = trim($_POST['Days'] ?? '');
    $Person = trim($_POST['Person'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check if passwords match
    if ($password !== $confirm_password) {
    } else {

        // Handle profile picture upload
        $Imagespot = '';
        if (isset($_FILES['Imagespot']) && $_FILES['Imagespot']['error'] === UPLOAD_ERR_OK) {
            $Imagespot = '../img/spots/' . basename($_FILES['Imagespot']['name']);
            move_uploaded_file($_FILES['Imagespot']['tmp_name'], $Imagespot);
        }
        $stmt = $conn->prepare("INSERT INTO package (LocationSpot, Location, Price, Days, Person, Imagespot) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $LocationSpot, $Location, $Price, $Days, $Person, $Imagespot);

        if ($stmt->execute()) {
            echo "<script>
            alert('New package added successfully');
            window.location.href = 'package.php';
            </script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Query to select all package data
$sql = "SELECT LocationSpot, Location, Price, Days, Person, Imagespot FROM package";
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
                    <h2>Add Package</h2>
                    <a href="package.php" style="
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
                      Back
                    </a>
                </div>
                <div class="form-container">
                    <form method="POST" action="addpackage.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="name-row">
                        <div>
                            <label for="LocationSpot">Name Spot:</label>
                            <input type="text" id="LocationSpot" name="LocationSpot" required>
                        </div>
                    </div>


                    <div class="name-row">
                        <div>
                            <label for="Person">Person:</label>
                            <input type="number" id="Person" name="Person" required>
                            <small style="font-size: 12px; color: #666;">Please enter the number of persons.</small>
                        </div>
                        <div>
                            <label for="Days">Days:</label>
                            <input type="number" id="Days" name="Days" required>
                            <small style="font-size: 12px; color: #666;">Number of days of stay.</small>
                        </div>
                        <div>
                            <label for="Price">Price:</label>
                            <input type="number" id="Price" name="Price" required>
                        </div>
                    </div>


                    <div class="details-row">
                        <div>
                        <label for="Location">Location:</label>
                        <input type="text" id="Location" name="Location" required>
                        <small style="font-size: 12px; color: #666;">Enter the exact location of the spot.</small>
                        </div>
                        <div>
                            <label for="Imagespot">Insert Image:</label>
                            <input type="file" id="Imagespot" name="Imagespot" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="add-button" style="margin-top: -5px;">
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
