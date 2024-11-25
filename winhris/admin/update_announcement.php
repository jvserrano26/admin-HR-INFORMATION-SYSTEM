<?php
require_once 'db_connect.php';

if (isset($_POST['announcement_id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['status'])) {
    $announcement_id = $_POST['announcement_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // SQL query to update announcement
    $sql = "UPDATE announcements SET title = ?, description = ?, status = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $title, $description, $status, $announcement_id);
        if ($stmt->execute()) {
            // Success response
            echo json_encode(['status' => 1, 'msg' => 'Announcement updated successfully.']);
        } else {
            // Error response
            echo json_encode(['status' => 0, 'msg' => 'Failed to update announcement.']);
        }
    } else {
        // Error response
        echo json_encode(['status' => 0, 'msg' => 'Error in preparing SQL query.']);
    }
} else {
    echo json_encode(['status' => 0, 'msg' => 'Required fields are missing.']);
}

$conn->close();
?>
