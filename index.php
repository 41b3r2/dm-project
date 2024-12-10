<?php
session_start();  // Make sure session is started
include "connection.php";
include 'css/homeimg.php';
if (!isset($_SESSION['Userid'])) {
    // Show the modal only if the user is not logged in
    include('modal.php');
} else {
    // User is logged in, show other content
    // echo "<p>Welcome, " . $_SESSION['Fname'] . "</p>";
}

$isLoggedIn = isset($_SESSION['Userid']);
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

    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
    <link href="css/homeimg.php">
    <link href="css/modal.css" rel="stylesheet">
    <script>
        // Pass PHP session login status to JavaScript
        var isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

        function openModal() {
            if (isLoggedIn) {
                alert("You are already logged in. Booking is enabled.");
                return;
            }
            // Modal open logic here (if any)
            alert("Modal opened.");
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
                    <a href="index.php" class="nav-item nav-link active">Home</a>
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

        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row justify-content-center py-5">
                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                        <h1 class="display-3 text-white mb-3 animated slideInDown">Enjoy Your Vacation With Us</h1>
                        <p class="fs-4 text-white mb-4 animated slideInDown">Discover the unspoiled beauty and adventure of Samar, where nature and culture come alive!</p>
                        <div class="position-relative w-75 mx-auto animated slideInDown">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    
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
                    <?php echo implode("<br>", $weltext2); ?>  
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
                    <a class="btn btn-primary py-3 px-5 mt-2" href="history.php">History of Samar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Services</h6>
                <h1 class="mb-5">Our Services</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5>Samar Tours</h5>
                            <div style="text-align: justify;">
                                <p><?php echo implode("<br>", $ourser1); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-hotel text-primary mb-4"></i>
                            <h5>Hotel Reservation</h5>
                            <div style="text-align: justify;">
                                <p><?php echo implode("<br>", $ourser2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-user text-primary mb-4"></i>
                            <h5>Travel Guides</h5>
                            <div style="text-align: justify;">
                                <p><?php echo implode("<br>", $ourser3); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-cog text-primary mb-4"></i>
                            <h5>Event Management</h5>
                            <div style="text-align: justify;">
                                <p><?php echo implode("<br>", $ourser4); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Destination Start -->
    <div class="container-xxl py-5 destination">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Destination</h6>
            <h1 class="mb-5">Popular Destination</h1>
        </div>
        <div class="row g-3 justify-content-center"> <!-- Center the row content -->
            <!-- First Column: Sohoton Cave -->
            <div class="col-lg-4 col-md-6">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                        <a class="position-relative d-block overflow-hidden" href="">
                            <img class="img-fluid" src='admin/<?php echo $popdes1; ?>' alt="Profile Picture">                                
                            <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">Basey, Samar</div>
                            <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">Sohoton Cave and Natural Bridge Park</div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Second Column: Langun-Gobingob Caves -->
            <div class="col-lg-4 col-md-6">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                        <a class="position-relative d-block overflow-hidden" href="">
                            <img class="img-fluid" src='admin/<?php echo $popdes2; ?>' alt="Profile Picture">  
                            <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">Calbiga, Samar</div>
                            <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">Langun-Gobingob Caves</div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Third Column: Ulot River Torpedo Boat Adventure -->
            <div class="col-lg-4 col-md-6">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                        <a class="position-relative d-block overflow-hidden" href="">
                            <img class="img-fluid" src='admin/<?php echo $popdes3; ?>' alt="Profile Picture">  
                            <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">Paranas, Samar</div>
                            <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">Ulot River Torpedo Boat Adventure</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Destination Start -->


    <!-- Package Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Packages</h6>
            <h1 class="mb-5">Awesome Packages</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $sql = "SELECT * FROM package LIMIT 6";  // Fetch only 6 records
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Echo each package
                    echo '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="package-item">
                                <div class="overflow-hidden">
                                    <img class="img-fluid" src="img/' . $row["Imagespot"] . '" alt="">
                                </div>
                                <div class="d-flex border-bottom">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i>' . $row["LocationSpot"] . '
                                    </small>
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-calendar-alt text-primary me-2"></i>' . $row["Days"] . ' days
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <i class="fa fa-user text-primary me-2"></i>' . $row["Person"] . ' Persons
                                    </small>
                                </div>
                                <div class="text-center p-4">
                                    <h3 class="mb-0">₱' . number_format($row['Price'], 2) . '</h3>
                                    <div class="mb-3">
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                    </div>
                                    <p style="font-size: 18px; color: #333; font-weight: bold; text-align: center;">Activities</p>
                                    <p>' . $row["Activity"] . '</p>
                                    <div class="d-flex justify-content-center mb-2">
                                        <a href="readmore.php?Locationid=' . $row['Locationid'] . '" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                        <a href="https://www.booking.com/region/ph/eastern-samar.en.html?aid=2276770&pagename=eastern-samar&label=msn-Mg6qExHUKndAfUX2Cwl9Lw-80127072754813:tikwd-80127261492782:loc-149:neo:mte:lp145635:dec:qssamar%20philippines%20%20hotels%20booking&utm_campaign=Region%20-%20Philippines&utm_medium=cpc&utm_source=bing&utm_term=Mg6qExHUKndAfUX2Cwl9Lw&msclkid=d2650679386a15ac7f696144aa4437f4" class="btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Book Now</a>
                                    </div>
                                </div>
                            </div>
                          </div>';
                }
            } else {
                echo '<p class="text-center">No packages available.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>
    <div class="col-12 text-center mt-4">
    <a href="package.php">
        <button id="seeMoreBtn" class="btn btn-primary">See More..</button>
    </a>
</div>

</div>
    <!-- Package End -->



    <!-- Process Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center pb-4 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Process</h6>
                <h1 class="mb-5">3 Easy Steps</h1>
            </div>
            <div class="row gy-5 gx-4 justify-content-center">
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow" style="width: 100px; height: 100px;">
                            <i class="fa fa-globe fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Choose A Destination</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">
                        <?php echo implode("<br>", $choices); ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow" style="width: 100px; height: 100px;">
                            <i class="fa fa-peso-sign fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Pay Online</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">
                            <?php echo implode("<br>", $payments); ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow" style="width: 100px; height: 100px;">
                            <i class="fa fa-plane fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Fly Today</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">
                        <?php echo implode("<br>", $flights); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Process Start -->


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


    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Clients Say!!!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item bg-white text-center border p-4">
                    <img class="bg-white rounded-circle shadow p-1 mx-auto mb-3" src="img/testimonial-1.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">John Doe</h5>
                    <p>New York, USA</p>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-white text-center border p-4">
                    <img class="bg-white rounded-circle shadow p-1 mx-auto mb-3" src="img/testimonial-2.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">John Doe</h5>
                    <p>New York, USA</p>
                    <p class="mt-2 mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-white text-center border p-4">
                    <img class="bg-white rounded-circle shadow p-1 mx-auto mb-3" src="img/testimonial-3.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">John Doe</h5>
                    <p>New York, USA</p>
                    <p class="mt-2 mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-white text-center border p-4">
                    <img class="bg-white rounded-circle shadow p-1 mx-auto mb-3" src="img/testimonial-4.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">John Doe</h5>
                    <p>New York, USA</p>
                    <p class="mt-2 mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
        

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