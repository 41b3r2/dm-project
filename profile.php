<?php
session_start();
include 'css/homeimg.php';
include "connection.php";
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
if (!isset($_SESSION['Userid']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}
if (isset($_SESSION['Userid'])) {
    $Userid = $_SESSION['Userid'];
    $query = "SELECT Profilepic FROM user WHERE Userid = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$Userid]);
    $user = $stmt->fetch();
    $Profilepic = $user['Profilepic'] ? $user['Profilepic'] : 'img/default-user.jpg';
}

if (!isset($_SESSION['Userid']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['Userid'])) {
    // Show the modal only if the user is not logged in
    include('modal.php');
} else {
    // User is logged in, show other content
    // echo "<p>Welcome, " . $_SESSION['Fname'] . "</p>";
}

// Get admin ID from URL parameter
$Userid = isset($_GET['id']) ? $_GET['id'] : $_SESSION['AdminId'];

// Query to get admin details
$sql = "SELECT * FROM user WHERE Userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WELCOME SA SAMAR!</title>
    <link rel="icon" href="img/logo.png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/css/profile.css" />
    <link href="css/homeimg.php">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <small class="me-3 text-light"><i class="fa fa-map-marker-alt me-2"></i>Location, Samar, Philippines</small>
                    <small class="me-3 text-light"><i class="fa fa-phone-alt me-2"></i>+012 345 6789</small>
                    <small class="text-light"><i class="fa fa-envelope-open me-2"></i>its.samar.time@gmail.com</small>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-twitter fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-linkedin-in fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle" href=""><i class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0" style="background: linear-gradient(to right, #333333, #B2C7B4, #333333); backdrop-filter: blur(20px);">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>It's Samar Time</h1>
                <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="service.php" class="nav-item nav-link">Services</a>
                <a href="package.php" class="nav-item nav-link">Packages</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="destination.php" class="dropdown-item">Destination</a>
                        <a href="booking.php" class="dropdown-item">Booking Packages</a>
                        <?php if(isset($_SESSION['Userid'])) {
                            echo '<a href="bookmanage.php?id=' . $_SESSION['Userid'] . '" class="dropdown-item">Book Manage</a>';
                        }
                        ?>
                        <a href="team.php" class="dropdown-item">Travel Guides</a>
                        <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                        <a href="404.php" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>

            <?php if (!isset($_SESSION['Userid'])): ?>
                <button class="modal-btn btn btn-primary rounded-pill py-2 px-4" onclick="openModal()">Sign In</button>
            <?php else: ?>
                <a href="profile.php?id=<?php echo $_SESSION['Userid']; ?>" class="btn btn-primary rounded-pill py-2 px-4">Go to Profile</a>
                <a href="Logout.php" class="nav-item nav-link">Logout</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="py-5 mb-4"></div>
</div>
    <!-- Navbar & Hero End -->

    <div style="background: white; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.01); max-width: 83%; padding: 20px; margin: 0 auto; ">
        <div style="display: flex; justify-content: space-between; width: 100%; padding: 8px;">
            <h2>Welcome <?php echo $user['Fname']; ?></h2>
            <a href="editprofile.php?id=<?php echo $_SESSION['Userid']; ?>" style="
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
                Manage Profile
            </a>
        </div>
        <div class="profile-section">
            <div class="profile-container">
            <div class="profile-details">
                <div class="profile-image-container">
                    <div class="profile-image">
                        <img src="<?php echo $user['Profilepic']; ?>" alt="Admin Profile Picture">
                    </div>
                </div>

        <div style="width: 100%; display: flex; flex-direction: column; justify-content: center; gap: 16px; text-align: left;">
            <div class="info-group">
                <div class="info-label">Full Name</div>
                <div class="name-value">
                    <?php echo $user['Fname'] . ' ' . $user['Mname'] . ' ' . $user['Lname']; ?>
                </div>
                <div class="info-label">Contact Details</div>
                <div class="info-value">
                    <ion-icon name="mail"></ion-icon>
                    <?php echo $user['Email']; ?>
                </div>
                <div class="info-value">
                    <ion-icon name="call"></ion-icon>
                    <?php echo $user['ContactNo']; ?>
                </div>
            </div>
        </div>
    </div>
    <hr style="margin-bottom: -20px;">
    <div class="contact-info">
        <div class="info-group">
            <div class="info-label">Birthday</div>
                <div class="info-value">
                    <ion-icon name="calendar"></ion-icon>
                    <?php echo $user['Birthday']; ?>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Gender</div>
                <div class="info-value">
                    <ion-icon name="people"></ion-icon>
                    <?php echo $user['Gender']; ?>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Age</div>
                <div class="info-value">
                    <ion-icon name="person"></ion-icon>
                    <span id="age">Years Old</span>
                </div>
            </div>
            
        </div>
        <div class="info-group">
            <div class="info-label">Complete Address</div>
            <div class="info-value">
                <ion-icon name="location"></ion-icon>
                <?php echo $user['Address']; ?>
            </div>
        </div>
        </div>
        </div>
        </div>
        


    <script>
        const birthDate = new Date('<?php echo $user["Birthday"]; ?>');
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
    



    <br> <br>


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script>
        function openModal() {
            document.getElementById('authModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        function closeModal() {
            document.getElementById('authModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        function toggleForm() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('authModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>