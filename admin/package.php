<?php 
session_start();
include "../connection.php";

// Check if the user is logged in
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


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


// Query to select all package data
$sql = "SELECT Locationid, LocationSpot, Location, Price, Imagespot FROM package";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../admin/css/administrators.css" />
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
          <h2>PACKAGE SITE</h2>
          </div>
          <!-- UserImg -->
          <div class="user">
          <img src="<?php echo htmlspecialchars($Profilepic); ?>" alt="User Image">

        </div>
        </div>

        <!-- Cards -->
        
        <div class="details">
          <!-- Orders datails List -->
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Package</h2>
              <a href="addpackage.php" style="
                display: inline-flex; 
                align-items: center; 
                padding: 5px 15px; 
                background-color: #2C6975; 
                color: #fff; 
                text-decoration: none; 
                border-radius: 10px; 
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); 
                font-weight: bold; 
                transition: background-color 0.3s, box-shadow 0.3s;"
                onmouseover="this.style.backgroundColor='#68B2A0'; this.style.boxShadow='4px 4px 10px rgba(0, 0, 0, 0.5)';"
                onmouseout="this.style.backgroundColor='#2C6975'; this.style.boxShadow='2px 2px 5px rgba(0, 0, 0, 0.3)';">
                <span style="
                    display: inline-block; 
                    margin-right: 8px; 
                    font-size: 18px; 
                    font-weight: bold;">+</span>
                Add Package
            </a>


            </div>
            <table>
            <thead>
              <tr>
                <td style="text-align: center; vertical-align: middle;">#</td>
                <td style="text-align: right; vertical-align: middle;"></td>
                <td style="text-align: left; vertical-align: middle;">Spots</td>
                <td style="text-align: center; vertical-align: middle;">Location</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($result->num_rows > 0) {
                  // Initialize counter outside the loop
                  $counter = 1;
                  
                  // Output data of each row
                  while ($row = $result->fetch_assoc()) {
                      $Spot = $row['LocationSpot'];
                      echo "<tr>";
                      echo "<td style='text-align: center; vertical-align: middle;'>$counter</td>";
                      echo "<td style='text-align: center; vertical-align: middle;'><div class='user'><img src='{$row['Imagespot']}' alt='User Image'></div></td>";
                      echo "<td style='text-align: left; vertical-align: middle;'>$Spot</td>";
                      echo "<td style='text-align: center; vertical-align: middle;'>" . $row['Location'] . "</td>";
                      echo "<td>
                                <a href='packagedetails.php?id=" . $row['Locationid'] . "' 
                                  style='
                                      display: inline-block; 
                                      padding: 5px 15px; 
                                      background-color: #2C6975; 
                                      color: #fff; 
                                      text-decoration: none; 
                                      border-radius: 10px; 
                                      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); 
                                      transition: background-color 0.3s, box-shadow 0.3s;'
                                  onmouseover=\"this.style.backgroundColor='#68B2A0'; this.style.boxShadow='4px 4px 10px rgba(2, 0, 0, 0.5)';\"
                                  onmouseout=\"this.style.backgroundColor='#2C6975'; this.style.boxShadow='2px 2px 5px rgba(2, 0, 0, 0.3)';\">
                                  VIEW
                                </a>
                            </td>";
                      echo "</tr>";
                      // Increment counter after each row
                      $counter++;
                  }
              } else {
                  echo "<tr><td colspan='4'>No package data found</td></tr>";
              }
              ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="main.js"></script>
  </body>
</html>
