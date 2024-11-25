<?php
// Include the database connection
require_once 'db_connect.php';

// Check if 'id' is passed in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM `announcements` WHERE id = ?";

    // Prepare and execute the query
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id); // Bind the id to the prepared statement
        if($stmt->execute()) {
            // If deletion was successful, send success message
            echo json_encode(["status" => 1, "msg" => "Announcement deleted successfully."]);
        } else {
            // If something went wrong
            echo json_encode(["status" => 0, "msg" => "Failed to delete announcements."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => 0, "msg" => "Query preparation failed."]);
    }

    // Close the connection
    $conn->close();
} else {
    // If no id is provided
    echo json_encode(["status" => 0, "msg" => "Invalid request."]);
}
?>
