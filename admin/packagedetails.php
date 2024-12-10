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

if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get admin ID from URL parameter
$Locationid = isset($_GET['id']) ? $_GET['id'] : $_SESSION['Locationid '];


// Query to get admin details
$sql = "SELECT * FROM package WHERE Locationid  = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Locationid);
$stmt->execute();
$result = $stmt->get_result();
$Locationid = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../admin/css/administrators.css" />
    <link rel="stylesheet" href="../admin/css/packagedetails.css" />
    <title>ADMIN PORTAL</title>
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <div class="container">
        <!-- Navigation -->
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
                <div class="cardHeader">
                    <h2>ADMIN DETAILS</h2>
                </div>
                <div class="user">
                <img src="<?php echo htmlspecialchars($Profilepic); ?>" alt="User Image">
                </div>
            </div>

            <!-- Admin Details Content -->
            <div class="details">
            <div class="recentOrders admin-details">
                <div class="cardHeader">
                    <a href="package.php" style="
                        margin-bottom: 10px;
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
                    <?php 
    // Get the Locationid from URL parameter
    $currentLocationId = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($currentLocationId) {
        echo '<a href="editpackage.php?Locationid=' . $currentLocationId . '" style="
            margin-bottom: 10px;
            display: inline-block; 
            padding: 5px 15px; 
            background-color: #2C6975; 
            color: #fff; 
            text-decoration: none; 
            border-radius: 10px; 
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); 
            transition: background-color 0.3s, box-shadow 0.3s;"
            onmouseover="this.style.backgroundColor=\'#68B2A0\'; this.style.boxShadow=\'4px 4px 10px rgba(0, 0, 0, 0.5)\';"
            onmouseout="this.style.backgroundColor=\'#2C6975\'; this.style.boxShadow=\'2px 2px 5px rgba(0, 0, 0, 0.3)\';">
            Edit
        </a>';
    }
    ?>
                </div> 
                <div class="profile-section">
                    <div class="profile-container">
                        <!-- Profile Image Container and Admin Badge -->
                        <div class="profile-details">
                            <div class="profile-image-container">
                                <div class="profile-image">
                                    <img src="<?php echo $Locationid['Imagespot']; ?>" alt="Admin Profile Picture">
                                </div>
                            </div>

                            <!-- Profile Information -->
                            <div class="profile-info">
                                <div class="info-group">
                                    <div class="info-label">Spot Name</div>
                                    <div class="name-value">
                                        <?php echo $Locationid['LocationSpot']; ?>
                                    </div>
                                    <div class="admin-id">
                                        <div class="info-value">
                                            <ion-icon name="location"></ion-icon>
                                            <?php echo $Locationid['Location']; ?>
                                        </div>
                                    </div>
                                    <div class="admin-badge">
                                    <ion-icon name="book"></ion-icon>
                                    Package Details Below
                                </div>
                                </div>
                            </div>
                        </div>
                        <hr style="margin-bottom: -20px;">

                        <div class="contact-info">
                            <div class="info-group">
                                <div class="info-label">Persons</div>
                                <small style="font-size: 12px; color: #666;">Available number of persons.</small>
                                <div class="info-value">
                                    <ion-icon name="people"></ion-icon>
                                    <?php echo $Locationid['Person']; ?> Persons
                                </div>
                            </div>

                            <div class="info-group">
                                <div class="info-label">Days</div>
                                <small style="font-size: 12px; color: #666;">Number of days of stay.</small>
                                <div class="info-value">
                                    <ion-icon name="calendar"></ion-icon>
                                    <?php echo $Locationid['Days']; ?> Days
                                </div>
                            </div>

                            <div class="info-group">
                                <div class="info-label">Price</div>
                                <small style="font-size: 12px; color: #666;">Price of Staying.</small>
                                <div class="info-value">
                                    <b>₱</b> <?php echo $Locationid['Price']; ?>
                                </div>
                            </div>

                        </div>
                        <div class="info-group">
                            <div class="info-label">Images</div>
                            <div class="admin-id text-sm text-gray-500">
                                <div class="info-value">
                                    <ion-icon name="image"></ion-icon>
                                    <?php echo $Locationid['Location']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const birthDate = new Date('<?php echo $Locationid["Birthday"]; ?>');
        function calculateAge(birthDate) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const month = today.getMonth();
            const day = today.getDate();
            if (month < birthDate.getMonth() || (month === birthDate.getMonth() && day < birthDate.getDate())) {
                age--;
            }
            
            return age;
        }
        document.getElementById('age').textContent = `${calculateAge(birthDate)} Years Old`;
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="main.js"></script>
</body>
</html>