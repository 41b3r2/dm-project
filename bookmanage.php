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
    include('modal.php');
} else {
}

$Userid = isset($_GET['id']) ? $_GET['id'] : $_SESSION['AdminId'];

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
    <link href="css/bookm.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/css/profile.css" />
    <link href="css/homeimg.php">
    <style>
        .status-badge.maroon {
    background-color: maroon;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}

.status-badge.green {
    background-color: green;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}

.status-badge.blue {
    background-color: blue;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}

.status-badge.red {
    background-color: red;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}

.status-badge.default {
    background-color: gray;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
</style>
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
    <div class="py-5 mb-4"></div>
</div>
    <!-- Navbar & Hero End -->

<div class="profile-container">
    <div class="contact-info">
        <div class="info-group"><div>
        <div style="display: flex; justify-content: space-between; width: 100%; padding: 8px;">
            <div class="info-label"><ion-icon name="calendar" style="margin-right: 8px;"></ion-icon>Book Details</div>
                    <a href="profile.php?id=<?php echo $_SESSION['Userid']; ?>" style="
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
                Profile
            </a>
        </div>
        <?php
        $results_per_page = isset($_GET['entries']) ? (int)$_GET['entries'] : 5;
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start_from = ($current_page - 1) * $results_per_page;

        $search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

        $where_clause = "WHERE Userid = '$Userid'";
        if (!empty($search_query)) {
            $where_clause .= " AND (
                Date LIKE '%$search_query%' OR 
                Destination LIKE '%$search_query%' OR 
                schedule LIKE '%$search_query%' OR 
                Status LIKE '%$search_query%'
            )";
        }

        $query = "SELECT * FROM booking $where_clause LIMIT $start_from, $results_per_page";
        $resultBooks = mysqli_query($conn, $query);

        // Get total records for pagination with search
        $total_query = "SELECT COUNT(*) as count FROM booking $where_clause";
        $total_result = mysqli_query($conn, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total_records = $total_row['count'];
        $total_pages = ceil($total_records / $results_per_page);
        ?>

        
    <div class="table-container">
        <div class="table-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div> Show 
                <select class="entries-selector" onchange="changeEntries(this.value)">
                    <option value="5" <?php echo $results_per_page == 5 ? 'selected' : ''; ?>>5</option>
                    <option value="15" <?php echo $results_per_page == 15 ? 'selected' : ''; ?>>15</option>
                    <option value="25" <?php echo $results_per_page == 25 ? 'selected' : ''; ?>>25</option>
                </select> 
                entries
            </div>
        <div>
            <input type="text" class="search-box" placeholder="Search:" 
                value="<?php echo htmlspecialchars($search_query); ?>" 
                onkeyup="searchTable(this.value)">
        </div>
    </div>
</div>

    <?php if (mysqli_num_rows($resultBooks) > 0): ?>
        <table class="booking-table" id="bookingTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 20%;">DateTime</th>
                    <th style="width: 20%;">Package</th>
                    <th style="width: 20%;">Schedule</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = $start_from + 1;
                while ($row = mysqli_fetch_assoc($resultBooks)): 
                    $status_class = strtolower($row['Status']) == 'done' ? 'status-done' : '';
                ?>
                        <tr id="row-<?php echo $row['Bookid']; ?>">
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($row['Date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['Destination']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['schedule'])); ?></td>
                            <?php 
                            $status = $row['Status'];
                                switch ($status) {
                                    case 'Pending':
                                        $status_class = 'maroon';
                                        break;
                                    case 'Accepted':
                                        $status_class = 'green';
                                        break;
                                    case 'Done':
                                        $status_class = 'blue';
                                        break;
                                    case 'Rejected':
                                        $status_class = 'red';
                                        break;
                                    default:
                                        $status_class = 'default';
                                        break;
                                }
                            ?>
                            <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $row['Status']; ?></span></td>
                            <td style="text-align: right;">
                                <div class="action-dropdown">
                                    <button onclick="toggleDropdown(<?php echo $row['Bookid']; ?>)" class="action-btn">Action ▼</button>
                                    <div id="dropdown-<?php echo $row['Bookid']; ?>" class="dropdown-content">
                                        <a href="edit.php?Bookid=<?php echo $row['Bookid']; ?>">Edit</a>
                                        <a href="javascript:void(0)" onclick="cancelBooking(<?php echo $row['Bookid']; ?>)">Cancel</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="pagination">
                <div>
                    Showing <?php echo $start_from + 1; ?> to 
                    <?php echo min($start_from + $results_per_page, $total_records); ?> of 
                    <?php echo $total_records; ?> entries
                </div>
                <div>
                    <?php if ($current_page > 1): ?>
                        <a href="javascript:void(0)" onclick="changePage(<?php echo $current_page - 1; ?>)" class="page-nav">Previous</a>
                    <?php endif; ?>

                    <button class="action-btn page-number"><?php echo $current_page; ?></button>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="javascript:void(0)" onclick="changePage(<?php echo $current_page + 1; ?>)" class="page-nav">Next</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
                <p>No bookings found.</p>
            <?php endif; ?>
        </div>

<script>
let searchTimeout = null;

function searchTable(query) {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    // Store the current scroll position
    scrollPosition = window.scrollY;

    searchTimeout = setTimeout(() => {
        const urlParams = new URLSearchParams(window.location.search);

        if (query) {
            urlParams.set('search', query);
        } else {
            urlParams.delete('search');
        }
        urlParams.set('page', '1');
        window.location.href = '?' + urlParams.toString();
    }, 500);
}

// You can call this function to restore the scroll position after a page load or query change
window.onload = function() {
    window.scrollTo(0, scrollPosition);
};


function changeEntries(entries) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('entries', entries);
    urlParams.set('page', '1');
    window.location.href = '?' + urlParams.toString();

    // Scroll to bottom after modifying the entries
    scrollToBottom();
}

// Auto-scroll to bottom function
function scrollToBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
}


function changePage(page) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('page', page);
    window.location.href = '?' + urlParams.toString();
}

// Auto-scroll to bottom function
function scrollToBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
}

// Call scrollToBottom if a search query exists
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search') && urlParams.get('search').trim() !== '') {
        scrollToBottom();
    }
}

// Close all dropdowns when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.action-btn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

// Function to toggle the dropdown visibility
function toggleDropdown(bookId) {
    const dropdown = document.getElementById(`dropdown-${bookId}`);
    if (dropdown) {
        // Toggle 'show' class to display or hide the dropdown
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
}

// Function to handle booking cancellation
function cancelBooking(bookId) {
    if (confirm('Are you sure you want to cancel this booking?')) {
        // Perform cancellation logic (e.g., send AJAX request or redirect)
        console.log(`Booking with ID ${bookId} cancelled.`);
        // Example: Redirect to a PHP script for handling cancellation
        window.location.href = `cancel.php?Bookid=${bookId}`;
    }
}

</script>

<?php
// Close database connection
$conn->close();
?>
</div>
</div>
    </div>
</div>
<br>
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
    



    <br> <br><br>


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