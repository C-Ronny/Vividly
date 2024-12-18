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

// Fetch liked pins for the current user
$liked_pins_query = "SELECT p.*, u.fname, u.lname, l.like_id 
                    FROM Pins p 
                    JOIN Likes l ON p.pin_id = l.pin_id 
                    JOIN Users u ON p.user_id = u.user_id 
                    WHERE l.user_id = ? 
                    ORDER BY l.created_at DESC";
$liked_pins_stmt = $conn->prepare($liked_pins_query);
$liked_pins_stmt->bind_param("i", $user_id);
$liked_pins_stmt->execute();
$liked_pins_result = $liked_pins_stmt->get_result();

// Close the statements and connection
$stmt->close();
$liked_pins_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Liked Pins</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/boards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
        function unlikePin(pinId) {
            if (confirm('Are you sure you want to unlike this pin?')) {
                fetch('../../db/user_db/unlike_pin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'pin_id=' + pinId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the pin card from the display
                        document.getElementById('pin-' + pinId).remove();
                    } else {
                        alert('Failed to unlike pin. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        }
    </script>
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
                    <span>Profile</span>
                </a>
                <a href="boards.php" class="nav-item">
                    <i class="fas fa-th-large"></i>
                    <span>Boards</span>
                </a>
                <a id="likes" href="likes.php" class="nav-item">
                    <i class="fas fa-heart"></i>
                    <span>Likes</span>
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
            <h1 id="welcome">Your Liked Pins</h1>
            <p id="welcome-text">Here are all the pins you've liked</p>

            <!-- Liked Pins Grid -->
            <div class="flex flex-row flex-wrap gap-6 p-8">
                <?php while ($pin = $liked_pins_result->fetch_assoc()): ?>
                    <div id="pin-<?= $pin['pin_id'] ?>" class="flex-shrink-0 w-64 shadow-sm hover:transform hover:scale-105 transition-transform duration-200">
                        <div class="relative overflow-hidden">
                            <img
                                src="<?= htmlspecialchars($pin['image_url']) ?>"
                                alt="<?= htmlspecialchars($pin['caption']) ?>"
                                class="w-full h-48 object-cover rounded-3xl"
                            />
                            <button
                                onclick="unlikePin(<?= $pin['pin_id'] ?>)"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2"
                            >
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <h6 class="text-white text-lg font-semibold mb-2">
                                <?= htmlspecialchars($pin['caption']) ?>
                            </h6>
                            <p class="text-slate-500 text-sm leading-normal font-light">
                                <?= htmlspecialchars($pin['description']) ?>
                            </p>
                            <p class="text-slate-400 text-xs mt-2">
                                By <?= htmlspecialchars($pin['fname']) ?> <?= htmlspecialchars($pin['lname']) ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>
</body>

</html> 