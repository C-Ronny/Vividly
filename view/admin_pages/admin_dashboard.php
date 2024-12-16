<?php
// Include the database configuration
include '../../db/config.php';

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../logIn.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];

$query = "SELECT fname, lname, email, role, created_at FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Fetch total users
$queryUsers = "SELECT COUNT(*) AS total_users FROM Users";
$resultUsers = $conn->query($queryUsers);
$totalUsers = $resultUsers->fetch_assoc()['total_users'];

// Fetch new users this month
$queryNewUsers = "SELECT COUNT(*) as new_users 
FROM Users 
WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$resultNewUsers = $conn->query($queryNewUsers);
$newUsers = $resultNewUsers->fetch_assoc()['new_users'];


// Fetch total boards
$queryBoards = "SELECT COUNT(*) AS total_boards FROM Boards";
$resultBoards = $conn->query($queryBoards);
$totalBoards = $resultBoards->fetch_assoc()['total_boards'];

// Average Pins per Board
$queryAvgPins = "SELECT AVG(pin_count) as avg_pins 
FROM (
    SELECT board_id, COUNT(*) as pin_count 
    FROM Pins 
    WHERE board_id IS NOT NULL 
    GROUP BY board_id
) as board_stats";
$resultAvgPins = $conn->query($queryAvgPins);
$avgPins = round($resultAvgPins->fetch_assoc()['avg_pins'], 1);

// Fetch total pins / images
$queryPins = "SELECT COUNT(*) AS total_pins FROM Pins";
$resultPins = $conn->query($queryPins);
$totalPins = $resultPins->fetch_assoc()['total_pins'];

// Fetch most active category
$queryCategory = "SELECT c.name, COUNT(p.pin_id) as pin_count 
FROM Categories c 
JOIN Pins p ON c.category_id = p.category_id 
GROUP BY c.category_id 
ORDER BY pin_count DESC 
LIMIT 1";
$resultCategory = $conn->query($queryCategory);
$mostActiveCategory = $resultCategory->fetch_assoc()['name'];



// Total Categories
$queryCategories = "SELECT COUNT(*) as total_categories FROM Categories";
$resultCategories = $conn->query($queryCategories);
$totalCategories = $resultCategories->fetch_assoc()['total_categories'];

// Total Admins
$queryAdmins = "SELECT COUNT(*) as total_admins FROM Users WHERE role = 1";
$resultAdmins = $conn->query($queryAdmins);
$totalAdmins = $resultAdmins->fetch_assoc()['total_admins'];


// Close the statement and connection
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../../functions/admin_js/users_table.js"></script>
</head>

<body>
    <!-- Nav Bar -->
    <nav id="nav">
        <h2 id="vividly-logo">Vividly</h2>

        <div class="nav-links">
            <!-- <a class="nav-a" href="#">Boards</a> -->
            <a class="nav-a" href="../../actions/logout_user.php">Logout</a>
            <a href="#"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>
    <hr id="nav-rule">

    <main>

        <div class="welcome">
            <h1>Welcome, <?= htmlspecialchars($user['fname']) ?>!</h1>
            <p>Here's the site overview</p>
        </div>


        <!-- Cards -->
        <section class="container">
            <div class="card">
                <h2>Total No. of Users</h2>
                <p id="total_users"><?= htmlspecialchars($totalUsers) ?></p>
                <p id="new_users"><?= htmlspecialchars($newUsers) ?> new this month</p>
            </div>
            <div class="card">
                <h2>Total No. of Boards</h2>
                <p id="total_boards"><?= htmlspecialchars($totalBoards) ?></p>
                <p id="avg_pins">Average <?= htmlspecialchars($avgPins) ?> pins per board</p>
            </div>
            <div class="card" id="images">
                <h2>Total No. of Pins</h2>
                <p id="total_pins"><?= htmlspecialchars($totalPins) ?></p>
                <p id="most_active_category">Most active in <?= htmlspecialchars($mostActiveCategory) ?></p>
            </div>
            <div class="card">
                <h2>Total No. of Categories</h2>
                <p id="total_categories"><?= htmlspecialchars($totalCategories) ?></p>
            </div>
            <div class="card">
                <h2>Total No. of Admins</h2>
                <p id="total_admins"><?= htmlspecialchars($totalAdmins) ?></p>
            </div>

        </section>

        <!--Tables and images-->
        <section class="other_stats">
            <div class="data_table">
                
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Joined</th>
                                <th>No. of Pins Uploaded</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table class="content-table" cellpadding="0" cellspacing="0">
                        <tbody>
                            <!-- Rows will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="data_images">
                <div id="chart"></div>

            </div>
        </section>

        <section class="row3">
        <h1 id="title_text2">Number of Pins per Category</h1>
        <div id="chart1"></div>
        </section>


    </main>


    <!-- <script src="../../functions/admin_js/card_details.js"></script> -->
    <script src="../../functions/admin_js/charts.js"></script>

</body>

</html>