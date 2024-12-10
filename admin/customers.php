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

$results_per_page = isset($_GET['entries']) ? (int)$_GET['entries'] : 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

// Get search query if exists
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Modify query to include search filter
if ($search_query != '') {
    $query = "SELECT * FROM booking WHERE Destination LIKE '%$search_query%' LIMIT $start_from, $results_per_page";
} else {
    $query = "SELECT * FROM booking LIMIT $start_from, $results_per_page";
}

$resultBooks = mysqli_query($conn, $query);

// Get total records for pagination with search
$total_query = "SELECT COUNT(*) as count FROM booking";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['count'];
$total_pages = ceil($total_records / $results_per_page);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../admin/css/administrators.css" />
    <link rel="stylesheet" href="../admin/css/book.css" />
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
          <h2>BOOKING SITE</h2>
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
              <h2><ion-icon name="calendar" style="margin-right: 8px;"></ion-icon>Book Details</h2>
              <form method="post" action="files.php">
                <input type="hidden" name="file_type" value="pdf">
                <button type="submit" name="download" class="btn btn-primary" value="pdf">Download PDF</button>
            </form>



            </div>
            <div class="info-group"><div>

    
                
                <?php

// Pagination settings
$results_per_page = isset($_GET['entries']) ? (int)$_GET['entries'] : 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

// Get search query if exists
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Modify query to include search filter
if ($search_query != '') {
    $query = "SELECT * FROM booking WHERE Destination LIKE '%$search_query%' LIMIT $start_from, $results_per_page";
} else {
    $query = "SELECT * FROM booking LIMIT $start_from, $results_per_page";
}

$resultBooks = mysqli_query($conn, $query);

// Get total records for pagination with search
$total_query = "SELECT COUNT(*) as count FROM booking";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['count'];
$total_pages = ceil($total_records / $results_per_page);
?>

</head>
<body>

<div class="table-container">
    <div class="table-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        Show 
        <select class="entries-selector" onchange="changeEntries(this.value)">
            <option value="5" <?php echo $results_per_page == 5 ? 'selected' : ''; ?>>5</option>
            <option value="15" <?php echo $results_per_page == 15 ? 'selected' : ''; ?>>15</option>
            <option value="25" <?php echo $results_per_page == 25 ? 'selected' : ''; ?>>25</option>
        </select> 
        entries
    </div>
    <div class="search-container">
                    <input type="text" class="search-box" placeholder="Search by Destination..." 
                           value="<?php echo htmlspecialchars($search_query); ?>" onkeyup="searchTable(this.value)">
                </div>
</div>

    </div>

    <?php if (mysqli_num_rows($resultBooks) > 0): ?>
        <table class="booking-table" id="bookingTable">
            <thead>
                <tr>
                    <td>#</td>
                    <td style="width: 15%; text-align: center;">DateTime</td>
                    <td style="width: 30%; text-align: center;">Package</td>
                    <td style="width: 15%; text-align: center;">Schedule</td>
                    <td style="width: 20%; text-align: center;">Email</td>
                    <td style="width: 10%; text-align: center;">Status</td>
                    <td style="width: 10%; text-align: center;">Action</td>
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
    <td style="text-align: center;"><?php echo date('Y-m-d H:i', strtotime($row['Date'])); ?></td>
    <td style="text-align: center;"><?php echo htmlspecialchars($row['Destination']); ?></td>
    <td style="text-align: center;"><?php echo date('Y-m-d', strtotime($row['schedule'])); ?></td>
    <td style="text-align: center;"><?php echo htmlspecialchars($row['Email']); ?></td>
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
    <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span></td>
    <td style="text-align: right;">
    <div class="action-dropdown">
    <button onclick="toggleDropdown(<?php echo $row['Bookid']; ?>)" class="action-btn">Action ▼</button>
    <div id="dropdown-<?php echo $row['Bookid']; ?>" class="dropdown-content">
        <a href="javascript:void(0)" onclick="openEditModal(<?php echo $row['Bookid']; ?>, '<?php echo $row['Status']; ?>')">Edit</a>
        <a href="javascript:void(0)" onclick="deleteBooking(<?php echo $row['Bookid']; ?>)">Delete</a>
    </div>
</div>

    </td>
</tr>

<?php endwhile; ?>

            </tbody>
        </table>






<!-- Modal for editing status -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Status</h2>
        <form method="POST" action="update_status.php">
    <input type="hidden" name="Bookid" id="Bookid">
    <select name="Status" id="Status">
        <option value="accepted">Accepted</option>
        <option value="done">Done</option>
        <option value="pending">Pending</option>
        <option value="rejected">Rejected</option>
    </select>
    <button type="submit">Update Status</button>
</form>


    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>






















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

        // Reset to page 1 for fresh search
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












function deleteBooking(bookId) {
    if (confirm("Are you sure you want to delete this booking?")) {
        // Perform the deletion using AJAX
        fetch(`delete_booking.php?Bookid=${bookId}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                const row = document.querySelector(`#row-${bookId}`);
                if (row) {
                    row.remove();
                }
                alert("Booking deleted successfully.");
            } else {
                alert("Error deleting booking: " + data.error);
            }
        })
        .catch(error => {
            alert("An error occurred: " + error.message);
        });
    }
}






function openEditModal(bookid, currentStatus) {
    document.getElementById('Bookid').value = bookid;
    document.getElementById('Status').value = currentStatus;
    document.getElementById('editModal').style.display = "block";
}


function closeModal() {
    document.getElementById('editModal').style.display = "none";
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
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="main.js"></script>
  </body>
</html>
