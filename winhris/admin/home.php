<?php
    include 'auth.php';  // Authentication logic
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard | Simple Employee Attendance Record System</title>
    <?php include 'header.php'; ?>
    <!-- Include Bootstrap CSS (optional, if not already included in header.php) -->
	 
	 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uc7IeQ+7hPVx1q/KxYjw9I6b2ohhMD6GF7zU6B05O0hF3sF8kWX1l" crossorigin="anonymous">
    <link rel = "stylesheet" type = "text/css" href = "../assets/css/style.css" /> <!-- Custom Styles -->
	<?php include 'header.php'; ?>
</head>
<style>
	body{
		ackground-image: linear-gradient(to bottom right,rgba(70, 195, 236, 0.836), rgb(250, 250, 248));
		background-color: #ccc8c6;
	}
	#table {
    border-collapse: collapse; /* Ensures proper border styling */
}

#table th, #table td {
    border-bottom: 1px solid #343a40; /* Darker bottom border (dark grey/black) */
}

#table th {
    border-top: 2px solid #343a40; /* Optional: Dark top border for header */
}
.custom-height {
	margin-left: 10px;
    height: 200px; /* You can set this to any specific height you need */
  
}

</style>
<body>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <?php include 'nav_bar.php'; ?>
    </div>

    <!-- Main content -->
    <div id="main" class="container-fluid admin">
        <!-- Toggle Button -->
		 <div style="background-color: #1c2b52;">
        <button class="openbtn" onclick="toggleNav()" style="background-color: #1c2b52;">☰ </button>  
		<iframe src="https://free.timeanddate.com/clock/i9n9b8eh/n145/fcfff/tc1c2b52" frameborder="0" width="115" height="18"></iframe>
        </div>
        <!-- Page Header -->
        <div class="display-3 text-center mt-4" style="color: #6699CC;font-size: 60px;">Dashboard</div>
        <h5 class="text-center">Welcome, <?php echo ucwords($user_name); ?>!</h5>
           
		
        <!-- Dashboard Stats Cards -->
        <div class="container mt-4">
            <div class="row" >

            <!-- Employees Column -->
<div class="col-md-4 col-lg-4 col-xl-4">
    <div class="card text-white bg-white mb-3" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;box-shadow: 5px 5px 5px grey;border: grey 1px solid">
        <div class="card-header text-white h3" style="background-color: #1c2b52;">Employees  📋</div>
        <div class="card-body">
            <?php
                // Pagination logic
                $limit = 5; // Set minimum 5 rows per page
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page, default is 1
                $offset = ($page - 1) * $limit; // Calculate the offset

                // Fetch employees with pagination
                $employee_qry = $conn->query("SELECT * FROM employee LIMIT $limit OFFSET $offset") or die(mysqli_error($conn));

                // Get total number of employees for pagination
                $total_result = $conn->query("SELECT COUNT(*) AS total FROM employee")->fetch_array();
                $total_records = $total_result['total'];
                $total_pages = ceil($total_records / $limit); // Calculate total pages
            ?>

            <!-- Make the table responsive -->
            <div class="table-responsive">
                <table id="table" class="table table-striped">
                    <thead>
                        <tr class="text-dark">
                            <th>Employee No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $employee_qry->fetch_array()) { ?>
                            <tr class="text-dark">
                                <td><?php echo $row['employee_no']; ?></td>
                                <td><?php echo $row['firstname']; ?></td>
                                <td><?php echo $row['lastname']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <div class="pagination">
                <ul class="pagination">
                    <!-- Previous Button -->
                    <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= max(1, $page - 1) ?>">Previous</a>
                    </li>

                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Button -->
                    <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>



                <!-- Attendance Column -->
                <div class="col-md-4">
                    <div class="card text-white bg-white mb-3"  style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;box-shadow: 5px 5px 5px grey;border: grey 1px solid">
                        <div class="card-header text-white h3 " style="background-color: #1c2b52;">Attendance 🕗</div>
                        <div class="card-body">
                            <?php
                                $attendance_qry = $conn->query("SELECT * FROM attendance") or die(mysqli_error());
                            ?>
                            <table id="table" class="table  table-striped">
                                <thead>
                                    <tr class="text-dark">
                                        <th>Employee ID</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $attendance_qry->fetch_array()) { ?>
                                        <tr class="text-dark">
                                            <td><?php echo $row['employee_id']; ?></td>
                                            <td><?php echo $row['datetime_log']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Column -->
<div class="col-md-4">
    <div class="card text-white bg-white mb-3" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; box-shadow: 5px 5px 5px grey; border: grey 1px solid">
        <div class="card-header text-white h4" style="background-color: #ff9800;">
            Leave Requests 💼
        </div>
        <div class="card-body">
            <?php
                // Modify query to fetch only pending leave requests
                $employee_leaves_qry = $conn->query("SELECT * FROM employee_leaves WHERE status = 'pending'") or die(mysqli_error());
            ?>

            <!-- Make the table responsive -->
            <div class="table-responsive">
                <table id="table" class="table table-striped">
                    <thead>
                        <tr class="text-dark">
                            <th>Name</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $employee_leaves_qry->fetch_array()) { ?>
                            <tr class="text-dark">
                                <td><?php echo $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['reason']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


            
                <!-- holidays Column -->
				<div class="col-md-8">
    <div class="card text-white bg-white mb-3"  style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;box-shadow: 5px 5px 5px grey;border: grey 1px solid">
        <div class="card-header text-white h4" style="background-color: crimson;">Holidays 🎉</div>
        <div class="card-body">
            <?php
                // Number of records per page
                $limit = 5; // Set the limit to show 5 holidays per page

                // Get the current page from the URL (defaults to page 1)
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Get the total number of records
                $total_qry = $conn->query("SELECT COUNT(*) as total FROM holidays");
                $total_result = $total_qry->fetch_assoc();
                $total_records = $total_result['total'];

                // Calculate total number of pages
                $total_pages = ceil($total_records / $limit);

                // Query the holidays for the current page with pagination
                $holidays_qry = $conn->query("SELECT * FROM holidays LIMIT $offset, $limit") or die(mysqli_error());
            ?>
            <table id="table" class="table table-striped">
                <thead>
                    <tr class="text-dark">
                        <th>Holidays</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $holidays_qry->fetch_array()) { ?>
                        <tr class="text-dark">
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=1" aria-label="First">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Page Number Links -->
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>

                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $total_pages; ?>" aria-label="Last">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
 
        
		<!-- Announcement Column -->
<div class="col-md-4">
    <div class="card text-white bg-white mb-3" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; box-shadow: 5px 5px 5px grey; border: grey 1px solid">
        <div class="card-header text-white h3" style="background-color: #1c2b52;">
            Announcements 📣
        </div>
        <div class="card-body">
            <?php
                $attendance_qry = $conn->query("SELECT * FROM attendance") or die(mysqli_error());
            ?>

            <!-- Make the table responsive -->
            <div class="table-responsive">
                <table id="table" class="table table-striped">
                    <thead>
                        <tr class="text-dark">
                            <th>Announcement</th>
                            <th>Description</th>
                            <th>Date to</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $attendance_qry->fetch_array()) { ?>
                            <tr class="text-dark">
                                <td><?php echo $row['employee_id']; ?></td>
                                <td><?php echo $row['datetime_log']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

          
      
      

        <!-- Maintenance Section -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <h4 class="alert-heading">Under Maintenance</h4>
                        <p>We are currently working on some updates. Please check back later for more information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Toggle Sidebar
        function toggleNav() {
            var sidebar = document.getElementById("mySidebar");
            var mainContent = document.getElementById("main");
            var openBtn = document.querySelector(".openbtn");

            // Toggle sidebar visibility
            if (sidebar.style.width === "250px") {
                sidebar.style.width = "0";
                mainContent.style.marginLeft = "0";
                openBtn.textContent = "☰"; // Open button
            } else {
                sidebar.style.width = "250px";
                mainContent.style.marginLeft = "250px";
                openBtn.textContent = "✖"; // Close button
            }
        }
    </script>
</body>

</html>
