<?php
// Include your database connection
include('../connection.php');

// Fetch the image URL from the database
$query = "SELECT Homeimg FROM process WHERE id = 1"; // Modify the query as per your DB structure
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $Homeimg = $row['Homeimg'];
} else {
    // Handle query failure
    $Homeimg = ''; // Default image or handle error
}

// Set the Content-Type to CSS
header("Content-type: text/css");

// Output the CSS with the dynamic image URL
?>

hero-header {
    background: linear-gradient(rgba(20, 20, 31, 0.845), rgba(20, 20, 31, 0)), url('<?php echo $Homeimg; ?>');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
}
