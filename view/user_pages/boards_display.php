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

// Get board ID and title from URL
$board_id = isset($_GET['board_id']) ? $_GET['board_id'] : null;
$board_title = isset($_GET['title']) ? urldecode($_GET['title']) : 'Board';

// Fetch pins for this specific board
$pins_query = "SELECT p.* 
               FROM Pins p 
               WHERE p.board_id = ?";
$pins_stmt = $conn->prepare($pins_query);
$pins_stmt->bind_param("i", $board_id);
$pins_stmt->execute();
$pins_result = $pins_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | <?= htmlspecialchars($board_title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/boards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
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
    
    <main class="main-content">
        <h1 id="welcome"><?= htmlspecialchars($board_title) ?></h1>
        
        <!-- Display pins in a grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
            <?php while ($pin = $pins_result->fetch_assoc()): ?>
                <div class="pin-card group relative">
                    <img 
                        src="<?= htmlspecialchars($pin['image_url']) ?>" 
                        alt="<?= htmlspecialchars($pin['caption']) ?>"
                        class="w-full h-auto rounded-lg shadow-md cursor-pointer"
                        onclick="openRemoveModal(<?= $pin['pin_id'] ?>)"
                    >
                    <div class="p-2">
                        <h3 class="text-white text-lg"><?= htmlspecialchars($pin['caption']) ?></h3>
                        <p class="text-gray-400"><?= htmlspecialchars($pin['description']) ?></p>
                    </div>
                    <!-- Overlay with remove button -->
                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                        <button onclick="openRemoveModal(<?= $pin['pin_id'] ?>)" 
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                            Remove Pin
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <?php
    // Close database connections
    $pins_stmt->close();
    $conn->close();
    ?>

    <!-- Add this modal HTML before closing body tag -->
    <div id="remove-pin-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-gray-800 rounded-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold mb-4 text-white">Remove Pin</h2>
            <p class="text-gray-300 mb-6">Are you sure you want to remove this pin from the board?</p>
            <form id="remove-pin-form" method="POST" action="../../db/user_db/remove_pin.php">
                <input type="hidden" id="pin-id-input" name="pin_id" value="">
                <input type="hidden" name="board_id" value="<?= htmlspecialchars($board_id) ?>">
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeRemoveModal()" 
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Remove
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add JavaScript before closing body tag -->
    <script>
    function openRemoveModal(pinId) {
        document.getElementById('pin-id-input').value = pinId;
        document.getElementById('remove-pin-modal').classList.remove('hidden');
    }

    function closeRemoveModal() {
        document.getElementById('remove-pin-modal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('remove-pin-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRemoveModal();
        }
    });
    </script>
</body>
</html>