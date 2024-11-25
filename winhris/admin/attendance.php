<?php
    require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance List | Employee Attendance Record System</title>
    <?php include 'header.php'; ?>
</head>

<body>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <?php include 'nav_bar.php'; ?>
    </div>

    <!-- Main Content -->
    <div id="main" class="container-fluid admin">
        <!-- Toggle Button -->
        <div style="background-color: #1c2b52;">
        <button class="openbtn" onclick="toggleNav()" style="background-color: #1c2b52;">☰ </button>  
		<iframe src="https://free.timeanddate.com/clock/i9n9b8eh/n145/fcfff/tc1c2b52" frameborder="0" width="115" height="18"></iframe>
        </div> 
        <div  class="py-4 px-4 fs-1" style="font-size: 40px;font-weight: bold ;">Attendance List</div>

        <!-- Modal for Delete Action (hidden for now) -->
        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModallabel"></div>

        <!-- Table for Attendance Records -->
        <div class="well col-lg-12">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Log Type</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Fetch attendance data with employee details
                        $attendance_qry = $conn->query(
                            "SELECT a.*, CONCAT(e.firstname, ' ', e.middlename, ' ', e.lastname) AS name, e.employee_no 
                            FROM `attendance` a
                            INNER JOIN employee e ON a.employee_id = e.id"
                        ) or die(mysqli_error());

                        while ($row = $attendance_qry->fetch_array()) {
                            // Determine log type description
                            $log = '';
                            switch ($row['log_type']) {
                                case 1: $log = "TIME IN AM"; break;
                                case 2: $log = "TIME OUT AM"; break;
                                case 3: $log = "TIME IN PM"; break;
                                case 4: $log = "TIME OUT PM"; break;
                            }
                    ?>  
                        <tr>
                            <td><?php echo $row['employee_no']; ?></td>
                            <td><?php echo htmlentities($row['name']); ?></td>
                            <td><?php echo date("F d, Y", strtotime($row['datetime_log'])); ?></td>
                            <td><?php echo $log; ?></td>
                            <td><?php echo date("h:i a", strtotime($row['datetime_log'])); ?></td>
                            <td>
                                <center>
                                    <button data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger remove_log" type="button">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
            <br><br><br>
        </div>
    </div>

    <!-- Optional JS for DataTable and AJAX interactions -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

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
                openBtn.textContent = "☰"; // Open button text
            } else {
                sidebar.style.width = "250px";
                mainContent.style.marginLeft = "250px";
                openBtn.textContent = "✖"; // Close button text
            }
        }

        // Initialize DataTable
        $(document).ready(function() {
            $('#table').DataTable();
        });

        // Handle log removal via AJAX
        $(document).ready(function() {
            $('.remove_log').click(function() {
                var id = $(this).data('id');
                var _conf = confirm("Are you sure to delete this data?");
                if (_conf) {
                    $.ajax({
                        url: 'delete_log.php?id=' + id,
                        error: function(err) {
                            console.log(err);
                        },
                        success: function(resp) {
                            if (typeof resp !== 'undefined') {
                                resp = JSON.parse(resp);
                                if (resp.status == 1) {
                                    alert(resp.msg);
                                    location.reload(); // Reload page after deletion
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
