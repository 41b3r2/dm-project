<?php
session_start();
include "../connection.php";

// Database connection settings
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

// Check if user is logged in
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}

// Retrieve admin profile information
if (isset($_SESSION['AdminId'])) {
    $AdminId = $_SESSION['AdminId'];
    $query = "SELECT * FROM admin WHERE AdminId = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$AdminId]);
    $admin = $stmt->fetch();
    $Profilepic = $admin['Profilepic'] ? $admin['Profilepic'] : 'img/default-user.jpg';
}


// Retrieve Locationid from URL or session
if (isset($_GET['Locationid'])) {
    $Locationid = $_GET['Locationid'];
    $_SESSION['Locationid'] = $Locationid;
} elseif (isset($_SESSION['Locationid'])) {
    $Locationid = $_SESSION['Locationid'];
} else {
    echo "<script>alert('Location ID not provided!'); window.location.href = 'packagedetails.php';</script>";
    exit;
}

// Retrieve package information
$query = "SELECT * FROM package WHERE Locationid = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$Locationid]);
$package = $stmt->fetch();
$Imagespot = $package['Imagespot'] ? $package['Imagespot'] : 'img/default-user.jpg';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $LocationSpot = trim($_POST['LocationSpot'] ?? '');
    $Location = trim($_POST['Location'] ?? '');
    $Price = trim($_POST['Price'] ?? '');
    $Days = trim($_POST['Days'] ?? '');
    $Person = trim($_POST['Person'] ?? '');
    $Activity = trim($_POST['Activity'] ?? '');
    $Description = trim($_POST['Description'] ?? '');
    $Address = trim($_POST['address'] ?? '');

    // Handle profile picture upload
    if (isset($_FILES['Imagespot']) && $_FILES['Imagespot']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'spots/';
        $filename = basename($_FILES['Imagespot']['name']);
        $Imagespot = $uploadDir . $filename;
        move_uploaded_file($_FILES['Imagespot']['tmp_name'], $Imagespot);
    }

    // Update package data in database
    $stmt = $pdo->prepare("UPDATE package SET LocationSpot = ?, Location = ?, Price = ?, Days = ?, Person = ?, Activity = ?, Description = ?, Imagespot = ? WHERE Locationid = ?");
    $stmt->execute([$LocationSpot, $Location, $Price, $Days, $Person, $Activity, $Description, $Imagespot, $Locationid]);

    // Notify user about the update
    echo "<script>
    alert('Package details updated successfully');
    window.location.href = 'package.php';
    </script>";
    exit;
}
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
                    <h2>Update Spot</h2>
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
                    <form method="POST" action="editpackage.php" enctype="multipart/form-data">
                    <div class="name-row">
                        <div>
                            <label for="LocationSpot">Spot Name:</label>
                            <input type="text" id="LocationSpot" name="LocationSpot" value="<?php echo htmlspecialchars($package['LocationSpot']); ?>" required>
                        </div>
                    </div>
                    <div class="details-row">
                        <div>
                            <label for="Days">Days:</label>
                            <input type="number" id="Days" name="Days"value="<?php echo htmlspecialchars($package['Days']); ?>" required maxlength="2" oninput="validatenum()">
                        </div>
                        <div>
                            <label for="Person">Persons:</label>
                            <input type="number" id="Person" name="Person" value="<?php echo htmlspecialchars($package['Person']); ?>" required maxlength="2" oninput="validatenum()">
                        </div>
                        <div>
                            <label for="Price">Price:</label>
                            <input type="number" id="Price" name="Price"value="<?php echo htmlspecialchars($package['Price']); ?>" required maxlength="5" oninput="validatenum()">
                        </div>
                    </div>
                    <div>
                            <label for="Activity">Activities:</label>
                            <input type="text" id="Activity" name="Activity" value="<?php echo htmlspecialchars($package['Activity']); ?>" >
                        </div>
                    <div>
                      <label for="Description">Description:</label>
                      <input type="text" id="Description" name="Description" value="<?php echo htmlspecialchars($package['Description']); ?>" >
                    </div>
                    <div>
                            <label for="Location">Complete Address:</label>
                            <input type="text" id="Location" name="Location" value="<?php echo htmlspecialchars($package['Location']); ?>" required>
                    </div>


                    <div>
                    <div class="name-row">
                        <label for="Imagespot">Insert Image:</label>
                            <input style="width: 60%;" type="file" id="Imagespot" name="Imagespot" accept="image/*">
                            <img id="profilepicPreview" src="<?php echo htmlspecialchars($package['Imagespot']); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>
                    
                   
                    <div class="add-button">
                    <button type="submit">Update Admin</button>
                    </div>
                    
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('profilepicPreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
        preview.src = e.target.result; // Set the preview image
        }

        if (file) {
        reader.readAsDataURL(file); // Read the file as a Data URL
        }
    }
    
    function validatenum() {
    var Person = document.getElementById('Person').value;
    var Price = document.getElementById('Price').value;
    var Days = document.getElementById('Days').value;

    // Restrict the length to 2 digits
    if (Person.length > 2) {
        Person = Person.slice(0, 2);
        document.getElementById('Person').value = Person;
    }

    if (Price.length > 2) {
        Price = Price.slice(0, 5);
        document.getElementById('Price').value = Price;
    }

    if (Days.length > 2) {
        Days = Days.slice(0, 2);
        document.getElementById('Days').value = Days;
    }
}

    
</script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="main.js"></script>
</body>
</html>
