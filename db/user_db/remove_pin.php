<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin_id = $_POST['pin_id'];
    $board_id = $_POST['board_id'];
    
    // Update the pin to remove it from the board
    $query = "UPDATE Pins SET board_id = NULL WHERE pin_id = ? AND board_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $pin_id, $board_id);
    
    if ($stmt->execute()) {
        // Redirect back to the board page
        header("Location: ../../view/user_pages/boards_display.php?board_id=" . $board_id . "&title=" . urlencode($_GET['title']));
        exit();
    } else {
        echo "Error removing pin: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
