<?php
require_once 'auth.php';
require_once 'db_connect.php'; // Include your database connection

// Handle search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM employee_leaves 
          WHERE first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ?";
$stmt = $conn->prepare($query);
$searchParam = "%{$search}%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Management</title>
    <?php include('header.php') ?>
    <style>
        /* General styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        h1, h2 {
            text-align: center;
            color: #444;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input {
            padding: 10px;
            width: 60%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            text-align: left;
            background-color: #fafafa;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        tr:hover td {
            background-color: #e9ecef;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons a {
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .action-buttons a.view {
            background-color: #28a745;
        }

        .action-buttons a.edit {
            background-color: #ffc107;
        }

        .action-buttons a.delete {
            background-color: #dc3545;
        }

        .action-buttons a:hover {
            opacity: 0.8;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .search-container input, .search-container button {
                width: 100%;
                margin-bottom: 15px;
            }

            table {
                font-size: 14px;
            }
        }

    </style>
</head>
<body>

<div id="mySidebar" class="sidebar">
		
		<?php include 'nav_bar.php' ?>
	  </div>

   
	   <div  id="main" class = "container-fluid admin" >
       <div style="background-color: #1c2b52;">
        <button class="openbtn" onclick="toggleNav()" style="background-color: #1c2b52;">☰ </button>  
		<iframe src="https://free.timeanddate.com/clock/i9n9b8eh/n145/fcfff/tc1c2b52" frameborder="0" width="115" height="18"></iframe>
        </div>
    
        <h1  class="py-4 px-4 fs-1" style="font-size: 40px;font-weight: bold ;">Employee Leave </h1>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="index.php" method="GET">
                <input type="text" name="search" placeholder="Search by Employee Name..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Leave Records Table -->
        <h2>Leave Records</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Description</th>
                <th>Reason</th>
                <th>Leave From</th>
                <th>Leave To</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
            <?php
             

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                    echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>{$full_name}</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>" . htmlspecialchars($row['reason']) . "</td>
                        <td>" . htmlspecialchars($row['leave_from']) . "</td>
                        <td>" . htmlspecialchars($row['leave_to']) . "</td>
                        <td>" . htmlspecialchars($row['return_date']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['comment']) . "</td>
                        <td class='action-buttons'>
                            <a href='leave_view.php?id=" . htmlspecialchars($row['id']) . "' class='view'>View</a>
                            <a href='leave_edit.php?id=" . htmlspecialchars($row['id']) . "' class='edit'>Edit</a>
                            <a href='leave_delete.php?id=" . htmlspecialchars($row['id']) . "' onclick=\"return confirm('Are you sure you want to delete this record?');\" class='delete'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='10' style='text-align:center;'>No records found.</td></tr>";
            }
            ?>
        </table>
    </div>
        
        

    <script>
        function toggleNav() {
				var sidebar = document.getElementById("mySidebar");
				var mainContent = document.getElementById("main");
				var openBtn = document.querySelector(".openbtn");

				// Toggle sidebar visibility
				if (sidebar.style.width === "250px") {
					// If sidebar is open, close it
					sidebar.style.width = "0";
					mainContent.style.marginLeft = "0";
					openBtn.textContent = "☰"; // Change button text to "Open"
				} else {
					// If sidebar is closed, open it
					sidebar.style.width = "250px";
					mainContent.style.marginLeft = "250px";
					openBtn.textContent = "✖"; // Change button text to "Close"
				}
			}
    </script>
</body>
</html>
