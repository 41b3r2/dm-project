<?php
include_once 'connection.php';
// Get image path from the database
$sql = "SELECT Homeimg FROM process LIMIT 1"; // Assuming you only need one result
$resultProcess = $conn->query($sql);

$homeImageURL = '';  // Default to empty

// Check if there's any result
if ($resultProcess->num_rows > 0) {
    $row = $resultProcess->fetch_assoc();
    if (!empty($row['Homeimg'])) {
        $homeImageURL = 'admin/' . $row['Homeimg'];
        // Check if file exists
        if (!file_exists($homeImageURL)) {
            echo "Warning: Image file does not exist at: " . $homeImageURL . "<br>";
            $homeImageURL = '';  // Reset if file is missing
        }
    }
} else {
    echo "No image found in the database.";
}

// Output the style block with the dynamic image URL
?>
<style>
.hero-header {
    background: linear-gradient(rgba(20, 20, 31, 0.845), rgba(20, 20, 31, 0)),
                url('<?php echo htmlspecialchars($homeImageURL ? $homeImageURL : 'images/default-image.jpg'); ?>') !important;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 300px; /* Add a minimum height to ensure visibility */
}
</style>
