<?php 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

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
          <div class="search">
            <label>
              <input type="text" placeholder="Search here">
              <ion-icon name="search-outline"></ion-icon>
            </label>
          </div>
          <!-- UserImg -->
          <div class="user">
            <img src="img/user.jpg" alt="User Image">
          </div>
        </div>

        <!-- Cards -->
        <div class="cardBox">
          <div class="card">
            <div>
              <div class="numbers">1,504</div>
              <div class="cardName">Daily Views</div>
            </div>
            <div class="IconBx">
              <ion-icon name="eye-outline"></ion-icon>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers">80</div>
              <div class="cardName">Sales</div>
            </div>
            <div class="IconBx">
              <ion-icon name="cart-outline"></ion-icon>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers">284</div>
              <div class="cardName">Commem</div>
            </div>
            <div class="IconBx">
              <ion-icon name="chatbubbles-outline"></ion-icon>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers">$7,842</div>
              <div class="cardName">Earning</div>
            </div>
            <div class="IconBx">
              <ion-icon name="cash-outline"></ion-icon>
            </div>
          </div>
        </div>
        <div class="details">
          <!-- Orders datails List -->
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Recent Orders</h2>
              <a href="#" class="btn">View All</a>
            </div>
            <table>
              <thead>
                <tr>
                  <td>Name</td>
                  <td>Price</td>
                  <td>Payment</td>
                  <td>Status</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Star Refrigerator</td>
                  <td>$1200</td>
                  <td>Paid</td>
                  <td><span class="status delivered">Delivered</span></td>
                </tr>
                <tr>
                  <td>Window Coolers</td>
                  <td>$110</td>
                  <td>Due</td>
                  <td><span class="status pending">Pending</span></td>
                </tr>
                <tr>
                  <td>Speakers</td>
                  <td>$620</td>
                  <td>Paid</td>
                  <td><span class="status return">Return</span></td>
                </tr>
                <tr>
                  <td>Hp Leptop</td>
                  <td>$110</td>
                  <td>Due</td>
                  <td><span class="status inprogress">In Progress</span></td>
                </tr>
                <tr>
                  <td>Apple Watch</td>
                  <td>$1200</td>
                  <td>Paid</td>
                  <td><span class="status delivered">Delivered</span></td>
                </tr>
                <tr>
                  <td>Wall Fan</td>
                  <td>$110</td>
                  <td>Paid</td>
                  <td><span class="status pending">Pending</span></td>
                </tr>
                <tr>
                  <td>Adidas Shoes</td>
                  <td>$620</td>
                  <td>Paid</td>
                  <td><span class="status return">Return</span></td>
                </tr>
                <tr>
                  <td>Demin Shirts</td>
                  <td>$110</td>
                  <td>Due</td>
                  <td><span class="status inprogress">In Progress</span></td>
                </tr>
                <tr>
                  <td>Casual Shoes</td>
                  <td>$575</td>
                  <td>Due</td>
                  <td><span class="status inprogress">In Progress</span></td>
                </tr>
                <tr>
                  <td>Wall Fan</td>
                  <td>$110</td>
                  <td>Paid</td>
                  <td><span class="status pending">Pending</span></td>
                </tr>
                <tr>
                  <td>Demin Shirts</td>
                  <td>$110</td>
                  <td>Due</td>
                  <td><span class="status inprogress">In Progress</span></td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- New Customers -->
          <div class="recentCustomers">
            <div class="cardHeader">
              <h2>Recent Customers</h2>
            </div>
            <table>
              <tr>
                <td width="60px"><div class="img8x"><img src="img/img1.jpg"></div></td>
                <td><h4>David<br><span>Italy</span></h4></td>
              </tr>
              <tr>
                <td><div class="img8x"><img src="img/img2.jpg"></div></td>
                <td><h4>Muhammed<br><span>India</span></h4></td>
               </tr>
               <tr>
                <td><div class="img8x"><img src="img/img3.jpg"></div></td>
                <td><h4>Amelia<br><span>France</span></h4></td>
               </tr>
               <tr>
                <td><div class="img8x"><img src="img/img4.jpg"></div></td>
                <td><h4>Olivia<br><span>USA</span></h4></td>
               </tr>
               <tr>
                <td><div class="img8x"><img src="img/img5.jpg"></div></td>
                <td><h4>Amit<br><span>Japan</span></h4></td>
               </tr>
               <tr>
                <td><div class="img8x"><img src="img/img6.jpg"></div></td>
                <td><h4>Ashraf<br><span>India</span></h4></td>
               </tr>
               <tr>
                <td><div class="img8x"><img src="img/img7.jpg"></div></td>
                <td><h4>Diana<br><span>Malaysia</span></h4></td>
               </tr>
               <tr>
                <td><div class="img8x"><img src="img/img8.jpg"></div></td>
                <td><h4>Amit<br><span>India</span></h4></td>
               </tr>
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
