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

// Check if user is logged in
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['AdminId'])) {
    $AdminId = $_SESSION['AdminId'];
    $query = "SELECT * FROM admin WHERE AdminId = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$AdminId]);
    $admin = $stmt->fetch();
    $Profilepic = $admin['Profilepic'] ? $admin['Profilepic'] : 'img/default-user.jpg';
}

if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
  $uploadDir = 'ad_image/';
  $filename = basename($_FILES['profilepic']['name']);
  $profilepic = $uploadDir . $filename;
  
  // Move the uploaded file to the designated directory
  if (!move_uploaded_file($_FILES['profilepic']['tmp_name'], $profilepic)) {
      echo "<script>alert('Failed to upload the image. Please try again.');</script>";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $fname = trim($_POST['fname'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
    } else {
        // Hash the password if it's not empty
        $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $admin['Password'];

        // Handle profile picture upload
        $profilepic = $admin['Profilepic']; // Keep existing picture if no new one is uploaded
        if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
            $profilepic = 'ad_image/' . basename($_FILES['profilepic']['name']);
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $profilepic);
        }

        // Update admin data in database
        $stmt = $pdo->prepare("UPDATE admin SET Fname = ?, Mname = ?, Lname = ?, Birthday = ?, Email = ?, Address = ?, Contact = ?, Password = ?, Profilepic = ? WHERE AdminId = ?");
        $stmt->execute([$fname, $mname, $lname, $birthday, $email, $address, $contact, $hashed_password, $profilepic, $AdminId]);
        // Notify user about the update
        echo "<script>
        alert('Admin details updated successfully');
        window.location.href = 'profile.php';
        </script>";
        exit;

    }
}


if (isset($_POST['changepassword'])) {
  // Get the current, new, and confirm password values
  $current_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  // Get the AdminId from session (assuming the admin is logged in and has a session variable for AdminId)
  $AdminId = $_SESSION['AdminId'];

  // Fetch the current password from the database
  $sql = "SELECT Password FROM admin WHERE AdminId = '$AdminId'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Fetch the password
      $row = $result->fetch_assoc();
      $stored_password = $row['Password'];

      // Check if the entered current password matches the hashed password
      if (password_verify($current_password, $stored_password)) {
          // Check if the new password and confirm password match
          if ($new_password == $confirm_password) {
              // Hash the new password before updating (for security)
              $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

              // Update the password in the database
              $update_sql = "UPDATE admin SET Password = '$hashed_new_password' WHERE AdminId = '$AdminId'";

              if ($conn->query($update_sql) === TRUE) {
                  echo "<script> alert('Password updated successfully!');
                  window.location.href = 'editdetails.php';
                  </script>";
              } else {
                  echo "Error updating password: " . $conn->error;
              }
          } else {
              echo "<script> alert('New password and confirm password do not match!');
              window.location.href = 'editdetails.php';
              </script>";
          }
      } else {
          echo "<script> alert('Current password is incorrect!');
          window.location.href = 'editdetails.php';
          </script>";
      }
  } else {
      echo "<script> alert('Admin not found');
      window.location.href = 'editdetails.php';
      </script>";
  }
}


$conn->close();
?>
<!-- (... rest of the HTML code remains the same ...) -->
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
                    <a href="profile.php" style="
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
                    <form method="POST" action="editdetails.php" enctype="multipart/form-data">
                    <div class="name-row">
                        <div>
                            <label for="fname">First Name:</label>
                            <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($admin['Fname']); ?>" required>
                        </div>
                        <div>
                            <label for="mname">Middle Name:</label>
                            <input type="text" id="mname" name="mname" value="<?php echo htmlspecialchars($admin['Mname']); ?>" required>
                        </div>
                        <div>
                            <label for="lname">Last Name:</label>
                            <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($admin['Lname']); ?>" required>
                        </div>
                    </div>
                    <div class="details-row">
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"value="<?php echo htmlspecialchars($admin['Email']); ?>" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}" title="Please enter a valid email address (e.g., example@domain.com)" onblur="validateEmail()">
                            <span id="email-error" style="color: red; display: none;">Invalid email format! Please enter a valid email with '@' and '.com'</span>
                        </div>
                        <div>
                            <label for="contact">Contact No.:</label>
                            <input type="tel" id="contact" name="contact" value="<?php echo htmlspecialchars($admin['Contact']); ?>" required maxlength="11" oninput="validateContact()" pattern="^09\d{9}$">
                            <span id="contact-error" style="color: red; display: none;">Invalid contact number</span>
                        </div>
                        <div>
                            <label for="birthday">Birthday:</label>
                            <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($admin['Birthday']); ?>" required 
                                max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                        </div>

                    </div>
                    
                    <div>
                            <label for="address">Complete Address:</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($admin['Address']); ?>" required>
                    </div>


                    <div>
                    <div class="name-row">
                        <label for="profilepic">Insert Image:</label>
                            <input style="width: 60%;" type="file" id="profilepic" name="profilepic" accept="image/*">
                            <img id="profilepicPreview" src="<?php echo htmlspecialchars($admin['Profilepic']); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div></div>
                    
                   
                    <div class="add-button">
                    <button type="submit">Update Admin</button>
                    </div>
                    
                    </form>
                </div>
            </div>
          </div>
        </div>







        <div class="recentOrders">
    <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Change Password</h2>
            </div>
            <div class="form-container">
                <form method="POST" action="editdetails.php" enctype="multipart/form-data">
                    <div class="name-row">
                        <div>
                            <label for="current_password">Current Password:</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        <div>
                            <label for="new_password">New Password:</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div>
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    
                    <div class="add-button">
                        <button type="changepassword" name="changepassword">Update Password</button>
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
    function validateAge() {
        var age = document.getElementById('age').value;
        if (age.length > 2) {
            age = age.slice(1, 2); 
        document.getElementById('age').value = age;
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
