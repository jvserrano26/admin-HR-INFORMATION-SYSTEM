<?php
require_once 'auth.php';
require_once 'db_connect.php';  // Include the database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the record
    $sql = "DELETE FROM employee_leaves WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect to the employee list after deletion
    header("Location: leave.php");
}
?>
