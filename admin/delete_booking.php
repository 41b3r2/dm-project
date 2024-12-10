<?php
if (isset($_GET['Bookid'])) {
    $bookId = intval($_GET['Bookid']);

    // Database connection
    include '../connection.php';

    $query = "DELETE FROM booking WHERE Bookid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "No Bookid provided."]);
}
?>
