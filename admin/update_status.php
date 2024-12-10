<?php
session_start();
include "../connection.php";

if (isset($_POST['Bookid']) && isset($_POST['Status'])) {
    $Bookid = $_POST['Bookid'];
    $Status = $_POST['Status'];

    // Update the status in the database
    $query = "UPDATE booking SET Status = ? WHERE Bookid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $Status, $Bookid);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status.";
    }
} else {
    echo "Missing required data.";
}
?>
