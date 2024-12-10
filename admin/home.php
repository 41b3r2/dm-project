<?php 
session_start();
$host = 'localhost';
$dbname = 'sql_db';
$username = 'root';
$password = '';
 
$conn = mysqli_connect($host, $username, $password, $dbname);

// Suriin kung may error sa koneksyon
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
} else {
    header("Location: login.php");
    exit;
}
 
$queryPackage = "SELECT * FROM package";
$queryUser = "SELECT * FROM user";
$queryBooks = "SELECT * FROM booking";


$resultPackage = mysqli_query($conn, $queryPackage);
$resultUser = mysqli_query($conn, $queryUser);
$resultBooks = mysqli_query($conn, $queryBooks);

$totalPackage = mysqli_num_rows($resultPackage);
$totalUser = mysqli_num_rows($resultUser);
$totalBooks = mysqli_num_rows($resultBooks);

// Retrieve the user's first name
$fname = $_SESSION['Fname'];

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="styles.css" />
        <link rel="stylesheet" href="bar.css" />
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
          <h2>DASHBOARD</h2>
          </div>
            <!-- UserImg -->
            <div class="user">
            <img src="<?php echo htmlspecialchars($Profilepic); ?>" alt="User Image">
            </div>
            </div>

            <!-- Cards -->
            <div class="cardBox">
            <div class="card">
                <div>
                <div class="numbers">
                    <?php 
                    if(mysqli_num_rows($resultUser) > 0) {
                        $totalUser = mysqli_num_rows($resultUser);
                            echo  $totalUser;
                        } else {
                            echo "Walang laman ang table na 'User'.";
                        }
                    ?>
                </div>
                <div class="cardName">Customers</div>
                </div>
                <div class="IconBx">
                <ion-icon name="eye-outline"></ion-icon>
                </div>
            </div>

            <a href="booking.php" style="text-decoration: none;">
                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php 
                            if(mysqli_num_rows($resultBooks) > 0) {
                                $totalBooks = mysqli_num_rows($resultBooks);
                                    echo  $totalBooks;
                                } else {
                                    echo "Walang laman ang table na 'User'.";
                                }
                            ?>
                        </div>
                        <div class="cardName">Bookings</div>
                    </div>
                    <div class="IconBx">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </div>
                </div>
            </a>

            <div class="card">
                <div>
                <div class="numbers">284</div>
                <div class="cardName">Feedbacks</div>
                </div>
                <div class="IconBx">
                <ion-icon name="chatbubbles-outline"></ion-icon>
                </div>
            </div>
            <a href="package.php" style="text-decoration: none;">
                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php 
                                if(mysqli_num_rows($resultPackage) > 0) {
                                    $totalPackage = mysqli_num_rows($resultPackage);
                                    echo  $totalPackage;
                                } else {
                                    echo "Walang laman ang table na 'package'.";
                                }
                            ?>
                        </div>
                        <div class="cardName">Package Spots</div>
                    </div>
                    <div class="IconBx">
                        <ion-icon name="Location-outline"></ion-icon>
                    </div>
                </div>
            </a>
            </div>
            <div class="details">
            <div class="recentOrders">
            <div class="cardHeader">
              <h2>Package Spots</h2>
              <a href="addpackage.php" style="
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
                  Add Package Spot
              </a>

            </div>

                <table>
            <thead>
              <tr>
                <td style="text-align: center; vertical-align: middle;">#</td>
                <td style="text-align: right; vertical-align: middle;"></td>
                <td style="text-align: left; vertical-align: middle;">Spots</td>
                <td style="width: 15%;text-align: left; vertical-align: middle;">Price</td>
                <td style="width: 10%;text-align: center; vertical-align: middle;">Action</td>
              </tr>
            </thead>
            <tbody>
              
              

            <?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$rowsPerPage = 5;
$offset = ($page - 1) * $rowsPerPage;

$totalRowsQuery = "SELECT COUNT(*) AS total FROM package";
$totalRowsResult = $conn->query($totalRowsQuery);
$totalRows = $totalRowsResult->fetch_assoc()['total'];

$totalPages = ceil($totalRows / $rowsPerPage);
$query = "SELECT * FROM package LIMIT $offset, $rowsPerPage";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $counter = $offset + 1;

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $Spot = $row['LocationSpot'];
        echo "<tr>";
        echo "<td style='text-align: center; vertical-align: middle;'>$counter</td>";
        echo "<td style='text-align: center; vertical-align: middle;'><div class='user'><img src='{$row['Imagespot']}' alt='User Image'></div></td>";
        echo "<td style='text-align: left; vertical-align: middle;'>$Spot</td>";
        echo "<td style='text-align: left; vertical-align: middle;'>₱" . number_format($row['Price'], 2) . "</td>";
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
        $counter++;
    }
} else {
    echo "<tr><td colspan='5'>No package data found</td></tr>";
}

// Pagination buttons

// Pagination buttons (standalone, no class styles applied)
echo "<tr style='background: none;'><td colspan='5' style='text-align: center; padding: 20px 0;'>";

if ($page > 1) {
    echo "<button 
            style='margin-right: 10px; padding: 8px 15px; background-color: #2C6975; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: 0.3s;' 
            onclick=\"window.location.href='?page=" . ($page - 1) . "'\"
            onmouseover=\"this.style.backgroundColor='#68B2A0';\" 
            onmouseout=\"this.style.backgroundColor='#2C6975';\">
            Previous
          </button>";
}

$startPage = max(1, $page - 2);
$endPage = min($totalPages, $page + 2);

for ($i = $startPage; $i <= $endPage; $i++) {
    if ($i == $page) {
        echo "<button 
                style='margin: 0 5px; padding: 8px 15px; background-color: #68B2A0; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; font-weight: bold;' 
                disabled>
                $i
              </button>";
    } else {
        echo "<button 
                style='margin: 0 5px; padding: 8px 15px; background-color: #2C6975; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;' 
                onclick=\"window.location.href='?page=$i'\"
                onmouseover=\"this.style.backgroundColor='#68B2A0';\" 
                onmouseout=\"this.style.backgroundColor='#2C6975';\">
                $i
              </button>";
    }
}

if ($page < $totalPages) {
    echo "<button 
            style='margin-left: 10px; padding: 8px 15px; background-color: #2C6975; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: 0.3s;' 
            onclick=\"window.location.href='?page=" . ($page + 1) . "'\"
            onmouseover=\"this.style.backgroundColor='#68B2A0';\" 
            onmouseout=\"this.style.backgroundColor='#2C6975';\">
            Next
          </button>";
}

echo "</td></tr>";
?>




            
            </tbody>
          </table>
            </div>







            <?php

// Fetch and rank the data
$sql = "
    SELECT 
        p.Locationspot, 
        p.Imagespot, 
        COUNT(b.Locationid) AS count
    FROM 
        booking b
    INNER JOIN 
        package p 
    ON 
        b.Locationid = p.Locationid
    GROUP BY 
        b.Locationid
    ORDER BY 
        count DESC
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$conn->close();
?>




<div class="Rank">
    <div class="rankhead">
        <h2>Ranking Spots Destination</h2>
    </div>
    <div class="ranking-container">
        <?php foreach ($data as $item): ?>
            <div class="ranking-item">
                <div class="img8x1">
                    <img src="<?= htmlspecialchars($item['Imagespot']); ?>" alt="Spot Image">
                </div>
                <div class="ranking-details">
                    <h4>
                        <?= htmlspecialchars($item['Locationspot']); ?>
                        <br>
                        <span>
                            <div class="ranking-bar" style="width: <?= $item['count'] * 10; ?>px;"></div>
                            <?= $item['count']; ?> <?= (int)$item['count'] === 1 ? 'booking' : 'bookings'; ?>
                        </span>
                    </h4>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>





        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="main.js"></script>
    </body>
    </html>
