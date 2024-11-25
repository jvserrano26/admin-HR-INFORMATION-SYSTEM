<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Management</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header Styling */
        h1 {
            text-align: center;
            color: #444;
            margin-top: 40px;
            font-size: 2.5em;
        }

        /* Container for the Form */
        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Form Elements */
        .form-container label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        /* Focus and Disabled Input Styling */
        .form-container input:focus, .form-container textarea:focus, .form-container select:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-container textarea {
            height: 120px;
            resize: vertical;
        }

        /* Button Styling */
        .form-container button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        /* Search Bar Styling (if you plan to add a search functionality) */
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input {
            width: 80%;
            max-width: 600px;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h1 {
                font-size: 2em;
            }

            .form-container input, .form-container textarea, .form-container select {
                padding: 10px;
                font-size: 14px;
            }

            .form-container button {
                padding: 10px 20px;
                font-size: 14px;
            }

            .search-container input {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Main Container -->
    <div class="container">
        <h1>Request Form</h1>

        <!-- Add Leave Form -->
        <div class="form-container">
            <form action="add.php" method="POST">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" placeholder="First Name" required>

                <label for="middle_name">Middle Name:</label>
                <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Description" required></textarea>

                <label for="reason">Reason for Leave:</label>
                <textarea id="reason" name="reason" placeholder="Reason for Leave" required></textarea>

                <label for="leave_from">Leave From:</label>
                <input type="date" id="leave_from" name="leave_from" required>

                <label for="leave_to">Leave To:</label>
                <input type="date" id="leave_to" name="leave_to" required>

                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" name="return_date" required>

                <button type="submit">Request Leave</button>
            </form>
        </div>
    </div>

</body>
</html>
