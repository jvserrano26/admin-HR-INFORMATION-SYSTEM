<?php 
// Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'winhris';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start session to access session variables
session_start();

// Auto-delete holidays that are past the current date
$today = date('Y-m-d');
$deleteQuery = "DELETE FROM holidays WHERE date < :today";
$deleteStmt = $conn->prepare($deleteQuery);
$deleteStmt->bindParam(':today', $today);
$deleteStmt->execute();

// Fetch holidays within 2 days
$currentDate = date('Y-m-d');
$upcomingDate = date('Y-m-d', strtotime('+2 days'));

$query = "SELECT * FROM holidays WHERE date BETWEEN :currentDate AND :upcomingDate ORDER BY date ASC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate);
$stmt->bindParam(':upcomingDate', $upcomingDate);
$stmt->execute();
$upcomingHolidays = $stmt->fetchAll();

// Define pagination variables
$limit = 10; // Number of holidays per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number
$offset = ($page - 1) * $limit; // Calculate the offset for the SQL query

// Search filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch holidays with optional search filter and pagination
$query = "SELECT * FROM holidays";
$searchClause = "";
if (!empty($search)) {
    $searchClause = " WHERE name LIKE :search";
}
$query .= $searchClause . " ORDER BY date DESC LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
}
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$holidays = $stmt->fetchAll();

// Get the total number of holidays for pagination
$countQuery = "SELECT COUNT(*) FROM holidays" . $searchClause;
$countStmt = $conn->prepare($countQuery);
if (!empty($search)) {
    $countStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
}
$countStmt->execute();
$totalHolidays = $countStmt->fetchColumn();
$totalPages = ceil($totalHolidays / $limit);

// Handle the POST requests for Edit and Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['action'])) {
        $id = $_POST['id'];

        if ($_POST['action'] == 'edit') {
            $name = $_POST['name'];
            $date = $_POST['date'];
            $description = $_POST['description'];

            // Update the holiday in the database
            $stmt = $conn->prepare("UPDATE holidays SET name = :name, date = :date, description = :description WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Holiday updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update holiday!";
            }
        } elseif ($_POST['action'] == 'delete') {
            // Delete the holiday from the database
            $stmt = $conn->prepare("DELETE FROM holidays WHERE id = :id");
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Holiday deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete holiday!";
            }
        }

        // Redirect to holiday_display.php after the action
        header("Location: holiday_display.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
    <?php include 'header.php'; ?>
  <style>
        .container {
            margin-top: 50px;
        }
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: auto;
            min-width: 200px;
            margin: 0;
            transition: opacity 0.5s ease;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-around;
        }
        .modal-header {
            background-color: #f8f9fa;
        }
    </style>
</head>
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
        
    <h1 class="text-center mb-4">Holiday List</h1>

    <!-- Add New Holiday Button Modal Trigger -->
    <div class="mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addHolidayModal">Add New Holiday</button>
    </div>

    <!-- Search Form -->
    <form method="GET" action="holiday_display.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by holiday name" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Display Success or Error Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" id="successMessage">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" id="errorMessage">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Holiday Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Holiday Name</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($holidays as $holiday): ?>
                <tr>
                    <td><?= htmlspecialchars($holiday['name']) ?></td>
                    <td><?= htmlspecialchars($holiday['date']) ?></td>
                    <td><?= htmlspecialchars($holiday['description']) ?></td>
                    <td class="action-buttons">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal" data-id="<?= $holiday['id'] ?>" data-name="<?= htmlspecialchars($holiday['name'], ENT_QUOTES) ?>" data-date="<?= htmlspecialchars($holiday['date'], ENT_QUOTES) ?>" data-description="<?= htmlspecialchars($holiday['description'], ENT_QUOTES) ?>">View</button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $holiday['id'] ?>" data-name="<?= htmlspecialchars($holiday['name'], ENT_QUOTES) ?>" data-date="<?= htmlspecialchars($holiday['date'], ENT_QUOTES) ?>" data-description="<?= htmlspecialchars($holiday['description'], ENT_QUOTES) ?>">Edit</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $holiday['id'] ?>" data-name="<?= htmlspecialchars($holiday['name'], ENT_QUOTES) ?>">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <ul class="pagination">
            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&search=<?= htmlspecialchars($search) ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>&search=<?= htmlspecialchars($search) ?>">Next</a>
            </li>
        </ul>
    </div>
  </div>

  <!-- Modal for Adding New Holiday -->
  <div class="modal fade" id="addHolidayModal" tabindex="-1" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addHolidayModalLabel">Add New Holiday</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="holiday_crud.php" method="POST">
            <div class="mb-3">
              <label for="name" class="form-label">Holiday Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">Date</label>
              <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Holiday</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
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
