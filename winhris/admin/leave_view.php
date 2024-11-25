<?php
require_once 'auth.php';
require_once 'db_connect.php';  // Include the database connection

// Check if the 'id' is passed via URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to fetch the employee leave record from the database using the ID
    $sql = "SELECT * FROM employee_leaves WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the record exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    } else {
        echo "No record found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Record</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-top: 40px;
        }

        /* Container for the form */
        .container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Form Container */
        .form-container {
            margin-bottom: 30px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #555;
        }

        .form-container input, .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .form-container input[disabled], .form-container textarea[disabled] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .form-container textarea {
            height: 120px;
            resize: vertical;
        }

        /* Button Styling */
        .form-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        /* Back Link */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        /* Back Link Styling */
.back-link {
    margin-top: 20px;
    text-align: center; /* Center the link */
}

/* Back Link Styling */
.back-link {
    text-align: center; /* Center the link horizontally */
    margin-top: 20px; /* Add some space above the link */
}

/* Back Button Styling */
.back-button {
    display: inline-block; /* Makes it behave like a block, but only takes up necessary width */
    padding: 12px 25px; /* Adds padding for better clickability */
    background-color: #555; /* Light blue background */
    color: white; /* White text */
    text-decoration: none; /* Removes the underline */
    border-radius: 30px; /* Rounded corners */
    font-size: 16px; /* Slightly larger text for readability */
    font-weight: 500; /* Medium weight text */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition for hover effects */
}

/* Back Button Hover Effect */
.back-button:hover {
    background-color: #ccc; /* Darker blue on hover */
    transform: translateY(-3px); /* Slight lift effect when hovering */
}

/* Optional: Focus Style for Accessibility */
.back-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.5); /* Subtle focus outline for accessibility */
}

    </style>
</head>
<body>

    <div class="container">
        <h1>Leave Record Details</h1>

        <div class="form-container">
            <form action="edit.php?id=<?php echo $row['id']; ?>" method="POST">
                <label for="full_name">Employee Name:</label>
                <input type="text" id="full_name" value="<?php echo $full_name; ?>" disabled>

                <label for="description">Description:</label>
                <textarea id="description" disabled><?php echo $row['description']; ?></textarea>

                <label for="reason">Reason for Leave:</label>
                <textarea id="reason" disabled><?php echo $row['reason']; ?></textarea>

                <label for="leave_from">Leave From:</label>
                <input type="date" id="leave_from" value="<?php echo $row['leave_from']; ?>" disabled>

                <label for="leave_to">Leave To:</label>
                <input type="date" id="leave_to" value="<?php echo $row['leave_to']; ?>" disabled>

                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" value="<?php echo $row['return_date']; ?>" disabled>

                <label for="status">Status:</label>
                <input type="text" id="status" value="<?php echo $row['status']; ?>" disabled>

                <label for="comment">Comment:</label>
                <textarea id="comment" disabled><?php echo $row['comment']; ?></textarea>
            </form>
        </div>

        <!-- Back to Employee List Link -->
        <div class="back-link">
    <a href="index.php" class="back-button">Back to Employee List</a>
</div>


</body>
</html>
