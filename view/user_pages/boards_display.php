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

$query = "SELECT fname, lname, email FROM Users WHERE user_id = ?";
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

// Close the statement and connection
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Account Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/boards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo"><a href="landingpage.php">Vividly</a></h1>
            </div>

            <nav class="sidebar-nav">
                <a href="account.php" class="nav-item">
                    <i class="fas fa-user"></i>
                    <span >Profile</span>
                </a>
                <a id="boards" href="boards.php" class="nav-item">
                    <i class="fas fa-th-large"></i>
                    <span>Boards</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="landingpage.php" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 id="welcome">Board Name</h1>

            <!-- Add the gallery here -->
            <div class="relative flex flex-col my-10 mx-[9.5rem] shadow-sm w-64">
                <div class="relative overflow-hidden">
                    <img 
                        src="https://images.unsplash.com/photo-1499696010180-025ef6e1a8f9?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1470&amp;q=80" 
                        alt="card-image"
                        class="w-full h-auto object-cover rounded-3xl"
                    />
                </div>
                <div class="p-4">
                    <div class="flex items-center mb-2">
                        <h6 class="text-white text-lg font-semibold italic">
                            Wooden House, Florida
                        </h6>
                    </div>
                    <p class="text-slate-500 text-sm leading-normal font-light">
                        160 pins
                    </p>
                </div>
            </div>
            
        </main>
    </div>
</body>

</html>