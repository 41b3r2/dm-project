<?php
session_start();
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

if (!isset($_SESSION['Userid'])) {
    header('Location: index.php');
    exit;
}

$Userid = $_SESSION['Userid'];

// Fetch user details
$query = "SELECT * FROM user WHERE Userid = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$Userid]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Profilepic = $user['Profilepic'];
    $currentPassword = $_POST['Password'];
    $newPassword = $_POST['newPassword'];     
    $confirmPassword = $_POST['confirmPassword'];

    // Check if current password matches the one in the database
    if ($currentPassword !== $user['Password']) {
        $error = "Current password is incorrect.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirmation password do not match.";
    } else {

        // Hash the new password before storing it
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        if (isset($_FILES['Profilepic']) && $_FILES['Profilepic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'img/users/';
            $uploadFile = $uploadDir . basename($_FILES['Profilepic']['name']);

            if (move_uploaded_file($_FILES['Profilepic']['tmp_name'], $uploadFile)) {
                $Profilepic = $uploadFile;
            }
        }

        // Update the user profile with the new password and profile picture
        $updateQuery = "UPDATE user SET Profilepic = ?, Password = ? WHERE Userid = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$Profilepic, $hashedPassword, $Userid]);

        header('Location: profile.php?id=' . $_SESSION['Userid']);
        exit;
    }
}
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




<div class="container mt-2">
    <div class="shadow-lg">
        <div class="card-body px-5 py-4">
            <form method="POST" enctype="multipart/form-data">
                <!-- Profile Picture Section -->
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        <img 
                            src="<?php echo $user['Profilepic'] ? $user['Profilepic'] : 'img/default-user.jpg'; ?>" 
                            alt="Profile Picture" 
                            class="rounded-circle shadow-sm border mb-2 img-thumbnail" 
                            style="width: 120px; height: 120px; object-fit: cover;"
                        >
                        <label for="Profilepic" class="position-absolute bottom-0 start-50 translate-middle-x bg-primary text-white rounded-circle shadow-sm" 
                            style="width: 32px; height: 32px; line-height: 32px; text-align: center; cursor: pointer;">
                            <i class="bi bi-camera"></i>
                        </label>
                        <input 
                            type="file" 
                            class="form-control d-none" 
                            id="Profilepic" 
                            name="Profilepic"
                            onchange="document.querySelector('label[for=Profilepic] + img').src = window.URL.createObjectURL(this.files[0]);"
                        >
                    </div>
                    <p class="text-muted small">Click the camera icon to update</p>
                </div>

                <!-- Update password Section -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control shadow-sm" id="currentPassword" name="Password" required>
                    </div>
                    <div class="col-md-4">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control shadow-sm" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="col-md-4">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control shadow-sm" id="confirmPassword" name="confirmPassword" required>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">Update Password</button>  
                    <button class="btn btn-primary px-4 py-2 shadow-sm" onclick="window.location.href='profile.php?id=<?php echo $_SESSION['Userid']; ?>'">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<style>
    /* Custom Styling */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #68B2A0;
        box-shadow: 0 0 5px rgba(37, 117, 252, 0.6);
    }

    button.btn-primary {
        background-color: #68B2A0;
        border: none;
    }

    button.btn-primary:hover {
        background-color: #2C6975;
    }

    .bi-camera {
        font-size: 1.2rem;
    }
</style>



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
