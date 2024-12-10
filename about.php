<?php
session_start();  // Make sure session is started
include 'css/homeimg.php';

if (!isset($_SESSION['Userid'])) {
    // Show the modal only if the user is not logged in
    include('modal.php');
} else {
    // User is logged in, show other content
    // echo "<p>Welcome, " . $_SESSION['Fname'] . "</p>";
}
$sql = "SELECT * FROM package";
$result = $conn->query($sql);

$sql = "SELECT * FROM process";
$resultProcess = $conn->query($sql);

$choices = [];
$payments = [];
$flights = [];

$weltext1 = [];
$weltext2 = [];

$subtext1 = [];
$subtext2 = [];
$subtext3 = [];
$subtext4 = [];
$subtext5 = [];
$subtext6 = [];
    
$ourser1 = [];
$ourser2 = [];
$ourser3 = [];
$ourser4 = [];

    if ($resultProcess->num_rows > 0) {
        while ($row = $resultProcess->fetch_assoc()) {
            $choices[] = $row["Choose"];
            $payments[] = $row["Pay"];
            $flights[] = $row["Fly"];
            $weltext1[] = $row["weltext1"];
            $weltext2[] = $row["weltext2"];
            
            $subtext1[] = $row["subtext1"];
            $subtext2[] = $row["subtext2"];
            $subtext3[] = $row["subtext3"];
            $subtext4[] = $row["subtext4"];
            $subtext5[] = $row["subtext5"];
            $subtext6[] = $row["subtext6"];
            
            $ourser1[] = $row["ourser1"];
            $ourser2[] = $row["ourser2"];
            $ourser3[] = $row["ourser3"];
            $ourser4[] = $row["ourser4"];
        }
    } else {
        $choices[] = "Empty.";
        $payments[] = "Empty.";
        $flights[] = "Empty.";
        $weltext1[] = "Empty.";
        $weltext2[] = "Empty.";
        
        $subtext1[] = "Empty.";
        $subtext2[] = "Empty.";
        $subtext3[] = "Empty.";
        $subtext4[] = "Empty.";
        $subtext5[] = "Empty.";
        $subtext6[] = "Empty.";
        
        $ourser1[] = "Empty.";
        $ourser2[] = "Empty.";
        $ourser3[] = "Empty.";
        $ourser4[] = "Empty.";
    }


    $Processid = filter_input(INPUT_GET, 'Processid', FILTER_VALIDATE_INT) ?: 1;

// PDO database connection with improved security
try {
    // Use environment variables or a secure configuration file for credentials
    $pdo = new PDO("mysql:host=localhost;dbname=sql_db;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Log the error instead of displaying sensitive information
    error_log("Database Connection Error: " . $e->getMessage());
    die("A database error occurred.");
}

// Prepare and execute query with parameterized statement
try {
    $sqlimg = "SELECT popdes1, popdes2, popdes3, popdes4 FROM process WHERE Processid = :Processid";
    $stmt = $pdo->prepare($sqlimg);
    $stmt->bindParam(':Processid', $Processid, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the row safely
    if ($row = $stmt->fetch()) {
        // Sanitize image paths before output
        $popdes1 = htmlspecialchars($row['popdes1'], ENT_QUOTES, 'UTF-8');
        $popdes2 = htmlspecialchars($row['popdes2'], ENT_QUOTES, 'UTF-8');
        $popdes3 = htmlspecialchars($row['popdes3'], ENT_QUOTES, 'UTF-8');
        $popdes4 = htmlspecialchars($row['popdes4'], ENT_QUOTES, 'UTF-8');

        // Output images with proper escaping
        // echo "<img src='admin/" . $popdes1 . "' alt='Image 1'>";
        // Add more image outputs as needed
    } else {
        echo "No images found for the given Process ID.";
    }
} catch (PDOException $e) {
    // Log query errors
    error_log("Query Error: " . $e->getMessage());
    echo "An error occurred while retrieving images.";
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
    <link href="css/homeimg.php">
    <script>
        window.onload = function() {
            // Check if there's a 'success' or 'error' message in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const successMessage = urlParams.get('success');
            const errorMessage = urlParams.get('error');
            
            if(successMessage) {
                alert(successMessage); // Display success message
            }
            if(errorMessage) {
                alert(errorMessage); // Display error message
            }
        }
    </script>
</head>

<body>
<?php include('modal.php'); ?>
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
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>It's Samar Time!</h1>
                <!-- <img src="img/logo.png" alt="Logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link active">About</a>
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

        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row justify-content-center py-5">
                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                        <h1 class="display-3 text-white animated slideInDown">About Us</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                                <li class="breadcrumb-item text-white active" aria-current="page">About</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->
<!-- Modal Start -->
    <div class="modal" id="authModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeModal()">&times;</button>
            
            <!-- Login Form -->
            <div class="form-container" id="loginForm">
                <h2>Login</h2>
                <form action="userlogin.php" method="POST">
                    <div class="form-group">
                        <label for="loginEmail">Email</label>
                        <input type="email" id="loginEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" required>
                    </div>
                    <button type="submit" class="submit-btn">Login</button>
                </form>
                <div class="switch-form">
                    <a href="#" onclick="toggleForm()">Don't have an account? Register here</a>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="form-container" id="registerForm" style="display: none;">
                <h2>Register</h2>
                <form action="#" method="POST">
                    <div class="form-container1">
                        <div class="form-group1">
                            <label for="registerName1">First Name</label>
                            <input type="text" id="registerName1" name="name1" required>
                        </div>
                        <div class="form-group1">
                            <label for="registerName2">Middle Name</label>
                            <input type="text" id="registerName2" name="name2" required>
                        </div>
                        <div class="form-group1">
                            <label for="registerName2">Last Name</label>
                            <input type="text" id="registerName2" name="name2" required>
                        </div>
                    </div>
                    <div class="form-container1">
                        <div class="form-group1">
                            <label for="registerName1">Email</label>
                            <input type="text" id="registerName1" name="name1" required>
                        </div>
                        <div class="form-group1">
                            <label for="registerName2">Phone Number</label>
                            <input type="text" id="registerName2" name="name2" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Complete Address</label>
                        <input type="email" id="registerEmail" name="email" required>
                    </div>
                    <div class="form-container1">
                        <div class="form-group1">
                            <label for="registerName1">Password</label>
                            <input type="text" id="registerName1" name="name1" required>
                        </div>
                        <div class="form-group1">
                            <label for="registerName2">Confirm Password</label>
                            <input type="text" id="registerName2" name="name2" required>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">Register</button>
                </form>
                <div class="switch-form">
                    <a href="#" onclick="toggleForm()">Already have an account? Login here</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                    <img src="img/logo.png" alt="Admin Logo" style="width: 100%; height: 100%; border-radius: 50%; filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 5));">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Welcome to <span class="text-primary">Samar</span></h1>
                    <p class="mb-4">
                    <?php echo implode("<br>", $weltext1); ?>
                    </p>
                    <p class="mb-4">
                        Discover Samar like never before with guides who know every story and every secret of this paradise. We promise to make your experience safe, fun, and full of excitement, as we share the beauty and history of our beloved island. Let us show you the true spirit of Samar and why it’s a destination worth exploring!
                    </p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>
                            <?php echo implode("<br>", $subtext1); ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>
                            <?php echo implode("<br>", $subtext2); ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>
                            <?php echo implode("<br>", $subtext3); ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>
                            <?php echo implode("<br>", $subtext4); ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>
                            <?php echo implode("<br>", $subtext5); ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>
                            <?php echo implode("<br>", $subtext6); ?>
                            </p>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">History of Samar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Team Start -->
    <?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sql_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the admin table
$sql = "SELECT Adminid, Fname, Mname, Lname, Email, Profilepic FROM admin";
$result = $conn->query($sql);
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Travel Guide</h6>
            <h1 class="mb-5">Meet Our Guide</h1>
        </div>
        <div class="row g-4">
            <?php
            if ($result->num_rows > 0) {
                $count = 0; // Counter for rows
                while ($row = $result->fetch_assoc()) {
                    $fullname = $row['Fname'] . ' ' . $row['Mname'] . ' ' . $row['Lname'];
                    $profilepic = !empty($row['Profilepic']) ? $row['Profilepic'] : 'default.jpg'; // Fallback image

                    // Open a new row if it's the first item or after every 3 items
                    if ($count % 3 == 0 && $count != 0) {
                        echo '</div><div class="row g-4">';
                    }
            ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" 
     data-wow-delay="0.<?= $count * 2 + 1 ?>s" 
     style=" border-radius: 10px; padding: 20px; margin: 5px 0;">
    <br>
    <div class="team-item">
        <div class="overflow-hidden">
            <img class="img-fluid" 
                 style="object-fit: cover;" 
                 src="admin/<?= $profilepic ?>" alt="Profile Picture">
        </div>
        <div class="position-relative d-flex justify-content-center" 
             style="margin-top: -19px;">
            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
        </div>
        <div class="text-center p-4">
            <h5 class="mb-0"><?= htmlspecialchars($fullname) ?></h5>
            <small><?= htmlspecialchars($row['Email']) ?></small>
        </div>
    </div>
</div>

            <?php
                    $count++;
                }
            } else {
                echo "<p>No admins found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>
    <!-- Team End -->
        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Company</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Location, Samar, Philippines</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>its.samar.time@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/package-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/package-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/package-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/package-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/package-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/package-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; IT'S SAMAR TIME, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


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