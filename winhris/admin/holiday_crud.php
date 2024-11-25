<?php
// Database Connection
require_once 'auth.php';
require_once 'db_connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission to add a new holiday
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    // Insert new holiday into the database
    $stmt = $conn->prepare("INSERT INTO holidays (name, date, description) VALUES (:name, :date, :description)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':description', $description);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Holiday added successfully!';
        header('Location: holiday_display.php'); // Redirect back to the holiday list
        exit();
    } else {
        $_SESSION['error'] = 'Failed to add holiday.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Holiday</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn {
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 90%;
            max-width: 500px;
            margin: 0 auto;
            opacity: 1;
            transition: opacity 0.5s ease-out;
            border-radius: 8px;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
        .cancel-btn {
            background-color: #f8d7da;
            color: #721c24;
        }
        .cancel-btn:hover {
            background-color: #f5c6cb;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Add New Holiday</h1>

    <!-- Display Success or Error Message -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" id="error-alert">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" id="success-alert">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Holiday Add Form -->
    <form action="holiday_crud.php" method="POST" id="holidayForm" onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="name" class="form-label">Holiday Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
            <div class="invalid-feedback">Please enter a holiday name.</div>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" name="date" id="date" required>
            <div class="invalid-feedback">Please select a date.</div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
            <div class="invalid-feedback">Please provide a description.</div>
        </div>
        <button type="submit" class="btn btn-primary">Add Holiday</button>
        <a href="holiday_display.php" class="btn cancel-btn ms-3">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS and custom validation script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Custom form validation
    function validateForm() {
        let isValid = true;
        const form = document.getElementById('holidayForm');
        const inputs = form.getElementsByClassName('form-control');
        
        for (let i = 0; i < inputs.length; i++) {
            if (!inputs[i].value) {
                inputs[i].classList.add('is-invalid');
                isValid = false;
            } else {
                inputs[i].classList.remove('is-invalid');
            }
        }
        return isValid;
    }

    // Function to show the success alert and auto-dismiss after 2 seconds
    window.onload = function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'block'; // Show alert
            setTimeout(function() {
                successAlert.style.opacity = 0; // Fade out alert
                setTimeout(function() {
                    successAlert.style.display = 'none'; // Hide alert completely
                }, 500); // Wait for fade-out to complete
            }, 2000); // Wait 2 seconds before hiding the alert
        }
    };

    // Function to make the alert fade out and disappear after 1.5 seconds
    setTimeout(function() {
        var errorAlert = document.getElementById('error-alert');
        var successAlert = document.getElementById('success-alert');

        if (errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s';
            errorAlert.style.opacity = '0';
            setTimeout(function() {
                errorAlert.style.display = 'none';
            }, 500);  // Wait for the fade-out transition
        }

        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 500);  // Wait for the fade-out transition
        }
    }, 1500);  // 1.5 seconds delay before fading out
</script>
</body>
</html>
