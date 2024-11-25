<?php
 require_once 'auth.php';
 require_once 'db_connect.php';
?>      

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Employee</h2>
    <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Employee</button>

    <!-- Table to display users -->
    <table class="table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Civil Status</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM employees");
            while ($row = $result->fetch_assoc()):
            ?>
           <tr>
    <td><?= $row['Emp_no'] ?></td>
    <td><?= $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] ?></td>
    <td><?= $row['gender'] ?></td>
    <td><?= $row['civil_status'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['number'] ?></td>
    <td><?= $row['address'] ?></td>
    <td>
        <button class="btn btn-primary editBtn" data-toggle="modal" data-target="#editModal"
            data-id="<?= $row['id'] ?>" data-first_name="<?= $row['first_name'] ?>" 
            data-middle_name="<?= $row['middle_name'] ?>" data-last_name="<?= $row['last_name'] ?>" data-gender="<?= $row['gender'] ?>"
            data-civil_status="<?= $row['civil_status'] ?>" data-email="<?= $row['email'] ?>" data-number="<?= $row['number'] ?>"
             data-age="<?= $row['age'] ?>" data-birth="<?= $row['birth'] ?>" data-address="<?= $row['address'] ?>" data-birth_place="<?= $row['birth_place'] ?>" >Edit</button>
        <button class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal"
            data-id="<?= $row['id'] ?>">Delete</button>
    </td>
</tr>

            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="index.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <label for="Emp_no">Employee ID:</label><br>
        <input type="text" id="Emp_no" name="Emp_no" required><br><br>
		
		<label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br><br>
		
		<label for="middle_name">Middle Name:</label><br>
        <input type="text" id="middle_name" name="middle_name" required><br><br>
		<label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>
		
		<label for="gender">Gender:</label><br>
        <select name="gender" id="gender" required>
                    <option value=""></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
        
        </select><br><br>
		
		<label for="civil_status">Civil Status:</label><br>
       <Select name="civil_status" id="civil_status" required>
                    <option value=""></option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="separated">Separated</option>
                    <option value="widowed">Widowed</option>
       </Select><br><br>
		
		<label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
		
		<label for="number">Contact Number:</label><br>
        <input type="text" id="number" name="number" required><br><br>
		
		<label for="age">Age:</label><br>
        <input type="number" id="age" name="age" required><br><br>
		
		<label for="birth">Birthdate:</label><br>
        <input type="date" id="birth" name="birth" required><br><br>
		
		<label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>
		
		<label for="birth_place">Place of Birth:</label><br>
        <input type="text" id="birth_place" name="birth_place" required><br><br>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="index.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Employee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
		
		<label for="first_name">First Name:</label><br>
        <input type="text" id="editfirst_name" name="first_name" required><br><br>
		
		<label for="middle_name">Middle Name:</label><br>
        <input type="text" id="editmiddle_name" name="middle_name" required><br><br>
		<label for="last_name">Last Name:</label><br>
        <input type="text" id="editlast_name" name="last_name" required><br><br>
		
		<label for="gender">Gender:</label><br>
        <select name="gender" id="editgender" required>
                    <option value=""></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option> 
        </select><br><br>
		
		<label for="civil_status">Civil Status:</label><br>
       <Select name="civil_status" id="editcivil_status" required>
                    <option value=""></option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="separated">Separated</option>
                    <option value="widowed">Widowed</option>
       </Select><br><br>
		
		<label for="email">Email:</label><br>
        <input type="email" id="editEmail" name="email" required><br><br>
		
		<label for="number">Contact Number:</label><br>
        <input type="text" id="editnumber" name="number" required><br><br>
		
		<label for="age">Age:</label><br>
        <input type="number" id="editAge" name="age" required><br><br>
		
		<label for="birth">Birthdate:</label><br>
        <input type="date" id="editbirth" name="birth" required><br><br>
		
		<label for="address">Address:</label><br>
        <input type="text" id="editaddress" name="address" required><br><br>
		
		<label for="birth_place">Place of Birth:</label><br>
        <input type="text" id="editbirth_place" name="birth_place" required><br><br>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="index.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                    <input type="hidden" name="id" id="deleteId">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/getDataForEdit.js"></script>

</body>
</html>
