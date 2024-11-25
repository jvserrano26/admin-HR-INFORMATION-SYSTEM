<?php
    require_once 'auth.php';
    require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Announcements and Attendance List | Employee System</title>
    <?php include('header.php'); ?>
</head>

<body>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <?php include 'nav_bar.php'; ?>
    </div>

    <!-- Main Content -->
    <div id="main" class="container-fluid admin">
        <!-- Sidebar Toggle Button -->
		<div style="background-color: #1c2b52;">
        <button class="openbtn" onclick="toggleNav()" style="background-color: #1c2b52;">☰ </button>  
		<iframe src="https://free.timeanddate.com/clock/i9n9b8eh/n145/fcfff/tc1c2b52" frameborder="0" width="115" height="18"></iframe>
        </div>  

        <!-- Announcements List Section -->
        <div  class="py-4 px-4 fs-1" style="font-size: 40px;font-weight: bold ;">Announcements List</div>

        <!-- Edit Announcement Modal -->
        <div class="modal fade" id="editAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="editAnnouncementModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editAnnouncementForm">
                            <input type="hidden" id="announcement_id" name="announcement_id">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements Table -->
        <div class="well col-lg-12">
            <table id="announcements_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Employee</th>
                        <th>Created By</th>
                        <th>Announcement Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $announcement_qry = $conn->query(
                            "SELECT a.*, CONCAT(e.firstname, ' ', e.lastname) AS employee_name, u.username AS created_by 
                             FROM announcements a
                             INNER JOIN employee e ON a.employee_id = e.id
                             INNER JOIN users u ON a.created_by = u.id"
                        ) or die(mysqli_error());

                        while ($row = $announcement_qry->fetch_array()) {
                    ?>
                        <tr>
                            <td><?php echo htmlentities($row['title']); ?></td>
                            <td><?php echo htmlentities($row['description']); ?></td>
                            <td><?php echo htmlentities($row['employee_name']); ?></td>
                            <td><?php echo htmlentities($row['created_by']); ?></td>
                            <td><?php echo date("F d, Y h:i a", strtotime($row['announcement_date'])); ?></td>
                            <td><?php echo htmlentities($row['status']); ?></td>
                            <td>
                                <center>
                                    <button data-id="<?php echo $row['id']; ?>" data-title="<?php echo htmlentities($row['title']); ?>"
                                            data-description="<?php echo htmlentities($row['description']); ?>"
                                            data-status="<?php echo htmlentities($row['status']); ?>"
                                            class="btn btn-sm btn-outline-warning edit_announcement" type="button">
                                        <i class="fa fa-pencil"></i> Edit
                                    </button>
                                    <button data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger remove_announcement" type="button">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </center>
                            </td>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript">
        // Toggle Sidebar
        function toggleNav() {
            const sidebar = document.getElementById("mySidebar");
            const mainContent = document.getElementById("main");
            const openBtn = document.querySelector(".openbtn");

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

        // DataTable Initialization
        $(document).ready(function() {
            $('#announcements_table').DataTable();
        });

        // Announcement Deletion
        $(document).ready(function() {
            $('.remove_announcement').click(function() {
                const id = $(this).data('id');
                const _conf = confirm("Are you sure to delete this announcement?");
                
                if (_conf) {
                    $.ajax({
                        url: 'delete_announcement.php?id=' + id,
                        error: function(err) {
                            console.log(err);
                        },
                        success: function(resp) {
                            if (resp) {
                                resp = JSON.parse(resp);
                                if (resp.status === 1) {
                                    alert(resp.msg);
                                    location.reload();
                                }
                            }
                        }
                    });
                }
            });

            // Edit Announcement
            $('.edit_announcement').click(function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const description = $(this).data('description');
                const status = $(this).data('status');

                // Populate the modal with data
                $('#announcement_id').val(id);
                $('#title').val(title);
                $('#description').val(description);
                $('#status').val(status);

                // Show the modal
                $('#editAnnouncementModal').modal('show');
            });

            // Update Announcement
            $('#editAnnouncementForm').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: 'update_announcement.php', // PHP file to handle update
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        const resp = JSON.parse(response);
                        if (resp.status === 1) {
                            alert(resp.msg);
                            location.reload();
                        } else {
                            alert(resp.msg);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        });
    </script>
</body>

</html>
